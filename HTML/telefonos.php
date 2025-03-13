<?php
include "../PHP/conexion.php";

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();
// if (!isset($_SESSION['ID_Cliente'])) {
//     header("Location: index.html");
//     exit;
// }

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
        <!-- Incluir menu de navegación -->
        <?php include "navbar.php" ?>

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

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</body>
</html>