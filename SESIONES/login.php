<?php
session_start();
include "../PHP/conexion.php";

// Forzar respuesta en JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM clientes WHERE Correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();

        // Validar contraseña
        if (hash('sha256', $contrasena) === $fila['Contrasena']) {
            $_SESSION['ID_Cliente'] = $fila['ID_Cliente'];
            $_SESSION['Nombre'] = $fila['Nombre'];
            $_SESSION['Correo'] = $fila['Correo'];

            echo json_encode([
                'success' => true,
                'redirect' => '../HTML/menu.php'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'La contraseña es incorrecta.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'El usuario no existe.'
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Solicitud inválida.'
    ]);
}

$conexion->close();
?>
