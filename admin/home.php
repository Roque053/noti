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
    <title>Admin</title>
    <link href="../lib/bootstrap-5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="../lib/bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>

</head>

<body>
<div class="container-fluid">
        <?php 
        if ($_SESSION['id_usuario'] == 1){
           require("menu_admin_gral.php");
        }else{
             require("menu.php");
        }
        
         ?>
        <h1>Noticias</h1>

        <div class="row">
            <?php
            require("conexion.php");
            $conexion = mysqli_connect($server_db, $usuario_db, $password_db,$base_db)
                or die("No se puede conectar con el servidor");
            mysqli_select_db($conexion, $base_db)
                or die("No se puede seleccionar la base de datos");
            $instruccion = "SELECT * FROM noticias";

            $consulta = mysqli_query($conexion, $instruccion) or die("No se puede consultar");

            while ($resultado = mysqli_fetch_array($consulta)) {
                echo '
                <div class="col-12 col-md-4">
                    <div class="card">
                        <img src="../imagenes_subidas/' . $resultado['imagen'] . '" class="card-img-top" alt="' . $resultado['titulo'] . '">
                        <div class="card-body">
                            <h5 class="card-title">' . $resultado['titulo'] . '</h5>
                            <p class="card-text">' . substr($resultado['copete'], 0, 40) . '</p>
                            <a href="ver_noticia.php?id_noticias=' . $resultado['id_noticias'] . '" class="btn btn-primary">Leer más</a>
                        </div>
                    </div>
                </div>';
            }
            mysqli_close($conexion);
            ?>
        </div>
    </div>
</body>
</body>

</html>