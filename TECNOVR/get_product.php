<?php
// Habilita cabeceras para CORS y JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Validación básica de entrada
if (isset($_GET['categoria'])) {
    // Nuevo endpoint: obtener productos por categoría
    $categoria_id = (int)$_GET['categoria'];
    
    // Consulta SQL segura para obtener todos los productos de una categoría
    $stmt = $conexion->prepare("
        SELECT p.ID_Producto, p.Nombre, p.Descripcion, p.Precio, p.Stock, pf.Ruta1, pf.Ruta2
        FROM productos p
        LEFT JOIN productos_fotos pf ON p.ID_Producto = pf.ID_Producto
        WHERE p.ID_Categoria = ?
        ORDER BY p.Nombre ASC
    ");
    $stmt->bind_param("i", $categoria_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    $productos = [];
    while ($row = $resultado->fetch_assoc()) {
        $productos[] = $row;
    }
    
    echo json_encode($productos, JSON_UNESCAPED_UNICODE);
    $stmt->close();
    $conexion->close();
    exit;
}

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Falta parámetro id o categoria']);
    exit;
}

// Mapeo de ID de objeto a ID_Producto (esto puede reemplazarse por una tabla de relación si prefieres)
$mapa_objetos = [
    'laptop1'    => 19, // HP Pavilion x360
    'celular1'   => 6,  // Samsung Galaxy S23 Ultra
    'monitor1'   => 34, // Samsung S90C (QD-OLED)
    'monitor2'   => 38, // Sony X90J (OLED)
    'cube1'      => 1,  // iPhone 15 Pro Max (ejemplo)
    'cube2'      => 2,  // JBL TUNE 520 (ejemplo)
    'cube3'      => 3,  // Samsung TV 50 4K (ejemplo)
    
    // Laptops gamer
    'lapgamer'   => 4,  // MSI KATANA 15
    'lapgamer1'  => 20, // Dell Inspiron 14
    'lapgamer2'  => 21, // Lenovo IdeaPad 3
    'lapgamer3'  => 22, // Asus VivoBook 15
    'lapgamer5'  => 23, // Acer Aspire 5
    
    // PCs gamer
    'pc1'        => 5,  // PC Gamer Fury
    'pc2'        => 15, // Digital Master PC Gamer SILVER PRO
    'pc3'        => 16, // PC Gamer Spartan Imagine
    'pc4'        => 17, // Xtreme PC Gaming CM-05505
    'pc5'        => 18, // PC Gamer Delios 80
    'pc6'        => 5,  // PC Gamer Fury (duplicado para tener suficientes PCs)
];

$objetoId = $_GET['id'];

if (!isset($mapa_objetos[$objetoId])) {
    echo json_encode(['error' => 'ID no válido']);
    exit;
}

$id_producto = $mapa_objetos[$objetoId];

// Configuración de conexión
include("../PHP/conexion.php");

// Consulta SQL segura con JOIN para obtener imágenes
$stmt = $conexion->prepare("
    SELECT p.ID_Producto, p.Nombre, p.Descripcion, p.Precio, p.Stock, pf.Ruta1, pf.Ruta2
    FROM productos p
    LEFT JOIN productos_fotos pf ON p.ID_Producto = pf.ID_Producto
    WHERE p.ID_Producto = ?
");
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo json_encode(['error' => 'Producto no encontrado']);
} else {
    $producto = $resultado->fetch_assoc();
    echo json_encode($producto, JSON_UNESCAPED_UNICODE);
}

$stmt->close();
$conexion->close();
