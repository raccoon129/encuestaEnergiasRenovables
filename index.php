<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
} else {
    if ($_SESSION['sector'] == 'admon') {
        header("Location: panel_administrativo.php");
    } else {
        if ($_SESSION['check_respuesta']) {
            header("Location: views/agradecimiento.php");
        } else {
            header("Location: views/encuesta.php");
        }
    }
}
?>
