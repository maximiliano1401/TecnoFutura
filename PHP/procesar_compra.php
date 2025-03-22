<?php
include "conexion.php";

// Verificación de sesión activa
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: index.html");
    exit;
}

$id_cliente = $_SESSION['ID_Cliente'];

// Validación para verificar que se hayan recibido los datos necesarios
if (isset($_POST['id_producto'], $_POST['metodo_pago'], $_POST['direccion'])) {
    $id_producto = $_POST['id_producto'];
    $id_metodo = $_POST['metodo_pago'];
    $id_direccion = $_POST['direccion'];

    // Iniciar transacción
    $conexion->begin_transaction();
    try {
        // Verificar el stock disponible
        $sql_stock = "SELECT Stock FROM productos WHERE ID_Producto = ?";
        $stmt_stock = $conexion->prepare($sql_stock);
        $stmt_stock->bind_param("i", $id_producto);
        $stmt_stock->execute();
        $resultado_stock = $stmt_stock->get_result();

        if ($resultado_stock->num_rows > 0) {
            $producto = $resultado_stock->fetch_assoc();
            $stock_disponible = $producto['Stock'];

            if ($stock_disponible > 0) {
                // Insertar el detalle del pedido en la tabla detalles_pedidos
                $sql_insert = "INSERT INTO detalles_pedido (ID_Estado, ID_Producto, Cantidad, ID_Cliente, ID_Metodo, ID_Direccion)
                               VALUES (1, ?, 1, ?, ?, ?)";
                $stmt_insert = $conexion->prepare($sql_insert);
                $stmt_insert->bind_param("iiii", $id_producto, $id_cliente, $id_metodo, $id_direccion);
                $stmt_insert->execute();

                // Actualizar el stock restando la cantidad comprada (1 unidad)
                $sql_resta_stock = "UPDATE productos SET Stock = Stock - 1 WHERE ID_Producto = ?";
                $stmt_resta_stock = $conexion->prepare($sql_resta_stock);
                $stmt_resta_stock->bind_param("i", $id_producto);
                $stmt_resta_stock->execute();

                // Confirmar la transacción
                $conexion->commit();
                echo "Compra registrada y stock actualizado correctamente.";
                header("Location: ../HTML/compra_exitosa.html");
            } else {
                throw new Exception("Stock insuficiente para realizar la compra.");
            }
        } else {
            throw new Exception("Producto no encontrado.");
        }
    } catch (Exception $e) {
        // Revertir transacción en caso de error
        $conexion->rollback();
        echo "Error al procesar la compra: " . $e->getMessage();
    }

    $stmt_stock->close();
    $stmt_insert->close();
    $stmt_resta_stock->close();
} else {
    echo "Datos incompletos para procesar la compra.";
}

$conexion->close();
?>
