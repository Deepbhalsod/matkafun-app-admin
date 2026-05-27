<?php

$host = "localhost";
$user = "u472706178_wonder1club";
$pass = "Wonder1Club@2025";
$dbname = "u472706178_wonder1club";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) die("DB Connection failed: " . $conn->connect_error);

date_default_timezone_set('Asia/Kolkata');


function undoOldResult($conn, $result_id)
{
    $result_key = $result_id . "M";
    $rid_numeric = (string)$result_id;

    // 1. Minus winning ONLY from user_trans records
    $q = $conn->prepare("SELECT id, user_id, points FROM user_trans WHERE trans_det = ? AND trans_type = 5");
    $q->bind_param("s", $result_key);
    $q->execute();
    $res = $q->get_result();

    while ($row = $res->fetch_assoc()) {
        $uid = (int)$row['user_id'];
        $points = (int)$row['points'];
        $tid = (int)$row['id'];

        $conn->query("UPDATE users SET available_points = available_points - $points WHERE id = $uid");
        $conn->query("DELETE FROM user_trans WHERE id = $tid");
    }
    $q->close();

    // 2. Do NOT minus bid.win_points again. Only reset old winning bids.
    $stmt = $conn->prepare("
        UPDATE bid 
        SET win_points = 0, won = 0, result_id = '', won_at = '0000-00-00 00:00:00'
        WHERE result_id = ? OR result_id = ?
    ");
    $stmt->bind_param("ss", $rid_numeric, $result_key);
    $stmt->execute();
    $stmt->close();
}


$today = date("Y-m-d");
$decleared_at = date("Y-m-d H:i:s");


$api_url = "https://matkaresultapi.online/apis/market_api.php";
$payload = json_encode([
    "domain" => "wonder1club.click",
    "api_key" => "b9fa1ab646498590bc66182a2d75c300",
    "domain_key" => "970938bb458730f8a05149d110d3cd01",
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
$updated = 0;


if ($result_data['status'] === true && !empty($result_data['data'])) {
    foreach ($result_data['data'] as $row) {
        $market = trim($row['name']);
        $result = trim($row['result']);

        $result_id = null;

        
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

            $check = $conn->prepare("SELECT id, open_panna, open_digit, close_panna, close_digit, manual_lock FROM result WHERE game_id = ? AND DATE(decleared_at) = ?");
            $check->bind_param("is", $game_id, $today);
            $check->execute();
            $res = $check->get_result();

            if ($row_existing = $res->fetch_assoc()) {
    $existing_id = $row_existing['id'];

    if ((int)$row_existing['manual_lock'] === 1) {
        echo "<tr>
            <td>$market</td>
            <td colspan='5' class='text-info'>Skipped - Manual Edited Result Locked</td>
        </tr>";
        continue;
    }

    $final_open    = ($open === "***") ? $row_existing['open_panna'] : $open;
    $final_open_d  = ($open_digit === "*") ? $row_existing['open_digit'] : $open_digit;
    $final_close   = ($close === "***") ? $row_existing['close_panna'] : $close;
    $final_close_d = ($close_digit === "*") ? $row_existing['close_digit'] : $close_digit;

    // Check if final result is different from old result
    $result_changed =
        $row_existing['open_panna'] != $final_open ||
        $row_existing['open_digit'] != $final_open_d ||
        $row_existing['close_panna'] != $final_close ||
        $row_existing['close_digit'] != $final_close_d;

    // If changed, remove old winning money first
    if ($result_changed) {
        undoOldResult($conn, $existing_id);
    }

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

if ($open !== "***" && $open_digit !== "*") {
    $session_types[] = "Open";
}

if ($close !== "***" && $close_digit !== "*") {
    $session_types[] = "Close";
}
                foreach ($session_types as $session) {
                    $digit_col = $session === "Open" ? "open_digit" : "close_digit";
                    $panna_col = $session === "Open" ? "open_panna" : "close_panna";
                    $digit_val = $session === "Open" ? $open_digit : $close_digit;
                    $panna_val = $session === "Open" ? $open : $close;

                    
                    $like_date = "$today%";

if ($session === "Close") {
    $query = "SELECT * FROM bid 
              WHERE game_id=? 
              AND bidded_at LIKE ? 
              AND won=0";
    $bids = $conn->prepare($query);
    $bids->bind_param("is", $game_id, $like_date);
} else {
    $query = "SELECT * FROM bid 
              WHERE game_id=? 
              AND session=? 
              AND bidded_at LIKE ? 
              AND won=0";
    $bids = $conn->prepare($query);
    $bids->bind_param("iss", $game_id, $session, $like_date);
}
                    
                    $bids->execute();
                    $resb = $bids->get_result();

                    while ($bid = $resb->fetch_assoc()) {
                        $win = false;
                        if ($bid['game_type'] === 'single_digit' && $bid[$digit_col] == $digit_val) {
    $win = true;
}

if (
    in_array($bid['game_type'], ['single_panna', 'double_panna', 'triple_panna']) &&
    $bid[$panna_col] == $panna_val
) {
    $win = true;
}

if (
    $session === "Close" &&
    $bid['game_type'] === 'jodi_digit' &&
    $bid['open_digit'] . $bid['close_digit'] == $jodi
) {
    $win = true;
}

if (
    $session === "Close" &&
    $bid['game_type'] === 'full_sangam' &&
    $bid['open_panna'] == $open &&
    $bid['close_panna'] == $close
) {
    $win = true;
}

if (
    $session === "Close" &&
    $bid['game_type'] === 'half_sangam' &&
    (
        ($bid['session'] === 'Open' && $bid['open_digit'] == $open_digit && $bid['close_panna'] == $close) ||
        ($bid['session'] === 'Close' && $bid['open_panna'] == $open && $bid['close_digit'] == $close_digit)
    )
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

                           $result_key = $result_id . "M";

$conn->query("INSERT INTO user_trans 
(user_id, points, trans_type, trans_det, trans_status, admin_status, created_at) 
VALUES 
($uid, $earned, 5, '$result_key', 'SUCCESSFULL', 'APPROVED', '$decleared_at')
");

$conn->query("UPDATE bid 
SET win_points = $earned, won = 1, result_id = '$result_key', won_at = '$decleared_at' 
WHERE id = {$bid['id']}");
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
