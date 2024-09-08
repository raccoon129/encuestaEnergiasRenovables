<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title>Iniciar Sesión - Encuesta para evaluar las barreras de la adopción de energía renovable en México</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/vegas/2.5.4/vegas.min.css">
    <link rel="stylesheet" href="styles/stylesLogin.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vegas/2.5.4/vegas.min.js"></script>
    <style>
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 60px;
            background-color: white;
            text-align: center;
        }
        .footer img {
            height: 60px;
            width: auto;
            box-shadow: none;
        }
        
    </style>
</head>

<body>
    <div id="background"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 login-form">
                <h2>Iniciar Sesión</h2>
                <form action="validar.php" method="POST">
                    <div class="form-group">
                        <label for="username">Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                </form>
            </div>
            <div class="col-md-6 info-section">
                <h2>Encuesta para evaluar las barreras de la adopción de energía renovable en México</h2>
                <p>Bienvenido. Por favor, inicie sesión con su usuario y contraseña previamente proporcionado para continuar.</p>
                <p>Si es un administrador, será redirigido al panel administrativo donde podrá visualizar los resultados de las encuestas.</p>
                <p>Si es un encuestado, ingrese sus credenciales y será redirigido a la encuesta correspondiente.</p>
                <button type="button" class="btn btn-outline-info" onclick="window.open('https://forms.gle/N6DbKfD4r5WbApBw5', '_blank')">Hacer un comentario</button>
            </div>
        </div>
    </div>
    <div class="footer">
        <img src="img/ISC x IER.gif" alt="ISC x IER">
    </div>
    <script>
        $(document).ready(function() {
            <?php
            session_start();
            if (isset($_SESSION['error'])) {
                echo "toastr.error('{$_SESSION['error']}');";
                unset($_SESSION['error']);
            }
            ?>

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