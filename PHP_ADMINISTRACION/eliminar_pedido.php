<?php
include '../PHP/conexion.php';

// Comprobar si se ha pasado el ID del producto
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $response = ["status" => "error", "message" => "Error: No se especificó el ID del producto."];
    echo json_encode($response);
    exit;
}

$ID_DetallePedido = $_GET['id'];

// Consulta para eliminar el producto de la tabla productos
$query = "DELETE FROM detalles_pedido WHERE ID_DetallePedido = ?";

// Preparar y ejecutar la consulta
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $ID_DetallePedido);

if ($stmt->execute()) {
    $response = ["status" => "success", "message" => "Pedido eliminado con éxito."];
} else {
    $response = ["status" => "error", "message" => "Error al eliminar el producto: " . $conexion->error];
}

$stmt->close();
$conexion->close();

echo json_encode($response);
exit;
?>
