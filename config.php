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
?>
