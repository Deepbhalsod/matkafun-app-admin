<?php
require('config.php');

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

function sendNotification($title, $message) {
    global $app_id, $api_key;

    $fields = [
        'app_id' => $app_id,
        'included_segments' => ['All'],
        'headings' => ['en' => $title],
        'contents' => ['en' => $message],
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ' . $api_key,
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}


while ($row = $res->fetch_assoc()) {

    $id   = (int)$row['id'];
    $game = strtoupper(trim($row['game_name']));

    $openAvailable  = ($row['open_panna'] !== '***' && $row['open_digit'] !== '*');
    $closeAvailable = ($row['close_panna'] !== '***' && $row['close_digit'] !== '*');

    if (!$openAvailable && !$closeAvailable) continue;

    $sentQuery = $conn->query("SELECT sent_type FROM notifications_sent WHERE result_id = $id ORDER BY sent_type DESC LIMIT 1");
    $sentRow   = $sentQuery ? $sentQuery->fetch_assoc() : null;
    $sentType  = $sentRow['sent_type'] ?? null;

    $title = $game;
    $message = "";

    if ($openAvailable && $closeAvailable) {
        $message = "{$row['open_panna']}-{$row['open_digit']}{$row['close_digit']}-{$row['close_panna']}";
    } elseif ($openAvailable) {
        $message = "{$row['open_panna']}-{$row['open_digit']}";
    } elseif ($closeAvailable) {
        $message = "{$row['close_panna']}-{$row['close_digit']}";
    }

    if ($message === "") continue;

    if ($openAvailable && !$closeAvailable && !$sentType) {
        $msg = $message;
        sendNotification($title, $msg);
        echo "✅ Sent OPEN for $game → $message\n";
        $conn->query("INSERT IGNORE INTO notifications_sent (result_id, sent_type) VALUES ($id, 'OPEN')");
    }
    elseif ($openAvailable && $closeAvailable && $sentType !== 'BOTH') {
        $msg = $message;
        sendNotification($title, $msg);
        echo "✅ Sent BOTH for $game → $message\n";
        $conn->query("INSERT IGNORE INTO notifications_sent (result_id, sent_type) VALUES ($id, 'BOTH')");
    }
}

$conn->close();
echo "✅ Done sending result notifications.\n";
?>
