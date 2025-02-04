<?php
include "conexion.php";
header('Content-Type: application/json');

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();

//Guardo la id en una variable
$id_cliente = $_SESSION['ID_Cliente'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $calle = isset($_POST['calle']) ? $_POST['calle'] : $calle;
    $num_ext = isset($_POST['num_ext']) ? $_POST['num_ext'] : $num_ext;
    $num_int = isset($_POST['num_int']) ? $_POST['num_int'] : $num_int;
    $entre_calles = isset($_POST['entre_calles']) ? $_POST['entre_calles'] : $entre_calles;
    $num_contacto = isset($_POST['num_contacto']) ? $_POST['num_contacto'] : $num_contacto;
    $colonia = isset($_POST['colonia']) ? $_POST['colonia'] : $colonia;

    // Validacion para no admitir campos vacios
    if (empty($calle) || empty($num_ext) || empty($entre_calles) || empty($num_contacto) || empty($colonia)) {
        echo json_encode(["message" => "Todos los campos (EXCEPTUANDO NUMERO INTERIOR) son obligatorios para poder actualizar."]);
        exit;
    }

    // Validacion para verificar que sean datos numericos.
    if (!is_numeric($num_ext) || !is_numeric($num_int) || !is_numeric($num_contacto)) {
        echo json_encode(["message" => "En numero exterior, numero interior o numero de contacto solo se admiten números."]);
        exit;
    }

// consultamos el usuario y actualizamos
$sql = "UPDATE direcciones SET Calle = '$calle', NumExt = '$num_ext', NumInt = '$num_int', Entrecalles = '$entre_calles', NumContacto = '$num_contacto', Colonia = '$colonia' WHERE ID_Cliente = '$id_cliente'";

if (mysqli_query($conexion, $sql)) {
    echo json_encode(["message" => "Tu direccion han sido actualizados exitosamente."]);
} else {
    echo json_encode(["message" => "Error al actualizar tu direccion."]);
}

}

mysqli_close($conexion);

?>
