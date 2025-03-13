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

//Consulta a la base de datos para obtener direcciones
$sql = "SELECT ID_Direccion, Calle, NumExt, NumInt, Entrecalles, NumContacto, Colonia FROM direcciones WHERE ID_Cliente = '$id_cliente'";
$result = mysqli_query($conexion, $sql);

if (!$result) {
    echo "Error al consultar las direcciones: " . mysqli_error($conexion);
    exit;
}
//Cerrar conexión después de usarla
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Dirección</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/ver_metodos.css">
</head>

<body>
    <header>
        <button class="back-button" onclick="window.location.href='menu.php'">&#8592;</button>
    </header>
    <div class="contenedor-login">
        <h1>Direcciones Registradas</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>Calle</th>
                    <th>Número Exterior</th>
                    <th>Número Interior</th>
                    <th>Entre Calles</th>
                    <th>Contacto</th>
                    <th>Colonia</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['Calle']; ?></td>
                            <td><?php echo $row['NumExt']; ?></td>
                            <td><?php echo $row['NumInt']; ?></td>
                            <td><?php echo $row['Entrecalles']; ?></td>
                            <td><?php echo $row['NumContacto']; ?></td>
                            <td><?php echo $row['Colonia']; ?></td>
                            <td>
                                <a href="editar_direccion.php?id=<?php echo $row['ID_Direccion']; ?>" class="btn-accion btn-editar">Editar</a>
                                <button type="button" class="btn-accion btn-eliminar" onclick="openModal(<?php echo $row['ID_Direccion']; ?>)">Eliminar</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No tienes direcciones registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <!-- <center>
            <div class="boton-aceptar">
                <button class="boton-fondo" type="button" onclick="window.location.href='menu.php'">REGRESAR</button>
            </div>
        </center> -->
    </div>

    <!-- Modal de confirmación -->
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
                    ¿Estás seguro de que deseas eliminar esta dirección?
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" action="../PHP/procesar_eliminar_direccion.php" method="get">
                        <input type="hidden" name="id" id="direccionId">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function openModal(idDireccion) {
            document.getElementById('direccionId').value = idDireccion;
            $('#deleteModal').modal('show');
        }
    </script>

</body>

</html>