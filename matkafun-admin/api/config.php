<?php
date_default_timezone_set('Asia/Kolkata');

// ========== DB CONFIG ==========
$servername = "localhost";
$username   = "sql_matkafun_fun";
$password   = "MatkaFun@2025";
$dbname     = "sql_matkafun_fun";

// ========== ONESIGNAL CONFIG ==========
$app_id  = "32163764-747f-40f1-b39c-48f138f76e2f";
$api_key = "os_v2_app_gildozdup5apdm44jdytr53of5j4rf4a4x5e4p4sawqaz4ybb7iyiqmlrxluoztklubdhdenufarce7bipppbc5a3hka626bkwg362q";

// ========== CONNECT ==========
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}
?>
