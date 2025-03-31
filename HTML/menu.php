<?php
// conexión a la base de datos
include "../PHP/conexion.php";

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();
// if (!isset($_SESSION['ID_Cliente'])) {
//     header("Location: index.html");
//     exit;
// }

// CONSULTA CON JOIN ENTRE PRODUCTOS, CATEGORÍAS Y PRODUCTOS_FOTOS
$sql = "
    SELECT p.ID_Producto, p.Nombre, p.Descripcion, p.Precio, pf.Ruta1
    FROM productos p
    JOIN categorias c ON p.ID_Categoria = c.ID_Categoria
    LEFT JOIN productos_fotos pf ON p.ID_Producto = pf.ID_Producto
    WHERE c.ID_Categoria = 1
    ORDER BY RAND()
";
$result = $conexion->query($sql);

// Verificar si el usuario tiene el correo "administrador@gmail.com"
// $isAdmin = $_SESSION['Correo'] == 'administrador@gmail.com';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/menu.css">
    <title>Menú</title>
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
        <!-- CARRUSEL -->
        <div id="imageCarousel" class="carousel slide Iphone151350X1080Px1" data-ride="carousel" data-interval="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img width="150px" height="250px" controls src="../IMG/fly1.png" class="d-block w-100" alt="Imagen 1">
                </div>
                <div class="carousel-item">
                    <img width="150px" height="250px" controls src="../IMG/fly2.png" class="d-block w-100" alt="Imagen 2">
                </div>
                <div class="carousel-item">
                    <img width="150px" height="250px" controls src="../IMG/aa.webp" class="d-block w-100" alt="Imagen 3">
                </div>
            </div>
            <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Siguiente</span>
            </a>
        </div>
        <!-- FIN CARRUSEL -->
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
</body>

</html>