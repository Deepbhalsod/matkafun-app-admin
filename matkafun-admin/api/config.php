<?php
date_default_timezone_set('Asia/Kolkata');

// ========== DB CONFIG ==========
$servername = "localhost";
$username   = "sql_matkafun_fun";
$password   = "MatkaFun@2025";
$dbname     = "sql_matkafun_fun";

// ========== ONESIGNAL CONFIG ==========
$app_id  = "073624c4-92c2-4807-80d7-4c1744fa381f";
$api_key = "os_v2_app_a43cjresyjeapagxjqluj6ryd7ipkx43tmtu3hfeeqnirxpcpmkza5dkbo5qsxtdpxe6j554w3safw556y5r3lm7qdx4y4vnbfbqm6i";

// ========== CONNECT ==========
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}
?>
