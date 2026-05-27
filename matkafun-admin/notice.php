<?php
header('Content-Type: application/json');

// Include global constants
define('BASEPATH', 'system');
define('APPPATH', 'application/');
require_once 'application/Site_constants.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
  die(json_encode(["status"=>"error","message"=>"Database error"]));
}

$sql = "SELECT notice_text FROM app_notice ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  echo json_encode(["status" => "success", "notice" => $row['notice_text']]);
} else {
  echo json_encode(["status" => "error", "message" => "No notice found"]);
}

$conn->close();
?>
