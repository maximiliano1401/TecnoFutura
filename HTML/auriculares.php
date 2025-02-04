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
    WHERE c.ID_Categoria = 4
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
    <link rel="stylesheet" href="../CSS/categorias.css">  
    <link rel="stylesheet" href="../CSS/auriculares.css">

    <title>Auriculares</title>
</head>
<body>
    <div class="Menu">
        <div class="Categorizador">
            <br><br>
            <p>Categorías</p>
            <img src="../IMG/1.png" onclick="window.location.href='telefonos.php'" />
            <img src="../IMG/2.png" onclick="window.location.href='television.php'"/>
            <img src="../IMG/3.png" onclick="window.location.href='computadora.php'" />
        </div>
        
        <div>
            <img class="boton" src="../IMG/Button.png" onclick="window.location.href='menu.php' ">

            <center>
                <div class="marcas">
                    <p>Marcas Disponibles</p>
                    <img src="../IMG/17.png"/>
                    <img src="../IMG/19.png"/>
                    <img src="../IMG/20.png"/>
                    <img src="../IMG/18.png"/>
                </div>
            </center>

            <div class="container">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="rectangle">';
                        echo '<a href="producto.php?id_producto=' . $row['ID_Producto'] . '">';
                        echo '<img src="' . $row['Ruta1'] . '" alt="' . $row['Nombre'] . '" class="product-img">';
                        echo '<div class="nombre">';
                        echo '<p class="product-name">' . $row['Nombre'] . '</p>';
                        echo '</div>';
                        echo '<div class="descripcion">';
                        echo '<p class="product-description">' . $row['Descripcion'] . '</p>';
                        echo '</div>';
                        echo '<div class="precio">';
                        echo '<p class="product-price">$' . $row['Precio'] . '</p>';
                        echo '</div>';
                        echo '</a>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No se encontraron productos en la categoría 'Auriculares'.</p>";
                }
                $conexion->close();
                ?>
            </div>
        </div>  
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
