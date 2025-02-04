<?php
include "../PHP/conexion.php";
session_start();

// Verificar sesión activa
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: index.html");
    exit;
}

// Verificar si el ID está presente en la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID no especificado en la URL.";
    exit;
}

$id_detalle_pedido = $_GET['id']; // Capturar el ID en una variable

// Consulta para obtener los detalles del pedido
$query = "
    SELECT 
        dp.ID_DetallePedido,
        ep.Descripcion AS Estado, -- Estado del pedido
        p.Nombre AS ProductoNombre, -- Nombre del producto
        p.Descripcion, -- Descripción del producto
        p.Precio, -- Precio del producto
        p.Stock, -- Stock del producto
        c.Nombre AS ClienteNombre, -- Nombre del cliente
        mp.Numeros AS NumeroTarjeta, -- Número de tarjeta
        CONCAT(
            d.Calle, ' ', 
            'No. ', d.NumExt, 
            IF(d.NumInt IS NOT NULL AND d.NumInt != '', CONCAT(', Int. ', d.NumInt), ''), ', ', 
            'Colonia ', d.Colonia, ', ', 
            'Entre calles: ', d.Entrecalles
        ) AS DireccionEnvio, -- Dirección completa
        pf.Ruta1 AS ImagenProducto -- Imagen del producto
    FROM 
        detalles_pedido dp
    LEFT JOIN estado_pedidos ep ON dp.ID_Estado = ep.ID_Estado
    LEFT JOIN productos p ON dp.ID_Producto = p.ID_Producto
    LEFT JOIN productos_fotos pf ON p.ID_Producto = pf.ID_Producto
    LEFT JOIN clientes c ON dp.ID_Cliente = c.ID_Cliente
    LEFT JOIN metodospagos mp ON dp.ID_Metodo = mp.ID_Metodo
    LEFT JOIN direcciones d ON dp.ID_Direccion = d.ID_Direccion
    WHERE dp.ID_DetallePedido = $id_detalle_pedido";

$result = $conexion->query($query);

if ($result->num_rows > 0) {
    $detalle = $result->fetch_assoc();
} else {
    echo "No se encontró el detalle del pedido con ID: $id_detalle_pedido";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Envío</title>
    <link rel="stylesheet" href="../css/detalles.css">
</head>
<body>
    <section class="rastreo-pedidos">
        <header class="encabezado">
            <img class="boton" src="../IMG/Button.png" onclick="window.location.href='ordenes.php'">
            <center><img class="logo" src="../IMG/logo.png" alt="Logo" /></center>
            <h1>Rastrear pedidos</h1>
        </header>
        
        <div class="contenido">
            <div class="producto">
                <img src="<?php echo $detalle['ImagenProducto']; ?>" alt="<?php echo $detalle['ProductoNombre']; ?>">
                <div class="detalles-producto">
                    <h2><?php echo $detalle['ProductoNombre']; ?></h2>
                    <p class="descripcion"><?php echo $detalle['Descripcion']; ?></p>
                    <p class="precio">$<?php echo number_format($detalle['Precio'], 2); ?></p>
                </div>
            </div>

            <div class="detalles-envio">
                <div class="direccion">
                    <h3>Dirección de Envío</h3>
                    <p><?php echo $detalle['ClienteNombre']; ?></p>
                    <p><?php echo $detalle['DireccionEnvio']; ?></p>
                </div>

                <div class="pedido">
                    <h3>Estado del Pedido</h3>
                    <p><?php echo $detalle['Estado']; ?></p>
                </div>

                <div class="metodo-pago">
                    <h3>Método de Pago</h3>
                    <p><?php echo $detalle['NumeroTarjeta']; ?></p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
