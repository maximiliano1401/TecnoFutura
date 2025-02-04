<?php
include "conexion.php";
header('Content-Type: application/json');

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();

//Guardo la id en una variable
$id_cliente = $_SESSION['ID_Cliente'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $calle = $_POST['calle'];
    $NumExt = $_POST['NumExt'];
    $NumInt = $_POST['NumInt'];
    $entre = $_POST['entre'];
    $NumContacto = $_POST['NumContacto'];
    $colonia = $_POST['colonia'];

    // Validacion para no admitir campos vacios
    if (empty($calle) || empty($NumExt) || empty($entre) || empty($NumContacto) || empty($colonia)) {
        echo json_encode(["message" => "Todos los campos son obligatorios (EXCEPTO NUMERO INTERIOR) para poder dar de alta la direccion.."]);
        exit;
    }

// consultamos el usuario y actualizamos
$sql = "INSERT INTO direcciones (Calle, NumExt, NumInt, Entrecalles, NumContacto, Colonia, ID_Cliente) VALUES ('$calle','$NumExt','$NumInt','$entre','$NumContacto','$colonia','$id_cliente')";

if (mysqli_query($conexion, $sql)) {
    echo json_encode(["message" => "Tu nueva direccion ha sido registrada exitosamente."]);
} else {
    echo json_encode(value: ["message" => "Error al registrar tu direccion."]);
}

}

mysqli_close($conexion);

?>
