<?php

$server = 'localhost:3307';
$username = 'root';
$password = '';
$database = 'facultad';

try {
  $conn =mysqli_connect($server, $username, $password, $database);
} catch (PDOException $variable_error){
    echo "Conexión errónea".$variable_error;
}

/* 
CON PDO

try {
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $variable_error){
    echo "Conexión errónea".$variable_error;
}
*/
?>



