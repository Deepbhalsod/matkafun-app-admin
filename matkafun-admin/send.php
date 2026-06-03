<?php
date_default_timezone_set('Asia/Kolkata');

// ========== DB CONFIG ==========
define('BASEPATH', 'system');
define('APPPATH', 'application/');
require_once 'application/Site_constants.php';

// ========== ONESIGNAL CONFIG ==========
$app_id  = ONESIGNAL_APP_ID;
$api_key = ONESIGNAL_REST_API_KEY;

// ========== CONNECT ==========
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) die("DB Connection failed: " . $conn->connect_error);

// ========== CREATE TRACKING TABLE IF MISSING ==========
$conn->query("
CREATE TABLE IF NOT EXISTS notifications_sent (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    result_id BIGINT NOT NULL,
    sent_type ENUM('OPEN','BOTH') DEFAULT 'OPEN',
    sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_result (result_id, sent_type)
) ENGINE=InnoDB;
");

// ========== FETCH TODAY'S RESULTS ==========
$sql = "
SELECT r.id, r.game_id, r.open_panna, r.open_digit, r.close_panna, r.close_digit, g.name AS game_name
FROM result r
JOIN games g ON r.game_id = g.id
WHERE DATE(r.decleared_at) = CURDATE()
";
$res = $conn->query($sql);

if (!$res || $res->num_rows === 0) {
    echo "No results found today.\n";
    exit;
}

// ========== FUNCTION: SEND ONESIGNAL NOTIFICATION ==========
function sendNotification($title, $message, $app_id, $api_key) {
    $fields = [
        'app_id' => $app_id,
        'included_segments' => ['All'],
        'headings' => ['en' => $title],
        'contents' => ['en' => $message],
        'data' => ['notification_type' => 'ROOT_CRON_SEND']
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Key ' . $api_key,
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

// ========== LOOP EACH RESULT ==========
while ($row = $res->fetch_assoc()) {
    $id = (int)$row['id'];
    $game = strtoupper(trim($row['game_name']));

    $openAvailable  = ($row['open_panna'] !== '***' && $row['open_digit'] !== '*');
    $closeAvailable = ($row['close_panna'] !== '***' && $row['close_digit'] !== '*');

    if (!$openAvailable && !$closeAvailable) continue;

    // Check previously sent type
    $sentQuery = $conn->query("SELECT sent_type FROM notifications_sent WHERE result_id = $id ORDER BY sent_type DESC LIMIT 1");
    $sentRow   = $sentQuery ? $sentQuery->fetch_assoc() : null;
    $sentType  = $sentRow['sent_type'] ?? null;

    // Determine message format
    $title = "[AUTO-ROOT] RESULT DECLARED";
    $message = "";

    if ($openAvailable && $closeAvailable) {
        // Example: 114-6 + 123-6 → 114-66-123
        $message = "{$row['open_panna']}-{$row['open_digit']}{$row['close_digit']}-{$row['close_panna']}";
    } elseif ($openAvailable) {
        $message = "{$row['open_panna']}-{$row['open_digit']}";
    } elseif ($closeAvailable) {
        $message = "{$row['close_panna']}-{$row['close_digit']}";
    }

    if ($message === "") continue;

    // Send logic:
    $created_date = date('Y-m-d H:i:s');

    // 1️⃣ Send "OPEN" only once when open available
    // 2️⃣ Send "BOTH" only when close also declared (even if open already sent)
    if ($openAvailable && !$closeAvailable && !$sentType) {
        $msg = "$game Result Declared $message";
        $resp = sendNotification($title, $msg, $app_id, $api_key);
        echo "✅ Sent OPEN for $game → $message\n";
        $conn->query("INSERT IGNORE INTO notifications_sent (result_id, sent_type) VALUES ($id, 'OPEN')");

        // Save to app notification history
        $stmt_hist = $conn->prepare("INSERT INTO notifications (heading, message, user_id, status, icon, created_date) VALUES (?, ?, 'all', 1, '', ?)");
        $stmt_hist->bind_param("sss", $game, $msg, $created_date);
        $stmt_hist->execute();
    }
    elseif ($openAvailable && $closeAvailable && $sentType !== 'BOTH') {
        $msg = "$game Result Declared $message";
        $resp = sendNotification($title, $msg, $app_id, $api_key);
        echo "✅ Sent BOTH for $game → $message\n";
        $conn->query("INSERT IGNORE INTO notifications_sent (result_id, sent_type) VALUES ($id, 'BOTH')");

        // Save to app notification history
        $stmt_hist = $conn->prepare("INSERT INTO notifications (heading, message, user_id, status, icon, created_date) VALUES (?, ?, 'all', 1, '', ?)");
        $stmt_hist->bind_param("sss", $game, $msg, $created_date);
        $stmt_hist->execute();
    }

    sleep(1);
}

$conn->close();
echo "✅ Done sending result notifications.\n";
?>
