<?php
include "../PHP/conexion.php";

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: index.html");
    exit;
}

// CONSULTA CON JOIN ENTRE PRODUCTOS, CATEGORÍAS Y PRODUCTOS_FOTOS
$sql = "
    SELECT p.ID_Producto, p.Nombre, pf.Ruta1, p.Descripcion, p.Precio
    FROM productos p
    JOIN categorias c ON p.ID_Categoria = c.ID_Categoria
    LEFT JOIN productos_fotos pf ON p.ID_Producto = pf.ID_Producto
    WHERE c.ID_Categoria = 1
";

$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/menu.css">

    <title>Auriculares</title>
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
                            <!-- Botón de administracion (solo visible si el usuario es administrador) -->
                            <?php if ($isAdmin): ?>
                                <a href="../ADMINISTRACION/administracion.php" class="btn btn-primary mt-3">Acceder a Modo Administración</a>
                            <?php endif; ?>
                        </ul>
                </div>
            </div>
            <!-- Fin del menu desplegable -->
            <!-- Barra de busqueda -->
            <div class="navbar-center">
                <form class="search-form" action="buscar.php" method="GET">
                    <input type="text" class="search-input" name="busqueda" placeholder="Buscar...">
                    <button type="submit" class="search-button">
                        <img src="../IMG/search.png" alt="Buscar">
                    </button>
                </form>
            </div>
            <!-- Fin de la barra de busqueda -->
            <div class="navbar-right">
                <div class="user-info">
                    <img src="../IMG/user-avatar.png" alt="Avatar" class="user-avatar">
                    <a href="perfil.php" class="user-name">
                        <span class="user-name"><strong>Hola</strong> <br> <?php echo $_SESSION['Nombre']; ?></span>
                    </a>
                </div>
                <a href="carrito.php" class="cart">
                    <span class="cart-text">Mis compras</span>
                    <img src="../IMG/Shopping_cart.svg" alt="Carrito" class="cart-icon">
                </a>
            </div>
        </nav>
    </header>

    <main>
        <section class="categorias">
            <h2 class="titulo-seccion">Categorías</h2>
            <div class="iconos-categorias">
                <img src="../IMG/Smartphone.svg" alt="Teléfonos" onclick="window.location.href='telefonos.php'">
                <img src="../IMG/Monitor.svg" alt="Televisores" onclick="window.location.href='television.php'">
                <img src="../IMG/Laptop.svg" alt="Computadoras" onclick="window.location.href='computadora.php'">
                <img src="../IMG/Headphones.svg" alt="Auriculares" onclick="window.location.href='auriculares.php'">
            </div>
        </section>
        <hr>
        <section class="productos">
            <h2 class="titulo-seccion">Explora lo Último en Tecnología</h2>
            <div class="productos-grid">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="producto-card">';
                        echo '<a href="producto.php?id_producto=' . $row['ID_Producto'] . '">';
                        echo '<img src="' . $row['Ruta1'] . '" alt="' . $row['Nombre'] . '" class="producto-imagen">';
                        echo '<div class="producto-info">';
                        echo '<h3 class="producto-nombre">' . $row['Nombre'] . '</h3>';
                        echo '<p class="producto-descripcion">' . $row['Descripcion'] . '</p>';
                        echo '<p class="producto-precio">$' . $row['Precio'] . '</p>';
                        echo '</div>';
                        echo '</a>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No se encontraron productos en la categoría seleccionada.</p>";
                }
                $conexion->close();
                ?>
            </div>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2025 Tecnofutura. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>