<?php
include "conexion.php";
header('Content-Type: application/json');

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();

// Guardo la id en una variable
$id_cliente = $_SESSION['ID_Cliente'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $numero = $_POST['numero'];
    $cvv = $_POST['cvv'];
    $mes = $_POST['mes'];
    $anio = $_POST['anio'];

    // Validación para no admitir campos vacíos.
    if (empty($nombre) || empty($numero) || empty($cvv) || empty($mes) || empty($anio)) {
        echo json_encode(["message" => "Todos los campos son obligatorios para poder registrar tu método de pago."]);
        exit;
    }

    // Validacion para verificar que sean datos numericos.
    if (!is_numeric($numero) || !is_numeric($cvv) || !is_numeric($mes) || !is_numeric($anio)) {
        echo json_encode(["message" => "En número de tarjeta, CVV, mes y año solo se admiten números."]);
        exit;
    }

    // Validacion para verificar que el numero de tarjeta sea siempre 16 digitos
    if (strlen($numero) !== 16) {
        echo json_encode(["message" => "El número de tarjeta debe tener 16 dígitos."]);
        exit;
    }

    // Validacion para verificar que el CVV sea igual a 3 digitos
    if (strlen($cvv) !== 3) {
        echo json_encode(["message" => "El CVV debe tener 3 dígitos."]);
        exit;
    }

    // Validacion para verificar que el mes sea entre 1 y 12 (ENERO Y DICIEMBRE)
    if ($mes < 1 || $mes > 12) {
        echo json_encode(["message" => "El mes debe ser un valor entre 1 y 12."]);
        exit;
    }

    // Validacion para verificar que año no sea menor que el año actual Y YEAR
    if ($anio < date("Y")) {
        echo json_encode(["message" => "El año debe ser mayor o igual al año actual."]);
        exit;
    }

    // Formatear mes y año como MM-YYYY
    $mya = sprintf("%02d-%d", $mes, $anio);

    // Insertar en la base de datos
    $sql = "INSERT INTO metodospagos (Titular, Numeros, CVV, MyA, ID_Cliente) VALUES ('$nombre', '$numero', '$cvv', '$mya', '$id_cliente')";

    if (mysqli_query($conexion, $sql)) {
        echo json_encode(["message" => "Método de pago registrado exitosamente."]);
    } else {
        echo json_encode(["message" => "Error al registrar el método de pago."]);
    }
}

mysqli_close($conexion);
?>
