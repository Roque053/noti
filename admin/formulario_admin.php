<?php
session_start();
require("conexion.php");

if (!isset($_SESSION['usuario_logueado'])) {
    header("location:index.php");
    exit; 
}

$mensaje = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuarioId = $_POST["usuario"];
    
    // Insertar la solicitud en la tabla administradores
    $conexion = mysqli_connect($server_db, $usuario_db, $password_db, $base_db)
        or die("No se puede conectar con el servidor");
    mysqli_select_db($conexion, $base_db)
        or die("No se puede seleccionar la base de datos");
    
    $instruccion = "INSERT INTO administradores (id_usuario, estado) VALUES ('$usuarioId', 'pendiente')";
    $consulta = mysqli_query($conexion, $instruccion);
    
    if ($consulta) {
        $mensaje = "Solicitud enviada con éxito";
    } else {
        $mensaje = "Error al enviar la solicitud";
    }
    
    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Administrador</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center">Solicitud de Administrador</h1>
                    </div>
                    <div class="card-body">
                        <?php
                        // Mostrar el mensaje de éxito o error usando un alert
                        if (!empty($mensaje)) {
                            echo '<div class="alert alert-info alert-dismissible fade show" role="alert">' . $mensaje . '
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                        }
                        ?>
                        <h3 class="text-center"><?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?></h3>
                        <form action="procesar_solicitud.php" method="post">
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Enviar solicitud</button>
                                <a href="./home.php" class="btn btn-outline-info">Volver</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
