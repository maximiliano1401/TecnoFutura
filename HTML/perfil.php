<?php
include "../PHP/conexion.php";

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: index.html");
    exit;
}

//Guardo la id en una variable
$id_cliente = $_SESSION['ID_Cliente'];

//Con esa variable consulto en la BD
$sql = "SELECT Nombre, Correo, Telefono, Edad FROM clientes WHERE ID_Cliente = '$id_cliente'";
$result = mysqli_query($conexion, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    //Asigno los datos en una variable
    $row = mysqli_fetch_assoc($result);
    $nombre = $row['Nombre'];
    $correo = $row['Correo'];
    $telefono = $row['Telefono'];
    $edad = $row['Edad'];
} else {
    //En caso de no encontrar mantener al usuario en la pagina
    header("Location: perfil.php");
    exit;
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver perfil</title>
    <link rel="stylesheet" href="../CSS/perfil.css">
</head>
<body>
<div class="contenedor-login">


  <div class="titulo"> PERFIL DE USUARIO: </div>
  <br><br>
  <form action="" method="post">
<div class="etiqueta">Nombre Completo:</div>
<div class="campo">
  <div class="campo-fondo"></div>
  <input class="campo-texto" type="text" name="nombreCompleto" value="<?= $nombre ?>" disabled />
  <img class="icono" src="../IMG/usuario.png" alt="Usuario Icono" />
</div>
<br>
<div class="etiqueta">Correo Electrónico:</div>
<div class="campo">
  <div class="campo-fondo"></div>
  <input class="campo-texto" type="email" name="correoElectronico" value="<?= $correo ?>" disabled />
  <img class="icono" src="../IMG/sobre 2.png" alt="Usuario Icono" />
</div>
<br>
<div class="etiqueta">Número Telefónico:</div>
<div class="campo">
  <div class="campo-fondo"></div>
  <input class="campo-texto" type="tel" name="numeroTelefonico" value="<?= $telefono ?>" disabled />
  <img class="icono" src="../IMG/wats.png" alt="Usuario Icono" />
</div>
<br>
  <div class="etiqueta">Edad:</div>
  <div class="campo">
    <div class="campo-fondo"></div>
    <input class="campo-texto" type="int" name="edad" value="<?= $edad ?>" disabled />
    <img class="icono" src="../IMG/aaa.png" alt="Edad Icono" />
  </div>
</form>
<br>
  
  <div class="boton-aceptar">
    <button type="submit" class="boton-fondo"onclick="window.location.href='editar_perfil.php'">EDITAR PERFIL</button>
    <br><br>
    <button class="boton-fondo" type="submit" onclick="window.location.href='menu.php' ">REGRESAR</button>
    <br>
    <br>

</div>
</div>
</body>
</html>