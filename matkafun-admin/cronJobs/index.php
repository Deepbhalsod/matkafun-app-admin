<?php
    $game= $_GET["game"];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://matkagold.com/autoresult/fetchAutoResult/$game");   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 900);
    $content = curl_exec($ch);
    echo $content;
    curl_close($ch); 
?>