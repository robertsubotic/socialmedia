<?php    
    session_start();

    $server_name = "localhost";
    $db_username = "root";
    $db_password = "";
    $database_name = "user-socialmedia";

    $connection = mysqli_connect($server_name, $db_username, $db_password, $database_name);

    if (!$connection) die("Error on connection to the database.");
?>