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
    <title>Nuevo metodo de pago</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/pago.css">
</head>

<body>
    <div class="contenedor">

        <img class="logo" src="../IMG/logo.png" alt="Logo" />
        <form id="login-form">
            <center>
                <h2>Agregar Un Nuevo Metodo de Pago</h2>
            </center>
            <br><br>
            <div class="input">
                <input type="text" id="nombre" name="nombre" class="input-field" placeholder="Nombre completo del titular" required>
            </div>
            <div class="input">
                <input type="text" id="numero" name="numero" class="input-field" placeholder="Número completo de la tarjeta" required>
            </div>
            <div class="input">
                <input type="text" id="cvv" name="cvv" class="input-field" placeholder="CVV" required>
            </div>
            <div class="input">
                <input type="number" id="mes" name="mes" min="1" max="12" class="input-fieldd" placeholder="Mes (MM)" required>
                <input type="number" id="anio" name="anio" min="2024" class="input-fieldd" placeholder="Año (YYYY)" required>
            </div>

            <center>
                <br>
                <div class="boton-movido">
                    <button type="button" onclick="registro()" class="boton-fondo" id="botonaceptar">AGREGAR</button>
                    <button type="button" class="boton-fondo" onclick="window.location.href='menu.php'">REGRESAR</button>
                </div>
            </center>
        </form>
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

        function registro() {
            const formulario = document.getElementById("login-form");
            const formData = new FormData(formulario);

            fetch('../PHP/procesar_metodo.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        mostrarModal(data.message);
                        window.location.href = 'nuevo_metodo.php';
                    } else {
                        mostrarModal(data.message);
                    }
                    formulario.reset();
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarModal("Ocurrió un error al intentar registrar tu nuevo metodo de pago. Intente de nuevo.");
                });
        }
    </script>

</body>

</html>