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
    <title>Editar Perfil</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/perfil.css">
</head>

<body>
    <main class="editar-perfil">
        <h1>Editar Perfil</h1>
        <div class="contenedor">
            <div class="perfil-y-formulario">
            <div class="perfil">
    <div class="imagen-perfil">
        <img id="preview" src="<?= file_exists("../PERFILES/$id_cliente.jpg") ? "../PERFILES/$id_cliente.jpg" : "../IMG/user-avatar.png" ?>" alt="Foto de perfil">
        <input type="file" id="fotoPerfil" name="fotoPerfil" accept="image/*" style="display: none;">
        <div class="editar-icono" onclick="document.getElementById('fotoPerfil').click();">✏️</div>
    </div>
</div>

                <form class="formulario" id="login-form">
                    <label for="nombre">Nombre Completo:</label>
                    <div class="campo">
                        <img src="../IMG/usuario.png" class="icono">
                        <input type="text" id="nombre" name="nombreCompleto" value="<?= $nombre ?>" placeholder="Nombre Completo">
                    </div>
                    <label for="correo">Correo Electrónico</label>
                    <div class="campo">
                        <img src="../IMG/sobre 2.png" class="icono">
                        <input type="email" id="correo" name="correoElectronico" value="<?= $correo ?>" placeholder="Correo Electrónico">
                    </div>
                    <label for="telefono">Télofono</label>
                    <div class="campo">
                        <img src="../IMG/wats.png" class="icono">
                        <input type="tel" id="telefono" name="numeroTelefonico" value="<?= $telefono ?>" placeholder="Teléfono">
                    </div>
                    <label for="fecha">Edad:</label>
                    <div class="campo">
                        <img src="../IMG/aaa.png" class="icono">
                        <input type="int" id="fecha" name="edad" value="<?= $edad ?>">
                    </div>
                </form>
            </div>
        </div>
        <div class="boton-contenedor">
            <button class="boton boton-regresar" onclick="window.location.href='perfil.php'">Regresar</button>
            <button class="boton boton-guardar" onclick="actualizar()">Guardar</button>
        </div>

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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.location.reload();">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Agregar jQuery completo y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('fotoPerfil').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

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

    // Agregar la imagen si fue seleccionada
    const fileInput = document.getElementById('fotoPerfil');
    if (fileInput.files.length > 0) {
        formData.append('fotoPerfil', fileInput.files[0]);
    }

    fetch('../PHP/actualizar_usuarios.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            mostrarModal(data.message);
            setTimeout(() => {
                location.reload();
            }, 2000);
        } else {
            mostrarModal(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarModal("Ocurrió un error al intentar actualizar el perfil.");
    });
}

    </script>
</body>

</html>