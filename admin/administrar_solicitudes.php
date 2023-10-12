<?php
session_start();
require("conexion.php");

if (!isset($_SESSION['usuario_logueado'])) {
    header("location:index.php");
    exit;
}

// Realizar la conexión a la base de datos
$conexion = mysqli_connect($server_db, $usuario_db, $password_db, $base_db) or die("No se puede conectar con el servidor");
mysqli_select_db($conexion, $base_db) or die("No se puede seleccionar la base de datos");

// Obtener las solicitudes pendientes
$instruccion = "SELECT a.id_solicitud, u.nombre, a.estado FROM administradores a
                INNER JOIN usuarios u ON a.id_usuario = u.id_usuario WHERE a.estado = 'pendiente'";
$consulta = mysqli_query($conexion, $instruccion) or die("Error al obtener las solicitudes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Solicitudes y Usuarios</title>
    <link href="../lib/bootstrap-5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="../lib/bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="container mt-5">
        <h1 class="text-center">Administrar Solicitudes y Usuarios</h1>

        <?php
        // Mostrar mensaje de eliminación o error si está presente en la sesión
        if (isset($_SESSION['mensaje'])) {
            echo '<div class="alert alert-success">' . $_SESSION['mensaje'] . '</div>';
            unset($_SESSION['mensaje']);
        }
        ?>
        <h2>Solicitudes pendientes</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Solicitud</th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($resultado = mysqli_fetch_array($consulta)) {
                    echo '<tr>';
                    echo '<td>' . $resultado['id_solicitud'] . '</td>';
                    echo '<td>' . $resultado['nombre'] . '</td>';
                    echo '<td>' . $resultado['estado'] . '</td>';
                    echo '<td>
                            <a href="./aprobar_solicitud.php?id=' . $resultado['id_solicitud'] . '" class="btn btn-success">Aprobar</a>
                            <a href="./rechazar_solicitud.php?id=' . $resultado['id_solicitud'] . '" class="btn btn-danger">Rechazar</a>
                          </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

        <h2>Usuarios Registrados</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Usuario</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar lista de usuarios registrados
                $instruccion = "SELECT id_usuario, nombre FROM usuarios";
                $consulta = mysqli_query($conexion, $instruccion) or die("Error al obtener los usuarios");

                while ($usuario = mysqli_fetch_array($consulta)) {
                    echo '<tr>';
                    echo '<td>' . $usuario['id_usuario'] . '</td>';
                    echo '<td>' . $usuario['nombre'] . '</td>';
                    echo '<td>
                            <a href="editar_usuario.php?id=' . $usuario['id_usuario'] . '" class="btn btn-primary">Editar</a>
                            <a href="borrar_usuarios_admin.php?id=' . $usuario['id_usuario'] . '" class="btn btn-danger" onclick="return confirmarEliminacion();">Eliminar</a>
                          </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

        <a href="menu_admin_gral.php" class="btn btn-primary">Volver al Menú Principal</a>
    </div>
</div>

<script>
    function confirmarEliminacion() {
        if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
            return true; // Continuar con la eliminación
        } else {
            return false; // Cancelar la eliminación
        }
    }
</script>
</body>
</html>
