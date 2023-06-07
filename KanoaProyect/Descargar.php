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

// Verificar si se ha proporcionado un ID de archivo válido
if (isset($_GET['id'])) {
    $id_archivo = $_GET['id'];

    // Obtener la información del archivo de la base de datos
    $consulta = "SELECT nombre, imagen_proyecto FROM archivos WHERE id = $id_archivo";
    $resultado = mysqli_query($conexión, $consulta);
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
        $nombre_archivo = $fila['nombre'];
        $contenido_archivo = $fila['imagen_proyecto'];

        // Establecer las cabeceras para la descarga del archivo
        header("Content-Disposition: attachment; filename=\"$nombre_archivo\"");
        header("Content-Type: application/octet-stream");
        header("Content-Length: " . strlen($contenido_archivo));

        // Enviar el contenido del archivo al cliente
        echo $contenido_archivo;
        exit();
    }
}

// Si no se proporcionó un ID de archivo válido o no se encontró el archivo en la base de datos, redirigir a la página principal
header("Location: Archivos.php");
exit();
