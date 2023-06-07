<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
} else {
    // Aquí puedes obtener los datos completos del usuario desde la base de datos
    $emailUsuario = $_SESSION['email'];

    // Realiza la consulta para obtener los datos del usuario
    $sql = "SELECT id, nombre, email, direccion_billetera, saldo_criptomonedas FROM usuarios WHERE email = '$emailUsuario'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Guarda los datos del usuario en la variable de sesión
        $_SESSION['usuario'] = $result->fetch_assoc();
    } else {
        // El usuario no fue encontrado en la base de datos
        // Puedes mostrar un mensaje de error o redireccionar a otra página
    }
}
?>
