<?php
// Habilita cabeceras para CORS y JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Configuración de conexión (debe ir antes de cualquier uso)
include("../PHP/conexion.php");

// Forzar UTF-8 en la conexión MySQL
if (!$conexion->set_charset("utf8mb4")) {
    $conexion->set_charset("utf8");
}

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

// Mapeo de ID de objeto a ID_Producto
// Modelos 3D reales implementados
$mapa_objetos = [
    // MÓVILES - Modelos 3D reales
    'mobile1' => 1,  // iPhone 15 Pro Max
    'mobile2' => 6,  // Samsung Galaxy S23 Ultra
    'mobile3' => 7,  // Xiaomi 13T
    'mobile4' => 8,  // iPhone 16 Pro Max
    'mobile5' => 10, // Xiaomi 14 Ultra
    
    // COMPUTADORAS / PCs - Modelos 3D reales
    'pc1' => 19, // HP Pavilion x360
    'pc2' => 21, // Lenovo ThinkPad
    'pc3' => 22, // MacBook Air
    'pc4' => 23, // ASUS ROG
    'pc5' => 24, // Acer Aspire
    
    // TELEVISORES - Modelos 3D reales
    'tv1' => 3,  // Samsung TV 50 4K
    'tv2' => 34, // Samsung S90C
    'tv3' => 38, // Sony X90J
    'tv4' => 35, // LG OLED
];

$objetoId = $_GET['id'];

if (!isset($mapa_objetos[$objetoId])) {
    echo json_encode(['error' => 'ID no válido']);
    exit;
}

$id_producto = $mapa_objetos[$objetoId];

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
    // Producto no encontrado en la base de datos
    echo json_encode([
        'error' => 'Producto no encontrado',
        'id_producto' => $id_producto,
        'objeto_id' => $objetoId
    ], JSON_UNESCAPED_UNICODE);
} else {
    $producto = $resultado->fetch_assoc();
    
    // Validar que el producto tenga datos mínimos
    if (empty($producto['Nombre'])) {
        echo json_encode([
            'error' => 'Producto sin datos válidos',
            'id_producto' => $id_producto
        ], JSON_UNESCAPED_UNICODE);
    } else {
        // Limpiar caracteres UTF-8 inválidos
        array_walk_recursive($producto, function(&$item) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8', 'UTF-8');
            }
        });
        
        // Todo OK - devolver producto
        $json = json_encode($producto, JSON_UNESCAPED_UNICODE);
        
        // Verificar que json_encode funcionó
        if ($json === false) {
            echo json_encode([
                'error' => 'Error de codificación: ' . json_last_error_msg(),
                'id_producto' => $id_producto
            ]);
        } else {
            echo $json;
        }
    }
}

$stmt->close();
$conexion->close();
// NO cerrar etiqueta PHP - evita espacios que corrompan JSON
