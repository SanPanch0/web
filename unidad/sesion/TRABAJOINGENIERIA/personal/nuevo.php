<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos del formulario
    $nombre_completo = $_POST['nombre_completo'];
    $dni = $_POST['dni'];
    $numero_celular = $_POST['numero_celular'];
    $tipo = $_POST['tipo'];
    $licencia_conducir = $_POST['licencia_conducir'];
    $clase_licencia = $_POST['clase_licencia'];
    $direccion = $_POST['direccion'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $email = $_POST['email'];
    $estado = $_POST['estado'];

    // Subir la imagen
    if (isset($_FILES['imagen'])) {
        $imagen = $_FILES['imagen'];
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_destino = 'uploads/' . $imagen_nombre;
        move_uploaded_file($imagen_tmp, $imagen_destino);
    }

    // Insertar el personal en la base de datos
    $sql = "INSERT INTO personal (nombre_completo, dni, numero_celular, tipo, licencia_conducir, clase_licencia, direccion, fecha_nacimiento, fecha_ingreso, email, estado, imagen) VALUES ('$nombre_completo', '$dni', '$numero_celular', '$tipo', '$licencia_conducir', '$clase_licencia', '$direccion', '$fecha_nacimiento', '$fecha_ingreso', '$email', '$estado', '$imagen_nombre')";

    if ($conn->query($sql) === TRUE) {
        echo "Nuevo personal añadido correctamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
