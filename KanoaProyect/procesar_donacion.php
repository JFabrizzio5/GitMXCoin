<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
} else {
    // Obtener el ID del usuario de la sesión
    $idUsuario = $_SESSION['usuario']['id'];
}

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

// Obtener los datos del formulario
$idPropietario = isset($_POST['id_propietario']) ? $_POST['id_propietario'] : '';
$cantidadDonacion = isset($_POST['cantidad']) ? $_POST['cantidad'] : '';

// Validar la cantidad de donación
if ($cantidadDonacion <= 0) {
    die("La cantidad de donación debe ser mayor a 0.");
}

// Iniciar la transacción
$conn->begin_transaction();

try {
    // Consultar el saldo del usuario donante
    $querySaldoDonante = "SELECT saldo_criptomonedas FROM usuarios WHERE id = $idUsuario FOR UPDATE";
    $resultadoSaldoDonante = $conn->query($querySaldoDonante);

    if ($resultadoSaldoDonante->num_rows > 0) {
        $filaSaldoDonante = $resultadoSaldoDonante->fetch_assoc();
        $saldoDonante = $filaSaldoDonante['saldo_criptomonedas'];

        // Verificar si el saldo del usuario donante es suficiente para la donación
        if ($saldoDonante >= $cantidadDonacion) {
            // Restar la cantidad donada al saldo del usuario donante
            $saldoDonante -= $cantidadDonacion;

            // Actualizar el saldo del usuario donante en la base de datos
            $queryActualizarSaldoDonante = "UPDATE usuarios SET saldo_criptomonedas = $saldoDonante WHERE id = $idUsuario";
            $conn->query($queryActualizarSaldoDonante);

            // Consultar el saldo del propietario
            $querySaldoPropietario = "SELECT saldo_criptomonedas FROM usuarios WHERE id = $idPropietario FOR UPDATE";
            $resultadoSaldoPropietario = $conn->query($querySaldoPropietario);

            if ($resultadoSaldoPropietario->num_rows > 0) {
                $filaSaldoPropietario = $resultadoSaldoPropietario->fetch_assoc();
                $saldoPropietario = $filaSaldoPropietario['saldo_criptomonedas'];

                // Sumar la cantidad donada al saldo del propietario
                $saldoPropietario += $cantidadDonacion;

                // Actualizar el saldo del propietario en la base de datos
                $queryActualizarSaldoPropietario = "UPDATE usuarios SET saldo_criptomonedas = $saldoPropietario WHERE id = $idPropietario";
                $conn->query($queryActualizarSaldoPropietario);

                // Insertar la donación en la tabla donaciones
                $queryInsertarDonacion = "INSERT INTO donaciones (propietario_id, donacion) VALUES ($idPropietario, $cantidadDonacion)";
                $conn->query($queryInsertarDonacion);

                // Confirmar la transacción
                $conn->commit();

                echo "La donación se ha realizado correctamente.";
            } else {
                throw new Exception("No se encontró el saldo del propietario.");
            }
        } else {
            throw new Exception("No tienes saldo suficiente para realizar la donación.");
        }
    } else {
        throw new Exception("No se encontró el saldo del usuario donante.");
    }
} catch (Exception $e) {
    // Revertir la transacción
    $conn->rollback();

    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
$conn->close();
?>
