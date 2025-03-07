<?php
// Configuración de la base de datos
$host = "localhost";
$usuario = "root";
$contraseña = "";
$base_de_datos = "tecnofutura";

// Conexión a MySQL
$conn = new mysqli($host, $usuario, $contraseña, $base_de_datos);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los correos de usuarios registrados
$sql = "SELECT Correo FROM clientes -- WHERE suscrito_marketing = 1";
$result = $conn->query($sql);

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
