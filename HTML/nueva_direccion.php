<?php
include "../PHP/conexion.php";

// VERIFICACION DE SESION ACTIVA
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Dirección</title>
    <link rel="stylesheet" href="../CSS/direccion.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<img class="boton" src="../IMG/Button.png" onclick="window.location.href='menu.php'">
    <div class="contenedor-login">
        <div class="titulo">REGISTRAR UNA NUEVA DIRECCION:</div>
        <br>
        <form id="login-form">
            <div class="etiqueta">Calle:</div>
            <div class="campo">
                <div class="campo-fondo"></div>
                <input class="campo-texto" type="text" name="calle" placeholder="Dirección y/o Domicilio"  />
            </div>
            <br>
            <div class="etiqueta">Número exterior:</div>
            <div class="campo">
                <div class="campo-fondo"></div>
                <input class="campo-texto" type="number" name="NumExt" placeholder="Ingresa tu numero exterior."  />
            </div>
            <br>
            <div class="etiqueta">Número interior:</div>
            <div class="campo">
                <div class="campo-fondo"></div>
                <input class="campo-texto" type="number" name="NumInt" placeholder="Ingresa tu numero interior. (OPCIONAL)"  />
            </div>
            <br>
            <div class="etiqueta">¿Entre qué calles está?</div>
            <div class="campo">
                <div class="campo-fondo"></div>
                <input class="campo-texto" type="text" name="entre" placeholder="Ingresa entre que calles se encuentra tu domicilio."  />
            </div>
            <br>
            <div class="etiqueta">Número de contacto:</div>
            <div class="campo">
                <div class="campo-fondo"></div>
                <input class="campo-texto" type="number" name="NumContacto" placeholder="Ingresa algun numero de contacto del domicilio."  />
            </div>
            <br>
            <div class="etiqueta">Colonia:</div>
            <div class="campo">
                <div class="campo-fondo"></div>
                <input class="campo-texto" type="text" name="colonia" placeholder="Ingresa la colonia."/>
            </div>
        </form>
        <br>
        <div class="boton-aceptar">
            <button type="button"  onclick="direccion()" class="boton-fondo">REGISTRAR DIRECCION</button>
        </div>

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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Agregar enlaces a jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function mostrarModal(mensaje) {
            // Insertar el mensaje en el cuerpo del modal
            const modalMessage = document.getElementById("modal-message");
            modalMessage.textContent = mensaje;

            // Mostrar el modal usando Bootstrap
            $('#responseModal').modal('show');
        }

        function direccion() {
            const formulario = document.getElementById("login-form");
            const formData = new FormData(formulario);

            fetch('../PHP/procesar_direccion.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                         mostrarModal(data.message);
                        window.location.href = 'nueva_direccion.php'; 
                    } else {
                        mostrarModal(data.message);
                    }
                    formulario.reset();
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarModal("Ocurrió un error al intentar registrar la direccion. Intente de nuevo.");
                });
        }

    </script>
</body>
</html>
