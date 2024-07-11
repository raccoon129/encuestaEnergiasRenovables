<?php

if (!isset($_SESSION['usuario']) || $_SESSION['sector'] != 'admon') {
    header("Location: ../../login.php");
    exit();
}