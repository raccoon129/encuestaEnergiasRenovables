<?php
// Inicia la sesión
session_start();

// Incluye la configuración de la base de datos
include('../../db.php');

// Verifica si el usuario está autenticado y tiene una encuesta activa
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Actualiza el estado de la respuesta en el usuario
    $sql = "UPDATE Usuario SET check_respuesta = 1 WHERE usuario = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error al preparar la declaración: " . $conn->error;
    }

    // Cierra la conexión
    $conn->close();

    // Destruye la sesión
    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agradecimiento</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .thank-you-container {
            text-align: center;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .thank-you-container h1 {
            margin-bottom: 1rem;
            color: #007bff;
        }
        .thank-you-container p {
            margin-bottom: 1rem;
        }
        .thank-you-container .btn {
            margin-top: 1rem;
        }
    </style>
    <script>
        function finalizarEncuesta() {
            // Abre la página de login en una nueva pestaña
            window.open('../../login.php', '_blank'); 
            // Cierra la pestaña actual
            window.close(); 
        }
    </script>
</head>

<body>
    <div class="thank-you-container">
        <h1>¡Gracias por completar la encuesta!</h1>
        <p>Finalice la encuesta dando clic en el botón a continuación</p>
        <button class="btn btn-primary" onclick="finalizarEncuesta()">Finalizar</button>
    </div>
</body>

</html>
