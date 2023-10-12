<?php
session_start();
extract($_REQUEST);
if (!isset($_SESSION['usuario_logueado'])) {
    header("location:index.php");
    //exit;
}

require("conexion.php");
$conexion = mysqli_connect($server_db, $usuario_db, $password_db, $base_db)
    or die("No se puede conectar con el servidor");
mysqli_select_db($conexion, $base_db)
    or die("No se puede seleccionar la base de datos");

// Validar si el usuario existe antes de eliminarlo
$instruccion_validar = "SELECT id_usuario FROM usuarios WHERE id_usuario='$id_usuario'";
$consulta_validar = mysqli_query($conexion, $instruccion_validar);
if (mysqli_num_rows($consulta_validar) > 0) {
    // El usuario existe en la base de datos, proceder con la eliminación
    $instruccion = "DELETE FROM usuarios WHERE id_usuario='$id_usuario'";
    $consulta = mysqli_query($conexion, $instruccion);

    if ($consulta) {
        // Éxito al eliminar
        $_SESSION['mensaje'] = "Usuario eliminado con éxito";
    } else {
        // Error en la eliminación
        $_SESSION['mensaje'] = "Error al eliminar el usuario";
    }
} else {
    // El usuario no existe en la base de datos
    $_SESSION['mensaje'] = "El usuario no existe en la base de datos";
}

mysqli_close($conexion);

// Redirigir a la página deseada
header("location:administrar_solicitudes.php");
?>
