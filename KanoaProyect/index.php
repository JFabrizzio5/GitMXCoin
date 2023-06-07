<!DOCTYPE html>
<html>
<head>
    <title>Archivos Disponibles</title>
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
        
        .search-bar {
            text-align: center;
            margin-bottom: 20px;
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
            height: 200px;
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
        
        /* Estilos para enlaces */
        .nav-links {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        
        .nav-links a {
            color: white;
            margin-left: 10px;
            text-decoration: none;
        }
        
        .nav-links a:hover {
            text-decoration: underline;
        }
        
        /* Estilos para el saldo del usuario */
        .user-saldo {
            font-weight: bold;
            margin-right: 10px;
            color: #ff4081;
        }
    </style>
</head>
<body>
    <header>
        <div class="search-bar">
            <form action="" method="GET">
                <input type="text" name="search" placeholder="Buscar archivos...">
                <input type="submit" value="Buscar">
            </form>
        </div>
        <h1>Archivos Disponibles</h1>
        <div class="nav-links">
            
            <?php
            session_start();
            
            if (isset($_SESSION['email'])) {
                // El usuario ha iniciado sesión, muestra el saldo y enlaza al perfil
                echo '<span class="user-saldo">KanoaCoins ' . $_SESSION['usuario']['saldo_criptomonedas'] . '</span>';
                echo '<a href="home.php?id=' . $_SESSION['usuario']['id'] . '">' . $_SESSION['usuario']['nombre'] . '</a>';
            } else {
                // El usuario no ha iniciado sesión, muestra los botones de login y registro
                echo '<a href="login.php">Login</a>';
                echo '<a href="register.php">Register</a>';
            }
            ?>
            <span>  <a href="Tienda.php">Tienda</a></span>
        </div>
    </header>
    <div class="file-container">
        <?php
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
                $idPropietario = $fila['id_usuario_propietario'];
                $nombre = $fila['nombre'];
                $descripcion = $fila['descripcion'];
                $rutaImagen = $fila['imagen_proyecto'];
                $rutaArchivo = $fila['Proyecto'];
        
                // Convertir la imagen en base64
                $imagenCodificada = base64_encode($rutaImagen);
        
                echo '<div class="file-item">
                      
                        <h3>' . $nombre . '</h3>
                        <p>ID del propietario: ' . $idPropietario . '</p>
                        <p>' . $descripcion . '</p>
                        <a href="perfilP.php?id=' . $idPropietario . '">Ver perfil</a>
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
