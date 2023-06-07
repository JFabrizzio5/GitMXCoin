
<!DOCTYPE html>
<html>
<head>
    <title>Página Principal</title>
    <style>
        /* Estilos generales */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        
        /* Encabezado */
        header {
            background: linear-gradient(to bottom, #1a237e, #283593);
            padding: 20px;
            color: #fff;
        }
        
        h1 {
            margin: 0;
            font-size: 24px;
        }
        
        .search-bar {
            margin-top: 20px;
        }
        
        .search-bar input[type="text"] {
            padding: 8px;
            width: 300px;
        }
        
        .search-bar input[type="submit"] {
            padding: 8px 20px;
            background-color: #4CAF50;
            border: none;
            color: white;
            cursor: pointer;
        }
        
        /* Contenedor de los archivos */
        .file-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }
        
        .file-item {
            width: 300px;
            margin: 10px;
            padding: 10px;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .file-item img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        
        .file-item h3 {
            margin: 0;
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .file-item p {
            margin: 0;
            font-size: 14px;
        }
        
        .file-item a {
            display: block;
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
    <header>
        <h1>Archivos Disponibles</h1>
        <div class="search-bar">
            <form action="" method="GET">
                <input type="text" name="search" placeholder="Buscar archivos...">
                <input type="submit" value="Buscar">
            </form>
        </div>
    </header>
    <div class="file-container">
        
        <?php
        

require_once 'config.php';
require_once 'session_check.php';


// Obtener el correo electrónico de la sesión
$emailUsuario = $_SESSION['email'];

// Configuración de la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "n0m3l0";
        $dbname = "Jos5Dev";
        
        // Establecer la conexión a la base de datos
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        
        // Obtener el término de búsqueda
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
        
        // Consultar los archivos disponibles
        $query = "SELECT * FROM archivos WHERE nombre LIKE '%$searchTerm%'";
        $resultado = $conn->query($query);
        
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $nombre = $fila['nombre'];
                $descripcion = $fila['descripcion'];
                $rutaImagen = $fila['imagen_proyecto'];
                $rutaArchivo = $fila['Proyecto'];
        
                // Convertir la imagen en base64
                $imagenCodificada = base64_encode($rutaImagen);
        
                echo '<div class="file-item">
                        <img src="data:image/jpeg;base64,' . $imagenCodificada . '" alt="' . $nombre . '">
                        <h3>' . $nombre . '</h3>
                        <p>' . $descripcion . '</p>
                        <a href="' . $rutaArchivo . '" download>Descargar</a>
                    </div>';
            }
        } else {
            echo "No se encontraron archivos disponibles.";
        }
        
        // Cerrar la conexión
        $conn->close();
        ?>
    </div>
</body>
</html>



 <a href="login.php">login</a>
        <a href="register.php">Register</a>
         <a href="home.php">home</a>
             <a href="Subir_archivo.php">home</a>