<?php
session_start();
if (!isset($_SESSION['usuario_logueado'])) {
    header("location: index.php"); // Redirige si no hay sesión de usuario
}

// Verifica que el usuario logueado sea el administrador general (usuario número 1)
if ($_SESSION['id_usuario'] !== 1) {
    header("location: menu.php"); // Redirige a la página de menú si no es el administrador general
}

// Consulta la base de datos para obtener todas las solicitudes pendientes
require("conexion.php");
$conexion = mysqli_connect($server_db, $usuario_db, $password_db, $base_db) or die("No se puede conectar con el servidor");
mysqli_select_db($conexion, $base_db) or die("No se puede seleccionar la base de datos");
$instruccion = "SELECT a.id_solicitud, u.nombre, a.estado FROM administradores a INNER JOIN usuarios u ON a.id_usuario = u.id_usuario WHERE a.estado = 'pendiente'";
$consulta = mysqli_query($conexion, $instruccion) or die("Error al obtener las solicitudes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Solicitudes de Administrador</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Administrar Solicitudes de Administrador</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre del Usuario</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($resultado = mysqli_fetch_array($consulta)) { ?>
                    <tr>
                        <td><?php echo $resultado['nombre']; ?></td>
                        <td><?php echo $resultado['estado']; ?></td>
                        <td>
                            <a href="aprobar_solicitud.php?id=<?php echo $resultado['id_solicitud']; ?>" class="btn btn-success">Aprobar</a>
                            <a href="rechazar_solicitud.php?id=<?php echo $resultado['id_solicitud']; ?>" class="btn btn-danger">Rechazar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="menu.php" class="btn btn-primary">Volver al Menú</a>
    </div>
</body>
</html>

<?php mysqli_close($conexion); ?>
