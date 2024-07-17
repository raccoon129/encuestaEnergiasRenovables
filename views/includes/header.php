<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Encuesta para evaluar las barreras para la adopción de energía renovable en México</a>
    <div class="collapse navbar-collapse">
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