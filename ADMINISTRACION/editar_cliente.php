<?php
include '../PHP/conexion.php';

// VERIFICACIÓN DE SESIÓN ACTIVA
session_start();
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: ../HTML/index.html");
    exit;
}

// Verificar si el cliente existe y obtener sus datos
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_cliente = $_GET['id'];

    // Obtener los datos del cliente para mostrar en el formulario
    $query = "SELECT * FROM clientes WHERE ID_Cliente = ?";
    $stmt = $conexion->prepare($query);
    if ($stmt === false) {
        $response = ["status" => "error", "message" => "Error al preparar la consulta: " . $conexion->error];
        echo json_encode($response);
        exit;
    }
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $cliente = $result->fetch_assoc();
    } else {
        $response = ["status" => "error", "message" => "Cliente no encontrado."];
        echo json_encode($response);
        exit;
    }
} else {
    $response = ["status" => "error", "message" => "ID de cliente no especificado."];
    echo json_encode($response);
    exit;
}

// Procesar la actualización del cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $edad = $_POST['edad'];

    // Actualizar los datos del cliente
    $update_query = "UPDATE clientes SET nombre = ?, Correo = ?, telefono = ?, Edad = ? WHERE ID_Cliente = ?";
    $stmt_update = $conexion->prepare($update_query);
    if ($stmt_update === false) {
        $response = ["status" => "error", "message" => "Error al preparar la consulta de actualización: " . $conexion->error];
        echo json_encode($response);
        exit;
    }
    $stmt_update->bind_param("ssssi", $nombre, $email, $telefono, $edad, $id_cliente);
    
    if ($stmt_update->execute()) {
        $response = ["status" => "success", "message" => "Cliente actualizado con éxito."];
    } else {
        $response = ["status" => "error", "message" => "Error al actualizar el cliente: " . $stmt_update->error];
    }

    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/editar_clientes.css">
    <title>Editar Cliente</title>
</head>
<body>
<img class="boton" src="../IMG/Button.png" onclick="window.location.href='ver_clientes.php'">
    <h1>Editar Cliente</h1>
    <form id="clienteForm" action="editar_cliente.php?id=<?php echo $cliente['ID_Cliente']; ?>" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $cliente['Nombre']; ?>" required>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" value="<?php echo $cliente['Correo']; ?>" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo $cliente['Telefono']; ?>" required>

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" value="<?php echo $cliente['Edad']; ?>" required>

        <input type="submit" value="Guardar Cambios">
    </form>

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
        document.getElementById('clienteForm').addEventListener('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                $('#modalResponseMessage').text(data.message);
                $('#responseModal').modal('show');
            })
            .catch(error => {
                console.error('Error:', error);
                $('#modalResponseMessage').text('Hubo un error en la solicitud.');
                $('#responseModal').modal('show');
            });
        });
    </script>
</body>
</html>
