<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de registro</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/registrousuarios.css">
</head>

<body>

    <div class="registro-container">
        <!-- Lado izquierdo -->
        <div class="logo-section">
            <h1 class="titulo">¡Bienvenido!</h1>
            <p class="subtitulo">Se parte de nuestra familia</p>
            <img src="../IMG/logo.png" alt="Logo" class="logo" />
        </div>

        <!-- Lado derecho -->
        <div class="form-section">
            <div class="instruction">Registrate</div>
            <form id="login-form" class="formm">
                <div class="input">
                    <input type="text" id="nombre" name="nombre" class="input-field" placeholder="Ingresa tu nombre completo" required>
                </div>
                <div class="input">
                    <input type="number" id="edad" name="edad" min="0" class="input-field" placeholder="Fecha de nacimiento" required>
                </div>
                <div class="input">
                    <input type="email" id="correo" name="correo" class="input-field" placeholder="Ingresa un correo" required>
                </div>
                <div class="input">
                    <input type="number" id="numero" name="numero" min="0" class="input-field" placeholder="Ingresa tu númerdo de celular" required>
                </div>
                <div class="input password">
                    <input type="password" id="contrasena" name="contrasena" class="input-field" placeholder="Ingresa una contraseña" required>
                </div>

                <div class="terms">
                    <input class="izquierda" type="checkbox" id="terminos" onclick="checkboxverificador()">
                    <label for="terminos">
                        <a href="terminos_condiciones.html" target="_blank">Estoy de acuerdo con los Términos de servicio y la política de privacidad.</a>
                    </label>
                </div>

                <center>
                    <button type="button" onclick="registro()" class="button aceptar" id="botonaceptar" disabled>ACEPTAR</button>
                    <br>
                    <button type="button" class="button regresar" onclick="window.location.href='index.html'">REGRESAR</button>
                </center>

            </form>
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

        function registro() {
            const formulario = document.getElementById("login-form");
            const formData = new FormData(formulario);

            fetch('../PHP/procesar_usuarios.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        mostrarModal(data.message);
                        formulario.reset(); // Reinicia el formulario solo si el registro es exitoso
                        window.location.href = 'index.html';
                    } else {
                        mostrarModal(data.message); // Muestra el mensaje de error sin reiniciar el formulario
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarModal("Ocurrió un error al intentar registrar al usuario. Intente de nuevo.");
                });
        }

    </script>
</body>

</html>
