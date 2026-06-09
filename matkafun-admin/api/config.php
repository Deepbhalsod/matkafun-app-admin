<?php
date_default_timezone_set('Asia/Kolkata');

// ========== DB CONFIG ==========
$servername = "localhost";
$username   = "u951306038_matkafun";
$password   = "MatkaFun@2025";
$dbname     = "u951306038_matkafun";

// ========== ONESIGNAL CONFIG ==========
$app_id  = "32163764-747f-40f1-b39c-48f138f76e2f";
$api_key = "os_v2_app_gildozdup5apdm44jdytr53of4rmg4fd4hle6gu6umu4cahiqo4fmyo4c3tz6kkq5pju3no54i7sdbny6wr3aljq5b6dyqdc47dkkeq";

// ========== CONNECT ==========
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}
?>
