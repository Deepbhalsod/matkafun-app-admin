<?php
define('BASEPATH', 'system');
define('APPPATH', 'application/');
require_once 'application/Site_constants.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= SITE_NAME ?> Delete Account / Data Request</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f8;
    margin: 0;
    padding: 0;
}
.container {
    max-width: 420px;
    margin: 80px auto;
    background: #ffffff;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
h2 {
    text-align: center;
    color: #333;
}
p {
    font-size: 14px;
    color: #555;
    line-height: 1.6;
}
.email-box {
    background: #f1f1f1;
    padding: 12px;
    border-radius: 5px;
    margin: 15px 0;
    text-align: center;
    font-weight: bold;
}
button {
    width: 100%;
    padding: 12px;
    background: #007bff;
    border: none;
    color: #fff;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
}
button:hover {
    background: #0056b3;
}
.footer {
    text-align: center;
    font-size: 12px;
    color: #777;
    margin-top: 15px;
}
</style>
</head>

<body>

<div class="container">
    <h2>Delete Account / Data</h2>

    <p>
        If you want to delete your account or personal data associated with our app,
        please send an email request from your registered email ID.
    </p>

    <p><strong>Include the following details in your email:</strong></p>
    <ul>
        <li>Registered Mobile Number</li>
        <li>Reason for data deletion (optional)</li>
    </ul>

    <div class="email-box">
       support@<?= strtolower(SITE_NAME) ?>.com
    </div>

    <button onclick="sendEmail()">Send Email</button>

    <div class="footer">
        Your data will be deleted within 7 working days.
    </div>
</div>

<script>
function sendEmail() {
    window.location.href = "mailto:support@<?= strtolower(SITE_NAME) ?>.com?subject=Delete Account / Data Request&body=Registered Mobile Number:%0D%0AReason:";
}
</script>

</body>
</html>
