<?php
session_start();
//if (!isset($_SESSION['usuario']) || $_SESSION['sector'] == 'admon') {
  //  header("Location: login.php");
  //  exit();
//}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta - Energías Renovables</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>

<div class="container">
    <h1>Encuesta - Energías Renovables</h1>
    <form action="guardar_encuesta.php" method="POST">
        <!-- Ejemplo de pregunta -->
        <div class="form-group">
            <label>¿Qué factor representa una barrera para la implementación de energía renovable en México?</label>
            <div class="row">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Factor A</h5>
                            <p class="card-text">Falta de redes de transmisión eléctrica en zonas con potencial de producción de energías renovables.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 text-center align-self-center">
                    <strong>VS</strong>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Factor B</h5>
                            <p class="card-text">Falta de personal formado en el desarrollo e implantación de proyectos de energías renovables.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="range" class="form-control-range" min="0" max="100" value="50" id="factorRange" name="factorRange">
                <div class="d-flex justify-content-between">
                    <span>Factor A</span>
                    <span>Factor B</span>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Respuesta</button>
    </form>
</div>

</body>
</html>
