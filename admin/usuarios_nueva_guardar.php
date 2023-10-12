<?php
session_start();
extract($_REQUEST);
if (!isset($_SESSION['usuario_logueado']))
    header("location:index.php");

require("conexion.php");
$conexion = mysqli_connect($server_db, $usuario_db, $password_db)
    or die("No se puede conectar con el servidor");
mysqli_select_db($conexion, $base_db)
    or die("No se puede seleccionar la base de datos");
$fecha = date("Y-m-d");
$id_usuario = $_SESSION['id_usuario'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escapar y obtener los datos del formulario
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);

    // Encriptar la contraseña
   
    $salt = substr($usuario, 0, 2);
    $clave_crypt = crypt($password, $salt);

    // Insertar el usuario en la base de datos
    $instruccion = "INSERT INTO usuarios (nombre, apellido, usuario, password) VALUES ('$nombre', '$apellido', '$usuario', '$clave_crypt')";
    $consulta = mysqli_query($conexion, $instruccion) or die("No pudo insertar");

    // Mostrar un mensaje y redirigir al usuario según su elección
    echo '<script>';
    echo 'if (confirm("¿Desea convertirse en administrador?")) {';
    echo '  window.location.href = "formulario_admin.php";';
    echo '} else {';
    echo '  window.location.href = "usuarios.php?mensaje=Guardo";';
    echo '}';
    echo '</script>';
}

mysqli_close($conexion);
?>
