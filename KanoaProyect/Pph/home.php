<?php
require_once 'config.php';
require_once 'session_check.php';


// Obtener el correo electrónico de la sesión
$emailUsuario = $_SESSION['email'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <h2>Bienvenido, <?php echo $emailUsuario; ?>!</h2>
    <a href="logout.php">Cerrar sesión</a>
    <!-- Aquí puedes agregar el contenido adicional de tu página de inicio -->
</body>
</
