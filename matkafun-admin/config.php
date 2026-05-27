<?php
// Database connection settings
define('BASEPATH', 'system');
define('APPPATH', 'application/');
require_once 'application/Site_constants.php';

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->query("SET time_zone = '+05:30'");
?>
