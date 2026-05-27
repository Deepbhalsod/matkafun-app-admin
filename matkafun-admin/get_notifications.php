<?php
require('config.php');
header('Content-Type: application/json');

// Using SELECT * to ensure all columns (heading, message, created_date) are included
$result = $conn->query("SELECT * FROM notifications WHERE created_date >= (NOW() - INTERVAL 1 DAY) ORDER BY id DESC LIMIT 200");
$notices = [];

$prefixes = ['[MANUAL] ', '[ADMIN] ', '[ADMIN-ROOT] ', '[AUTO-ROOT] ', '[GALI] ', '[AUTO-API] '];

while ($row = $result->fetch_assoc()) {
    $clean_heading = $row['heading'];
    foreach ($prefixes as $prefix) {
        if (stripos($clean_heading, $prefix) === 0) {
            $clean_heading = substr($clean_heading, strlen($prefix));
            break;
        }
    }
    
    // We add both 'heading' and 'title' keys for compatibility with the app
    $row['heading'] = $clean_heading;
    $row['title'] = $clean_heading;
    $row['time'] = $row['created_date'];
    $notices[] = $row;
}

echo json_encode($notices, JSON_UNESCAPED_UNICODE);
?>
