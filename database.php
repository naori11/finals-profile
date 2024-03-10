<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = 'profile_login';

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection to database failed: " . $conn->connect_error);
    }

?>