<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introducción - Encuesta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../styles/stylesEncuesta.css">
</head>

<body>
    <div class="container mt-2">
        <div class="alert alert-primary" role="alert">
            La realización de esta encuesta tomará aproximadamente <strong>15 minutos</strong>.
            Su progreso se va almacenando conforme cada respuesta sea guardada, por lo cual puede reanudarla en cualquier momento.
            Por favor, asegúrese de terminarla en su totalidad.
        </div>
        <div class="alert alert-info" role="alert">
            A continuación se presentan 17 factores, los cuales deberá relacionar con base en su experiencia y respondiendo a la siguiente premisa:
            <br>
            <strong>¿Qué factor representa una barrera para la implementación de energía renovable en México?</strong>
            <br>
            <div class="alert alert-info" role="alert">
                <h5>Instrucciones:</h5>
                <p>Lea con antención los enunciados que se presentan, y seleccione el que se adapte mejor a su inclinación.
                </p>
                <li> Solo puede seleccionar uno de cada par, el contrario permanecerá en ceros automáticamente.
                    Mueva el control deslizante hasta establecer un porcentaje, el cual va de 0 a 100, para cada uno de los factores presentados.
                </li>
                <li>Una vez hecha su elección, de clic en <strong>Guardar</strong> y posteriormente clic al nuevo plantemiento que desee contestar, marcados en color azul. <br> <strong>¡No podrá modificar su respuesta una vez guardada!</strong></li>
            </div>
            <div class="alert alert-success" role="alert">
                <h5>Ejemplo:</h5>

                    Si usted considera que el <strong>Factor C</strong> incide más que el <strong>Factor F</strong> en la adopción
                    de energía renovable en México, deberá mover el control deslizante de dicho factor hacia la derecha,
                    colocándolo en el valor (de 0 a 100) en cuanto a la medida de la incidencia, en este ejemplo <strong>20%</strong>
                
            </div>
            <img src="../../img/Factoress.png" class="img-fluid shadow-lg rounded" alt="Imagen de ejemplo sobre como responder cada plantemiento">

        </div>
        <div class="alert alert-warning" role="alert">
            Para una mejor experiencia, la encuesta está optimizada para ser respondida desde un entorno de escritorio (PC) o tablet en modo horizontal.
        </div>
        <a href="categoria1.php" class="btn btn-success">Comenzar Encuesta</a>
        <br>
    </div>
    <br>
</body>

</html>