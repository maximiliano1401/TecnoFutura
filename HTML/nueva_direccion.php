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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/direccion.css">
</head>

<body>
    <header>
        <button class="back-button" onclick="window.location.href='menu.php'">
            <img src="../IMG/Arrow-left-circle.png" alt="Logo" class="logo">
        </button>
    </header>

    <h1>Añadir Nueva Dirección</h1>
    <main>
        <form id="direccion-form">
            <label for="colonia">Colonia*:</label>
            <input type="text" id="colonia" name="colonia" placeholder="Nombre De La Colonia" required>

            <label for="calle">Calle*:</label>
            <input type="text" id="calle" name="calle" placeholder="Nombre de calle" required>

            <div class="row">
                <div class="column">
                    <label for="num_exterior">Número exterior:</label>
                    <input type="text" id="num_exterior" name="NumExt" placeholder="(OPCIONAL)">
                </div>
                <div class="column">
                    <label for="num_interior">Número interior:</label>
                    <input type="text" id="num_interior" name="NumInt" placeholder="(OPCIONAL)">
                </div>
            </div>

            <div class="row">
                <div class="column">
                    <label for="entre_calles">¿Entre qué calles está?</label>
                    <input type="text" id="entre_calles" name="entre" placeholder="(OPCIONAL)">
                </div>
                <div class="column">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="NumContacto" placeholder="Número telefónico">
                </div>
            </div>

            <button type="submit" onclick="direccion()" class="guardar-btn">Guardar</button>
        </form>
    </main>

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