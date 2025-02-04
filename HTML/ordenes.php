<?php
include "../PHP/conexion.php";

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: index.html");
    exit;
}

// Guardamos la ID del cliente en una variable
$ID_Cliente = $_SESSION['ID_Cliente'];

// Hacemos consultas con JOINS para filtrar productos EN PROCESO y ENVIADOS junto con informacion de cada producto.
$sql = "SELECT dp.*, ep.Descripcion AS EstadoDescripcion, p.Nombre AS ProductoNombre, p.Descripcion AS ProductoDescripcion, 
               p.Precio, pf.Ruta1 AS Foto
        FROM detalles_pedido dp
        JOIN estado_pedidos ep ON dp.ID_Estado = ep.ID_Estado
        JOIN productos p ON dp.ID_Producto = p.ID_Producto
        LEFT JOIN productos_fotos pf ON p.ID_Producto = pf.ID_Producto
        WHERE dp.ID_Cliente = ? AND dp.ID_Estado IN (1, 2)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $ID_Cliente);  // Consultamos el cliente con sesión activa
$stmt->execute();
$result = $stmt->get_result();

$stmt->close();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mis Ordenes</title>
  <link rel="stylesheet" href="../CSS/ordenes.css">
</head>
<body>
  <img class="boton" src="../IMG/Button.png" onclick="window.location.href='menu.php' ">
  <center>
    <div class="container">
      <img class="logo" src="../IMG/logo.png" alt="Logo" />
      <div class="titulo">Mis Tecnocompras</div>
    </center>
    <div class="cart">
      <?php
      // Verifica si hay resultados
      if ($result->num_rows > 0) {
          // Iteración de pedidos en la BD desde el resultado obtenido
          while ($row = $result->fetch_assoc()) {
              echo "
              <div class='item'>
                <img src='../IMG/{$row['Foto']}' alt='Producto'>
                <div class='details'>
                  <h2 class='producto'>{$row['ProductoNombre']}</h2>
                  <p>{$row['ProductoDescripcion']}</p>
                  <div class='estado'>Estado: {$row['EstadoDescripcion']}</div>
                  <div class='cantidad'>Cantidad: {$row['Cantidad']}</div>
                  <div class='price'>$ {$row['Precio']}</div>
                </div>
                <button class='boton-fondo' onclick='window.location.href=\"detalles.php?id={$row['ID_DetallePedido']}\"'>Ver Detalles</button>
              </div>";
          }
      } else {
          echo "<p>No tienes pedidos en proceso o enviados.</p>";
      }
      ?>
    </div>
  </div>
</body>
</html>
