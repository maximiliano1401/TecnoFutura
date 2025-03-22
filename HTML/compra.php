<?php
include "../PHP/conexion.php";

// Verificación de sesión activa
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: index.html");
    exit;
}

// Obtener los datos del cliente
$id_cliente = $_SESSION['ID_Cliente'];

// Consulta metodos de pago del cliente
$sql_metodos = "SELECT ID_Metodo, Titular, Numeros, MyA FROM metodospagos WHERE ID_Cliente = $id_cliente";
$result_metodos = $conexion->query($sql_metodos);

// Consulta direcciones del cliente
$sql_direcciones = "SELECT ID_Direccion, Calle, NumExt, NumInt, Colonia FROM direcciones WHERE ID_Cliente = $id_cliente";
$result_direcciones = $conexion->query($sql_direcciones);

// Verificar si hay métodos de pago
$hay_metodos = $result_metodos->num_rows > 0;

// Verificar si hay direcciones
$hay_direcciones = $result_direcciones->num_rows > 0;

// Verificar producto enviado
if (isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];

    // Consulta detalles del producto
    $sql_producto = "SELECT Nombre, Precio FROM productos WHERE ID_Producto = $id_producto";
    $result_producto = $conexion->query($sql_producto);

    if ($result_producto->num_rows > 0) {
        $producto = $result_producto->fetch_assoc();
        $nombre_producto = $producto['Nombre'];
        $precio_producto = $producto['Precio'];
    } else {
        echo "Producto no encontrado.";
        exit;
    }
} else {
    echo "Producto no válido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Compra</title>
    <link rel="stylesheet" href="../CSS/compra.css">
    <script>
        function redirigirNuevoMetodo() {
            window.location.href = "nuevo_metodo.php";
        }

        function redirigirNuevaDireccion() {
            window.location.href = "nueva_direccion.php";
        }
    </script>
</head>
<body>
<img class="boton" src="../IMG/Arrow-left-circle.png" onclick="window.location.href='carrito.php'">

<div class="contenedor-compra">
<h1>Confirmar Compra</h1>

        <!-- Detalles del producto -->
        <div class="tarjeta">
            <div class="card-body">
                <h5 class="etiqueta">Detalles del Producto</h5>
                <p><strong>Producto:</strong> <?php echo $nombre_producto; ?></p>
                <p><strong>Precio:</strong> $<?php echo number_format($precio_producto, 2); ?> MXN</p>
            </div>
        </div>

        <form action="../PHP/procesar_compra.php" method="post">
            <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
            <input type="hidden" name="id_cliente" value="<?php echo $id_cliente; ?>">

            <!-- Selección de metodo de pago -->
            <div class="seccion">
                <label for="metodo_pago" class="etiqueta">Método de Pago</label>
                <?php if ($hay_metodos): ?>
                    <select name="metodo_pago" id="metodo_pago" class="campo-seleccion" required>
                        <option value="">Selecciona un método de pago</option>
                        <?php while ($fila = $result_metodos->fetch_assoc()): ?>
                            <option value="<?php echo $fila['ID_Metodo']; ?>">
                                <?php 
                                // USAMOS SUBSTRING -4 PARA ESPECIFICAR INICIO EN LOS 4 DIGITOS FINALES
                                $numero_final = substr($fila['Numeros'], -4);
                                echo $fila['Titular'] . " - **** " . $numero_final . " (Exp. " . $fila['MyA'] . ")"; 
                                ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                <?php else: ?>
                    <div class="alerta" role="alert">
                        No tienes métodos de pago registrados.
                        <button type="button" class="boton-fondoo " onclick="redirigirNuevoMetodo()">Agregar Método de Pago</button>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Selección de direccion -->
            <div class="seccion">
                <label for="direccion" class="etiqueta">Dirección de Envío</label>
                <?php if ($hay_direcciones): ?>
                    <select name="direccion" id="direccion" class="campo-seleccion" required>
                        <option value="">Selecciona una dirección</option>
                        <?php while ($fila = $result_direcciones->fetch_assoc()): ?>
                            <option value="<?php echo $fila['ID_Direccion']; ?>">
                                <?php 
                                echo $fila['Calle'] . " #" . $fila['NumExt'];
                                if (!empty($fila['NumInt'])) {
                                    echo " Int. " . $fila['NumInt'];
                                }
                                echo ", " . $fila['Colonia'];
                                ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                <?php else: ?>
                    <div class="alerta" role="alert">
                        No tienes direcciones registradas.
                        <button type="button" class="boton-fondoo" onclick="redirigirNuevaDireccion()">Agregar Dirección</button>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Botón de confirmacion -->
            <?php if ($hay_metodos && $hay_direcciones): ?>
                <div class="etiqueta">
                    <p><strong>Total a pagar:</strong> $<?php echo number_format($precio_producto, 2); ?> MXN</p>
                </div><br>
                <button type="submit" class="boton-fondoo">Confirmar Compra</button>
            <?php else: ?>
                <div class="alert alert-warning" role="alert">
                    Completa tus métodos de pago y direcciones antes de continuar.
                </div>
            <?php endif; ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
