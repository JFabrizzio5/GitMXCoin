<?php
require_once 'config.php';
require_once 'session_check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se ha enviado el proyectoId
    if (isset($_POST['proyectoId'])) {
        $proyectoId = $_POST['proyectoId'];

        // Verificar si se ha enviado el parámetro 'action' para determinar la acción a realizar
        if (isset($_POST['action'])) {
            $action = $_POST['action'];

            if ($action === 'eliminar') {
                // Eliminar el proyecto de la base de datos
                $eliminarQuery = "DELETE FROM archivos WHERE id = ?";
                $stmt = $conn->prepare($eliminarQuery);
                $stmt->bind_param('i', $proyectoId);
                $stmt->execute();
            } elseif ($action === 'modificar') {
                // Redirigir a la página de modificación del proyecto
                header('Location: modificar_proyecto.php?id=' . $proyectoId);
                exit();
            }
        }
    }
}

// Obtener los datos del usuario de la sesión
$datosUsuario = $_SESSION['usuario'];

// Obtener todos los proyectos del usuario
$query = "SELECT * FROM archivos WHERE id_usuario_propietario = " . $datosUsuario['id'];
$resultado = $conn->query($query);

// Array para almacenar los proyectos
$proyectos = array();

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $proyectos[] = $fila;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <style>
        /* Estilos generales */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        
        /* Encabezado */
        header {
            background: linear-gradient(to bottom, #4a148c, #7b1fa2);
            padding: 20px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        h1 {
            margin: 0;
            font-size: 24px;
        }
        
        /* Estilos de la card */
        .card {
            width: 300px;
            margin: 20px;
            padding: 20px;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: inline-block;
            vertical-align: top;
        }
        
        /* Estilos de la card - contenido */
        .card-content {
            margin-top: 20px;
        }
        
        .card-content ul {
            padding-left: 0;
            list-style-type: none;
        }
        
        .card-content ul li {
            margin-bottom: 10px;
        }
        
        .card-content ul li span {
            font-weight: bold;
        }
        
        /* Estilos del botón "Volver" */
        .back-button {
            padding: 8px 20px;
            background-color: #4CAF50;
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }
        
        /* Estilos del botón "Agregar Proyecto" */
        .add-project-button {
            padding: 8px 20px;
            background-color: #4CAF50;
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            margin-right: 10px;
        }
        
        /* Estilos de la lista de proyectos */
        .project-list {
            margin-top: 20px;
            list-style-type: none;
            padding-left: 0;
        }
        
        .project-list li {
            margin-bottom: 10px;
        }
        
        .project-list li span {
            font-weight: bold;
        }
        
        /* Estilos de los botones "Eliminar" y "Modificar" */
        .delete-button
         {
            padding: 8px 20px;
            background-color: #ff0000;
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            margin-right: 5px;
        }
        .modify-button
         
         {
            padding: 8px 20px;
            background-color: yellowgreen;
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <header>
        <button class="back-button" onclick="location.href='index.php'">Volver</button>
        <h1>Home</h1>
        <button class="add-project-button" onclick="location.href='Subir_archivo.php'">Agregar Proyecto</button>
        
    </header>
    <div class="card">
        <h2>Bienvenido, <?php echo $datosUsuario['nombre']; ?>!</h2>
        <div class="card-content">
            <ul>
                <li><span>ID:</span> <?php echo $datosUsuario['id']; ?></li>
                <li><span>Nombre:</span> <?php echo $datosUsuario['nombre']; ?></li>
                <li><span>Email:</span> <?php echo $datosUsuario['email']; ?></li>
                <li><span>Dirección de Billetera:</span> <?php echo $datosUsuario['direccion_billetera']; ?></li>
                <li><span>Saldo de Criptomonedas:</span> <?php echo $datosUsuario['saldo_criptomonedas']; ?></li>
            </ul>
            <a class="logout-button" href="logout.php">Cerrar sesión</a>
        </div>
    </div>
    <ul class="project-list">
        <h3>Proyectos:</h3>
        <?php foreach ($proyectos as $proyecto) : ?>
            <li>
                <div class="card">
                    <h3><?php echo $proyecto['nombre']; ?></h3>
                    <p><?php echo $proyecto['descripcion']; ?></p>
                    <form method="POST" action="">
                        <input type="hidden" name="proyectoId" value="<?php echo $proyecto['id']; ?>">
                        <button class="delete-button" type="submit" name="action" value="eliminar">Eliminar</button>
                        <button class="modify-button" type="submit" name="action" value="modificar">Modificar</button>
                    </form>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
