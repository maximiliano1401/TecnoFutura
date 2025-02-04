<?php
include "conexion.php";
session_start();

// Verifica si la sesión del cliente está activa
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: index.html");
    exit;
}

// Verifica si se recibieron los datos requeridos
if (isset($_POST['id_producto']) && isset($_POST['id_cliente'])) {
    $id_producto = $_POST['id_producto'];
    $id_cliente = $_POST['id_cliente']; 

    // Verifica si el producto ya está en el carrito
    $sql_verificar = "SELECT * FROM carrito_compras WHERE ID_Cliente = '$id_cliente' AND ID_Producto = '$id_producto'";
    $resultado = $conexion->query($sql_verificar);

    if ($resultado->num_rows > 0) {
        // Si el producto ya está en el carrito, no hace nada o puedes mostrar un mensaje
        header("Location: ../HTML/carrito.php?mensaje=El producto ya está en el carrito");
    } else {
        // Si no está en el carrito, lo inserta con cantidad 1
        $sql_insertar = "INSERT INTO carrito_compras (ID_Cliente, ID_Producto, Cantidad) VALUES ('$id_cliente', '$id_producto', 1)";
        if ($conexion->query($sql_insertar) === TRUE) {
            header("Location: ../HTML/carrito.php?mensaje=Producto agregado al carrito");
        } else {
            echo "Error al agregar el producto al carrito: " . $conexion->error;
        }
    }
} else {
    echo "Datos incompletos.";
}
?>
