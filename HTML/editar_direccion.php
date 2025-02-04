<?php
include "../PHP/conexion.php";

// VERIFICAR SESIÓN ACTIVA
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: index.html");
    exit;
}

// OBTENER ID DE LA DIRECCIÓN DESDE LA URL
if (!isset($_GET['id'])) {
    echo "Error: No se proporcionó un ID de dirección.";
    exit;
}

$id_direccion = $_GET['id'];

// CONSULTAR DATOS DE LA DIRECCIÓN
$sql = "SELECT Calle, NumExt, NumInt, Entrecalles, NumContacto, Colonia 
        FROM direcciones 
        WHERE ID_Direccion = '$id_direccion'";
$result = mysqli_query($conexion, $sql);

// VERIFICAR QUE EXISTA LA DIRECCIÓN
if (mysqli_num_rows($result) > 0) {
    $direccion = mysqli_fetch_assoc($result);
} else {
    echo "<script>
            alert('Dirección no encontrada.');
            window.location.href='perfil_direcciones.php';
          </script>";
    exit;
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Dirección</title>
    <link rel="stylesheet" href="../CSS/perfil.css">

    <link rel="stylesheet" href="../CSS/direccion.css">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<img class="boton" src="../IMG/Button.png" onclick="window.location.href='ver_direcciones.php'">

    <div class="contenedor-login">
        <div class="titulo">EDITAR DIRECCIÓN:</div>
        <br>
        <form id="direccion-form">
            <!-- Campo oculto para enviar el ID -->
            <input type="hidden" name="id_direccion" value="<?php echo $id_direccion; ?>" />

            <div class="etiqueta">Calle:</div>
            <div class="campo">
                <input class="campo-texto" type="text" name="calle" value="<?php echo $direccion['Calle']; ?>" required />
            </div>
            <br>
            <div class="etiqueta">Número exterior:</div>
            <div class="campo">
                <input class="campo-texto" type="text" name="num_ext" value="<?php echo $direccion['NumExt']; ?>" required />
            </div>
            <br>
            <div class="etiqueta">Número interior:</div>
            <div class="campo">
                <input class="campo-texto" type="text" name="num_int" value="<?php echo $direccion['NumInt']; ?>" />
            </div>
            <br>
            <div class="etiqueta">¿Entre qué calles está?</div>
            <div class="campo">
                <input class="campo-texto" type="text" name="entre_calles" value="<?php echo $direccion['Entrecalles']; ?>" />
            </div>
            <br>
            <div class="etiqueta">Número de contacto:</div>
            <div class="campo">
                <input class="campo-texto" type="tel" name="num_contacto" value="<?php echo $direccion['NumContacto']; ?>" required />
            </div>
            <br>
            <div class="etiqueta">Colonia:</div>
            <div class="campo">
                <input class="campo-texto" type="text" name="colonia" value="<?php echo $direccion['Colonia']; ?>" required />
            </div>
            <br>
            <div class="boton-aceptar">
                <button type="button" onclick="actualizar()" class="boton-fondo">ACTUALIZAR</button>
            </div>
        </form>

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
                        <!-- Mensaje del modal -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.location.reload();">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

        <script>
    function mostrarModal(mensaje) {
        document.getElementById("modal-message").textContent = mensaje;
        $('#responseModal').modal('show');
    }

    function actualizar() {
        const formulario = document.getElementById("direccion-form");
        const formData = new FormData(formulario);

        // Extraer los valores de los campos del formulario
        const calle = document.querySelector('input[name="calle"]').value || "<?= $direccion['Calle'] ?>";
        const num_ext = document.querySelector('input[name="num_ext"]').value || "<?= $direccion['NumExt'] ?>";
        const num_int = document.querySelector('input[name="num_int"]').value || "<?= $direccion['NumInt'] ?>";
        const entre_calles = document.querySelector('input[name="entre_calles"]').value || "<?= $direccion['Entrecalles'] ?>";
        const num_contacto = document.querySelector('input[name="num_contacto"]').value || "<?= $direccion['NumContacto'] ?>";
        const colonia = document.querySelector('input[name="colonia"]').value || "<?= $direccion['Colonia'] ?>";

        // Actualizar los datos en el FormData
        formData.set('calle', calle);
        formData.set('num_ext', num_ext);
        formData.set('num_int', num_int);
        formData.set('entre_calles', entre_calles);
        formData.set('num_contacto', num_contacto);
        formData.set('colonia', colonia);

        fetch('../PHP/editar_direccion.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    mostrarModal(data.message);
                    setTimeout(() => {
                        window.location.href = 'ver_direcciones.php';
                    }, 2000);
                } else {
                    mostrarModal(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarModal("Ocurrió un error al intentar actualizar la dirección. Intente de nuevo.");
            });
    }
</script>

    </div>
</body>
</html>
