<?php
include '../PHP/conexion.php';

// Comprobar si se ha pasado el ID del producto
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $response = ["status" => "error", "message" => "Error: No se especificó el ID del producto."];
    echo json_encode($response);
    exit;
}

$id_producto = $_GET['id'];

// Consulta para eliminar el producto de la tabla productos
$query = "DELETE FROM productos WHERE ID_Producto = ?";

// Eliminar las fotos del producto en productos_fotos
$consulta_eliminacion_fotos = "DELETE FROM productos_fotos WHERE ID_Producto = ?";
$smt_fotos = $conexion->prepare($consulta_eliminacion_fotos);
$smt_fotos->bind_param("i", $id_producto);
$smt_fotos->execute();

// Eliminar registros en el carrito de compras
$consulta_eliminacion_carrito = "DELETE FROM carrito_compras WHERE ID_Producto = ?";
$smt_carrito = $conexion->prepare($consulta_eliminacion_carrito);
$smt_carrito->bind_param("i", $id_producto);
$smt_carrito->execute();

// Eliminar registro en detalles pedido
$consulta_eliminacion_pedidos = "DELETE FROM detalles_pedido WHERE ID_Producto = ?";
$stmt_detalles = $conexion->prepare($consulta_eliminacion_pedidos);
$stmt_detalles->bind_param("i", $id_producto);
$stmt_detalles->execute();

// Preparar y ejecutar la consulta
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_producto);

if ($stmt->execute()) {
    $response = ["status" => "success", "message" => "Producto eliminado con éxito."];
} else {
    $response = ["status" => "error", "message" => "Error al eliminar el producto: " . $conexion->error];
}

$smt_fotos->close();
$smt_carrito->close();
$stmt_detalles->close();
$stmt->close();
$conexion->close();

echo json_encode($response);
exit;
?>
