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

// Hacemos consultas con JOINS para filtrar productos ANTERIORES (estado 3: FINALIZADO) junto con información de cada producto.
$sql = "SELECT dp.*, ep.Descripcion AS EstadoDescripcion, p.Nombre AS ProductoNombre, p.Descripcion AS ProductoDescripcion, 
               p.Precio, pf.Ruta1 AS Foto
        FROM detalles_pedido dp
        JOIN estado_pedidos ep ON dp.ID_Estado = ep.ID_Estado
        JOIN productos p ON dp.ID_Producto = p.ID_Producto
        LEFT JOIN productos_fotos pf ON p.ID_Producto = pf.ID_Producto
        WHERE dp.ID_Cliente = ? AND dp.ID_Estado = 3";
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
  <title>Mis Tecnocompras Anteriores</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../CSS/ordenes.css">
</head>

<body>
  <header class="header">
    <nav class="navbar">
      <div class="navbar-left">
        <!-- Boton hamburguesa -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
          data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a href="menu.php" class="navbar-brand">
          <img src="../IMG/logo.png" alt="Logo" class="logo">
        </a>
      </div>

      <!-- Menu desplegable -->
      <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <img class="boton" src="../IMG/Button.png" data-bs-dismiss="offcanvas" aria-label="Close">
        </div>
        <div class="offcanvas-body unu">
          <div class="user-info text-center">
            <div class="user-icon bg-success rounded-circle">
              <h5 class="text-primary mt-2"><?php echo $_SESSION['Nombre']; ?></h5>
            </div>
          </div>
          <ul class="list-group mt-4">
            <button class="list-group-item d-flex align-items-center" onclick="window.location.href='perfil.php'">
              <span class="fas fa-user me-3"></span> Mi perfil
            </button>
            <button class="list-group-item d-flex align-items-center dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#direccionesSubmenu">
              <span class="fas fa-shopping-bag me-3"></span> Mis Direcciones
            </button>
            <ul class="collapse list-unstyled ps-4" id="direccionesSubmenu">
              <button class="list-group-item" onclick="window.location.href='nueva_direccion.php'">Agregar Dirección</button>
              <button class="list-group-item" onclick="window.location.href='ver_direcciones.php'">Ver Direcciones Registradas</button>
            </ul>
            <button class="list-group-item d-flex align-items-center dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#metodosPagoSubmenu">
              <span class="fas fa-credit-card me-3"></span> Mis Métodos de Pago
            </button>
            <ul class="collapse list-unstyled ps-4" id="metodosPagoSubmenu">
              <button class="list-group-item" onclick="window.location.href='nuevo_metodo.php'">Agregar Método de Pago</button>
              <button class="list-group-item" onclick="window.location.href='ver_metodos.php'">Ver Métodos de Pago</button>
            </ul>
            <button class="list-group-item d-flex align-items-center dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#comprasSubmenu">
              <span class="fas fa-shopping-bag me-3"></span> Mis Compras
            </button>
            <ul class="collapse list-unstyled ps-4" id="comprasSubmenu">
              <button class="list-group-item" onclick="window.location.href='ordenes.php'">Órdenes</button>
              <button class="list-group-item" onclick="window.location.href='historial.php'">Historial de Compras</button>
            </ul>
            <a href="../SESIONES/cerrar.php" class="btn btn-danger">Cerrar sesión</a>
          </ul>
        </div>
      </div>
      <!-- Fin del menu desplegable -->
      <div class="navbar-right">
        <div class="user-info">
          <img src="../IMG/user-avatar.png" alt="Avatar" class="user-avatar">
          <a href="perfil.php" class="user-name">
            <span class="user-name"><strong>Hola</strong> <br> <?php echo $_SESSION['Nombre']; ?></span>
          </a>
        </div>
        <a href="carrito.php" class="cart">
          <img src="../IMG/Shopping_cart.svg" alt="Carrito" class="cart-icon">
        </a>
      </div>
    </nav>
  </header>

  <main>
    <section class="titulo-container">
      <h1>Mis Tecnocompras Anteriores</h1>
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
                </div>
              </div>";
        }
      } else {
        echo "<p>No tienes pedidos anteriores.</p>";
      }
      ?>
    </section>
  </main>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>