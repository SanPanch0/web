<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM unidad WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $unidad = $resultado->fetch_assoc();
        echo json_encode($unidad);
    } else {
        echo json_encode([]);
    }

    $stmt->close();
}

$conn->close();
?>
