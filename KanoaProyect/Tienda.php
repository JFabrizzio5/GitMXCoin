<!DOCTYPE html>
<html>
<head>
    <title>Comprar Monedas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .header {
            background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), linear-gradient(to bottom,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), linear-gradient(135deg,  #670d10 0%,#092756 100%);
            padding: 10px;
            text-align: center;
        }

        .header a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        h3 {
            margin-top: 20px;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        div.radio-group {
            margin-bottom: 10px;
        }

        div.radio-group label {
            margin-left: 10px;
        }

        select {
            margin-top: 10px;
        }

        button[type="submit"] {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="index.php">Volver al inicio</a>
    </div>
    <div class="container">
        <h1>Comprar Monedas</h1>
        <h3>Selecciona un paquete:</h3>
        <form method="post" action="">
            <div class="radio-group">
                <input type="radio" id="paqueteGratis" name="paquete" value="gratis" checked>
                <label for="paqueteGratis">Paquete Gratis (100 Monedas)</label>
            </div>
            <div class="radio-group">
                <input type="radio" id="paquete1000" name="paquete" value="1000">
                <label for="paquete1000">Paquete de 1000 Monedas</label>
            </div>
            <div class="radio-group">
                <input type="radio" id="paquete2000" name="paquete" value="2000">
                <label for="paquete2000">Paquete de 2000 Monedas</label>
            </div>
            <div class="radio-group">
                <input type="radio" id="paquete5000" name="paquete" value="5000">
                <label for="paquete5000">Paquete de 5000 Monedas</label>
            </div>
            <h3>Selecciona la forma de pago:</h3>
            <select name="formaPago">
                <option value="paypal">PayPal</option>
                <option value="metamask">MetaMask</option>
            </select>
            <button type="submit">Comprar</button>
        </form>
    </div>
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

    // Función para sumar monedas al saldo del usuario
    function sumarMonedas($cantidad, $idUsuario) {
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

        // Obtener el saldo actual del usuario
        $querySaldo = "SELECT saldo_criptomonedas FROM usuarios WHERE id = $idUsuario";
        $resultadoSaldo = $conn->query($querySaldo);

        if ($resultadoSaldo->num_rows > 0) {
            $filaSaldo = $resultadoSaldo->fetch_assoc();
            $saldoActual = $filaSaldo['saldo_criptomonedas'];

            // Sumar las monedas compradas al saldo actual
            $saldoActual += $cantidad;

            // Actualizar el saldo en la base de datos
            $queryActualizarSaldo = "UPDATE usuarios SET saldo_criptomonedas = $saldoActual WHERE id = $idUsuario";
            $conn->query($queryActualizarSaldo);

            // Cerrar la conexión
            $conn->close();
        }
    }

    // Obtener el paquete seleccionado y la forma de pago
    if (isset($_POST['paquete']) && isset($_POST['formaPago'])) {
        $paquete = $_POST['paquete'];
        $formaPago = $_POST['formaPago'];

        switch ($paquete) {
            case 'gratis':
                sumarMonedas(100, $idUsuario);
                break;
            case '1000':
            case '2000':
            case '5000':
                if ($formaPago === 'paypal') {
                    // Redirigir a PayPal
                    $paypalURL = "https://www.paypal.com/myaccount/transfer/homepage/buy/preview";
                    header("Location: $paypalURL");
                    exit;
                } elseif ($formaPago === 'metamask') {
                    // Redirigir a la página de inicio de MetaMask
                    $metamaskURL = "https://metamask.io/";
                    echo "<script>window.location.href = '$metamaskURL';</script>";
                    exit;
                }
                break;
        }
    }
    include './canjea.php';
    ?>
</body>
</html>
