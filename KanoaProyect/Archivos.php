<!DOCTYPE html>
<html>
<head>
    <title>Subir y descargar archivos</title>
</head>
<body>
    <h2>Subir archivo</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <label for="archivo">Selecciona un archivo:</label>
        <input type="file" name="archivo" id="archivo">
        <input type="submit" name="submit" value="Subir">
    </form>

    <h2>Archivos almacenados</h2>
    <?php
    // Configuración de la base de datos
    $host = "localhost";
    $usuario = "root";
    $contraseña = "n0m3l0";
    $base_de_datos = "Jos5Dev";

    // Conexión a la base de datos
    $conexión = mysqli_connect($host, $usuario, $contraseña, $base_de_datos);
    if (!$conexión) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }

    // Verificar si se ha enviado un archivo
    if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] == 0) {
        // Obtener información del archivo
        $nombre_archivo = $_FILES["archivo"]["name"];
        $tipo_archivo = $_FILES["archivo"]["type"];
        $tamano_archivo = $_FILES["archivo"]["size"];
        $ruta_temporal = $_FILES["archivo"]["tmp_name"];

        // Leer el contenido del archivo
        $contenido_archivo = file_get_contents($ruta_temporal);

        // Escapar caracteres especiales en el contenido del archivo
        $contenido_archivo = mysqli_real_escape_string($conexión, $contenido_archivo);

        // Insertar el archivo en la base de datos
        $consulta = "INSERT INTO archivos (nombre, imagen_proyecto) VALUES ('$nombre_archivo', '$contenido_archivo')";
        $resultado = mysqli_query($conexión, $consulta);
        if ($resultado) {
            echo "El archivo se ha subido correctamente.";
        } else {
            echo "Error al subir el archivo: " . mysqli_error($conexión);
        }
    }

    // Obtener todos los archivos de la base de datos
    $consulta = "SELECT id, nombre FROM archivos";
    $resultado = mysqli_query($conexión, $consulta);
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $id_archivo = $fila["id"];
            $nombre_archivo = $fila["nombre"];
            echo "<a href='descargar.php?id=$id_archivo'>$nombre_archivo</a> - <a href='descargar.php?id=$id_archivo&download=true'>Descargar</a><br>";
        }
    } else {
        echo "No se encontraron archivos almacenados.";
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexión);
    ?>
</body>
</html>
