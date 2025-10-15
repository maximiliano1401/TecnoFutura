<?php
include "conexion.php";
header('Content-Type: application/json');
session_start();

// Verificación de sesión activa
if (!isset($_SESSION['ID_Cliente'])) {
    echo json_encode(["message" => "No hay sesión activa."]);
    exit;
}

$id_cliente = $_SESSION['ID_Cliente'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escapar datos para evitar SQL Injection
    $nombre = isset($_POST['nombreCompleto']) ? mysqli_real_escape_string($conexion, $_POST['nombreCompleto']) : null;
    $correo = isset($_POST['correoElectronico']) ? mysqli_real_escape_string($conexion, $_POST['correoElectronico']) : null;
    $numero = isset($_POST['numeroTelefonico']) ? mysqli_real_escape_string($conexion, $_POST['numeroTelefonico']) : null;
    $edad = isset($_POST['edad']) ? (int) $_POST['edad'] : null;

    // Validación de campos vacíos
    if (empty($nombre) || empty($correo) || empty($numero) || empty($edad)) {
        echo json_encode(["message" => "Todos los campos son obligatorios para actualizar."]);
        exit;
    }

    // Validación de edad entre 18 y 90 años
    if ($edad < 18 || $edad > 90) {
        echo json_encode(["message" => "TecnoFutura solo admite usuarios entre 18 y 90 años."]);
        exit;
    }

    // Manejo de la imagen de perfil (si se sube)
$fotoPerfil = "";
if (!empty($_FILES['fotoPerfil']['name'])) {
    $rutaDirectorio = "../PERFILES/";
    $nombreArchivo = $id_cliente . ".jpg"; // Guardar como ID_Cliente.jpg
    $rutaCompleta = $rutaDirectorio . $nombreArchivo;

    $tipoArchivo = strtolower(pathinfo($_FILES['fotoPerfil']['name'], PATHINFO_EXTENSION));
    $tamañoArchivo = $_FILES['fotoPerfil']['size'];

    // Validaciones de imagen
    if ($tipoArchivo != "jpg" && $tipoArchivo != "jpeg" && $tipoArchivo != "png") {
        echo json_encode(["message" => "Solo se permiten imágenes JPG y PNG."]);
        exit;
    }

    if ($tamañoArchivo > 2097152) { // 2MB
        echo json_encode(["message" => "El archivo no debe superar los 2MB."]);
        exit;
    }

    // Mover la imagen al directorio
    if (!move_uploaded_file($_FILES['fotoPerfil']['tmp_name'], $rutaCompleta)) {
        echo json_encode(["message" => "Error al subir la imagen."]);
        exit;
    }

    // Guardar la ruta completa en la base de datos
    $fotoPerfil = ", FotoPerfil = '$rutaCompleta'";
}

    // Consulta de actualización
    $sql = "UPDATE clientes SET Nombre = '$nombre', Correo = '$correo', Telefono = '$numero', Edad = '$edad' $fotoPerfil WHERE ID_Cliente = '$id_cliente'";

    if (mysqli_query($conexion, $sql)) {
        $_SESSION['Nombre'] = $nombre;
        echo json_encode(["message" => "Tus datos han sido actualizados exitosamente."]);
    } else {
        echo json_encode(["message" => "Error al actualizar tus datos."]);
    }
}

mysqli_close($conexion);
?>
