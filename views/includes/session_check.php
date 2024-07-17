<?php
session_start();

// Verifica si la sesión está iniciada
if (!isset($_SESSION['username']) || !isset($_SESSION['sector'])) {
    header("Location: broken.php");
    exit();
}

function check_access($required_sector) {
    if ($_SESSION['sector'] !== $required_sector) {
        header("Location: broken.php");
        exit();
    }
}
?>
