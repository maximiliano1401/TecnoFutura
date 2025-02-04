<?php
include '../PHP/conexion.php';

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: ../HTML/index.html");
    exit;
}

// Consulta SQL para obtener los datos de clientes
$query = "
SELECT 
    ID_Cliente, 
    Nombre, 
    Correo, 
    Telefono, 
    Contrasena, 
    Edad
FROM clientes
";

// Ejecutar consulta
$result = $conexion->query($query);

if (!$result) {
    die("Error en la consulta: " . $conexion->error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/ver_clientes.css">
    <title>Listado de Clientes</title>
</head>
<body>
<img class="boton" src="../IMG/Button.png" onclick="window.location.href='administracion.php'">

    <div class="container">
        <h1>Listado de Clientes</h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID Cliente</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Contraseña</th>
                        <th>Edad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($cliente = $result->fetch_assoc()): ?>
                        <?php if ($cliente['ID_Cliente'] == 8) continue; ?> <!-- Saltar cliente con ID 8 -->
                        <tr>
                            <td><?= $cliente['ID_Cliente']; ?></td>
                            <td><?= $cliente['Nombre']; ?></td>
                            <td><?= $cliente['Correo']; ?></td>
                            <td><?= $cliente['Telefono']; ?></td>
                            <td><?= $cliente['Contrasena']; ?></td>
                            <td><?= $cliente['Edad']; ?></td>
                            <td>
                                <a href="editar_cliente.php?id=<?= $cliente['ID_Cliente']; ?>" class="btn btn-edit">Editar</a>
                                <button type="button" class="btn btn-delete" onclick="openDeleteModal(<?= $cliente['ID_Cliente']; ?>)">Eliminar</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Confirmación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este cliente?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Respuesta -->
    <div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="modalResponseLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalResponseLabel">Mensaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalResponseMessage">
                <!-- El mensaje se mostrará aquí -->
                </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var idClienteAEliminar = null;

    function openDeleteModal(idCliente) {
        idClienteAEliminar = idCliente;
        $('#deleteModal').modal('show');
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (idClienteAEliminar !== null) {
            $.ajax({
                url: '../PHP_ADMINISTRACION/eliminar_cliente.php',
                type: 'GET',
                data: {id: idClienteAEliminar},
                dataType: 'json',
                success: function(response) {
                    $('#deleteModal').modal('hide');
                    $('#modalResponseMessage').html(response.message);
                    $('#responseModal').modal('show');
                    if (response.status === 'success') {
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                },
                error: function(xhr, status, error) {
                    $('#deleteModal').modal('hide');
                    $('#modalResponseMessage').html('Hubo un error en la solicitud.');
                    $('#responseModal').modal('show');
                }
            });
        }
    });
</script>
</body>
</html>
