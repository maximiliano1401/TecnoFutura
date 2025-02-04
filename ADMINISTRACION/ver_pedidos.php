<?php
include '../PHP/conexion.php';

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: ../HTML/index.html");
    exit;
}

// Consulta SQL para obtener los detalles de pedidos con toda la información relacionada
$query = "
SELECT 
    dp.ID_DetallePedido, 
    ep.Descripcion AS Estado,
    p.Nombre AS Producto,
    dp.Cantidad,
    c.Nombre AS Cliente,
    c.Correo,
    c.Telefono,
    mp.Titular AS MetodoPago,
    mp.Numeros AS Tarjeta,
    d.Calle,
    d.NumExt,
    d.NumInt,
    d.Entrecalles,
    d.NumContacto,
    d.Colonia
FROM detalles_pedido dp
LEFT JOIN estado_pedidos ep ON dp.ID_Estado = ep.ID_Estado
LEFT JOIN productos p ON dp.ID_Producto = p.ID_Producto
LEFT JOIN clientes c ON dp.ID_Cliente = c.ID_Cliente
LEFT JOIN metodospagos mp ON dp.ID_Metodo = mp.ID_Metodo
LEFT JOIN direcciones d ON dp.ID_Direccion = d.ID_Direccion
";

// Ejecutar consulta
$result = $conexion->query($query);

if (!$result) {
    die("Error en la consulta: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Pedidos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/ver_pedidos.css">
</head>
<body>
<img class="boton" src="../IMG/Button.png" onclick="window.location.href='administracion.php'">
    <div class="container">
        <h1>Listado de Pedidos</h1>
        <table>
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Estado</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Cliente</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Método de Pago</th>
                    <th>Tarjeta</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pedido = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $pedido['ID_DetallePedido']; ?></td>
                        <td><?= $pedido['Estado']; ?></td>
                        <td><?= $pedido['Producto']; ?></td>
                        <td><?= $pedido['Cantidad']; ?></td>
                        <td><?= $pedido['Cliente']; ?></td>
                        <td><?= $pedido['Correo']; ?></td>
                        <td><?= $pedido['Telefono']; ?></td>
                        <td><?= $pedido['MetodoPago']; ?></td>
                        <td><?= $pedido['Tarjeta']; ?></td>
                        <td>
                            <?= $pedido['Calle']; ?> #<?= $pedido['NumExt']; ?><?= $pedido['NumInt'] ? ', Int: ' . $pedido['NumInt'] : ''; ?>, 
                            <?= $pedido['Colonia']; ?> (<?= $pedido['Entrecalles']; ?>, Contacto: <?= $pedido['NumContacto']; ?>)
                        </td>
                        <td>
                            <a href="editar_pedido.php?id=<?= $pedido['ID_DetallePedido']; ?>" class="btn editar">Editar</a>
                            <button type="button" class="btn eliminar" onclick="openDeleteModal(<?= $pedido['ID_DetallePedido']; ?>)">Eliminar</button>
                            <a href="../PHP_ADMINISTRACION/cambiar_estado.php?id=<?= $pedido['ID_DetallePedido']; ?>&estado=2" class="btn enviar">Enviado</a>
                            <a href="../PHP_ADMINISTRACION/cambiar_estado.php?id=<?= $pedido['ID_DetallePedido']; ?>&estado=3" class="btn recibir">Recibido</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal de Confirmación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este pedido?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

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
        var idPedidoAEliminar = null;

        function openDeleteModal(idPedido) {
            idPedidoAEliminar = idPedido;
            $('#deleteModal').modal('show');
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (idPedidoAEliminar !== null) {
                $.ajax({
                    url: '../PHP_ADMINISTRACION/eliminar_pedido.php',
                    type: 'GET',
                    data: {id: idPedidoAEliminar},
                    dataType: 'json',
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        $('#modalResponseMessage').text(response.message);
                        $('#responseModal').modal('show');
                        if (response.status === 'success') {
                            setTimeout(function() {
                                window.location.href = 'ver_pedidos.php';
                            }, 2000);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#deleteModal').modal('hide');
                        $('#modalResponseMessage').text('Hubo un error en la solicitud.');
                        $('#responseModal').modal('show');
                    }
                });
            }
        });
    </script>
</body>
</html>
