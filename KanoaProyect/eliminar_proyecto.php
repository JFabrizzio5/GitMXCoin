<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID del proyecto a eliminar
    $idProyecto = $_POST['id'];

    // Eliminar el proyecto de la base de datos
    $query = "DELETE FROM archivos WHERE id = $idProyecto";
    $resultado = $conn->query($query);

    // Redirigir a la página de inicio
    header("Location: home.php");
    exit;
}
?>
