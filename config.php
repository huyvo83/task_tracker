<?php

$host       = "localhost";
$db_username   = "root";
$db_password   = "root";
$db_name     = "u3149385"; // will use later
$dsn        = "mysql:host=$host;dbname=$db_name"; // will use later
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );
$connection = new PDO($dsn, $db_username, $db_password, $options);
if($connection === false){
    die("ERROR: Could not connect. " . $connection->connect_error);
}
?>