<?php
chdir(__DIR__);
ini_set('display_errors', 1);
error_reporting(E_ALL);
require('config.php');

function sendOneSignalNotification($title, $message, $conn, $type = 'GENERAL') {
    if (!defined('ONESIGNAL_APP_ID') || !defined('ONESIGNAL_REST_API_KEY') || !defined('ONESIGNAL_API_URL')) {
        return;
    }

    $push_title = $title; // ✅ CLEAN title for users
    $db_heading = "[" . $type . "] " . $title; // ✅ Prefixed title for admin
    $ist_time = date("Y-m-d H:i:s");

    $fields = [
        'app_id' => ONESIGNAL_APP_ID,
        'included_segments' => ['All'],
        'headings' => ["en" => $push_title], // ✅ Use clean title for users
        'contents' => ["en" => $message],
        'large_icon' => SITE_URL . 'assets/img/logo.png',
        'data' => [
            'notification_type' => $type,
            'admin_type' => $type // Optional internal classification
        ]
    ];

    $ch = curl_init(ONESIGNAL_API_URL);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json; charset=utf-8',
        "Authorization: Basic " . ONESIGNAL_REST_API_KEY
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    curl_close($ch);

    $stmt = $conn->prepare("INSERT INTO notifications (heading, message, user_id, status, created_date) VALUES (?, ?, 'all', 1, ?)");
    $stmt->bind_param("sss", $db_heading, $message, $ist_time);
    $stmt->execute();
    $stmt->close();
}

date_default_timezone_set('Asia/Kolkata');
$today = date("Y-m-d");
$decleared_at = date("Y-m-d H:i:s");


$api_url = "https://matkaresultapi.online/apis/market_api.php";
$payload = json_encode([
    "domain" => "pune777.com",
    "api_key" => "e7496888fb69f3d50e1b3882eeea5129",
    "domain_key" => "1cc013a9bd0290a2ab63ac4e248d4d1e",
    "market" => "all",
    "old" => false
]);

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);
curl_close($ch);

$result_data = json_decode($response, true);


echo "<!DOCTYPE html><html><head>
<title>Live Matka Data</title>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css'>
<style>
    body { padding: 20px; font-family: Arial; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
    th { background-color: #ffc107; }
</style>
</head><body>
<h2 class='mb-4 text-center'>Live Matka Results</h2>
<table class='table table-bordered'>
<thead class='bg-warning text-dark'>
<tr>
    <th>Market</th>
    <th>Open</th>
    <th>Close</th>
    <th>Figure open</th>
    <th>Figure close</th>
    <th>Jodi</th>
</tr>
</thead>
<tbody>
";

$inserted = 0;
$updated  = 0;
// Note: Stability delay remains active below to prevent API drops


if ($result_data['status'] === true && !empty($result_data['data'])) {
    foreach ($result_data['data'] as $row) {
        $market = trim($row['name']);
        $result = trim($row['result']);

        $result_id = null;
        $is_new_open = false;
        $is_new_close = false;

        
        if ($result === "" || $result === "-" || strtolower($result) === "null") {
            $open = "***";
            $close = "***";
            $open_digit = "*";
            $close_digit = "*";
            $jodi = "*";

            echo "<tr>
                <td>$market</td>
                <td>$open</td>
                <td>$close</td>
                <td>$open_digit</td>
                <td>$close_digit</td>
                <td>$jodi</td>
            </tr>";
        } else {
            $result_parts = explode('-', $result);
            if (count($result_parts) !== 3) {
                echo "<tr><td>$market</td><td colspan='5'>Invalid format</td></tr>";
                continue;
            }

            $open  = ($result_parts[0] !== "" ? $result_parts[0] : "***");
            $jodi  = ($result_parts[1] !== "" ? str_pad($result_parts[1], 2, "0", STR_PAD_LEFT) : "*");
            $close = ($result_parts[2] !== "" ? $result_parts[2] : "***");

            $open_digit  = "*";
            $close_digit = "*";

            if ($jodi !== "*" && strlen($jodi) == 2) {
                $open_digit  = $jodi[0];
                $close_digit = $jodi[1];
            } else {
                if ($open !== "***") {
                    $sum = array_sum(str_split($open));
                    $open_digit = $sum % 10;
                }
                if ($close !== "***") {
                    $sum = array_sum(str_split($close));
                    $close_digit = $sum % 10;
                }
            }

            echo "<tr>
                <td>$market</td>
                <td>$open</td>
                <td>$close</td>
                <td>$open_digit</td>
                <td>$close_digit</td>
                <td>$jodi</td>
            </tr>";
        }

       
        $stmt = $conn->prepare("SELECT id FROM games WHERE name = ? AND status = 1");
        $stmt->bind_param("s", $market);
        $stmt->execute();
        $stmt->bind_result($game_id);

        if ($stmt->fetch()) {
            $stmt->close();

            $check = $conn->prepare("SELECT id, open_panna, open_digit, close_panna, close_digit FROM result WHERE game_id = ? AND DATE(decleared_at) = ?");
            $check->bind_param("is", $game_id, $today);
            $check->execute();
            $res = $check->get_result();

            if ($row_existing = $res->fetch_assoc()) {
                $existing_id = $row_existing['id'];

                $is_new_open = ( ($row_existing['open_panna'] === "***" || $row_existing['open_panna'] === "") && $open !== "***" );
                $is_new_close = ( ($row_existing['close_panna'] === "***" || $row_existing['close_panna'] === "") && $close !== "***" );

                $final_open   = ($open   === "***") ? $row_existing['open_panna']  : $open;
                $final_open_d = ($open_digit === "*") ? $row_existing['open_digit'] : $open_digit;
                $final_close  = ($close  === "***") ? $row_existing['close_panna'] : $close;
                $final_close_d= ($close_digit === "*") ? $row_existing['close_digit'] : $close_digit;

                $update = $conn->prepare("UPDATE result 
                    SET open_panna=?, open_digit=?, close_panna=?, close_digit=?, decleared_at=? 
                    WHERE id=?");
                $update->bind_param(
                    "sssssi",
                    $final_open, $final_open_d, $final_close, $final_close_d, $decleared_at, $existing_id
                );
                $update->execute();
                $update->close();
                $updated++;
                $result_id = $existing_id;
            } else {
                $check->close();

                
                if (!($open === "***" && $close === "***" && $open_digit === "*" && $close_digit === "*")) {
                    $is_new_open = ($open !== "***");
                    $is_new_close = ($close !== "***");

                    $insert = $conn->prepare("INSERT INTO result 
                        (game_id, open_panna, open_digit, close_panna, close_digit, chart_color, decleared_at) 
                        VALUES (?, ?, ?, ?, ?, 'Black', ?)");
                    $insert->bind_param(
                        "isssss",
                        $game_id, $open, $open_digit, $close, $close_digit, $decleared_at
                    );
                    $insert->execute();
                    $result_id = $insert->insert_id;
                    $insert->close();
                    $inserted++;
                }
            }

            
                if ($result_id) {
                    $session_types = [];
                    if ($is_new_open) $session_types[] = "Open";
                    if ($is_new_close) $session_types[] = "Close";

                    if ($is_new_open) {
                        // Check if already sent
                        $check_sent = $conn->query("SELECT id FROM notifications_sent WHERE result_id = $result_id AND sent_type = 'OPEN'");
                        if ($check_sent->num_rows === 0) {
                            $mes = "Open " . $open . "-" . $open_digit;
                            sendOneSignalNotification($market, $mes, $conn, 'AUTO-API');
                            $conn->query("INSERT IGNORE INTO notifications_sent (result_id, sent_type) VALUES ($result_id, 'OPEN')");
                            echo "<div class='text-primary'>🔔 Notification Sent: $market (Open)</div>";
                            usleep(200000); // 0.2s delay for stability
                        }
                    }
                    if ($is_new_close) {
                        // Check if already sent BOTH
                        $check_sent = $conn->query("SELECT id FROM notifications_sent WHERE result_id = $result_id AND sent_type = 'BOTH'");
                        if ($check_sent->num_rows === 0) {
                            $mes = "Close " . $close . "-" . $close_digit;
                            sendOneSignalNotification($market, $mes, $conn, 'AUTO-API');
                            $conn->query("INSERT IGNORE INTO notifications_sent (result_id, sent_type) VALUES ($result_id, 'BOTH')");
                            echo "<div class='text-primary'>🔔 Notification Sent: $market (Close)</div>";
                            usleep(200000); // 0.2s delay for stability
                        }
                    }

                foreach ($session_types as $session) {
                    $digit_col = $session === "Open" ? "open_digit" : "close_digit";
                    $panna_col = $session === "Open" ? "open_panna" : "close_panna";
                    $digit_val = $session === "Open" ? $open_digit : $close_digit;
                    $panna_val = $session === "Open" ? $open : $close;

                    $query = "SELECT * FROM bid WHERE game_id=? AND session=? AND bidded_at LIKE ? AND won=0";
                    $like_date = "$today%";
                    $bids = $conn->prepare($query);
                    $bids->bind_param("iss", $game_id, $session, $like_date);
                    $bids->execute();
                    $resb = $bids->get_result();

                    while ($bid = $resb->fetch_assoc()) {
                        $win = false;
                        if (
                            ($bid['game_type'] === 'single_digit' && $bid[$digit_col] == $digit_val) ||
                            ($bid['game_type'] === 'jodi_digit' && $bid['open_digit'].$bid['close_digit'] == $jodi) ||
                            (strpos($bid['game_type'], 'panna') !== false && $bid[$panna_col] == $panna_val)
                        ) {
                            $win = true;
                        }

                        if ($win) {
                            $type = $bid['game_type'];
                            $rate_q = $conn->prepare("SELECT per_point_earning_amount FROM game_rate WHERE name=?");
                            $rate_q->bind_param("s", $type);
                            $rate_q->execute();
                            $rate_q->bind_result($rate);
                            $rate_q->fetch();
                            $rate_q->close();

                            $points = $bid['bid_points'];
                            $earned = $points * $rate;

                            $uid = $bid['user_id'];
                            $conn->query("UPDATE users SET available_points = available_points + $earned WHERE id = $uid");

                            $trans_det = $result_id . "M";
                            $conn->query("INSERT INTO user_trans (user_id, points, trans_type, trans_det, trans_status, admin_status, created_at) VALUES ($uid, $earned, 5, '$trans_det', 'SUCCESSFUL', 'APPROVED', '$decleared_at')");

                            $conn->query("UPDATE bid SET win_points = $earned, won = 1, result_id = '$trans_det', won_at = '$decleared_at' WHERE id = {$bid['id']}");
                        }
                    }
                    $bids->close();
                }
            }

        } else {
            $stmt->close();
        }
    }
} else {
    echo "<tr><td colspan='6' class='text-danger text-center'>❌ Error: " . ($result_data['message'] ?? 'No data') . "</td></tr>";
}

echo "</tbody></table>";
echo "<div class='alert alert-success text-center mt-4'>✅ Completed! Inserted: $inserted | Updated: $updated</div>";
echo "</body></html>";
$conn->close();
?>
