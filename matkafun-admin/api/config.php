<?php
date_default_timezone_set('Asia/Kolkata');

// ========== DB CONFIG ==========
$servername = "localhost";
$username   = "u472706178_matkafun";
$password   = "MatkaFun@2025";
$dbname     = "u472706178_matkafun";

// ========== ONESIGNAL CONFIG ==========
$app_id  = "24e340cf-5dbf-40cc-8954-b9ea8e502c56";
$api_key = "os_v2_app_etrubt25x5amzckuxhvi4ubmkywx4d5aceeuw7nekqfmc7bqpxip6pxfmibknr4ltwtvd2nl5ilirnjtgc6ipa4hgtacb2wy7zsed2a";

// ========== CONNECT ==========
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}
?>
