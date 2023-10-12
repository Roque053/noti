<?php
// Inicia la sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_logueado'])) {
    header("location:index.php");
    exit; 
}

// Comprueba si el usuario es el administrador general
if ($_SESSION['id_usuario'] == 1) {
    
    ?>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="home.php">Inicio</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="noticias.php">Noticias</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="administradores.php">Administradores</a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="administrar_solicitudes.php">Usuarios</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Salir</a>
        </li>
        <li class="nav-item">
            <?php
            echo "<a class='nav-link disabled'>{$_SESSION['nombre']} {$_SESSION['apellido']}</a>";
            ?>
        </li>
    </ul>
    <?php
} else {
    // El usuario no es el administrador general, puedes mostrar un mensaje o redirigir a otra página
    header("location:index.php"); 
}
?>
