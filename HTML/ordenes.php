<?php
include "../PHP/conexion.php";

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();
// if (!isset($_SESSION['ID_Cliente'])) {
//   header("Location: index.html");
//   exit;
// }

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
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mis Tecnocompras</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../CSS/ordenes.css">
</head>

<body>
      <!-- Incluir menu de navegación -->
      <?php include "navbar.php" ?>

  <main>
    <section class="titulo-container">
      <h1>Mis Tecnocompras</h1>
    </section>

    <section class="ordenes-container">
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "
              <div class='orden-item'>
                <img src='../IMG/{$row['Foto']}' alt='Producto'>
                <div class='orden-detalles'>
                  <h2 class='producto'>{$row['ProductoNombre']}</h2>
                  <p>{$row['ProductoDescripcion']}</p>
                  <div class='estado'><strong>Estado:</strong> {$row['EstadoDescripcion']}</div>
                  <div class='cantidad'><strong>Cantidad:</strong> {$row['Cantidad']}</div>
                </div>
                <div class='precio-detalles'>
                  <span class='precio'>$ {$row['Precio']}</span>
                  <br>
                  <button class='ver-detalles' onclick='window.location.href=\"detalles.php?id={$row['ID_DetallePedido']}\"'>Ver Detalles</button>
                </div>
              </div>";
        }
      } else {
        echo "<p class='mensaje-vacio'>No tienes pedidos en proceso o enviados.</p>";
      }
      ?>
    </section>
  </main>

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

  <?php 
  $conexion->close();
  ?>
</body>

</html>