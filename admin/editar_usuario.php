<?php
session_start();
extract($_REQUEST);
if (!isset($_SESSION['usuario_logueado'])) {
    header("location:index.php");
    exit;
}

require("conexion.php");
$conexion = mysqli_connect($server_db, $usuario_db, $password_db, $base_db)
    or die("No se puede conectar con el servidor");
mysqli_select_db($conexion, $base_db)
    or die("No se puede seleccionar la base de datos");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y limpiar los datos del formulario
    $id_usuario = (isset($id_usuario)) ? intval($id_usuario) : 0;
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);

    // Verificar si se proporcionó una nueva contraseña
    if (!empty($contrasena)) {
        $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($conexion, "UPDATE usuarios SET nombre=?, correo=?, contrasena=? WHERE id_usuario=?");
        mysqli_stmt_bind_param($stmt, "sssi", $nombre, $correo, $contrasena, $id_usuario);
    } else {
        $stmt = mysqli_prepare($conexion, "UPDATE usuarios SET nombre=?, correo=? WHERE id_usuario=?");
        mysqli_stmt_bind_param($stmt, "ssi", $nombre, $correo, $id_usuario);
    }

    if (mysqli_stmt_execute($stmt)) {
        $mensaje = "Usuario actualizado correctamente";
    } else {
        $mensaje = "Error al actualizar el usuario";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conexion);

// Redirigir de nuevo a la página de edición de usuario con un mensaje
header("location:administradores.php?id_usuario=$id_usuario&mensaje=$mensaje");
?>
