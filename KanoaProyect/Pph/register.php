<?php
require_once 'config.php';

// Comprobar si se envió el formulario de registro
if(isset($_POST['submit'])){
    // Obtener los datos enviados del formulario
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $direccion_billetera = $_POST['direccion_billetera'];

    // Verificar si ya existe un usuario con el mismo correo electrónico
    $query = "SELECT * FROM usuarios WHERE email='$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Ya existe un usuario con el mismo correo electrónico, mostrar un mensaje de error
        echo "Ya existe un usuario con el mismo correo electrónico. Por favor, utiliza otro correo electrónico.";
    } else {
        // Insertar el nuevo usuario en la base de datos
        $insertQuery = "INSERT INTO usuarios (nombre, email, contrasena, direccion_billetera) VALUES ('$username', '$email', '$password', '$direccion_billetera')";

        if ($conn->query($insertQuery) === TRUE) {
            // Registro exitoso, redireccionar al usuario a la página de inicio de sesión
            header('Location: login.php');
            exit;
        } else {
            echo "Error al registrar el usuario: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
     <link rel="stylesheet" type="text/css" href="Styles/styles.css">
</head>
<body>
    <div class="login">
    <h1>Registro</h1>
    <form method="POST" action="register.php">   
        <input type="text" placeholder= "Nombre de usuario" name="username" required><br><br>
        <input type="password" name="password" placeholder= "Contraseña" required><br><br>
        <input type="text" placeholder= "Email"name="email" required><br><br>
        <input type="text" placeholder= "Billetera" name="direccion_billetera" required><br><br>
        <input type="submit" name="submit" class="btn btn-primary btn-block btn-large" value="Registrar">
    </form>
    </div>
</body>
</html>
