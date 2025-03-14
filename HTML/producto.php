<?php
include "../PHP/conexion.php";

// Verificación de sesión activa
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: index.html");
    exit;
}

// Obtener el ID del producto desde la URL
if (isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];

    // Consulta SQL para obtener los detalles del producto
    $sql = "
        SELECT p.Nombre, p.Descripcion, p.Precio, p.Stock, c.Nombre AS Categoria, m.Marca AS Marca, p.ID_Categoria
        FROM productos p
        JOIN categorias c ON p.ID_Categoria = c.ID_Categoria
        JOIN marcas m ON p.ID_Marca = m.ID_Marca
        WHERE p.ID_Producto = $id_producto
    ";

    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
        $id_categoria = $producto['ID_Categoria']; //Guardamos la categoría del producto en una variable

        // Consulta para obtener las rutas de las imágenes del producto
        $sql_fotos = "
            SELECT Ruta1, Ruta2
            FROM productos_fotos
            WHERE ID_Producto = $id_producto
        ";

        $result_fotos = $conexion->query($sql_fotos);

        if ($result_fotos->num_rows > 0) {
            $fotos = $result_fotos->fetch_assoc();
        } else {
            echo "No se encontraron imágenes para este producto.";
            exit;
        }

        // Consulta para obtener productos recomendados de la misma categoría
        $sql_recomendados = "
    SELECT p.ID_Producto, p.Nombre, p.Precio, p.Stock, pf.Ruta1
    FROM productos p
    LEFT JOIN productos_fotos pf ON p.ID_Producto = pf.ID_Producto
    WHERE p.ID_Categoria = $id_categoria AND p.ID_Producto != $id_producto
    LIMIT 4
";
        $result_recomendados = $conexion->query($sql_recomendados);
        $productos_recomendados = [];

        if ($result_recomendados->num_rows > 0) {
            while ($row = $result_recomendados->fetch_assoc()) {
                $productos_recomendados[] = $row;
            }
        } else {
            echo "No se encontraron productos recomendados.";
        }
    } else {
        echo "Producto no encontrado.";
        exit;
    }
} else {
    echo "ID de producto no válido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $producto['Nombre']; ?></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/producto.css">
</head>

<body>
    <?php include "navbar.php" ?>
    <section class="producto">
        <div class="detalles">
            <h2><?php echo $producto['Nombre']; ?></h2>
        </div>

        <!-- Galería -->
        <div class="galeria">
            <div class="carousel-container">
                <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="../IMG_ITEM/<?php echo $fotos['Ruta1']; ?>" class="d-block w-100 tamano" alt="<?php echo $producto['Nombre']; ?>">
                        </div>
                        <?php if (!empty($fotos['Ruta2'])): ?>
                            <div class="carousel-item">
                                <img src="../IMG_ITEM/<?php echo $fotos['Ruta2']; ?>" class="d-block w-100 tamano" alt="<?php echo $producto['Nombre']; ?>">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>

        <!-- Información del producto -->
        <div class="info">
            <p><strong>Marca:</strong> <?php echo $producto['Marca']; ?></p>
            <p><strong>Categoría:</strong> <?php echo $producto['Categoria']; ?></p>
            <p><strong>Descripción:</strong> <?php echo $producto['Descripcion']; ?></p>
            <p class="envio">
                <img src="../IMG/coche.png" alt="Envío"> ENVÍO GRATIS
            </p>
            <form action="../PHP/procesar_carrito.php" method="post">
                <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                <input type="hidden" name="id_cliente" value="<?php echo $_SESSION['ID_Cliente']; ?>">
                <button type="submit" class="btn btn-primary aa">Agregar al carrito</button>
            </form>
        </div>

        <!-- Precio y acciones -->
        <div class="precio">
            <h3>$<?php echo number_format($producto['Precio'], 2); ?></h3>
            <button class="btn btn-secondary">Cantidad: 1</button>
            <a href="compra.php?id_producto=<?php echo $id_producto; ?>" class="btn btn-success">Comprar</a>
        </div>
        <section class="especificaciones">
            <div class="caracteristica">
                <p>Especificaciones <br><br><?php echo $producto['Descripcion']; ?></p>
            </div>
        </section>
    </section>


    <section class="financiamiento">
        <p>Paga a meses sin intereses con tarjetas de crédito participantes</p>
        <div class="logos">
            <img src="../IMG/bbva.png" alt="BBVA">
            <img src="../IMG/bbva.png" alt="Santander">
        </div>
    </section>

    <section class="recomendaciones">
        <center>
            <h3>Recomendaciones</h3>
        </center>
        <div class="container">
            <?php foreach ($productos_recomendados as $producto_recomendado): ?>
                <div class="rectangle">
                    <a href="producto.php?id_producto=<?php echo $producto_recomendado['ID_Producto']; ?>">
                        <img src="../IMG_ITEM/<?php echo $producto_recomendado['Ruta1']; ?>"
                            class="product-img img-fluid"
                            alt="<?php echo $producto_recomendado['Nombre']; ?>">
                        <p class="product-name"><?php echo $producto_recomendado['Nombre']; ?></p>
                        <p class="product-price">$<?php echo number_format($producto_recomendado['Precio'], 2); ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
</html>