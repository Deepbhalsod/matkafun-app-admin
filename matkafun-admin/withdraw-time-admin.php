<?php
/************ DATABASE CONFIG ************/
define('BASEPATH', 'system');
define('APPPATH', 'application/');
require_once 'application/Site_constants.php';

/************ DB CONNECTION ************/
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Database connection failed");
}

/************ UPDATE LOGIC ************/
$msg = "";
if (isset($_POST['update'])) {

    $open_time  = $_POST['withdraw_open_time'];
    $close_time = $_POST['withdraw_close_time'];

    // 24-hour format validation
    $time_pattern = '/^(2[0-3]|[01]?[0-9]):[0-5][0-9](:[0-5][0-9])?$/';

    if (!preg_match($time_pattern, $open_time) || !preg_match($time_pattern, $close_time)) {
        $msg = "❌ Invalid 24-hour time format";
    } else {

        $stmt = $conn->prepare("
            UPDATE account_details 
            SET withdraw_open_time = ?, withdraw_close_time = ?
            WHERE id = 1
        ");
        $stmt->bind_param("ss", $open_time, $close_time);

        if ($stmt->execute()) {
            $msg = "✅ Withdraw time updated successfully";
        } else {
            $msg = "❌ Update failed";
        }
    }
}

/************ FETCH CURRENT TIME ************/
$data = $conn->query("
    SELECT withdraw_open_time, withdraw_close_time 
    FROM account_details 
    WHERE id = 1
")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Withdraw Time Admin</title>
    <style>
        body { font-family: Arial; background:#f5f5f5; }
        .box {
            width: 350px;
            margin: 80px auto;
            background: #fff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
        }
        label { font-weight: bold; display:block; margin-top:10px; }
        input[type=time] {
            width: 100%;
            padding: 6px;
            margin-top: 5px;
        }
        button {
            margin-top: 15px;
            width: 100%;
            padding: 8px;
            background: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .msg {
            text-align: center;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="box">
    <h3 style="text-align:center;">Withdraw Time Settings</h3>

    <?php if($msg) echo "<div class='msg'>$msg</div>"; ?>

    <form method="post">
        <label>Withdraw Open Time (24 Hour)</label>
        <input type="time" name="withdraw_open_time" 
               value="<?= $data['withdraw_open_time']; ?>" required>

        <label>Withdraw Close Time (24 Hour)</label>
        <input type="time" name="withdraw_close_time" 
               value="<?= $data['withdraw_close_time']; ?>" required>

        <button type="submit" name="update">Update Time</button>
    </form>
</div>

</body>
</html>
