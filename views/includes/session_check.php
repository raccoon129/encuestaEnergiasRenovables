<?php
session_start();

// Verifica si la sesión está iniciada
if (!isset($_SESSION['username']) || !isset($_SESSION['sector'])) {
    header("Location: broken.php");
    exit();
}

function check_access($allowed_sectors) {
    if (!in_array($_SESSION['sector'], $allowed_sectors)) {
        header("Location: broken.php");
        exit();
    }
}
?>
