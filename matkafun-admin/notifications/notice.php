<?php
require('config.php'); // adjust path

$message = "";
$status = "";

// Fetch existing notice
$result = $conn->query("SELECT notice_text FROM app_notice WHERE id = 1");
$current_notice = "";
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_notice = $row['notice_text'];
}

// Handle notice update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_notice = trim($_POST['notice_text'] ?? '');

    if ($new_notice !== '') {
        $stmt = $conn->prepare("UPDATE app_notice SET notice_text = ? WHERE id = 1");
        $stmt->bind_param("s", $new_notice);
        if ($stmt->execute()) {
            $status = "success";
            $message = "✅ Notice updated successfully!";
            $current_notice = $new_notice;
        } else {
            $status = "error";
            $message = "❌ Error updating notice.";
        }
    } else {
        $status = "warning";
        $message = "⚠️ Notice text cannot be empty.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Update App Notice</title>
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
      min-height: 120px;
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

    .current {
      margin-top: 30px;
      background: #f8f8ff;
      border: 1px solid #eee;
      border-radius: 12px;
      padding: 15px;
      color: #333;
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
    <h2>📝 Update App Notice</h2>

    <form method="POST">
      <textarea name="notice_text" placeholder="Enter new notice text..."><?= htmlspecialchars($current_notice) ?></textarea>
      <button type="submit">Update Notice</button>
    </form>

    <?php if ($message): ?>
      <div class="alert <?= htmlspecialchars($status) ?>">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <div class="current">
      <strong>📢 Current Notice:</strong><br>
      <?= nl2br(htmlspecialchars($current_notice)) ?>
    </div>
  </div>
</body>
</html>
