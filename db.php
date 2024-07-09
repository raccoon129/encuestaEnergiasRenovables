<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "encuestasEnergiasRenovables";

$conn = new mysqli($servername, $username, $password, $dbname);


echo 'conectado';


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
