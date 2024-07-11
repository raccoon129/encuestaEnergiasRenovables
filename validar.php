<?php
session_start();
include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM Usuarios WHERE usuario = '$username' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['usuario'] = $row['usuario'];
    $_SESSION['sector'] = $row['sector'];
    $_SESSION['check_respuesta'] = $row['check_respuesta'];

    if ($row['sector'] == 'admon') {
        header("Location: views/panel_administrativo.php");
    } else {
        if ($row['check_respuesta']) {
            header("Location: views/agradecimiento.php");
        } else {
            header("Location: views/encuesta.php");
        }
    }
} else {
    echo "Usuario o contraseña incorrectos.";
}
?>
