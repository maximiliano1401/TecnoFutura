<?php
include "../PHP/conexion.php";

// Verificación de sesión activa
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: index.html");
    exit;
}

$id_cliente = $_SESSION['ID_Cliente'];

// Consulta metodos de pago del cliente
$sql_metodos = "SELECT ID_Metodo, Titular, Numeros, MyA FROM metodospagos WHERE ID_Cliente = $id_cliente";
$result_metodos = $conexion->query($sql_metodos);

// Consulta direcciones del cliente
$sql_direcciones = "SELECT ID_Direccion, Calle, NumExt, NumInt, Colonia FROM direcciones WHERE ID_Cliente = $id_cliente";
$result_direcciones = $conexion->query($sql_direcciones);

// Consulta productos del carrito del cliente
$sql_carrito = "
    SELECT c.ID_Producto, p.Nombre, p.Precio, c.Cantidad
    FROM carrito_compras c
    JOIN productos p ON c.ID_Producto = p.ID_Producto
    WHERE c.ID_Cliente = $id_cliente
";
$result_carrito = $conexion->query($sql_carrito);

// Verificar si hay metodos de pago y direcciones
$hay_metodos = $result_metodos->num_rows > 0;
$hay_direcciones = $result_direcciones->num_rows > 0;

// Calcular el total del carrito
$total_carrito = 0;
$productos = [];
if ($result_carrito->num_rows > 0) {
    while ($producto = $result_carrito->fetch_assoc()) {
        $productos[] = $producto;
        $total_carrito += $producto['Precio'] * $producto['Cantidad'];
    }
} else {
    echo "Tu carrito está vacío.";
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
<img class="boton" src="../IMG/Button.png" onclick="window.location.href='carrito.php'">
    <div class="contenedor-compra">
        <h1>Confirmar Compra</h1>

        <!-- Detalles del carrito -->
        <div class="tarjeta">
            <h2>Detalles del Carrito</h2>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo $producto['Nombre']; ?></td>
                        <td><?php echo $producto['Cantidad']; ?></td>
                        <td>$<?php echo number_format($producto['Precio'], 2); ?> MXN</td>
                        <td>$<?php echo number_format($producto['Precio'] * $producto['Cantidad'], 2); ?> MXN</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>
            <p class="total"><strong>Total:</strong> $<?php echo number_format($total_carrito, 2); ?> MXN</p>
        </div>

        <!-- Formulario de confirmacion -->
        <form action="../PHP/procesar_compra_carrito.php" method="post">
            <input type="hidden" name="id_cliente" value="<?php echo $id_cliente; ?>">
            <input type="hidden" name="total" value="<?php echo $total_carrito; ?>">
            <input type="hidden" name="desde_carrito" value="1">

            <!-- Metodos de pago -->
            <div class="seccion">
                <label for="metodo_pago" class="etiqueta">Método de Pago</label>
                <?php if ($hay_metodos): ?>
                    <select name="metodo_pago" id="metodo_pago" class="campo-seleccion" required>
                        <option value="">Selecciona un método de pago</option>
                        <?php while ($fila = $result_metodos->fetch_assoc()): ?>
                            <option value="<?php echo $fila['ID_Metodo']; ?>">
                                <?php 
                                $numero_final = substr($fila['Numeros'], -4);
                                echo $fila['Titular'] . " - **** " . $numero_final . " (Exp. " . $fila['MyA'] . ")"; 
                                ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                <?php else: ?>
                    <div class="alertaa">
                        No tienes métodos de pago registrados.
                        <button type="button" class="boton-fondo" onclick="redirigirNuevoMetodo()">Agregar Método de Pago</button>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Direcciones -->
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
                    <div class="alertaa">
                        No tienes direcciones registradas.
                        <button type="button" class="boton-fondo" onclick="redirigirNuevaDireccion()">Agregar Dirección</button>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Boton de confirmación -->
            <?php if ($hay_metodos && $hay_direcciones): ?>
                <button type="submit" class="boton-fondo">Confirmar Compra</button>
            <?php else: ?>
                <div class="alertaa">
                    Completa tus métodos de pago y direcciones antes de continuar.
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
