<?php
include '../PHP/conexion.php';

// Verificar si se recibieron los id necesarios
if (isset($_GET['id']) && isset($_GET['estado'])) {
    $idDetallePedido = $_GET['id'];
    $nuevoEstado = $_GET['estado'];

    // Validar que el estado sea válido (1 = EN PROCESO, 2 = ENVIADO, 3 = RECIBIDO)
    if (in_array($nuevoEstado, [1, 2, 3])) {
        // Consulta SQL para actualizar el estado
        $query = "UPDATE detalles_pedido SET ID_Estado = ? WHERE ID_DetallePedido = ?";

        // Preparar la consulta
        if ($stmt = $conexion->prepare($query)) {
            $stmt->bind_param("ii", $nuevoEstado, $idDetallePedido);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Redirigir al listado de pedidos después de actualizar
                header("Location: ../ADMINISTRACION/ver_pedidos.php");
                exit();
            } else {
                echo "Error al actualizar el estado.";
            }

            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta.";
        }
    } else {
        echo "Estado no válido.";
    }
} else {
    echo "Faltan parámetros.";
}

// Cerrar la conexión
$conexion->close();
?>
