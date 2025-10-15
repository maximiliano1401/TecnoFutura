<?php
include '../PHP/conexion.php';

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: ../HTML/index.html");
    exit;
}

// Consulta SQL para obtener los datos necesarios
$query = "
SELECT 
    p.ID_Producto, 
    p.Nombre, 
    p.Descripcion, 
    p.Precio, 
    p.Stock, 
    c.Nombre AS Categoria, 
    m.Marca,
    f.Ruta1,
    f.Ruta2
FROM productos p
LEFT JOIN categorias c ON p.ID_Categoria = c.ID_Categoria
LEFT JOIN marcas m ON p.ID_Marca = m.ID_Marca
LEFT JOIN productos_fotos f ON p.ID_Producto = f.ID_Producto
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
    <title>Listado de Productos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/ver_productos.css">
</head>
<body>
<img class="boton" src="../IMG/Button.png" onclick="window.location.href='administracion.php'">
    <div class="container">
        <h1>Listado de Productos</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Marca</th>
                    <th>Foto 1</th>
                    <th>Foto 2</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($producto = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $producto['ID_Producto']; ?></td>
                        <td><?= $producto['Nombre']; ?></td>
                        <td><?= $producto['Descripcion']; ?></td>
                        <td>$<?= $producto['Precio']; ?></td>
                        <td><?= $producto['Stock']; ?></td>
                        <td><?= $producto['Categoria']; ?></td>
                        <td><?= $producto['Marca']; ?></td>
                        <td>
                            <?php if (!empty($producto['Ruta1'])): ?>
                                <img src="<?= $producto['Ruta1']; ?>" alt="Foto 1">
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($producto['Ruta2'])): ?>
                                <img src="<?= $producto['Ruta2']; ?>" alt="Foto 2">
                            <?php endif; ?>
                        </td>
                        <td class="acciones">
                            <a href="editar_producto.php?id=<?= $producto['ID_Producto']; ?>" class="btn editar">Editar</a>
                            <button type="button" class="btn eliminar" onclick="openDeleteModal(<?= $producto['ID_Producto']; ?>)">Eliminar</button>
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
                    ¿Estás seguro de que deseas eliminar este producto?
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

        function openDeleteModal(productId) {
            idProductoAEliminar = productId;
            $('#deleteModal').modal('show');
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (idProductoAEliminar !== null) {
                $.ajax({
                    url: '../PHP_ADMINISTRACION/eliminar_producto.php',
                    type: 'GET',
                    data: {id: idProductoAEliminar},
                    dataType: 'json',
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        $('#modalResponseMessage').text(response.message);
                        $('#responseModal').modal('show');
                        if (response.status === 'success') {
                            setTimeout(function() {
                                window.location.href = '../ADMINISTRACION/ver_productos.php';
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
