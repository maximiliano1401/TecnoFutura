<?php
include "conexion.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $correo = $_POST['correo'];
    $numero = $_POST['numero'];
    $contrasena = $_POST['contrasena'];

    // Validacion para no admitir campos vacios
    if (empty($nombre) || empty($edad) || empty($correo) || empty($numero) || empty($contrasena)) {
        echo json_encode(["message" => "Todos los campos son obligatorios para poder registrarse."]);
        exit;
    }

    // Validación de edad mayor que 18 años
    if ($edad < 18) {
        echo json_encode(["message" => "TecnoFutura solo admite usuarios mayores a 18 años en edad"]);
        exit;
    }

    // Validación de edad menor que 90 años
    if ($edad > 90) {
        echo json_encode(["message" => "TecnoFutura solo admite usuarios menores a 90 años en edad"]);
        exit;
    }

    $contrasena_hash = hash('sha256', $contrasena);

    $sql = "INSERT INTO clientes (Nombre, Correo, Telefono, Contrasena, Edad) VALUES ('$nombre', '$correo', '$numero', '$contrasena_hash', '$edad')";

    if (mysqli_query($conexion, $sql)) {
        echo json_encode(["message" => "Registro exitoso."]);
    } else {
        echo json_encode(["message" => "Error al registrar tus datos."]);
    }
}

mysqli_close($conexion);
?>
