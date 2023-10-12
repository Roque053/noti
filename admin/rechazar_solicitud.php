<?php
session_start();
extract($_REQUEST);
if (!isset($_SESSION['usuario_logueado']))
    header("location:index.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechazar Solicitud de Administrador</title>
</head>
<body>
    <h1>Rechazar Solicitud de Administrador</h1>

    <?php
    if (isset($id)) {
        // Obtener el ID de la solicitud rechazada
        $id_solicitud = intval($id);

        // Actualizar el estado de la solicitud a "rechazada" en la base de datos
        require("conexion.php");
        $conexion = mysqli_connect($server_db, $usuario_db, $password_db, $base_db)
            or die("No se puede conectar con el servidor");
        mysqli_select_db($conexion, $base_db)
            or die("No se puede seleccionar la base de datos");
        $instruccion = "UPDATE administradores SET estado = 'rechazada' WHERE id_solicitud = $id_solicitud";
        mysqli_query($conexion, $instruccion) or die("Error al rechazar la solicitud");

        mysqli_close($conexion);

        echo '<p>Solicitud rechazada.</p>';
    } else {
        echo '<p>ID de solicitud no especificado.</p>';
    }
    ?>

    <a href="administrar_solicitudes.php">Volver</a>

</body>
</html>
