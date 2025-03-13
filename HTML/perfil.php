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

  <header class="header">
    <nav class="navbar">
      <div class="navbar-left">
        <a href="menu.php" class="navbar-brand">
          <img src="../IMG/Arrow-left-circle.png" alt="Logo" class="logo">
        </a>
      </div>
    </nav>
  </header>

  <main class="editar-perfil">
    <div class="contenedor">
      <div class="perfil-y-formulario">
        <div class="perfil">
          <div class="imagen-perfil">
            <img src="../IMG/user-avatar.png" alt="Foto de perfil">
          </div>
          <br>
          <button class="boton boton-editar" onclick="window.location.href='editar_perfil.php'">Editar Perfil</button>
        </div>
        <form class="formulario" id="login-form">
          <label for="nombre">Nombre Completo:</label>
          <div class="campo">
            <img src="../IMG/usuario.png" class="icono">
            <input type="text" id="nombre" name="nombreCompleto" value="<?= $nombre ?>" placeholder="Nombre Completo" disabled>
          </div>
          <label for="correo">Correo Electrónico</label>
          <div class="campo">
            <img src="../IMG/sobre 2.png" class="icono">
            <input type="email" id="correo" name="correoElectronico" value="<?= $correo ?>" placeholder="Correo Electrónico" disabled>
          </div>
          <label for="telefono">Télofono</label>
          <div class="campo">
            <img src="../IMG/wats.png" class="icono">
            <input type="tel" id="telefono" name="numeroTelefonico" value="<?= $telefono ?>" placeholder="Teléfono" disabled>
          </div>
          <label for="fecha">Edad:</label>
          <div class="campo">
            <img src="../IMG/aaa.png" class="icono">
            <input type="int" id="fecha" name="edad" value="<?= $edad ?>" disabled>
          </div>
        </form>
      </div>
    </div>
  </main>
</body>

</html>