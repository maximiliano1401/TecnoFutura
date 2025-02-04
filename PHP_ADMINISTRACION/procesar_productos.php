<?php
include "../PHP/conexion.php";
header('Content-Type: application/json');

session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: index.html");
    exit;
}

// Verificar la obtencion del formulario con metodo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario mediante los name
    $nombre_producto = $_POST['nombre_producto'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = $_POST['categoria'];
    $marca = $_POST['marca'];

    // Se prepara la carga de imagenes, primero apuntamos la RUTA
    $RUTA = "../IMG_ITEM/"; 
    // Luego de cada imagen ingresado en el input obtenemos su nombre de archivo
    $NombreImagen1 = basename($_FILES["imagen1"]["name"]);
    // Lo mismo con la segunda imagen
    $NombreImagen2 = basename($_FILES["imagen2"]["name"]);
    // Preparamos los archivos concatenando la ruta con el nombre de archivo y lo almacenamos en una variable
    $ImagenPreparada1 = $RUTA . $NombreImagen1;
    // Lo mismo con imagen 2
    $ImagenPreparada2 = $RUTA . $NombreImagen2;

    // Mover las imagenes a la carpeta de destino, el tmp name es la ubicacion temporal de la imagen en el server.
    if (move_uploaded_file($_FILES["imagen1"]["tmp_name"], $ImagenPreparada1) && move_uploaded_file($_FILES["imagen2"]["tmp_name"], $ImagenPreparada2)) {
        // Preparar y ejecutar la consulta para insertar el producto
        $stmt = $conexion->prepare("INSERT INTO productos (Nombre, Descripcion, Precio, Stock, ID_Categoria, ID_Marca) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdiis", $nombre_producto, $descripcion, $precio, $stock, $categoria, $marca);
        
        if ($stmt->execute()) {
            $id_producto = $stmt->insert_id; // Obtener el ID del nuevo producto

            // Insertar las imágenes en la tabla productos_foto
            $stmt_foto = $conexion->prepare("INSERT INTO productos_fotos (ID_Producto, Ruta1, Ruta2) VALUES (?, ?, ?)");
            $stmt_foto->bind_param("iss", $id_producto, $ImagenPreparada1, $ImagenPreparada2);
            
            if ($stmt_foto->execute()) {
                echo json_encode(["message" =>"Producto agregado correctamente con las fotos."]) ;
            } else {
                echo json_encode (["message" => "Error al insertar las fotos."]);
            }
        } else {
                echo json_encode (["message" =>"Error al agregar el producto."]);
        }

        $stmt->close();
        $stmt_foto->close();
    } else {
        echo json_encode (["message" => "Hubo un error al subir las imágenes."]);
    }
} else {
    echo json_encode(["message" =>  "No se recibió el formulario."]);
}

$conexion->close();
?>
