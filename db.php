<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "encuestaEnergiasRenovables";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


/*
$servername = "db4free.net";
$username = "pruebas4416";
$password = "sistemas";
$dbname = "pruebas4416";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
*/


?>
