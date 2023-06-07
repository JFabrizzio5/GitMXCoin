<!DOCTYPE html>
<html>
<head>
    <title>Perfil del Propietario</title>
    <style>
        /* Estilos generales */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        
        /* Estilos para el contenedor principal */
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Estilos para las tarjetas */
        .card {
            width: 100%;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .card h3 {
            margin: 0;
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .card p {
            margin: 0;
            font-size: 14px;
        }
        
        .card a {
            display: block;
            padding: 8px 20px;
            background-color: #4CAF50;
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }

        /* Estilos para el formulario de donación */
        .donation-form {
            margin-top: 20px;
            padding: 10px;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .donation-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .donation-form input[type="number"] {
            padding: 5px;
            width: 100%;
            margin-bottom: 10px;
        }

        .donation-form input[type="submit"] {
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

        // Obtener el ID del propietario
        $idPropietario = isset($_GET['id']) ? $_GET['id'] : '';

        // Consultar los datos del propietario
        $queryPropietario = "SELECT * FROM usuarios WHERE id = $idPropietario";
        $resultadoPropietario = $conn->query($queryPropietario);

        if ($resultadoPropietario->num_rows > 0) {
            $filaPropietario = $resultadoPropietario->fetch_assoc();
            $nombrePropietario = $filaPropietario['nombre'];
            $direccionBilletera = $filaPropietario['direccion_billetera'];

            echo '<div class="card">
                    <h3>Información del Propietario</h3>
                    <p><strong>Nombre:</strong> ' . $nombrePropietario . '</p>
                    <p><strong>Dirección de Billetera:</strong> ' . $direccionBilletera . '</p>
                </div>';

            // Consultar los proyectos del propietario
            $queryProyectos = "SELECT * FROM archivos WHERE id_usuario_propietario = $idPropietario";
            $resultadoProyectos = $conn->query($queryProyectos);

            echo '<h2>Proyectos del Propietario</h2>';
            if ($resultadoProyectos->num_rows > 0) {
                while ($filaProyecto = $resultadoProyectos->fetch_assoc()) {
                    $nombreProyecto = $filaProyecto['nombre'];
                    $descripcionProyecto = $filaProyecto['descripcion'];
                    $rutaImagenProyecto = $filaProyecto['imagen_proyecto'];
                    $rutaArchivoProyecto = $filaProyecto['Proyecto'];

                    // Convertir la imagen en base64
                    $imagenCodificadaProyecto = base64_encode($rutaImagenProyecto);

                    echo '<div class="card">
                            
                            <h3>' . $nombreProyecto . '</h3>
                            <p>' . $descripcionProyecto . '</p>
                            <a href="' . $rutaArchivoProyecto . '" download>Descargar</a>
                        </div>';
                }
            } else {
                echo "El propietario no tiene proyectos.";
            }

            // Mostrar formulario de donación
            echo '<div class="donation-form">
                    <h3>Realizar donación al propietario</h3>
                    <form method="POST" action="procesar_donacion.php">
                        <input type="hidden" name="id_propietario" value="' . $idPropietario . '">
                        <label for="cantidad">Cantidad a donar:</label>
                        <input type="number" name="cantidad" id="cantidad" required>
                        <input type="submit" name="submit" value="Donar">
                    </form>
                </div>';
        } else {
            echo "No se encontró el propietario.";
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </div>
</body>
</html>
