<?php
include '../conexion.php'; // Asegúrate de incluir la conexión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anio = $_POST['anio'];
    $color = $_POST['color'];
    $numero_placa = $_POST['numero_placa'];
    $estado = $_POST['estado'];

    if (empty($id)) {
        // Insertar nueva unidad
        $stmt = $conn->prepare("INSERT INTO unidad (nombre, marca, modelo, anio, color, numero_placa, estado) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $nombre, $marca, $modelo, $anio, $color, $numero_placa, $estado);
        
        if ($stmt->execute()) {
            echo "Unidad añadida exitosamente.";
        } else {
            echo "Error al añadir unidad: " . $stmt->error;
        }
    } else {
        // Actualizar unidad existente
        $stmt = $conn->prepare("UPDATE unidad SET nombre=?, marca=?, modelo=?, anio=?, color=?, numero_placa=?, estado=? WHERE id=?");
        $stmt->bind_param("sssssssi", $nombre, $marca, $modelo, $anio, $color, $numero_placa, $estado, $id);
        
        if ($stmt->execute()) {
            echo "Unidad actualizada exitosamente.";
        } else {
            echo "Error al actualizar unidad: " . $stmt->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>
