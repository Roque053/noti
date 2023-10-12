<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Noticia</title>
    <link href="lib/bootstrap-5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="lib/bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <h1>Mi Diario</h1>
        <?php
        require("conexion.php");
        $conexion = mysqli_connect($server_db, $usuario_db, $password_db, $base_db)
            or die("No se puede conectar con el servidor");
        mysqli_select_db($conexion, $base_db)
            or die("No se puede seleccionar la base de datos");

        // Verifica si se proporcionó un id_noticias válido en la URL
        if (isset($_GET['id_noticias']) && is_numeric($_GET['id_noticias'])) {
            $id_noticias = $_GET['id_noticias'];

            // Consulta la noticia completa basada en el id_noticias
            $id_noticias = mysqli_real_escape_string($conexion, $id_noticias);
            $instruccion = "SELECT * FROM noticias WHERE id_noticias = $id_noticias";
            $consulta = mysqli_query($conexion, $instruccion) or die("No se puede consultar");

            // Verifica si se encontró la noticia
            if ($resultado = mysqli_fetch_array($consulta)) {
                $inst2 = "SELECT * FROM usuarios WHERE id_usuario = '{$resultado['id_usuario']}'";
                $consulta2 = mysqli_query($conexion, $inst2) or die("No se puede consultar");
                $autor = mysqli_fetch_array($consulta2);

                // Muestra la noticia completa
                echo '<img src="../imagenes_subidas/' . $resultado['imagen'] . '" class="card-img-top" alt="' . $resultado['titulo'] . '">';
                echo '<h1>' . $resultado['titulo'] . '</h1>';
                echo '<p>' . $resultado['cuerpo'] . '</p>'; 
                echo '<p>Autor: ' . $autor['nombre'] ."  ". $autor['apellido']. '</p>';
            
            } else {
                echo '<p>La noticia no se encontró.</p>';
            }
        } else {
            echo '<p>El ID de la noticia no es válido.</p>';
        }

        mysqli_close($conexion);
        ?>
        
        
            <a class="btn-link" href="home.php">Volver</a>
       
        
    </div>
</body>

</html>
