<?php
require('config.php'); // adjust path

$message = "";
$status = "";

// Handle new notification send
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $heading = trim($_POST['title'] ?? 'Notification');
    $msg = trim($_POST['message'] ?? '');

    if ($msg !== '') {
        $push_title = $heading; // Clean title for users
        $db_heading = "[ADMIN-ROOT] " . $heading; // Prefixed title for admin
        $ist_time = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO notifications (heading, message, user_id, status, icon, created_date) VALUES (?, ?, 'all', 0, '', ?)");
        $stmt->bind_param("sss", $db_heading, $msg, $ist_time);
        
        if ($stmt->execute()) {
            // ✅ Data inserted into database — now send to OneSignal
            // ✅ Credentials managed centrally in Site_constants.php
            $app_id = ONESIGNAL_APP_ID;
            $api_key = ONESIGNAL_REST_API_KEY;

            $fields = [
                'app_id' => $app_id,
                'included_segments' => ['All'], // send to all users
                'headings' => ["en" => $push_title], // ✅ CLEAN title for users
                'contents' => ["en" => $msg],
                'large_icon' => SITE_URL . 'assets/img/logo.png',
                'data' => [
                    'notification_type' => 'ROOT_MANUAL_SEND',
                    'admin_type' => 'ADMIN-ROOT' // Optional internal classification
                ]
            ];

            $ch = curl_init(ONESIGNAL_API_URL);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json; charset=utf-8',
                "Authorization: Key $api_key"
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            
            $response = curl_exec($ch);
            curl_close($ch);

            $status = "success";
            $message = "✅ Notification sent successfully to all users!";
        } else {
            $status = "error";
            $message = "❌ Error saving notification: " . $conn->error;
        }
    } else {
        $status = "warning";
        $message = "⚠️ Message cannot be empty.";
    }
}

// Handle delete notification
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM notifications WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch notification history
$result = $conn->query("SELECT id, heading, message, created_date FROM notifications ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manage Notifications</title>
  <style>
    :root {
      --primary: #667eea;
      --secondary: #764ba2;
      --danger: #e74c3c;
    }

    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      display: flex;
      align-items: flex-start;
      justify-content: center;
      min-height: 100vh;
      margin: 0;
      padding: 30px 10px;
    }

    .container {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      width: 90%;
      max-width: 700px;
      padding: 25px;
      animation: fadeIn 0.6s ease-in-out;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    textarea {
      width: 100%;
      padding: 12px;
      border-radius: 10px;
      border: 1px solid #ccc;
      font-size: 15px;
      resize: none;
      outline: none;
      transition: border 0.3s ease, box-shadow 0.3s ease;
    }

    textarea:focus {
      border-color: var(--primary);
      box-shadow: 0 0 5px rgba(102, 126, 234, 0.4);
    }

    button {
      align-self: center;
      padding: 12px 30px;
      background: linear-gradient(90deg, var(--primary), var(--secondary));
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(102, 126, 234, 0.4);
    }

    .alert {
      margin-top: 15px;
      padding: 10px;
      border-radius: 8px;
      font-weight: 500;
      text-align: center;
    }

    .success { background: #e7f9ee; color: #1a7f37; }
    .error { background: #fde8e8; color: #c0392b; }
    .warning { background: #fff4e5; color: #b36b00; }

    .history {
      margin-top: 30px;
    }

    .notification {
      background: #f8f8ff;
      border: 1px solid #eee;
      border-radius: 12px;
      padding: 15px;
      margin-bottom: 12px;
      position: relative;
      transition: all 0.3s ease;
    }

    .notification:hover {
      background: #f1f3ff;
    }

    .heading {
      font-weight: 600;
      font-size: 15px;
      color: #333;
    }

    .message {
      font-size: 14px;
      color: #555;
      margin-top: 5px;
    }

    .timestamp {
      font-size: 12px;
      color: #777;
      margin-top: 8px;
    }

    .delete-btn {
      position: absolute;
      top: 10px;
      right: 12px;
      background: none;
      border: none;
      color: var(--danger);
      font-size: 18px;
      cursor: pointer;
      transition: 0.3s;
    }

    .delete-btn:hover {
      color: #ff2e2e;
      transform: scale(1.1);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 500px) {
      .container {
        padding: 20px 15px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>📢 Manage Notifications</h2>

    <form method="POST">
      <input type="text" name="title" placeholder="Enter notification title (e.g. Welcome)" style="width:100%; padding: 12px; border-radius: 10px; border: 1px solid #ccc; margin-bottom: 10px;">
      <textarea name="message" rows="4" placeholder="Enter notification message..."></textarea>
      <button type="submit">Send Notification</button>
    </form>

    <?php if ($message): ?>
      <div class="alert <?= htmlspecialchars($status) ?>">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <div class="history">
      <h3 style="text-align:center;margin-bottom:10px;">🕒 Notification History</h3>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="notification">
            <button class="delete-btn" onclick="if(confirm('Delete this notification?')) location.href='?delete=<?= $row['id'] ?>'">✖</button>
            <div class="heading"><?= htmlspecialchars($row['heading'] ?: '(No Heading)') ?></div>
            <div class="message"><?= htmlspecialchars($row['message']) ?></div>
            <div class="timestamp"><?= htmlspecialchars($row['created_date']) ?></div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p style="text-align:center;color:#666;">No notifications found.</p>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
