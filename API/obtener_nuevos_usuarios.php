<?php
// Conexión a la base de datos
include_once '../PHP/conexion.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

// Parámetro de tiempo (últimos X minutos)
$tiempo = isset($_GET['minutos']) ? (int) $_GET['minutos'] : 10;

// Consulta para obtener los nuevos usuarios registrados en los últimos X minutos
$sql = "SELECT Correo, Nombre FROM clientes WHERE fecha_registro >= NOW() - INTERVAL ? MINUTE";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $tiempo);
$stmt->execute();
$result = $stmt->get_result();

$usuarios = [];
while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

// Devolver los correos en formato JSON
echo json_encode($usuarios);
$stmt->close();
$conexion->close();
?>
