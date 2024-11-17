<?php
// Incluir el archivo de conexión
include 'conexion.php'; // Asegúrate de que la ruta es correcta

// Verificar si se ha proporcionado un ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta para eliminar el cliente
    $sql = "DELETE FROM cliente WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // "i" significa que el parámetro es un entero

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir de vuelta a la lista de clientes después de eliminar
        header("location: http://127.0.0.1/unidad/sesion/TRABAJOINGENIERIA/");
        exit();
    } else {
        echo "Error al eliminar el cliente: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "ID no proporcionado.";
}

// Cerrar la conexión
$conn->close();
?>
