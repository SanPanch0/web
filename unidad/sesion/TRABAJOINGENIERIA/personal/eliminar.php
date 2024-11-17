<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si se ha enviado el ID del registro a eliminar
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Asegurarse de que el ID es un número entero

    // Consulta para eliminar el registro
    $sql = "DELETE FROM personal WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // Ejecutar la consulta y verificar el resultado
    if ($stmt->execute()) {
        // Aquí puedes agregar un mensaje de éxito si lo deseas
        // echo "Registro eliminado con éxito.";
    } else {
        // Aquí puedes agregar un mensaje de error si lo deseas
        // echo "Error al eliminar el registro: " . $stmt->error;
    }

    $stmt->close();
}

// Cerrar la conexión
$conn->close();

// Redirigir a la página especificada después de eliminar
header("Location: http://127.0.0.1/unidad/sesion/TRABAJOINGENIERIA/");
exit();
?>
