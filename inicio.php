<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>my diario</title>
    <link href="lib/bootstrap-5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="lib/bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <div class="container-fluid">
        <div  class="text-center">
        <h1 class="display-1">Diario Prueba</h1>
       </div>
    <br>
        <div class="row">
        <?php
        require("./admin/conexion.php");
        $conexion = mysqli_connect($server_db, $usuario_db, $password_db, $base_db)
            or die("No se puede conectar con el servidor");
        mysqli_select_db($conexion, $base_db)
            or die("No se puede seleccionar la base de datos");
        $instruccion = "select * from noticias  order by fecha desc LIMIT 10";

        $consulta = mysqli_query($conexion, $instruccion) or die("no puedo consultar");

        $nfilas = mysqli_num_rows($consulta);
        for ($i = 0; $i < $nfilas; $i++) {
            $resultado = mysqli_fetch_array($consulta);
            $inst2="select * from usuarios where id_usuario='".$resultado['id_usuario']."'";
              $consulta2=mysqli_query($conexion, $inst2) or die("no puedo consultar");
              $autor = mysqli_fetch_array($consulta2);
            
                    print('
            <div class="col-3">
                <div class="card">
                <img src="imagenes_subidas/'.$resultado['imagen'].'" class="card-img-top" alt="'.$resultado['titulo'].'">
                    <div class="card-body">
                            <h5 class="card-title">'.$resultado['titulo'].'</h5>
                        <p class="card-text">'.substr($resultado['copete'],0,40).'</p>
                        <p class="card-text">'.$autor['nombre']." ".$autor['apellido'].'</p>
                        <a href="./admin/ver_noticia.php?id_noticias='.$resultado['id_noticias'].'" class="btn btn-primary">"Leer Mas"</a>
                    </div>
                    
                 </div>
                 
            </div>
                    
 ');
        }
            
         mysqli_close($conexion);
        ?>
        </div>

        <!-- Botón para ir a la página de inicio de sesión (login.php) -->
        <div class="text-center mt-4">
            <a href="./admin/login.php" class="btn btn-primary">Ir a Inicio de Sesión</a>
            <a href="./admin/usuarios.php" class="btn btn-outline-info">Registrate</a>
        </div>
    </div>

</body>

</html>
