<?php
include '../PHP/conexion.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_cliente = $_GET['id'];

    // Preparar respuestas JSON
    $response = ["status" => "", "message" => ""];

    // Primero eliminar los registros de carrito_compras relacionados con el cliente
    $delete_cart_query = "DELETE FROM carrito_compras WHERE ID_Cliente = ?";
    $stmt_delete_cart = $conexion->prepare($delete_cart_query);
    if ($stmt_delete_cart === false) {
        $response["status"] = "error";
        $response["message"] = "Error al preparar la consulta de eliminación en carrito_compras: " . $conexion->error;
        echo json_encode($response);
        exit;
    }
    $stmt_delete_cart->bind_param("i", $id_cliente);
    
    if ($stmt_delete_cart->execute()) {
        $response["message"] .= "Registros en carrito_compras eliminados con éxito.<br>";
    } else {
        $response["status"] = "error";
        $response["message"] = "Error al eliminar registros en carrito_compras: " . $stmt_delete_cart->error . "<br>";
        echo json_encode($response);
        exit;
    }

    // Eliminar los registros de detalles_pedido relacionados con el cliente
    $eliminar_detalles_pedidos = "DELETE FROM detalles_pedido WHERE ID_Cliente = ?";
    $stmt_delete_detalles = $conexion->prepare($eliminar_detalles_pedidos);
    if ($stmt_delete_detalles === false) {
        $response["status"] = "error";
        $response["message"] = "Error al preparar la consulta de eliminación en detalles_pedido: " . $conexion->error;
        echo json_encode($response);
        exit;
    }
    $stmt_delete_detalles->bind_param("i", $id_cliente);
    
    if ($stmt_delete_detalles->execute()) {
        $response["message"] .= "Registros en detalles_pedido eliminados con éxito.<br>";
    } else {
        $response["status"] = "error";
        $response["message"] = "Error al eliminar registros en detalles_pedido: " . $stmt_delete_detalles->error . "<br>";
        echo json_encode($response);
        exit;
    }

    // Eliminar los registros de direcciones relacionados con el cliente
    $eliminar_direcciones = "DELETE FROM direcciones WHERE ID_Cliente = ?";
    $stmt_delete_direcciones = $conexion->prepare($eliminar_direcciones);
    if ($stmt_delete_direcciones === false) {
        $response["status"] = "error";
        $response["message"] = "Error al preparar la consulta de eliminación en direcciones: " . $conexion->error;
        echo json_encode($response);
        exit;
    }
    $stmt_delete_direcciones->bind_param("i", $id_cliente);
    
    if ($stmt_delete_direcciones->execute()) {
        $response["message"] .= "Registros en direcciones eliminados con éxito.<br>";
    } else {
        $response["status"] = "error";
        $response["message"] = "Error al eliminar registros en direcciones: " . $stmt_delete_direcciones->error . "<br>";
        echo json_encode($response);
        exit;
    }

    // Eliminar los registros de metodospago relacionados con el cliente
    $eliminar_metodo = "DELETE FROM metodospagos WHERE ID_Cliente = ?";
    $stmt_delete_metodo = $conexion->prepare($eliminar_metodo);
    if ($stmt_delete_metodo === false) {
        $response["status"] = "error";
        $response["message"] = "Error al preparar la consulta de eliminación en metodospago: " . $conexion->error;
        echo json_encode($response);
        exit;
    }
    $stmt_delete_metodo->bind_param("i", $id_cliente);
    
    if ($stmt_delete_metodo->execute()) {
        $response["message"] .= "Registros en metodospago eliminados con éxito.<br>";
    } else {
        $response["status"] = "error";
        $response["message"] = "Error al eliminar registros en metodospago: " . $stmt_delete_metodo->error . "<br>";
        echo json_encode($response);
        exit;
    }

    // Luego eliminar al cliente
    $delete_client_query = "DELETE FROM clientes WHERE ID_Cliente = ?";
    $stmt_delete_client = $conexion->prepare($delete_client_query);
    if ($stmt_delete_client === false) {
        $response["status"] = "error";
        $response["message"] = "Error al preparar la consulta de eliminación del cliente: " . $conexion->error;
        echo json_encode($response);
        exit;
    }
    $stmt_delete_client->bind_param("i", $id_cliente);

    if ($stmt_delete_client->execute()) {
        $response["status"] = "success";
        $response["message"] .= "Cliente eliminado con éxito.";
    } else {
        $response["status"] = "error";
        $response["message"] = "Error al eliminar el cliente: " . $stmt_delete_client->error;
    }
} else {
    $response["status"] = "error";
    $response["message"] = "ID del cliente no especificado.";
}

echo json_encode($response);
exit;
?>
