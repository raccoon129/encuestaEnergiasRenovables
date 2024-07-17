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
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $factores[$row['id_factor']] = $row;
    }
} else {
    // Manejo de error si no hay factores
    die("Error al obtener los factores.");
}

// Definir los pares de factores
$pares = [
    [5, 6], [5, 7], [5, 8], [5, 9], [5, 10], [5, 11],
    [5, 12], [5, 13], [5, 14], [5, 15], [5, 16], [5, 17], [5, 18]
];

// Obtener las respuestas guardadas del usuario
$id_usuario = $_SESSION['id_usuario'];
$sql_respuestas = "SELECT id_factor_1, id_factor_2, porcentaje_incidencia, factor_dominante FROM Respuesta WHERE id_encuesta IN (SELECT id_encuesta FROM Encuesta WHERE id_usuario = $id_usuario)";
$result_respuestas = $conn->query($sql_respuestas);
$respuestas = [];
if ($result_respuestas && $result_respuestas->num_rows > 0) {
    while ($row_respuestas = $result_respuestas->fetch_assoc()) {
        $respuestas[$row_respuestas['id_factor_1'] . '-' . $row_respuestas['id_factor_2']] = $row_respuestas;
    }
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
    <title>Encuesta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="../../styles/stylesCategoriasEncuesta.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Categoría 5 - Costo de prod E</h2>
        <br>
        <div class="alert alert-primary" role="alert">
            ¿Qué factor representa una barrera para la implementación de energía renovable en México? <br>
            Seleccione el control deslizante relacionado al factor de su preferencia y desplacelo de acuerdo
            a su inclinación. Puede elegir solo uno por cada par.
        </div>
        <div class="accordion" id="accordionFactors">
            <?php if (!empty($pares)) : ?>
                <?php foreach ($pares as $index => $par) : ?>
                    <?php
                    $factor1 = $factores[$par[0]];
                    $factor2 = $factores[$par[1]];
                    $collapseId = 'collapse' . $index;
                    $headingId = 'heading' . $index;

                    $respuesta_guardada = isset($respuestas[$par[0] . '-' . $par[1]]);
                    $porcentaje_guardado_1 = $respuesta_guardada ? ($respuestas[$par[0] . '-' . $par[1]]['factor_dominante'] == $par[0] ? $respuestas[$par[0] . '-' . $par[1]]['porcentaje_incidencia'] : 0) : 0;
                    $porcentaje_guardado_2 = $respuesta_guardada ? ($respuestas[$par[0] . '-' . $par[1]]['factor_dominante'] == $par[1] ? $respuestas[$par[0] . '-' . $par[1]]['porcentaje_incidencia'] : 0) : 0;
                    $disabled_class = $respuesta_guardada ? 'disabled-range' : '';
                    $completed_class = $respuesta_guardada ? 'completed' : '';
                    $button_text = $respuesta_guardada ? 'Respondido' : 'Guardar';
                    $button_class = $respuesta_guardada ? 'btn-respondido' : 'btn-primary';
                    ?>
                    <div class="card <?php echo $completed_class; ?>" id="card-<?php echo $index; ?>">
                        <div class="card-header" id="<?php echo $headingId; ?>">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#<?php echo $collapseId; ?>" aria-expanded="false" aria-controls="<?php echo $collapseId; ?>">
                                    <?php echo $factor1['nombre_factor'] . ' vs ' . $factor2['nombre_factor']; ?>
                                </button>
                            </h5>
                        </div>

                        <div id="<?php echo $collapseId; ?>" class="collapse" aria-labelledby="<?php echo $headingId; ?>" data-parent="#accordionFactors">
                            <div class="card-body">
                                <form action="../includes/guardar_respuesta.php" method="POST" class="save-form" id="form-<?php echo $index; ?>">
                                    <input type="hidden" name="id_factor_1" value="<?php echo $factor1['id_factor']; ?>">
                                    <input type="hidden" name="id_factor_2" value="<?php echo $factor2['id_factor']; ?>">
                                    <input type="hidden" name="id_categoria" value="5"> <!-- Cambia este valor según la categoría -->
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
                                    <button type="submit" class="btn <?php echo $button_class; ?>" <?php echo $respuesta_guardada ? 'disabled' : ''; ?>><?php echo $button_text; ?></button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No hay pares de factores definidos.</p>
            <?php endif; ?>
        </div>
        <div class="text-center mt-4">
            <button id="continueBtn" class="btn btn-success" style="display: none;" onclick="location.href='categoria6.php';">Continuar a la siguiente página</button>
        </div>
        <div class="text-center mt-4">
            <p>Progreso: <span id="progressPercentage">0</span>%</p>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <br>
        </div>
    </div>

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
            validateSaveButton(pairIndex);
        }

                // Función para verificar si todos los pares han sido contestados
                function verificarRespuestas() {
            var pares = <?php echo json_encode($pares); ?>;
            var respuestas = <?php echo json_encode($respuestas); ?>;
            var totalPares = pares.length;
            var paresContestados = Object.keys(respuestas).length;

            var progressPercentage = (paresContestados / totalPares) * 100;
            document.getElementById('progressPercentage').innerText = progressPercentage.toFixed(0);
            document.querySelector('.progress-bar').style.width = progressPercentage + '%';

            if (paresContestados === totalPares) {
                document.getElementById('continueBtn').style.display = 'block';
            } else {
                document.getElementById('continueBtn').style.display = 'none';
            }
        }

        // Inicializar progreso y botón continuar al cargar la página
        $(document).ready(function() {
            verificarRespuestas();
        });

        // Función para validar y habilitar/deshabilitar el botón de guardar
        function validateSaveButton(pairIndex) {
            var range1 = document.getElementById('factor-' + pairIndex + '-1');
            var range2 = document.getElementById('factor-' + pairIndex + '-2');
            var saveButton = document.querySelector('#form-' + pairIndex + ' .btn-primary');

            if (saveButton) { // Asegúrate de que saveButton no sea null
                if (range1.value === '0' && range2.value === '0') {
                    saveButton.disabled = true;
                } else {
                    saveButton.disabled = false;
                }
            }
        }

        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

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
                            $form.find('button[type=submit]').text('Respondido').addClass('btn-respondido').prop('disabled', true);
                            $form.closest('.card').addClass('completed');

                            // Contraer el acordeón actual y abrir el siguiente
                            var $currentCard = $form.closest('.collapse');
                            var $nextCard = $currentCard.closest('.card').next('.card').find('.collapse');

                            if ($nextCard.length > 0) {
                                $currentCard.collapse('hide');
                                $nextCard.collapse('show');
                            } else {
                                // Mostrar el botón de continuar si no hay más pares


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

            <?php foreach ($pares as $index => $par) : ?>
                validateSaveButton(<?php echo $index; ?>);
            <?php endforeach; ?>

            // Inicializar el progreso
            updateProgress();

            // Abrir el último acordeón no respondido
            var $lastIncompleteCard = $('.card').not('.completed').first();
            if ($lastIncompleteCard.length) {
                $lastIncompleteCard.find('.collapse').collapse('show');
            } else {
                $('#continueBtn').show();
                $('#continueBtn').trigger('click');
            }
        });

        // Función para actualizar el progreso
        function updateProgress() {
            var totalCards = <?php echo $total_pares; ?>;
            var completedCards = $('.card.completed').length;
            var progressPercentage = Math.round((completedCards / totalCards) * 100);

            $('#progressPercentage').text(progressPercentage);
            $('.progress-bar').css('width', progressPercentage + '%').attr('aria-valuenow', progressPercentage);

            if (completedCards === totalCards) {
                $('#continueBtn').show();
                $('#continueBtn').trigger('click');
            }
        }
    </script>
</body>

</html>