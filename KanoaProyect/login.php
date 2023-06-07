<?php
require_once 'config.php';

// Verificar si se envió el formulario de inicio de sesión
if (isset($_POST['submit'])) {
    // Obtener los datos enviados del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para verificar las credenciales de inicio de sesión
    $query = "SELECT * FROM usuarios WHERE email='$email' AND contrasena='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Inicio de sesión exitoso, crear una sesión
        session_start();
        $_SESSION['email'] = $email;

        // Redireccionar a la página de inicio después del inicio de sesión exitoso
        header('Location: home.php');
        exit;
    } else {
        // Las credenciales de inicio de sesión son incorrectas, muestra un mensaje de error
        echo "Credenciales inválidas. Por favor, intenta nuevamente.";
    }
} else {
    // Verificar si ya se ha iniciado sesión
    session_start();
    if (isset($_SESSION['email'])) {
        // Redireccionar a la página de inicio si ya se ha iniciado sesión
        header('Location: home.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Iniciar sesión</title>

        <link rel="stylesheet" type="text/css" href="Styles/styles.css">
    </head>
    <body>
        <div class="login">
            <h1>Iniciar sesión</h1>
            <form method="POST" action="login.php">
                <input type="text" name="email" required>
                <input type="password" name="password" required>
                <button type="submit" name="submit" class="btn btn-primary btn-block btn-large" value="Iniciar sesión">Go</button>
            </form>
            <a href='register.php' >Registrarse</a>
        </div>
    </body>
</html>
