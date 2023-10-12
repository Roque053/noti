<?php
//session_start();
require("conexion.php");

if (isset($_SESSION['usuario_logueado'])) {
    // Verifica si el usuario es el administrador general (usuario 1)
    if ($_SESSION['id_usuario'] == 1) {
        header("Location: menu_admin_gral.php");
        exit;
    }
}
?>


<ul class="nav">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="home.php">Inicio</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="noticias.php">Noticias</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="formulario_admin.php">Ser administrador</a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link" href="logout.php">Salir</a>
    </li>

    <li class="nav-item">
        <?php 
        // Verifica si el usuario ha iniciado sesión antes de acceder a las variables de sesión
        if (isset($_SESSION['usuario_logueado'])) {
            echo "<a class='nav-link disabled'>{$_SESSION['nombre']} {$_SESSION['apellido']}</a>";
        }
        ?>
    </li>
</ul>


