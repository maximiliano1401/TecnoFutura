<?php
include "conexion.php";
header('Content-Type: application/json');

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();

//Guardo la id en una variable
$id_cliente = $_SESSION['ID_Cliente'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = isset($_POST['nombreCompleto']) ? $_POST['nombreCompleto'] : $nombre;
    $correo = isset($_POST['correoElectronico']) ? $_POST['correoElectronico'] : $correo;
    $numero = isset($_POST['numeroTelefonico']) ? $_POST['numeroTelefonico'] : $telefono;
    $edad = isset($_POST['edad']) ? $_POST['edad'] : $edad;

    // Validacion para no admitir campos vacios
    if (empty($nombre) || empty($correo) || empty($numero) || empty($edad)) {
        echo json_encode(["message" => "Todos los campos son obligatorios para poder actualizar."]);
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

// consultamos el usuario y actualizamos
$sql = "UPDATE clientes SET Nombre = '$nombre', Correo = '$correo', Telefono = '$numero', Edad = '$edad' WHERE ID_Cliente = '$id_cliente'";

if (mysqli_query($conexion, $sql)) {

    // Actualizamos el nombre en la sesion
    $_SESSION['Nombre'] = $nombre;

    echo json_encode(["message" => "Tus datos han sido actualizados exitosamente."]);
} else {
    echo json_encode(["message" => "Error al actualizar tus datos."]);
}

}

mysqli_close($conexion);

?>
