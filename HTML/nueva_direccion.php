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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
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
        <form id="login-form">
        <div class="row">
            <label for="colonia">Colonia*:</label>
            <input type="text" id="colonia" name="colonia" placeholder="Nombre De La Colonia" required>
        </div>
        <div class="row">
            <label for="calle">Calle*:</label>
            <input type="text" id="calle" name="calle" placeholder="Nombre de calle" required>
        </div>
            <div class="row">
                <div class="column">
                    <label for="num_exterior">Número exterior*:</label>
                    <input type="text" id="num_exterior" name="NumExt" placeholder="Número de casa" required>
                </div>
                <div class="column">
                    <label for="num_interior">Número interior:</label>
                    <input type="text" id="num_interior" name="NumInt" placeholder="(OPCIONAL)">
                </div>
            </div>

            <div class="row">
                <div class="column">
                    <label for="entre_calles">¿Entre qué calles está?*</label>
                    <input type="text" id="entre_calles" name="entre" placeholder=" Entre calles" required>
                </div>
                <div class="column">
                    <label for="telefono">Teléfono*:</label>
                    <input type="text" id="telefono" name="NumContacto" placeholder="Número telefónico">
                </div>
            </div>

            <button type="submit" class="guardar-btn">Guardar</button>
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
        // Función para mostrar el modal con el mensaje correspondiente
        function mostrarModal(mensaje) {
            const modalMessage = document.getElementById("modal-message");
            modalMessage.textContent = mensaje;
            $('#responseModal').modal('show');
        }
        // Event listener para manejar el envío del formulario
        const form = document.getElementById("login-form");
        form.addEventListener("submit", direccion);

        // Función para marcar los campos con error (clase is-invalid de Bootstrap)
        function marcarCamposError(campo, mensaje) {
            campo.classList.add("is-invalid"); // Marca el campo como inválido
            let errorElement = campo.parentElement.querySelector(".invalid-feedback");
            if (!errorElement) {
                errorElement = document.createElement("div");
                errorElement.classList.add("invalid-feedback");
                campo.parentElement.appendChild(errorElement);
            }
            errorElement.textContent = mensaje;
        }

        // Función para limpiar errores previos
        function limpiarErrores(formulario) {
            const campos = formulario.querySelectorAll("input");
            campos.forEach(campo => {
                campo.classList.remove("is-invalid"); // Eliminar clase de error
                const errorElement = campo.parentElement.querySelector(".invalid-feedback");
                if (errorElement) {
                    errorElement.remove(); // Eliminar mensaje de error
                }
            });
        }

        // Función para validar el formulario antes de enviar
        function direccion(event) {
            event.preventDefault(); // Prevenir el envío del formulario

            const formulario = document.getElementById("login-form");
            const formData = new FormData(formulario);

            // Limpiar errores previos
            limpiarErrores(formulario);

            // Variables de los campos del formulario
            const calle = document.getElementById("calle").value.trim();
            const NumExt = document.getElementById("num_exterior").value.trim();
            const NumContacto = document.getElementById("telefono").value.trim();
            const colonia = document.getElementById("colonia").value.trim();
            const entreCalles = document.getElementById("entre_calles").value.trim();

            let hayErrores = false;

            // Validación de los campos
            if (!calle) {
                marcarCamposError(document.getElementById("calle"), "Este campo es obligatorio.");
                hayErrores = true;
            }

            if (!NumExt) {
                marcarCamposError(document.getElementById("num_exterior"), "Este campo es obligatorio.");
                hayErrores = true;
            }

            if (!entreCalles) {
                marcarCamposError(document.getElementById("entre_calles"), "Este campo es obligatorio.");
                hayErrores = true;
            }

            if (!colonia) {
                marcarCamposError(document.getElementById("colonia"), "Este campo es obligatorio.");
                hayErrores = true;
            }

            if (!NumContacto || !/^[0-9]{10,}$/.test(NumContacto)) {
                marcarCamposError(document.getElementById("telefono"), "El número de teléfono debe contener al menos 10 dígitos numéricos.");
                hayErrores = true;
            }

            // Si hay errores, no continuar con la petición fetch
            if (hayErrores) {
                return; // Detener el envío del formulario
            }

            // Si no hay errores, realizar la solicitud AJAX
            fetch('../PHP/procesar_direccion.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        mostrarModal(data.message); // Mostrar mensaje de éxito
                        formulario.reset(); // Reiniciar el formulario solo si es exitoso
                    } else {
                        mostrarModal(data.message); // Mostrar mensaje de error
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarModal("Ocurrió un error al intentar registrar la dirección. Intente de nuevo.");
                });
        }
    </script>
</body>

</html>