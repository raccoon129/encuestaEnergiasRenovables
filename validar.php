<?php
session_start();
include 'db.php';

function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);

    // Consulta para obtener los detalles del usuario
    $sql = "SELECT u.id_usuario, u.password, s.nombre_sector, u.check_respuesta
            FROM Usuario u
            JOIN Sector s ON u.id_sector = s.id_sector
            WHERE u.usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verificación de la contraseña
        if ($password === $row['password']) { // Comparación directa, queda pendiente hashear
            $_SESSION['username'] = $username;
            $_SESSION['id_usuario'] = $row['id_usuario'];
            $_SESSION['sector'] = $row['nombre_sector'];
            $_SESSION['check_respuesta'] = $row['check_respuesta']; // Añade esto para check_respuesta

            if ($row['nombre_sector'] === 'admon') {
                header("Location: views/panel_administrativo.php");
                exit();
            } else {
                if ($row['check_respuesta']) {
                    header("Location: views/agradecimiento.php");
                    
                } else {
                    header("Location: views/encuesta.php");
                }
                exit();
            }
        } else {
            $_SESSION['error'] = "Contraseña incorrecta";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Usuario no encontrado";
        header("Location: login.php");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
