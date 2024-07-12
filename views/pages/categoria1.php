<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit();
}
include '../../db.php';

// Obtener los factores desde la base de datos
$sql = "SELECT id_factor, nombre_factor, contenido_factor FROM Factor WHERE id_factor BETWEEN 1 AND 18";
$result = $conn->query($sql);
$factores = [];
while ($row = $result->fetch_assoc()) {
    $factores[$row['id_factor']] = $row;
}

// Definir los pares de factores
$pares = [
    [1, 2], [1, 3], [1, 4], [1, 5], [1, 6], [1, 7], [1, 8], [1, 9], [1, 10], [1, 11],
    [1, 12], [1, 13], [1, 14], [1, 15], [1, 16], [1, 17], [1, 18]
];

// Obtener las respuestas guardadas del usuario
$id_usuario = $_SESSION['id_usuario'];
$sql_respuestas = "SELECT id_factor_1, id_factor_2, porcentaje_incidencia, factor_dominante FROM Respuesta WHERE id_encuesta IN (SELECT id_encuesta FROM Encuesta WHERE id_usuario = $id_usuario)";
$result_respuestas = $conn->query($sql_respuestas);
$respuestas = [];
while ($row_respuestas = $result_respuestas->fetch_assoc()) {
    $respuestas[$row_respuestas['id_factor_1'] . '-' . $row_respuestas['id_factor_2']] = $row_respuestas;
}

// Contar la cantidad total de pares contestados
$total_pares = count($pares);
$pares_contestados = count($respuestas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Red Conexión A - Encuesta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <style>
        .highlight {
            border: 2px solid #007bff;
        }

        .completed {
            background-color: #d4edda;
        }

        .disabled-range {
            pointer-events: none;
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Red Conexión A - Encuesta</h2>
        <div class="accordion" id="accordionFactors">
            <?php
            foreach ($pares as $index => $par) {
                $factor1 = $factores[$par[0]];
                $factor2 = $factores[$par[1]];
                $collapseId = 'collapse' . $index;
                $headingId = 'heading' . $index;

                $respuesta_guardada = isset($respuestas[$par[0] . '-' . $par[1]]);
                $porcentaje_guardado_1 = $respuesta_guardada ? ($respuestas[$par[0] . '-' . $par[1]]['factor_dominante'] == $par[0] ? $respuestas[$par[0] . '-' . $par[1]]['porcentaje_incidencia'] : 0) : 0;
                $porcentaje_guardado_2 = $respuesta_guardada ? ($respuestas[$par[0] . '-' . $par[1]]['factor_dominante'] == $par[1] ? $respuestas[$par[0] . '-' . $par[1]]['porcentaje_incidencia'] : 0) : 0;
                $disabled_class = $respuesta_guardada ? 'disabled-range' : '';
                $completed_class = $respuesta_guardada ? 'completed' : '';
            ?>
                <div class="card <?php echo $completed_class; ?>" id="card-<?php echo $index; ?>">
                    <div class="card-header" id="<?php echo $headingId; ?>">
                        <h5 class="mb-0">
                            <button class="btn btn-link <?php echo $index > 0 ? 'collapsed' : ''; ?>" type="button" data-toggle="collapse" data-target="#<?php echo $collapseId; ?>" aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>" aria-controls="<?php echo $collapseId; ?>">
                                <?php echo $factor1['nombre_factor'] . ' vs ' . $factor2['nombre_factor']; ?>
                            </button>
                        </h5>
                    </div>

                    <div id="<?php echo $collapseId; ?>" class="collapse <?php echo $index === 0 ? 'show' : ''; ?>" aria-labelledby="<?php echo $headingId; ?>" data-parent="#accordionFactors">
                        <div class="card-body">
                            <form action="../includes/guardar_respuesta.php" method="POST" class="save-form" id="form-<?php echo $index; ?>">
                                <input type="hidden" name="id_factor_1" value="<?php echo $factor1['id_factor']; ?>">
                                <input type="hidden" name="id_factor_2" value="<?php echo $factor2['id_factor']; ?>">
                                <input type="hidden" name="id_categoria" value="1"> <!-- Cambia este valor según la categoría -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $factor1['nombre_factor']; ?></h5>
                                                <p class="card-text"><?php echo $factor1['contenido_factor']; ?></p>
                                            </div>
                                            <div class="card-footer">
                                                <input type="range" class="form-control-range factor-range <?php echo $disabled_class; ?>" id="factor-<?php echo $index; ?>-1" name="porcentaje1" min="0" max="100" value="<?php echo $porcentaje_guardado_1; ?>" <?php echo $respuesta_guardada ? 'disabled' : ''; ?> oninput="updateRange(this, <?php echo $index; ?>, 1)">
                                                <output><?php echo $porcentaje_guardado_1; ?></output>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $factor2['nombre_factor']; ?></h5>
                                                <p class="card-text"><?php echo $factor2['contenido_factor']; ?></p>
                                            </div>
                                            <div class="card-footer">
                                                <input type="range" class="form-control-range factor-range <?php echo $disabled_class; ?>" id="factor-<?php echo $index; ?>-2" name="porcentaje2" min="0" max="100" value="<?php echo $porcentaje_guardado_2; ?>" <?php echo $respuesta_guardada ? 'disabled' : ''; ?> oninput="updateRange(this, <?php echo $index; ?>, 2)">
                                                <output><?php echo $porcentaje_guardado_2; ?></output>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" <?php echo $respuesta_guardada ? 'disabled' : ''; ?>>Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="text-center mt-4">
            <button id="continueBtn" class="btn btn-success" style="display: none;" onclick="location.href='categoria2.php';">Continuar a la siguiente página</button>
        </div>
    </div>

    <!-- Footer con el progreso -->
    <footer class="footer mt-auto py-3">
        <div class="container">
            <span class="text-muted">Progreso: <span id="progressPercentage"></span>%</span>
        </div>
    </footer>

    <?php include '../includes/footer.php'; ?>

    <script>
        // Función para actualizar los ranges
        function updateRange(element, pairIndex, factorIndex) {
            var oppositeFactorIndex = factorIndex === 1 ? 2 : 1;
            var oppositeRange = document.getElementById('factor-' + pairIndex + '-' + oppositeFactorIndex);
            var currentRange = element;

            // Si el range actual se mueve, el opuesto se pone a cero
            if (currentRange.value > 0) {
                oppositeRange.value = 0;
            }

            // Actualizar los valores de salida
            currentRange.nextElementSibling.value = currentRange.value;
            oppositeRange.nextElementSibling.value = oppositeRange.value;
        }

        $(document).ready(function() {
            $('.save-form').on('submit', function(event) {
                event.preventDefault();
                var $form = $(this);
                $.ajax({
                    type: $form.attr('method'),
                    url: $form.attr('action'),
                    data: $form.serialize(),
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            toastr.success('Respuesta guardada con éxito');

                            // Deshabilitar los elementos del formulario
                            $form.find('input[type=range]').addClass('disabled-range').prop('disabled', true);
                            $form.find('button[type=submit]').text('Guardado').addClass('btn-success').prop('disabled', true);
                            $form.closest('.card').addClass('completed');

                            // Contraer el acordeón actual y abrir el siguiente
                            var $currentCard = $form.closest('.collapse');
                            var $nextCard = $currentCard.closest('.card').next('.card').find('.collapse');

                            if ($nextCard.length > 0) {
                                $currentCard.collapse('hide');
                                $nextCard.collapse('show');
                            } else {
                                // Mostrar el botón de continuar si no hay más pares
                                $('#continueBtn').show();
                            }

                            // Actualizar el progreso
                            updateProgress();
                        } else {
                            toastr.error('Error: ' + result.message);
                        }
                    },
                    error: function() {
                        toastr.error('Error al guardar la respuesta');
                    }
                });
            });

            // Inicializar el progreso
            updateProgress();
        });

        // Función para actualizar el progreso
        function updateProgress() {
            var totalCards = <?php echo $total_pares; ?>;
            var completedCards = $('.card.completed').length;
            var progressPercentage = Math.round((completedCards / totalCards) * 100);

            $('#progressPercentage').text(progressPercentage);

            if (completedCards === totalCards) {
                $('#continueBtn').show();
            }
        }
    </script>
</body>
</html>