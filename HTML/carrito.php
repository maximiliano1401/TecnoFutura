<?php
include "../PHP/conexion.php";

// Verifica si la sesión del cliente está activa
session_start();
// if (!isset($_SESSION['ID_Cliente'])) {
//     header("Location: index.html");
//     exit;
// }

$id_cliente = $_SESSION['ID_Cliente'];

// Procesar eliminación de producto
if (isset($_POST['eliminar'])) {
    $id_producto_eliminar = $_POST['id_producto'];
    $sql_eliminar = "DELETE FROM carrito_compras WHERE ID_Cliente = '$id_cliente' AND ID_Producto = '$id_producto_eliminar'";
    $conexion->query($sql_eliminar);
    header("Location: carrito.php");
    exit;
}

// Consulta para obtener los productos del carrito
$sql_carrito = "
    SELECT 
        p.Nombre, 
        p.Precio, 
        pf.Ruta1 AS Foto, 
        c.Cantidad, 
        p.ID_Producto 
    FROM carrito_compras c 
    JOIN productos p ON c.ID_Producto = p.ID_Producto 
    LEFT JOIN productos_fotos pf ON p.ID_Producto = pf.ID_Producto 
    WHERE c.ID_Cliente = '$id_cliente'";

$resultado = $conexion->query($sql_carrito);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/carrito.css">
</head>

<body>
    <!-- Incluir menu de navegación -->
    <?php include "navbar.php" ?>

    <main class="contenedor-carrito">
        <section class="carrito">
            <h2>Carrito (<?php echo $resultado->num_rows; ?>)</h2>
            <div class="lista-productos">
                <?php if ($resultado->num_rows > 0): ?>
                    <?php $total = 0; ?>
                    <?php $cantidad = 0; ?>
                    <?php while ($producto = $resultado->fetch_assoc()):
                        $subtotal = $producto['Precio'] * $producto['Cantidad'];
                        $total += $subtotal;
                        $cantidad += $producto['Cantidad'];
                    ?>
                        <div class="producto">
                            <img src="../IMG/<?php echo $producto['Foto']; ?>" alt="<?php echo $producto['Nombre']; ?>">
                            <div class="detalles">
                                <h3><?php echo $producto['Nombre']; ?></h3>
                                <p class="precio">$<?php echo $producto['Precio']; ?></p>
                            </div>
                            <div class="cantidad">
        <button class="btn-decrementar" data-id="<?php echo $producto['ID_Producto']; ?>">-</button>
        <span id="cantidad-<?php echo $producto['ID_Producto']; ?>"><?php echo $producto['Cantidad']; ?></span>
        <button class="btn-incrementar" data-id="<?php echo $producto['ID_Producto']; ?>">+</button>
    </div>
                            <div class="remove-item">
                                <button class="btn" onclick="openModal(<?php echo $producto['ID_Producto']; ?>)">
                                <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No tienes productos en tu carrito.</p>
                    <?php 
                    $total = 0; 
                    $cantidad = 0;
                    ?>
                <?php endif; ?>
            </div>
        </section>
        <aside class="resumen">
            <h3>Resumen</h3>
            <p>Subtotal: MXM <span>$<?php echo $total; ?></span></p>
            <p>Cantidad: <span><?php echo $cantidad; ?></span></p>
            <!-- <p>Costo de envío: MXM <span>$4000</span></p> -->
            <p class="descuento">Cupón de descuento no aplica</p>
            <p class="total">Total: MXM <span>$<?php echo $total?></span></p>
            <button class="pagar" onclick="window.location.href='compra_carrito.php'">Proceder a pagar</button>
        </aside>
    </main>
    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este producto del carrito?
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" action="" method="post">
                        <input type="hidden" name="id_producto" id="id_producto">
                        <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin-top: 24px;">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- jQuery completo -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function openModal(idProducto) {
            document.getElementById('id_producto').value = idProducto;
            $('#deleteModal').modal('show');
        }

        $(document).ready(function () {
        $('.close, .btn-secondary').on('click', function () {
            $('#deleteModal').modal('hide');
        });
    });

    $(document).ready(function () {
        // Incrementar cantidad
        $('.btn-incrementar').on('click', function () {
            const idProducto = $(this).data('id');
            const cantidadActual = parseInt($('#cantidad-' + idProducto).text());
            const nuevaCantidad = cantidadActual + 1;

            // Actualiza la cantidad en el DOM
            $('#cantidad-' + idProducto).text(nuevaCantidad);

            // Llamada AJAX para actualizar en el servidor
            actualizarCantidad(idProducto, nuevaCantidad);
        });

        // Decrementar cantidad
        $('.btn-decrementar').on('click', function () {
            const idProducto = $(this).data('id');
            const cantidadActual = parseInt($('#cantidad-' + idProducto).text());

            if (cantidadActual > 1) {
                const nuevaCantidad = cantidadActual - 1;
                $('#cantidad-' + idProducto).text(nuevaCantidad);
                actualizarCantidad(idProducto, nuevaCantidad);
            }
        });

        // Función para actualizar la cantidad vía AJAX
        function actualizarCantidad(idProducto, nuevaCantidad) {
            $.ajax({
                url: '../PHP/actualizar_carrito.php',
                type: 'POST',
                data: { id_producto: idProducto, cantidad: nuevaCantidad },
                success: function (response) {
                    try {
                        const data = JSON.parse(response);
                        if (data.success) {
                            console.log('Carrito actualizado:', data.success);
                            // Actualizar el subtotal y total si es necesario
                            location.reload(); // Recarga la página para reflejar cambios en el total
                        } else {
                            console.error('Error:', data.error);
                        }
                    } catch (e) {
                        console.error('Error en la respuesta del servidor:', e);
                    }
                },
                error: function (error) {
                    console.error('Error AJAX:', error);
                }
            });
        }
    });
    </script>
</body>

</html>