<?php
//Este archivo verifica si hay una sesión activa
// Y redirige al panel adecuado ya sea encuestado
// o administrador.
session_start();
include 'db.php';

// Verifica si el usuario ha iniciado sesión
if (isset($_SESSION['username']) && isset($_SESSION['sector']) && isset($_SESSION['check_respuesta'])) {
    $username = $_SESSION['username'];
    $sector = $_SESSION['sector'];
    $check_respuesta = $_SESSION['check_respuesta'];

    // Redirige según el estado de check_respuesta y sector
    if ($sector === 'admon') {
        header("Location: views/panel_administrativo.php");
        exit();
    } elseif ($check_respuesta == 1) {
        header("Location: views/agradecimiento.php");
        exit();
    } elseif ($check_respuesta == 0) {
        header("Location: views/encuesta.php");
        exit();
    } else {
        // Si ninguna condición anterior se cumple, destruye la sesión y redirige al login
        session_destroy();
        header("Location: login.php");
        exit();
    }
} else {
    // Si no hay sesión iniciada, redirige al login
    header("Location: login.php");
    exit();
}
?>
?>
