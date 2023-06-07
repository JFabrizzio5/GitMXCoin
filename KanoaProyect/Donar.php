<?php
// Verificar si se ha enviado el formulario de donación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener la cantidad de criptomonedas donadas y el ID del usuario receptor
    $cantidadDonada = $_POST['cantidad'];
    $idUsuarioReceptor = $_POST['id_receptor'];

    // Validar los datos si es necesario

    // Conectarse a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "n0m3l0";
    $dbname = "Jos5Dev";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener el saldo actual del usuario receptor
    $query = "SELECT saldo_criptomonedas FROM usuarios WHERE id = '$idUsuarioReceptor'";
    $resultado = $conn->query($query);
    
    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $saldoActual = $fila['saldo_criptomonedas'];

        // Calcular el nuevo saldo después de la donación
        $nuevoSaldo = $saldoActual + $cantidadDonada;

        // Actualizar el saldo en la base de datos
        $queryUpdate = "UPDATE usuarios SET saldo_criptomonedas = '$nuevoSaldo' WHERE id = '$idUsuarioReceptor'";
        if ($conn->query($queryUpdate) === TRUE) {
            // Donación exitosa
            echo "La donación se ha realizado con éxito.";
        } else {
            // Error al actualizar el saldo
            echo "Error al actualizar el saldo: " . $conn->error;
        }
    } else {
        // No se encontró al usuario receptor
        echo "El usuario receptor no existe.";
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donar Criptomonedas</title>
</head>
<body>
    <h2>Donar Criptomonedas</h2>
    <form method="POST" action="donar.php">
        <label for="cantidad">Cantidad a donar:</label>
        <input type="number" name="cantidad" id="cantidad" required>
        <input type="hidden" name="id_receptor" value="ID_DEL_USUARIO_RECEPTOR"> <!-- Reemplazar con el ID del usuario receptor -->

        <input type="submit" value="Donar">
    </form>

    <h2>Insertar 100 Criptomonedas</h2>
    <form method="POST" action="donar.php">
        <input type="hidden" name="cantidad" value="100">
        <input type="hidden" name="id_receptor" value="ID_DEL_USUARIO_ACTUAL"> <!-- Reemplazar con el ID del usuario actual -->

        <input type="submit" value="Insertar 100 Criptomonedas">
    </form>
</body>
</html>
