<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];

    $stmt = $conn->prepare("DELETE FROM unidad WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Unidad borrada exitosamente.";
    } else {
        echo "Error al borrar unidad: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
