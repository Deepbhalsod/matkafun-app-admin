<?php
date_default_timezone_set('Asia/Kolkata');

// ========== DB CONFIG ==========
$servername = "localhost";
$username   = "sql_matkafun_fun";
$password   = "MatkaFun@2025";
$dbname     = "sql_matkafun_fun";

// ========== ONESIGNAL CONFIG ==========
$app_id  = "24e340cf-5dbf-40cc-8954-b9ea8e502c56";
$api_key = "os_v2_app_etrubt25x5amzckuxhvi4ubmkzfe3ud6l3futh5etbxefaygfxbk63jesdn3jkbabr46mgzsmoszxxaggovdwwyhqtqjyvjy3sdhpqy";

// ========== CONNECT ==========
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}
?>
