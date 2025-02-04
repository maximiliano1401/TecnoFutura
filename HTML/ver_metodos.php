<?php
include "../PHP/conexion.php";

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: index.html");
    exit;
}

// Guardo la id en una variable
$id_cliente = $_SESSION['ID_Cliente'];

// Verificación si se ha solicitado eliminar un método de pago
if (isset($_POST['eliminar'])) {
    $id_metodo = $_POST['id_metodo'];

    // Verificar si el método de pago está siendo usado en la tabla detalles_pedido
    $sql_check = "SELECT * FROM detalles_pedido WHERE ID_Metodo = '$id_metodo'";
    $check_result = mysqli_query($conexion, $sql_check);

    if (mysqli_num_rows($check_result) > 0) {
        // Si hay registros en detalles_pedido, no se puede eliminar el método de pago
        $_SESSION['message'] = "No puedes eliminar este método debido a que está enlazado a un pedido existente.";
    } else {
        // Si no hay registros, se puede eliminar el método de pago
        $sql_delete = "DELETE FROM metodospagos WHERE ID_Cliente = '$id_cliente' AND ID_Metodo = '$id_metodo'";

        if (mysqli_query($conexion, $sql_delete)) {
            $_SESSION['message'] = "Método de pago eliminado correctamente.";
        } else {
            $_SESSION['message'] = "Error al eliminar el método de pago: " . mysqli_error($conexion);
        }
    }
}

// Consulta a la base de datos para obtener los métodos de pago
$sql = "SELECT Titular, Numeros, CVV, MyA, ID_Cliente, ID_Metodo FROM metodospagos WHERE ID_Cliente = '$id_cliente'";
$result = mysqli_query($conexion, $sql);

if (!$result) {
    $_SESSION['message'] = "Error al consultar los métodos de pago: " . mysqli_error($conexion);
    exit;
}

// Cerrar conexión después de usarla
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metodos de pagos</title>
    <link rel="stylesheet" href="../CSS/ver_metodos.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="contenedor-login">
        <h1>Metodos de Pagos Registrados</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>Nombre del titular de la tarjeta</th>
                    <th>Numero de la tarjeta</th>
                    <th>Mes y Año</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['Titular']; ?></td>
                            <td><?php echo $row['Numeros']; ?></td>
                            <td><?php echo $row['MyA']; ?></td>
                            <td>
                                <button type="button" class="btn-accion btn-eliminar" onclick="openModal('<?php echo $row['ID_Metodo']; ?>')">Eliminar</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No tienes métodos de pago registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <center>
            <div class="boton-aceptar">
                <button class="boton-fondo" type="button" onclick="window.location.href='menu.php'">REGRESAR</button>
            </div>
        </center>
    </div>

    <!-- Modal -->
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
                    ¿Estás seguro de que deseas eliminar este método de pago?
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" action="" method="post">
                        <input type="hidden" name="id_metodo" id="id_metodo">
                        <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openModal(idMetodo) {
            document.getElementById('id_metodo').value = idMetodo;
            $('#deleteModal').modal('show');
        }
    </script>
</body>
</html>
