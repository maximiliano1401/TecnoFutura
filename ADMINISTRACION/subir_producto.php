<?php
include "../PHP/conexion.php";

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: ../HTML/index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto</title>
    <link rel="stylesheet" href="../CSS/subir.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<img class="boton" src="../IMG/Button.png" onclick="window.location.href='administracion.php'">
    <div class="contenedor">
    <br>

        <h2 class="titulo">Agregar Nuevo Producto</h2>
        <br>
        <form enctype="multipart/form-data" class="formulario" id="login-form">
        <div class="campo">
    <label for="productName" class="etiqueta">Nombre del Producto</label>
    <input type="text" id="productName" name="nombre_producto" class="campo-texto" placeholder="Ingrese el nombre del producto" required>
</div>
<div class="campo">
    <label for="productDescription" class="etiqueta">Descripción</label>
    <textarea id="productDescription" name="descripcion" rows="3" class="campo-texto textarea" placeholder="Ingrese una descripción del producto" required></textarea>
</div>
<div class="campo">
    <label for="productPrice" class="etiqueta">Precio</label>
    <input type="number" id="productPrice" name="precio" class="campo-texto" placeholder="Ingrese el precio del producto" required>
</div>
<div class="campo">
    <label for="productStock" class="etiqueta">Stock</label>
    <input type="number" id="productStock" name="stock" class="campo-texto" placeholder="Ingrese la cantidad en stock" required>
</div>

            <div class="campo">
                <label for="productCategory" class="etiqueta">Categoría</label>
                <select id="productCategory" name="categoria" class="campo-texto" required>
                    <option value="1">Teléfonos</option>
                    <option value="2">Cómputo</option>
                    <option value="3">Televisores</option>
                    <option value="4">Audio</option>
                </select>
            </div>
            <div class="campo">
                <label for="productBrand" class="etiqueta">Marca</label>
                <select id="productBrand" name="marca" class="campo-texto" required>
                    <option value="1">Samsung</option>
                    <option value="2">Sony</option>
                    <option value="3">MSI</option>
                    <option value="4">Apple</option>
                    <option value="5">JBL</option>
                    <option value="6">PC's</option>
                    <option value="7">Xiaomi</option>
                    <option value="8">OnePlus</option>
                    <option value="9">HP</option>
                    <option value="10">DELL</option>
                    <option value="11">Lenovo</option>
                    <option value="12">Asus</option>
                    <option value="13">Acer</option>
                    <option value="14">HyperX</option>
                    <option value="15">Corsair</option>
                    <option value="16">Arctis</option>
                    <option value="17">Razer</option>
                    <option value="18">Logitech</option>
                    <option value="19">Bose</option>
                    <option value="20">Sennheiser</option>
                    <option value="21">Technica</option>
                    <option value="22">TCL</option>
                    <option value="23">LG</option>
                    <option value="24">Vizio</option>
                    <option value="25">Hisense</option>
                    <option value="26">Toshiba</option>
                </select>
            </div>
            <div class="campo">
                <label for="productImage1" class="etiqueta">Imagen 1</label>
                <input type="file" id="productImage1" name="imagen1" class="campo-texto" required>
            </div>
            <div class="campo">
                <label for="productImage2" class="etiqueta">Imagen 2</label>
                <input type="file" id="productImage2" name="imagen2" class="campo-texto" required>
            </div>
            <div class="boton-aceptar">
                <button type="button" class="boton-fondo" onclick="nuevo()">Agregar Producto</button>
            </div>
        </form>
    </div>


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

        function nuevo() {
            const formulario = document.getElementById("login-form");
            const formData = new FormData(formulario);

            fetch('../PHP_ADMINISTRACION/procesar_productos.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                         mostrarModal(data.message);
                        window.location.href = 'subir_producto.php'; 
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
