<?php
include "conexion.php";

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: index.html");
    exit;
}

// Verificar ID en la URL
if (!isset($_GET['id'])) {
    $_SESSION['message'] = "Error: No se proporcionó un ID de dirección.";
    header("Location: ../HTML/ver_direcciones.php");
    exit;
}

// Obtener el ID de la dirección
$id_direccion = $_GET['id'];

// Verificar si la dirección tiene dependencias en "detalles_pedido"
$dependencias = "SELECT * FROM detalles_pedido WHERE ID_Direccion = '$id_direccion'";
$resultado_dependencias = mysqli_query($conexion, $dependencias);

if (mysqli_num_rows($resultado_dependencias) > 0) {
    $_SESSION['message'] = "No puedes eliminar esta dirección porque tienes pedidos registrados con este dato.";
    header("Location: ../HTML/ver_direcciones.php");
    exit;
}

// Si no hay dependencias, eliminar la dirección
$sql_delete = "DELETE FROM direcciones WHERE ID_Direccion = '$id_direccion'";
if (mysqli_query($conexion, $sql_delete)) {
    echo json_encode(["message" => "Dirección eliminada correctamente."]);
    header("Location: ../HTML/ver_direcciones.php");
} else {
    $_SESSION['message'] = "Error al eliminar la dirección: " . mysqli_error($conexion);
    header("Location: ../HTML/ver_direcciones.php");
}

// Cerrar conexión
mysqli_close($conexion);
?>
