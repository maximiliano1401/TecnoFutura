<?php
// Configuración de la base de datos
include_once 'conexion.php';

// Consulta para obtener los correos de usuarios registrados
$sql = "SELECT Correo FROM clientes -- WHERE suscrito_marketing = 1";
$result = $conexion->query($sql);

$emails = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $emails[] = $row['Correo'];
    }
}

// Devolver los correos en formato JSON
header('Content-Type: application/json');
echo json_encode($emails);

$conn->close();
?>
