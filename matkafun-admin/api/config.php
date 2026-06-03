<?php
date_default_timezone_set('Asia/Kolkata');

// ========== DB CONFIG ==========
$servername = "localhost";
$username   = "sql_matkafun_fun";
$password   = "MatkaFun@2025";
$dbname     = "sql_matkafun_fun";

// ========== ONESIGNAL CONFIG ==========
$app_id  = "073624c4-92c2-4807-80d7-4c1744fa381f";
$api_key = "os_v2_app_a43cjresyjeapagxjqluj6ryd6apkuz42sher5nnau5sgxtarm4lozq7qtw7pbmsx3ca4f7k2wy3dayg6tklibjoh4oz5qotw2ixzey";

// ========== CONNECT ==========
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}
?>
