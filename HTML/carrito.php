<?php
include "../PHP/conexion.php";
session_start();

// Verifica si la sesión del cliente está activa
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: index.html");
    exit;
}

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
    <link rel="stylesheet" href="../CSS/carrito.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <img class="boton" src="../IMG/Button.png" onclick="window.location.href='menu.php'">
    <div class="container">
        <br><br><br>
        <img class="logo" src="../IMG/logo.png" alt="Logo" />
        <div class="titulo">Mis Tecnocompras</div>
        <div class="cart">
            <?php if ($resultado->num_rows > 0): ?>
                <?php $total = 0; ?>
                <?php while ($producto = $resultado->fetch_assoc()): 
                    $subtotal = $producto['Precio'] * $producto['Cantidad'];
                    $total += $subtotal;
                ?>
                    <div class="item">
                        <img src="../IMG/<?php echo $producto['Foto']; ?>" alt="<?php echo $producto['Nombre']; ?>">
                        <div class="details">
                            <h3><?php echo $producto['Nombre']; ?></h3>
                            <div class="price">$<span class="item-price"><?php echo $producto['Precio']; ?></span></div>
                        </div>
                        <div class="quantity-control">
                            <span>Cantidad: <?php echo $producto['Cantidad']; ?></span>
                        </div>
                        <div class="remove-item">
                            <button class="btn btn-danger" onclick="openModal(<?php echo $producto['ID_Producto']; ?>)">Eliminar del carrito</button>
                        </div>
                    </div>
                <?php endwhile; ?>
                <div class="summary">
                    <h3>Mis Tecnocompras.</h3>
                    <div class="total">Total: $<span id="total-price"><?php echo $total; ?></span></div>
                    <button class="checkout" onclick="window.location.href='compra_carrito.php'">Pagar</button>
                </div>
            <?php else: ?>
                <p>No tienes productos en tu carrito.</p>
            <?php endif; ?>
        </div>
    </div>

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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openModal(idProducto) {
            document.getElementById('id_producto').value = idProducto;
            $('#deleteModal').modal('show');
        }
    </script>
</body>
</html>
