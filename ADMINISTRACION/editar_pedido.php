<?php
include '../PHP/conexion.php';

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: ../HTML/index.html");
    exit;
}

// Verificar si se ha pasado el ID del detalle del pedido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $response = ["status" => "error", "message" => "Error: No se especificó el ID del detalle del pedido."];
    echo json_encode($response);
    exit;
}

$id_detalle_pedido = $_GET['id'];

$query = "
SELECT 
    dp.ID_DetallePedido, 
    dp.ID_Estado, 
    dp.ID_Producto, 
    dp.Cantidad, 
    dp.ID_Cliente, 
    dp.ID_Metodo, 
    dp.ID_Direccion, 
    p.Nombre AS Producto, 
    c.Nombre AS Cliente_Nombre, 
    mp.Titular AS Metodo_Pago, 
    CONCAT(d.Calle, ' ', d.NumExt, ' ', IFNULL(d.NumInt, ''), ' ', IFNULL(d.Entrecalles, ''), ' ', d.Colonia) AS Direccion
FROM detalles_pedido dp
JOIN productos p ON dp.ID_Producto = p.ID_Producto
JOIN clientes c ON dp.ID_Cliente = c.ID_Cliente
JOIN metodospagos mp ON dp.ID_Metodo = mp.ID_Metodo
JOIN direcciones d ON dp.ID_Direccion = d.ID_Direccion
WHERE dp.ID_DetallePedido = ?
";

$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_detalle_pedido);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontro el detalle del pedido
if ($result->num_rows === 0) {
    $response = ["status" => "error", "message" => "Error: Detalle del pedido no encontrado."];
    echo json_encode($response);
    exit;
}

$detalle = $result->fetch_assoc();

// Consultas para obtener las opciones de estado, productos, métodos de pago y direcciones
$query_estados = "SELECT * FROM estado_pedidos";
$query_metodos = "SELECT * FROM metodospagos";
$query_direcciones = "SELECT * FROM direcciones WHERE ID_Cliente = ?"; // Filtramos la informacion con los datos de X cliente.
$query_productos = "SELECT * FROM productos";

$result_estados = $conexion->query($query_estados);
$result_metodos = $conexion->query($query_metodos);
$stmt_direcciones = $conexion->prepare($query_direcciones);
$stmt_direcciones->bind_param("i", $detalle['ID_Cliente']);
$stmt_direcciones->execute();
$result_direcciones = $stmt_direcciones->get_result();
$result_productos = $conexion->query($query_productos);

// Comprobar si se envio el formulario para editar el detalle del pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estado = $_POST['estado'];
    $metodo = $_POST['metodo'];
    $direccion = $_POST['direccion'];
    $producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];

    // Actualizar detalle del pedido
    $update_query = "
    UPDATE detalles_pedido
    SET ID_Estado = ?, ID_Producto = ?, Cantidad = ?, ID_Metodo = ?, ID_Direccion = ?
    WHERE ID_DetallePedido = ?
    ";

    $stmt_update = $conexion->prepare($update_query);
    $stmt_update->bind_param("iiiiii", $estado, $producto, $cantidad, $metodo, $direccion, $id_detalle_pedido);

    if ($stmt_update->execute()) {
        $response = ["status" => "success", "message" => "Detalle del pedido actualizado con éxito."];
    } else {
        $response = ["status" => "error", "message" => "Error al actualizar el detalle del pedido: " . $conexion->error];
    }

    echo json_encode($response);
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <link rel="stylesheet" href="../CSS/editar_pedido.css">   
    <title>Editar Detalle del Pedido</title>
</head>
<body>
<img class="boton" src="../IMG/Button.png" onclick="window.location.href='ver_pedidos.php'">

    <h1>Editar Detalle del Pedido</h1>
    <form id="pedidoForm" action="editar_pedido.php?id=<?= $detalle['ID_DetallePedido']; ?>" method="POST">
        <label for="estado">Estado del Pedido</label>
        <select name="estado" id="estado" required>
            <?php while ($estado = $result_estados->fetch_assoc()): ?>
                <option value="<?= $estado['ID_Estado']; ?>" <?= $estado['ID_Estado'] == $detalle['ID_Estado'] ? 'selected' : ''; ?>>
                    <?= $estado['Descripcion']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="producto">Producto</label>
        <select name="producto" id="producto" required>
            <?php while ($producto = $result_productos->fetch_assoc()): ?>
                <option value="<?= $producto['ID_Producto']; ?>" <?= $producto['ID_Producto'] == $detalle['ID_Producto'] ? 'selected' : ''; ?>>
                    <?= $producto['Nombre']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="cantidad">Cantidad</label>
        <input type="number" name="cantidad" id="cantidad" value="<?= $detalle['Cantidad']; ?>" required>

        <label for="metodo">Método de Pago</label>
        <select name="metodo" id="metodo" required>
            <?php while ($metodo = $result_metodos->fetch_assoc()): ?>
                <option value="<?= $metodo['ID_Metodo']; ?>" <?= $metodo['ID_Metodo'] == $detalle['ID_Metodo'] ? 'selected' : ''; ?>>
                    <?= $metodo['Numeros']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="direccion">Dirección</label>
        <select name="direccion" id="direccion" required>
            <?php while ($direccion = $result_direcciones->fetch_assoc()): ?>
                <option value="<?= $direccion['ID_Direccion']; ?>" <?= $direccion['ID_Direccion'] == $detalle['ID_Direccion'] ? 'selected' : ''; ?>>
                    <?= $direccion['Calle'] . ' ' . $direccion['NumExt']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit" class="btn">Actualizar Detalle del Pedido</button>
    </form>

    <!-- Modal de Respuesta -->
    <div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="modalResponseLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalResponseLabel">Mensaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalResponseMessage">
                    <!-- El mensaje se mostrará aquí -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('pedidoForm').addEventListener('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                $('#modalResponseMessage').text(data.message);
                $('#responseModal').modal('show');
            })
            .catch(error => {
                console.error('Error:', error);
                $('#modalResponseMessage').text('Hubo un error en la solicitud.');
                $('#responseModal').modal('show');
            });
        });
    </script>
</body>
</html>
