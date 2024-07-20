<?php
// session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm bg-white rounded">
    <a class="navbar-brand" href="#" style="white-space: normal;">Encuesta para evaluar las barreras de la adopción de energía renovable en México</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="nav-link">Usuario: <?php echo $_SESSION['username']; ?></span>
            </li>
            <li class="nav-item">
                <a href="includes/logout.php" class="btn btn-danger my-2 my-sm-0">Cerrar Sesión</a>
            </li>
        </ul>
    </div>
</nav>

<style>
    .navbar-brand {
        white-space: normal;
        word-wrap: break-word;
    }
</style>
