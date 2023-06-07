<?php


// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

// Incluir el archivo de configuración de la base de datos
require_once 'config.php';

// Obtener el correo o MetaMask ID del formulario
$correo = isset($_POST['correo']) ? $_POST['correo'] : '';

// Obtener la cantidad de monedas a canjear del formulario
$cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : '';

// Verificar si se envió el formulario
if (isset($_POST['submit'])) {
    // Verificar si se proporcionaron todos los datos
    if (!empty($correo) && !empty($cantidad)) {
        // Verificar si el saldo es suficiente para el canje
        if ($_SESSION['usuario']['saldo_criptomonedas'] >= $cantidad) {
            // Actualizar el saldo del usuario
            $nuevoSaldo = $_SESSION['usuario']['saldo_criptomonedas'] - $cantidad;
            $idUsuario = $_SESSION['usuario']['id'];
            $sqlActualizarSaldo = "UPDATE usuarios SET saldo_criptomonedas = $nuevoSaldo WHERE id = $idUsuario";
            $conn->query($sqlActualizarSaldo);

            // Registrar el canje en la tabla "canjeo"
            $sqlRegistrarCanjeo = "INSERT INTO canjeo (correo, cantidad) VALUES ('$correo', $cantidad)";
            $conn->query($sqlRegistrarCanjeo);

            // Actualizar la información del usuario en la sesión
            $_SESSION['usuario']['saldo_criptomonedas'] = $nuevoSaldo;

            // Redireccionar al index.php
            header('Location: index.php');
            exit;
        } else {
            $mensajeError = "Saldo insuficiente";
        }
    } else {
        $mensajeError = "Por favor, complete todos los campos";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Canjear Saldo</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
        }
        
        /* Formulario */
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f2f2f2;
        }
        
        h2 {
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
        }
        
        .error-message {
            color: red;
            margin-top: 10px;
        }
        
        .submit-btn {
            display: block;
            width: 100%;
            padding: 8px;
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
        <h2>Canjear Saldo</h2>
        <h4>El dinero se vera reflejado en tu cuenta en 3 dias habiles</h4>
        <?php if (isset($mensajeError)): ?>
            <p class="error-message"><?php echo $mensajeError; ?></p>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="correo">Correo o MetaMask ID:</label>
                <input type="text" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad de monedas:</label>
                <input type="number" id="cantidad" name="cantidad" required>
            </div>
            <button type="submit" name="submit" class="submit-btn">Aceptar</button>
        </form>
    </div>
</body>
</html>
