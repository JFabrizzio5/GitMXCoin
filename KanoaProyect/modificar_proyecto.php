<?php
require_once 'config.php';
require_once 'session_check.php';

// Verificar si se proporcionó un ID de proyecto
if (!isset($_GET['id'])) {
    // Redirigir a la página de inicio si no se proporcionó un ID válido
    header("Location: home.php");
    exit;
}

// Obtener el ID del proyecto a modificar
$idProyecto = $_GET['id'];

// Obtener los detalles del proyecto de la base de datos
$query = "SELECT * FROM archivos WHERE id = $idProyecto";
$resultado = $conn->query($query);

if ($resultado->num_rows != 1) {
    // Redirigir a la página de inicio si el proyecto no existe
    header("Location: home.php");
    exit;
}

$proyecto = $resultado->fetch_assoc();

// Verificar si se envió el formulario de modificación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    // Obtener el archivo enviado
    $nuevoArchivo = $_FILES['nuevoArchivo'];

    // Verificar si se seleccionó un nuevo archivo
    if ($nuevoArchivo['name'] != '') {
        // Eliminar el archivo anterior
        if (!empty($proyecto['Proyecto'])) {
            $archivoAnterior = $proyecto['Proyecto'];
            if (file_exists($archivoAnterior)) {
                unlink($archivoAnterior);
            }
        }

        // Obtener la ruta temporal del nuevo archivo
        $tempArchivo = $nuevoArchivo['tmp_name'];

        // Mover el archivo a la ubicación final
        $destinoArchivo = 'ruta/donde/guardar/archivos/' . $nuevoArchivo['name'];
        move_uploaded_file($tempArchivo, $destinoArchivo);

        // Actualizar los datos del proyecto en la base de datos, incluyendo la ruta del nuevo archivo
        $query = "UPDATE archivos SET nombre = ?, descripcion = ?, Proyecto = ? WHERE id = $idProyecto";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $nombre, $descripcion, $destinoArchivo);
        $stmt->execute();
    } else {
        // Actualizar los datos del proyecto en la base de datos sin cambiar el archivo
        $query = "UPDATE archivos SET nombre = ?, descripcion = ? WHERE id = $idProyecto";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $nombre, $descripcion);
        $stmt->execute();
    }

    // Redirigir a la página de inicio si la modificación fue exitosa
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modificar Proyecto</title>
    <style>
        /* Estilos generales */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        
        /* Contenedor */
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f2f2f2;
        }
        
        h2 {
            margin-top: 0;
        }
        
        /* Estilos del formulario */
        form {
            margin-top: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        
        /* Estilos del botón "Modificar" */
        .modify-button {
            padding: 8px 20px;
            background-color: #4CAF50;
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Modificar Proyecto</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $proyecto['nombre']; ?>" required>
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="5" required><?php echo $proyecto['descripcion']; ?></textarea>
            <label for="archivoActual">Archivo Actual:</label>
            <p><?php echo $proyecto['Proyecto']; ?></p>
            <label for="nuevoArchivo">Seleccionar Nuevo Archivo:</label>
            <input type="file" id="nuevoArchivo" name="nuevoArchivo">
            <button class="modify-button" type="submit">Modificar</button>
        </form>
    </div>
</body>
</html>
