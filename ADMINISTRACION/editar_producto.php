<?php
include '../PHP/conexion.php';

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: ../HTML/index.html");
    exit;
}

$response = ["status" => "error", "message" => "No se especificó el ID del producto."];

// Comprobar si se ha pasado el ID del producto
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode($response);
    exit;
}

$id_producto = $_GET['id'];

// Consulta para obtener los datos del producto
$query = "
SELECT 
    p.ID_Producto, 
    p.Nombre, 
    p.Descripcion, 
    p.Precio, 
    p.Stock, 
    p.ID_Categoria, 
    p.ID_Marca, 
    f.Ruta1, 
    f.Ruta2
FROM productos p
LEFT JOIN productos_fotos f ON p.ID_Producto = f.ID_Producto
WHERE p.ID_Producto = ?
";

// Preparamos y ejecutamos la consulta
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $response["message"] = "Error: Producto no encontrado.";
    echo json_encode($response);
    exit;
}

// Obtener el producto
$producto = $result->fetch_assoc();

// Consultas para obtener categorias y marcas (para llenar los selects)
$query_categorias = "SELECT * FROM categorias";
$query_marcas = "SELECT * FROM marcas";

$result_categorias = $conexion->query($query_categorias);
$result_marcas = $conexion->query($query_marcas);

// Comprobar si se envió el formulario para editar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = $_POST['categoria'];
    $marca = $_POST['marca'];

    // Actualizar producto en la base de datos
    $update_query = "
    UPDATE productos 
    SET Nombre = ?, Descripcion = ?, Precio = ?, Stock = ?, ID_Categoria = ?, ID_Marca = ? 
    WHERE ID_Producto = ?
    ";

    $stmt_update = $conexion->prepare($update_query);
    $stmt_update->bind_param("ssdiiii", $nombre, $descripcion, $precio, $stock, $categoria, $marca, $id_producto);

    if ($stmt_update->execute()) {
        $response = ["status" => "success", "message" => "Producto actualizado con éxito."];
    } else {
        $response["message"] = "Error al actualizar el producto: " . $conexion->error;
    }

    echo json_encode($response);
    exit;
}
?>

</style>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/editar_producto.css">
    <title>Editar Producto</title>
</head>
<body>
<img class="boton" src="../IMG/Button.png" onclick="window.location.href='ver_productos.php'" id="form">

    <h1>Editar Producto</h1>
    <form id="productoForm" action="editar_producto.php?id=<?= $producto['ID_Producto']; ?>" method="POST">
        <label for="nombre">Nombre del Producto</label>
        <input type="text" id="nombre" name="nombre" value="<?= $producto['Nombre']; ?>" required>

        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" required><?= $producto['Descripcion']; ?></textarea>

        <label for="precio">Precio</label>
        <input type="number" id="precio" name="precio" value="<?= $producto['Precio']; ?>" required step="0.01">

        <label for="stock">Stock</label>
        <input type="number" id="stock" name="stock" value="<?= $producto['Stock']; ?>" required>

        <label for="categoria">Categoría</label>
        <select id="categoria" name="categoria" required>
            <?php while ($categoria = $result_categorias->fetch_assoc()): ?>
                <option value="<?= $categoria['ID_Categoria']; ?>" <?= $categoria['ID_Categoria'] == $producto['ID_Categoria'] ? 'selected' : ''; ?>>
                    <?= $categoria['Nombre']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="marca">Marca</label>
        <select id="marca" name="marca" required>
            <?php while ($marca = $result_marcas->fetch_assoc()): ?>
                <option value="<?= $marca['ID_Marca']; ?>" <?= $marca['ID_Marca'] == $producto['ID_Marca'] ? 'selected' : ''; ?>>
                    <?= $marca['Marca']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit" class="btn">Guardar Cambios</button>
    </form>

    <!-- Modal de Respuesta -->
    <div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="modalResponseLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalResponseLabel">Mensaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalResponseMessage">
                    <!-- El mensaje se mostrará aquí -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('productoForm').addEventListener('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                $('#modalResponseMessage').text(data.message);
                $('#responseModal').modal('show');
            })
            .catch(error => {
                console.error('Error:', error);
                $('#modalResponseMessage').text('Hubo un error en la solicitud.');
                $('#responseModal').modal('show');
            });
        });
    </script>
</body>
</html>
