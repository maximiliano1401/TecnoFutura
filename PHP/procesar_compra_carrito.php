<?php
include "conexion.php";

// Verificar si hay sesión activa
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: ../HTML/index.html");
    exit;
}

$id_cliente = $_SESSION['ID_Cliente'];

//Validacion para verificar datos recibidos
if (!isset($_POST['metodo_pago']) || !isset($_POST['direccion'])) {
    echo "Método de pago o dirección no seleccionados.";
    exit;
}

$id_metodo = $_POST['metodo_pago'];
$id_direccion = $_POST['direccion'];

//Obtenemos los productos del carrito
$sql_carrito = "
    SELECT c.ID_Producto, c.Cantidad
    FROM carrito_compras c
    WHERE c.ID_Cliente = ?";
$stmt_carrito = $conexion->prepare($sql_carrito);
$stmt_carrito->bind_param("i", $id_cliente);
$stmt_carrito->execute();
$result_carrito = $stmt_carrito->get_result();

if ($result_carrito->num_rows > 0) {

    //Se hace conexion a la BD para empezar la compra (Usamos transaction para confirmar o revertir cambios)
    $conexion->begin_transaction();
    try {
        // Insertar detalles de cada producto en detalles_pedidos
        $sql_detalles = "INSERT INTO detalles_pedido (ID_Estado, ID_Producto, Cantidad, ID_Cliente, ID_Metodo, ID_Direccion) 
                         VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_detalles = $conexion->prepare($sql_detalles);

        //Estado inicial para el pedido
        $id_estado = 1; // Ejemplo: 1 = "Pendiente"

        //Insertar cada producto
        while ($producto = $result_carrito->fetch_assoc()) {
            $id_producto = $producto['ID_Producto'];
            $cantidad = $producto['Cantidad'];

            // Usamos parametros de validacion donde esperamos recibir datos i osea tipo INT
            $stmt_detalles->bind_param("iiiiii", $id_estado, $id_producto, $cantidad, $id_cliente, $id_metodo, $id_direccion);
            $stmt_detalles->execute();
        }

        // Vaciar carrito después de procesar la compra
        $sql_vaciar_carrito = "DELETE FROM carrito_compras WHERE ID_Cliente = ?";
        $stmt_vaciar_carrito = $conexion->prepare($sql_vaciar_carrito);
        $stmt_vaciar_carrito->bind_param("i", $id_cliente);
        $stmt_vaciar_carrito->execute();

        // Confirmar transacción
        $conexion->commit();

        echo "Compra procesada exitosamente.";
        header("Location: ../HTML/compra_exitosa.html");
    } catch (Exception $e) {
        // Revertir transacción en caso de error
        $conexion->rollback();
        echo "Error al procesar la compra: " . $e->getMessage();
    }
} else {
    echo "El carrito está vacío.";
}

$stmt_carrito->close();
$conexion->close();
?>
