<?php
include "conexion.php";
header('Content-Type: application/json');

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();

// Verificar si el cliente está autenticado
if (!isset($_SESSION['ID_Cliente'])) {
    echo json_encode(["status" => "error", "message" => "No tienes permiso para realizar esta acción."]);
    exit;
}

// Guardar la ID del cliente en una variable
$id_cliente = $_SESSION['ID_Cliente'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $calle = trim($_POST['calle'] ?? '');
    $NumExt = trim($_POST['NumExt'] ?? '');
    $NumInt = $_POST['NumInt'] ?? null; // Puede ser opcional
    $entre = trim($_POST['entre'] ?? '');
    $NumContacto = trim($_POST['NumContacto'] ?? '');
    $colonia = trim($_POST['colonia'] ?? '');

    // Validación de campos vacíos o solo espacios
    if (empty($calle) || empty($NumExt) || empty($entre) || empty($NumContacto) || empty($colonia)) {
        echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios (EXCEPTO NUMERO INTERIOR) para poder dar de alta la dirección."]);
        exit;
    }

    // Validación del número de teléfono (mínimo 10 dígitos y solo números)
    if (!empty($NumContacto) && (!preg_match('/^[0-9]{10,}$/', $NumContacto))) {
        echo json_encode(["status" => "error", "message" => "El número de teléfono debe contener al menos 10 dígitos numéricos."]);
        exit;
    }

    // Verificar que no contengan solo espacios
    if (preg_match('/^\s+$/', $calle) || preg_match('/^\s+$/', $NumExt) || preg_match('/^\s+$/', $entre) || preg_match('/^\s+$/', $NumContacto) || preg_match('/^\s+$/', $colonia)) {
        echo json_encode(["status" => "error", "message" => "Ningún campo puede contener solo espacios en blanco."]);
        exit;
    }

    // Consulta para insertar la dirección
    $sql = "INSERT INTO direcciones (Calle, NumExt, NumInt, Entrecalles, NumContacto, Colonia, ID_Cliente) 
            VALUES ('$calle', '$NumExt', '$NumInt', '$entre', '$NumContacto', '$colonia', '$id_cliente')";

    if (mysqli_query($conexion, $sql)) {
        echo json_encode(["status" => "success", "message" => "Tu nueva dirección ha sido registrada exitosamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al registrar tu dirección. Por favor, intenta de nuevo."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método de solicitud no permitido."]);
}

mysqli_close($conexion);
?>
