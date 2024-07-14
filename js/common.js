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

// Función para validar y habilitar/deshabilitar el botón de guardar
function validateSaveButton(pairIndex) {
    var range1 = document.getElementById('factor-' + pairIndex + '-1');
    var range2 = document.getElementById('factor-' + pairIndex + '-2');
    var saveButton = document.querySelector('#form-' + pairIndex + ' .btn-primary');

    if (range1.value === '0' && range2.value === '0') {
        saveButton.disabled = true;
    } else {
        saveButton.disabled = false;
    }
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
                    $form.find('button[type=submit]').text('Respondido').addClass('btn-success').prop('disabled', true);
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
    $('.card').each(function(index) {
        validateSaveButton(index);
    });

    // Inicializar el progreso
    updateProgress();

    // Abrir el último acordeón no completado
    var $lastIncompleteCard = $('.card:not(.completed)').first().find('.collapse');
    if ($lastIncompleteCard.length > 0) {
        $lastIncompleteCard.collapse('show');
    }
});

// Función para actualizar el progreso
function updateProgress() {
    var totalCards = $('.card').length;
    var completedCards = $('.card.completed').length;
    var progressPercentage = Math.round((completedCards / totalCards) * 100);

    $('#progressPercentage').text(progressPercentage);

    if (completedCards === totalCards) {
        $('#continueBtn').show();
    }
}
