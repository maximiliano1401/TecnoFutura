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
    <title>Editar perfil</title>
    <link rel="stylesheet" href="../CSS/perfil.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<div class="contenedor-login">

  <div class="titulo">EDITA TUS DATOS DE USUARIO:</div>
  <br>
  <form id="login-form">
<div class="etiqueta">Nombre Completo:</div>
<div class="campo">
  <div class="campo-fondo"></div>
  <input class="campo-texto" type="text" name="nombreCompleto"  value="<?= $nombre ?>"  />
  <img class="icono" src="../IMG/usuario.png" alt="Usuario Icono" />
</div>
<br>
<div class="etiqueta">Correo Electrónico:</div>
<div class="campo">
  <div class="campo-fondo"></div>
  <input class="campo-texto" type="email" name="correoElectronico"  value="<?= $correo ?>"  />
  <img class="icono" src="../IMG/sobre 2.png" alt="Usuario Icono" />
</div>
<br>
<div class="etiqueta">Número Telefónico:</div>
<div class="campo">
  <div class="campo-fondo"></div>
  <input class="campo-texto" type="tel" name="numeroTelefonico"  value="<?= $telefono ?>"  />
  <img class="icono" src="../IMG/wats.png" alt="Usuario Icono" />
</div>
<br>
  <div class="etiqueta">Edad:</div>
  <div class="campo">
    <div class="campo-fondo"></div>
    <input class="campo-texto" type="int" name="edad" value="<?= $edad ?>"  />
    <img class="icono" src="../IMG/aaa.png" alt="Contraseña Icono" />
  </div>

</form>
<div class="boton-aceptar">
    <button type="button" onclick="actualizar()" class="boton-fondo">ACTUALIZAR DATOS</button>
    <br><br>
    <button class="boton-fondo" type="submit" onclick="window.location.href='perfil.php' ">REGRESAR</button>
</div>

<!-- Modal de Bootstrap -->
<div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Mensaje</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-message">
                <!-- El mensaje se mostrará aquí -->
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.location.reload();">Cerrar</button>            </div>
        </div>
    </div>
</div>

<!-- Agregar jQuery completo y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
        function checkboxverificador() {
            const checkbox = document.getElementById("terminos");
            const BotonParaProcesar = document.getElementById("botonaceptar");

            if (checkbox.checked) {
                BotonParaProcesar.disabled = false;
            } else {
                BotonParaProcesar.disabled = true;
            }
        }

        function mostrarModal(mensaje) {
            // Insertar el mensaje en el cuerpo del modal
            const modalMessage = document.getElementById("modal-message");
            modalMessage.textContent = mensaje;

            // Mostrar el modal usando Bootstrap
            $('#responseModal').modal('show');
        }

        function actualizar() {
    const formulario = document.getElementById("login-form");
    const formData = new FormData(formulario);

    // Verifico que se envien datos hayan o NO HAYAN sido editados
    const nombre = document.querySelector('input[name="nombreCompleto"]').value || "<?= $nombre ?>";
    const correo = document.querySelector('input[name="correoElectronico"]').value || "<?= $correo ?>";
    const numero = document.querySelector('input[name="numeroTelefonico"]').value || "<?= $telefono ?>";
    const edad = document.querySelector('input[name="edad"]').value || "<?= $edad ?>";


    //agrego los datos en el formdata
    formData.set('nombreCompleto', nombre);
    formData.set('correoElectronico', correo);
    formData.set('numeroTelefonico', numero);
    formData.set('edad', edad);

    fetch('../PHP/actualizar_usuarios.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                mostrarModal(data.message);
                window.location.href = 'editar_perfil.php';
            } else {
                mostrarModal(data.message);
            }
            formulario.reset();
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarModal("Ocurrió un error al intentar actualizar al usuario. Intente de nuevo.");
        });
}
    </script>

</body>
</html>