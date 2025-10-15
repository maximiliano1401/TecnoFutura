<?php
include "../PHP/conexion.php";

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: ../HTML/index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MODO ADMINISTRACIÓN</title>
    <link rel="stylesheet" href="../CSS/admin.css">
</head>
<body>
<img class="boton" src="../IMG/Button.png" onclick="window.location.href='../HTML/menu.php'">

    <div class="container">
        <div class="header">
            <h5 class="username"><?php echo $_SESSION['Nombre']; ?></h5>
            <h5 class="email"><?php echo $_SESSION['Correo']; ?></h5>
        </div>

        <div class="button-container">
            <button class="custom-button" onclick="window.location.href='subir_producto.php'">Subir un nuevo producto</button>
            <button class="custom-button" onclick="window.location.href='ver_productos.php'">Editar un producto</button>
            <button class="custom-button" onclick="window.location.href='ver_pedidos.php'">Editar los envíos</button>
            <button class="custom-button" onclick="window.location.href='ver_clientes.php'">Gestionar a clientes</button>

        </div>
    </div>
</body>
</html>
