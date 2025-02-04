<?php
include "conexion.php";

// Verificación de sesión activa
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: index.html");
    exit;
}

$id_cliente = $_SESSION['ID_Cliente'];

//Validacion donde verificamos que hayamos recibido los datos.
if (isset($_POST['id_producto'], $_POST['metodo_pago'], $_POST['direccion'])) {
    $id_producto = $_POST['id_producto'];
    $id_metodo = $_POST['metodo_pago'];
    $id_direccion = $_POST['direccion'];

    // Insertar el detalle del pedido en la tabla detalles_pedidos
    $sql_insert = "INSERT INTO detalles_pedido (ID_Estado, ID_Producto, Cantidad, ID_Cliente, ID_Metodo, ID_Direccion)
                   VALUES (1, ?, 1, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_insert);
    $stmt->bind_param("iiii", $id_producto, $id_cliente, $id_metodo, $id_direccion);

    if ($stmt->execute()) {
        echo "Compra registrada con éxito.";
        header("Location: ../HTML/compra_exitosa.html");
    } else {
        echo "Error al registrar la compra: " . $conexion->error;
    }

    $stmt->close();
} else {
    echo "Datos incompletos para procesar la compra.";
}

$conexion->close();
?>
