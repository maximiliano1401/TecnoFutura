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
// SOLO productos con modelos 3D disponibles o cubos placeholder
$mapa_objetos = [
    // Modelos 3D disponibles
    'laptop1'    => 19, // HP Pavilion x360 - Modelo disponible
    'celular1'   => 6,  // Samsung Galaxy S23 Ultra - Modelo disponible
    'monitor1'   => 34, // Samsung S90C - Modelo disponible
    'monitor2'   => 38, // Sony X90J - Modelo disponible
    
    // Cubos placeholder para categoría Teléfonos
    'cube1'      => 1,  // iPhone 15 Pro Max
    'cube2'      => 7,  // Xiaomi 13T
    'phone_cube1' => 8,  // iPhone 16 Pro Max
    'phone_cube2' => 10, // Xiaomi 14 Ultra
    'phone_cube3' => 11, // OnePlus 12
    
    // Cubos placeholder para categoría Cómputo
    'comp_cube1'  => 20, // Dell Inspiron 14
    'comp_cube2'  => 21, // Lenovo IdeaPad 3
    'comp_cube3'  => 22, // Asus VivoBook 15
    'comp_cube4'  => 23, // Acer Aspire 5
    
    // Cubos placeholder para categoría Televisores
    'cube3'      => 3,  // Samsung TV 50 4K
    'tv_cube1'    => 35, // TCL QM851G
    'tv_cube2'    => 36, // Samsung The Frame
    'tv_cube3'    => 37, // Samsung Neo QLED
    
    // COMENTADO: Modelos 3D faltantes (descomentar cuando se transfieran desde Windows)
    // 'lapgamer'   => 4,  // MSI KATANA 15
    // 'lapgamer1'  => 20, // Dell Inspiron 14
    // 'lapgamer2'  => 21, // Lenovo IdeaPad 3
    // 'lapgamer3'  => 22, // Asus VivoBook 15
    // 'lapgamer5'  => 23, // Acer Aspire 5
    // 'pc1'        => 5,  // PC Gamer Fury
    // 'pc2'        => 15, // Digital Master PC Gamer SILVER PRO
    // 'pc3'        => 16, // PC Gamer Spartan Imagine
    // 'pc4'        => 17, // Xtreme PC Gaming CM-05505
    // 'pc5'        => 18, // PC Gamer Delios 80
    // 'pc6'        => 5,  // PC Gamer Fury (duplicado)
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
