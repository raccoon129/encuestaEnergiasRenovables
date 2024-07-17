<?php
session_start();
//Pendiente


// Verifica si la sesión está iniciada
if (!isset($_SESSION['username']) || !isset($_SESSION['sector'])) {
    header("Location: ../broken.php");
    exit();
}

// Verifica si el usuario ha completado la encuesta
if ($_SESSION['check_respuesta'] == 0) {
    header("Location: ../broken.php");
    exit();
}
?>
