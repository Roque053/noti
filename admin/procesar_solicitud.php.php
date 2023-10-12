<?php
// Manejar el formulario de solicitud de administrador
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuarioId = $_POST["usuario"];

    // Insertar la solicitud en la tabla administradores
    require("conexion.php");
    $conexion = mysqli_connect($server_db, $usuario_db, $password_db, $base_db)
        or die("No se puede conectar con el servidor");
    mysqli_select_db($conexion, $base_db)
        or die("No se puede seleccionar la base de datos");
    
    $instruccion = "INSERT INTO administradores (id_usuario, estado) VALUES ('$usuarioId', 'pendiente')";

    if (mysqli_query($conexion, $instruccion)) {
        mysqli_close($conexion);
        header("Location: menu.php?mensaje=Solicitud enviada con éxito");
        exit;
    } else {
        die("Error al enviar la solicitud: " . mysqli_error($conexion));
    }
}
?>
