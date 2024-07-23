<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presentación de diapositivas con Vegas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/vegas/2.5.4/vegas.min.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
        #background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            filter: blur(5px);  /* Aplica un desenfoque de 5 píxeles */
            transform: scale(1.1);  /* Escala ligeramente para evitar bordes borrosos */
        }
    </style>
</head>
<body>
    <div id="background"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vegas/2.5.4/vegas.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#background").vegas({
                slides: [{
                        src: "img/1.jpg"
                    },
                    {
                        src: "img/2.jpg"
                    },
                    {
                        src: "img/3.jpg"
                    },
                    {
                        src: "img/4.jpg"
                    },
                    {
                        src: "img/5.jpg"
                    },
                    {
                        src: "img/6.jpg"
                    }
                ],
                transition: ['fade', 'zoomOut'],
                animation: ['kenburnsUp', 'kenburnsDown', 'kenburnsLeft', 'kenburnsRight'],
                transitionDuration: 2000,
                delay: 7000,
                animationDuration: 20000,
                overlay: 'https://cdnjs.cloudflare.com/ajax/libs/vegas/2.5.4/overlays/08.png'
            });
        
        });
    </script>
</body>
</html>