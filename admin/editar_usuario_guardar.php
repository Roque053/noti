<?php
session_start();
extract($_POST);
if (!isset($_SESSION['usuario_logueado'])) {
    header("location:index.php");
    exit;
}

require("conexion.php");
$conexion = mysqli_connect($server_db, $usuario_db, $password_db, $base_db)
    or die("No se puede conectar con el servidor");
mysqli_select_db($conexion, $base_db)
    or die("No se puede seleccionar la base de datos");

// Validar datos
if (empty($id_usuario) || empty($nombre) || empty($correo)) {
    $mensaje = "Todos los campos son obligatorios.";
} else {
    $id_usuario = mysqli_real_escape_string($conexion, $id_usuario);
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $correo = mysqli_real_escape_string($conexion, $correo);
    $contrasena = mysqli_real_escape_string($conexion, $contrasena);

    // Verificar si se proporcionó una nueva contraseña
    if (!empty($contrasena)) {
        $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
        $instruccion = "UPDATE usuarios SET nombre='$nombre', correo='$correo', contrasena='$contrasena' WHERE id_usuario='$id_usuario'";
    } else {
        $instruccion = "UPDATE usuarios SET nombre='$nombre', correo='$correo' WHERE id_usuario='$id_usuario'";
    }

    $consulta = mysqli_query($conexion, $instruccion);

    if ($consulta) {
        $mensaje = "Usuario actualizado correctamente";
    } else {
        $mensaje = "Error al actualizar el usuario";
    }
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="../lib/bootstrap-5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="../lib/bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <div class="container">
        <!-- Mostrar el mensaje en la pantalla -->
        <h1>Editar Usuario</h1>
        <div class="mb-3">
            <?php
            if (isset($mensaje)) {
                echo '<div class="alert alert-info">' . $mensaje . '</div>';
            }
            ?>
        </div>
        <a href="administradores.php" class="btn btn-primary">Volver al Menú Principal</a>
    </div>
</body>

</html>
