<?php 
    $host ="localhost";
    $user ="root";
    $password ="";
    $dbname ="ecommerce";

    $conn = new mysqli($host,$user,$password,$dbname);

    if(!$conn) {
        die("connection failed" . $conn->connect_error());
    }
?>