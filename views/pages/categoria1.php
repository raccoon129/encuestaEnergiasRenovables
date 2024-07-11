<!DOCTYPE html>
<html lang="en">
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
    </style>
</head>
<body>

<?php
include '../includes/header.php';
include '../../db.php';

// Verificar si el usuario está autenticado
/*
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}
*/
// Obtener los factores desde la base de datos
$sql = "SELECT id_factor, nombre_factor, contenido_factor FROM Factor WHERE id_factor BETWEEN 1 AND 18";
$result = $conn->query($sql);
$factores = [];
while ($row = $result->fetch_assoc()) {
    $factores[$row['id_factor']] = $row;
}
?>

<div class="container mt-5">
    <h2>Red Conexión A - Encuesta</h2>
    <div class="accordion" id="accordionFactors">
        <?php
        $pares = [
            [1, 2], [1, 3], [1, 4], [1, 5], [1, 6], [1, 7], [1, 8], [1, 9], [1, 10], [1, 11], 
            [1, 12], [1, 13], [1, 14], [1, 15], [1, 16], [1, 17], [1, 18]
        ];

        foreach ($pares as $index => $par) {
            $factor1 = $factores[$par[0]];
            $factor2 = $factores[$par[1]];
            $collapseId = 'collapse' . $index;
            $headingId = 'heading' . $index;
        ?>
            <div class="card">
                <div class="card-header" id="<?php echo $headingId; ?>">
                    <h5 class="mb-0">
                        <button class="btn btn-link <?php echo $index > 0 ? 'collapsed' : ''; ?>" type="button" data-toggle="collapse" data-target="#<?php echo $collapseId; ?>" aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>" aria-controls="<?php echo $collapseId; ?>">
                            <?php echo $factor1['nombre_factor'] . ' vs ' . $factor2['nombre_factor']; ?>
                        </button>
                    </h5>
                </div>

                <div id="<?php echo $collapseId; ?>" class="collapse <?php echo $index === 0 ? 'show' : ''; ?>" aria-labelledby="<?php echo $headingId; ?>" data-parent="#accordionFactors">
                    <div class="card-body">
                        <form action="../includes/guardar_respuesta.php" method="POST" class="save-form">
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
                                            <input type="range" class="form-control-range factor-range" id="factor<?php echo $factor1['id_factor']; ?>" name="porcentaje1" min="0" max="100" value="0" oninput="updateRange(this, <?php echo $factor1['id_factor']; ?>, <?php echo $factor2['id_factor']; ?>)">
                                            <output>0</output>
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
                                            <input type="range" class="form-control-range factor-range" id="factor<?php echo $factor2['id_factor']; ?>" name="porcentaje2" min="0" max="100" value="0" oninput="updateRange(this, <?php echo $factor2['id_factor']; ?>, <?php echo $factor1['id_factor']; ?>)">
                                            <output>0</output>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="text-center mt-4">
        <button id="continueBtn" class="btn btn-success" style="display: none;">Continuar a la siguiente página</button>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<script>
function updateRange(element, currentFactorId, oppositeFactorId) {
    // Reset the opposite range
    document.getElementById('factor' + oppositeFactorId).value = 0;
    document.getElementById('factor' + oppositeFactorId).nextElementSibling.value = 0;

    // Highlight the current card
    element.closest('.card').classList.add('highlight');
    document.getElementById('factor' + oppositeFactorId).closest('.card').classList.remove('highlight');
    
    // Update the output value
    element.nextElementSibling.value = element.value;
}

$(document).ready(function(){
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
                } else {
                    toastr.error('Error: ' + result.message);
                }

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
            },
            error: function() {
                toastr.error('Error al guardar la respuesta');
            }
        });
    });
});
</script>

</body>
</html>
