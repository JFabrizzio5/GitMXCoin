<?php
require_once 'config.php';
require_once 'session_check.php';

// Procesar el formulario cuando se envíe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID del usuario propietario a partir del correo electrónico
    $correoUsuario = $_SESSION['email'];
    $query = "SELECT id FROM usuarios WHERE email = '$correoUsuario'";
    $resultado = $conn->query($query);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $idUsuarioPropietario = $fila['id'];

        // Obtener los valores del formulario
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precioCriptomonedas = $_POST['precio_criptomonedas'];

        // Manejar los archivos del proyecto
        $imagenProyecto = $_FILES['imagen_proyecto'];
        $archivoProyecto = $_FILES['archivo_proyecto'];

        // Ruta de almacenamiento para los archivos
        $rutaImagenProyecto = "ruta/donde/guardar/imagenes/" . $imagenProyecto['name'];
        $rutaArchivoProyecto = "ruta/donde/guardar/archivos/" . $archivoProyecto['name'];

        // Mover los archivos a la ruta de almacenamiento
        //move_uploaded_file($imagenProyecto['tmp_name'], $rutaImagenProyecto);
        //move_uploaded_file($archivoProyecto['tmp_name'], $rutaArchivoProyecto);

        // Insertar los datos en la tabla archivos
        $insertQuery = "INSERT INTO archivos (nombre, descripcion, id_usuario_propietario, precio_criptomonedas, imagen_proyecto, Proyecto)
                        VALUES ('$nombre', '$descripcion', $idUsuarioPropietario, $precioCriptomonedas, '$rutaImagenProyecto', '$rutaArchivoProyecto')";

        if ($conn->query($insertQuery) === TRUE) {
            //echo "Proyecto subido exitosamente.";
        } else {
            echo "Error al subir el proyecto: " . $conn->error;
        }
    } else {
        echo "Usuario no encontrado.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Subir proyecto</title>
      <link rel="stylesheet" type="text/css" href="Styles/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .form-container {
            width: 400px;
            padding: 30px;
            background-color: transparent;
            color: #fff;
            border-radius: 5px;
        }
        
        h2 {
            margin-top: 0;
            margin-bottom: 20px;
            text-align: center;
        }
        
        form {
            margin-top: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        input[type="text"],
        textarea {
            width: 100%;
            padding: 8px;
            border: none;
            border-radius: 3px;
            margin-bottom: 10px;
        }
        
        textarea {
            resize: vertical;
            height: 100px;
        }
        
        input[type="submit"],
        input[type="file"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            border: none;
            color: white;
            cursor: pointer;
            width: 100%;
        }
        
        
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Subir proyecto</h2>

        <form action="" method="POST" enctype="multipart/form-data">
            <label for="nombre">Nombre del proyecto:</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion"></textarea>

            <label for="imagen_proyecto">Imagen del proyecto (solo imágenes - .jpg, .jpeg, .png):</label>
            <input type="file" name="imagen_proyecto" id="imagen_proyecto" accept=".jpg, .jpeg, .png">

            <label for="archivo_proyecto">Archivo del proyecto (solo archivos comprimidos - .zip):</label>
            <input type="file" name="archivo_proyecto" id="archivo_proyecto" accept=".zip">

              <label for="precio_criptomonedas">Precio en criptomonedas:</label>
            <input type="number" step="0.01" name="precio_criptomonedas" id="precio_criptomonedas" required>
            
            <input type="submit" value="Subir proyecto">
        </form>
    </div>
</body>
</html>
