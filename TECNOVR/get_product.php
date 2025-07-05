<?php
// Habilita cabeceras para CORS y JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Validación básica de entrada
if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Falta parámetro id']);
    exit;
}

// Mapeo de ID de objeto a ID_Producto (esto puede reemplazarse por una tabla de relación si prefieres)
$mapa_objetos = [
    'laptop1'   => 19, // HP Pavilion x360
    'celular1'  => 6,  // Samsung Galaxy S23 Ultra
    'monitor1'  => 34, // Samsung S90C (QD-OLED)
    'monitor2'  => 38, // Sony X90J (OLED)
    'cube1'     => 1,  // iPhone 15 Pro Max (ejemplo)
    'cube2'     => 2,  // JBL TUNE 520 (ejemplo)
    'cube3'     => 3,  // Samsung TV 50 4K (ejemplo)
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
