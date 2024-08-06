<?php
session_start();
include 'db.php';

// Verificar si hay usuarios en la tabla usuario
$sql_check_users = "SELECT COUNT(*) as count FROM Usuario";
$result_check_users = $conn->query($sql_check_users);

// Verificar si la consulta tuvo éxito
if ($result_check_users) {
    $row_check_users = $result_check_users->fetch_assoc();
    $user_count = $row_check_users['count'];

    if ($user_count == 0) {
        // Generar una contraseña aleatoria
        function generarContraseñaAleatoria($longitud = 10) {
            $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $longitudCaracteres = strlen($caracteres);
            $contraseñaAleatoria = '';
            for ($i = 0; $i < $longitud; $i++) {
                $contraseñaAleatoria .= $caracteres[rand(0, $longitudCaracteres - 1)];
            }
            return $contraseñaAleatoria;
        }

        $usuario = 'Master';
        $contraseñaAleatoria = generarContraseñaAleatoria();
        $contraseñaCifrada = password_hash($contraseñaAleatoria, PASSWORD_BCRYPT);

        // Insertar el sector admon si no existe
        $sql_check_sector = "SELECT id_sector FROM Sector WHERE nombre_sector = 'admon'";
        $result_check_sector = $conn->query($sql_check_sector);
        if ($result_check_sector->num_rows == 0) {
            $sql_insert_sector = "INSERT INTO Sector (nombre_sector) VALUES ('admon')";
            $conn->query($sql_insert_sector);
            $id_sector = $conn->insert_id;
        } else {
            $row_check_sector = $result_check_sector->fetch_assoc();
            $id_sector = $row_check_sector['id_sector'];
        }

        // Insertar el usuario Master en la tabla usuario
        $sql_insert_user = "INSERT INTO Usuario (usuario, password, id_sector) VALUES ('$usuario', '$contraseñaCifrada', '$id_sector')";
        if ($conn->query($sql_insert_user) === TRUE) {
            $usuarioCreado = true;
        } else {
            $usuarioCreado = false;
            $mensajeError = "Error al crear el usuario: " . $conn->error;
        }
    } else {
        $usuarioCreado = false;
    }
} else {
    die("Error en la consulta SQL: " . $conn->error);
}

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['username']) && isset($_SESSION['sector']) && isset($_SESSION['check_respuesta'])) {
    $username = $_SESSION['username'];
    $sector = $_SESSION['sector'];
    $check_respuesta = $_SESSION['check_respuesta'];

    // Redirigir según el estado de check_respuesta y sector
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
        // Si ninguna condición anterior se cumple, destruir la sesión y redirigir al login
        session_destroy();
        header("Location: login.php");
        exit();
    }
} else {
    // Si no hay sesión iniciada
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Instalación de Encuesta</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5">
            <h1 class="text-center">Instalación de Encuesta para Evaluar las Barreras de la Adopción de Energía Renovable en México</h1>
            <div class="mt-4">
                <?php
                if ($usuarioCreado) {
                    echo '<div class="alert alert-success" role="alert">';
                    echo '<h2 class="alert-heading">Usuario Master creado exitosamente</h2>';
                    echo '<p>Usuario: ' . $usuario . '</p>';
                    echo '<p>Contraseña: ' . $contraseñaAleatoria . '</p>';
                    echo '<hr>';
                    echo '<button class="btn btn-primary" onclick="location.href=\'login.php\'">Continuar</button>';
                    echo '</div>';
                } elseif ($usuarioCreado === false && isset($mensajeError)) {
                    echo '<div class="alert alert-danger" role="alert">';
                    echo '<h2 class="alert-heading">Error</h2>';
                    echo '<p>' . $mensajeError . '</p>';
                    echo '</div>';
                } elseif (isset($_GET['desarrollo']) && $_GET['desarrollo'] == 'true') {
                    // Modo de desarrollo: mostrar contenido incluso si ya existen cuentas
                    echo '<div class="alert alert-info" role="alert">';
                    echo '<h2 class="alert-heading">Modo de Desarrollo Activado</h2>';
                    echo '<p>Este es el aspecto de la página de instalación cuando no hay cuentas de usuario creadas.</p>';
                    echo '<button class="btn btn-primary" onclick="location.href=\'login.php\'">Continuar</button>';
                    echo '</div>';
                } else {
                    // Si no hay sesión iniciada y no es la primera vez, redirigir al login
                    header("Location: login.php");
                    exit();
                }
                ?>
            </div>
        </div>
    </body>
    </html>
    <?php
}
?>
