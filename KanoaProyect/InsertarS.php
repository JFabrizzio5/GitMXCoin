<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "n0m3l0";
$dbname = "Jos5Dev";

// Establecer la conexión a la base de datos
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar la conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Obtener el ID del usuario en sesión
$userId = $_SESSION['usuario']['id'];

// Verificar si se ha enviado el formulario
if (isset($_POST['submit'])) {
    // Obtener la cantidad de fondos a agregar
    $fondos = $_POST['fondos'];

    // Validar la cantidad de fondos (puedes agregar más validaciones según tus necesidades)
    if ($fondos > 0) {
        // Actualizar el saldo en la base de datos
        $sql = "UPDATE usuarios SET saldo_criptomonedas = saldo_criptomonedas + $fondos WHERE id = $userId";

        if (mysqli_query($conn, $sql)) {
            echo "Fondos agregados exitosamente.";
        } else {
            echo "Error al agregar fondos: " . mysqli_error($conn);
        }
    } else {
        echo "La cantidad de fondos debe ser mayor a 0.";
    }
}

// Cerrar la conexión
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Fondos</title>
</head>
<body>
    <h1>Agregar Fondos</h1>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="fondos">Cantidad de Fondos:</label>
        <input type="number" name="fondos" id="fondos" required>
        <input type="submit" name="submit" value="Agregar Fondos">
    </form>
</body>
</html>
