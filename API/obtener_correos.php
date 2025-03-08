<?php
// Configuración de la base de datos
include_once '../PHP/conexion.php';

// Configuración de encabezados para evitar bloqueos por CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Token de seguridad
$token = "clave_secreta";

// Verificar el token en la URL
if (!isset($_GET['token']) || $_GET['token'] !== $token) {
    die(json_encode(["error" => "Acceso no autorizado"]));
}

// Verificar si la conexión es válida
if (!$conexion) {
    die(json_encode(["error" => "Error en la conexión a la base de datos."]));
}

// Consulta SQL corregida
$sql = "SELECT Correo FROM clientes -- WHERE suscrito_marketing = 1";
$result = $conexion->query($sql);

// Verificar si la consulta fue exitosa
if (!$result) {
    die(json_encode(["error" => "Error en la consulta: " . $conexion->error]));
}

// Extraer los correos y almacenarlos en un array
$emails = [];
while ($row = $result->fetch_assoc()) {
    $emails[] = $row['Correo'];
}

// Devolver los correos en formato JSON
echo json_encode($emails);

// Cerrar la conexión
$conexion->close();
?>
