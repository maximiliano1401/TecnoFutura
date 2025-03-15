<?php
// VERIFICACIÓN DE SESIÓN ACTIVA
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: index.html");
    exit;
}

// Verificar si el usuario tiene el correo "administrador@gmail.com"
$isAdmin = $_SESSION['Correo'] == 'administrador@gmail.com';
?>

<head>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../CSS/navbar.css">
</head>

<header class="header">
    <nav class="navbar">
        <div class="navbar-left">
            <!-- Botón hamburguesa -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a href="menu.php" class="navbar-brand">
                <img src="../IMG/logo.png" alt="Logo" class="logo">
            </a>
        </div>

        <!-- Menú desplegable -->
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
                    <!-- Opción Mi Perfil -->
                    <li class="list-group-item d-flex align-items-center">
                        <span class="fas fa-user me-3"></span>
                        <a href="perfil.php" class="w-100">Mi perfil</a>
                    </li>

                    <!-- Opción Mis Direcciones -->
                    <li class="list-group-item d-flex align-items-center justify-content-between dropdown-toggle"
                        data-bs-toggle="collapse" data-bs-target="#direccionesSubmenu">
                        <div><span class="fas fa-map-marker-alt me-3"></span>Mis Direcciones</div>
                        <span class="fas fa-chevron-down"></span>
                    </li>
                    <ul class="collapse list-unstyled ps-4" id="direccionesSubmenu">
                        <li class="list-group-item"><a href="nueva_direccion.php">Agregar Dirección</a></li>
                        <li class="list-group-item"><a href="ver_direcciones.php">Ver Direcciones Registradas</a></li>
                    </ul>

                    <!-- Opción Métodos de Pago -->
                    <li class="list-group-item d-flex align-items-center justify-content-between dropdown-toggle"
                        data-bs-toggle="collapse" data-bs-target="#metodosPagoSubmenu">
                        <div><span class="fas fa-credit-card me-3"></span>Mis Métodos de Pago</div>
                        <span class="fas fa-chevron-down"></span>
                    </li>
                    <ul class="collapse list-unstyled ps-4" id="metodosPagoSubmenu">
                        <li class="list-group-item"><a href="nuevo_metodo.php">Agregar Método de Pago</a></li>
                        <li class="list-group-item"><a href="ver_metodos.php">Ver Métodos de Pago</a></li>
                    </ul>

                    <!-- Opción Mis Compras -->
                    <li class="list-group-item d-flex align-items-center justify-content-between dropdown-toggle"
                        data-bs-toggle="collapse" data-bs-target="#comprasSubmenu">
                        <div><span class="fas fa-shopping-bag me-3"></span>Mis Compras</div>
                        <span class="fas fa-chevron-down"></span>
                    </li>
                    <ul class="collapse list-unstyled ps-4" id="comprasSubmenu">
                        <li class="list-group-item"><a href="ordenes.php">Órdenes</a></li>
                        <li class="list-group-item"><a href="historial.php">Historial de Compras</a></li>
                    </ul>

                    <!-- Cerrar sesión -->
                    <li class="list-group-item text-center">
                        <a href="../SESIONES/cerrar.php" class="btn btn-danger cerrar-sesion w-100">Cerrar sesión</a>
                    </li>

                    <!-- Botón de administración (solo visible si el usuario es administrador) -->
                    <?php if ($isAdmin): ?>
                        <li class="list-group-item text-center">
                            <a href="../ADMINISTRACION/administracion.php" class="btn btn-primary modo-admin w-100">Acceder a Modo Administración</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <!-- Fin del menú desplegable -->

        <!-- Barra de búsqueda -->
        <div class="navbar-center">
            <form class="search-form" action="buscar.php" method="GET">
                <input type="text" class="search-input" name="busqueda" placeholder="Buscar...">
                <button type="submit" class="search-button">
                    <img src="../IMG/search.png" alt="Buscar">
                </button>
            </form>
        </div>

        <!-- Sección derecha del navbar -->
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>