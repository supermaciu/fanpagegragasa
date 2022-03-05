<?php

    $server_name = "localhost";
    $database_username = "root";
    $database_password = "";
    $database_name = "fpg_db";
    
    $conn = mysqli_connect($server_name, $database_username,
    $database_password, $database_name);

    if (!$conn) {
        die("Connection failed : " . mysqli_connect_error());
    }

?>