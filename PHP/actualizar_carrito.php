<?php
// Verifica la sesión del cliente
session_start();
include "conexion.php";

if (!isset($_SESSION['ID_Cliente'])) {
    echo json_encode(['error' => 'No estás logueado']);
    exit;
}

$id_cliente = $_SESSION['ID_Cliente'];

if (isset($_POST['id_producto']) && isset($_POST['cantidad'])) {
    $id_producto = intval($_POST['id_producto']);
    $nueva_cantidad = intval($_POST['cantidad']);

    // Validación de cantidad válida
    if ($nueva_cantidad < 1) {
        echo json_encode(['error' => 'Cantidad no válida']);
        exit;
    }

    // Consulta para revisar si el producto está en el carrito
    $sql_verificar = "SELECT * FROM carrito_compras WHERE ID_Cliente = ? AND ID_Producto = ?";
    $stmt_verificar = $conexion->prepare($sql_verificar);
    $stmt_verificar->bind_param("ii", $id_cliente, $id_producto);
    $stmt_verificar->execute();
    $resultado = $stmt_verificar->get_result();

    if ($resultado->num_rows > 0) {
        // Si existe, se actualiza la cantidad
        $sql = "UPDATE carrito_compras SET Cantidad = ? WHERE ID_Cliente = ? AND ID_Producto = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("iii", $nueva_cantidad, $id_cliente, $id_producto);

        if ($stmt->execute()) {
            echo json_encode(['success' => 'Cantidad actualizada correctamente']);
        } else {
            echo json_encode(['error' => 'Error al actualizar la cantidad']);
        }
    } else {
        echo json_encode(['error' => 'El producto no está en el carrito']);
    }
} else {
    echo json_encode(['error' => 'Datos incompletos']);
}
?>