<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Encuestas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles/stylesLogin.css">
</head>
<body>

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
            <h2>Encuesta para la implementación de energía renovable en México</h2>
            <p>Bienvenido al sistema de encuestas. Por favor, inicie sesión con su usuario y contraseña previamente proporcionado para continuar.</p>
            <p>Si es un administrador, será redirigido al panel administrativo donde podrá visualizar los resultados de las encuestas.</p>
            <p>Si es un usuario encuestado, será redirigido a la encuesta correspondiente.</p>
        </div>
    </div>
</div>

</body>
</html>
