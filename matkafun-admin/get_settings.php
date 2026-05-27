<?php
include 'db.php';

$q = mysqli_query($conn,
    "SELECT add_coin_bonus_percent FROM app_settings LIMIT 1");

$row = mysqli_fetch_assoc($q);

echo json_encode([
    "status" => "success",
    "add_coin_bonus_percent" => $row['add_coin_bonus_percent']
]);
