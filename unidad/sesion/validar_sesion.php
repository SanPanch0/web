<?php
session_start();
include 'conexion.php'; // Asegúrate de tener este archivo con la conexión a la BD

// Obtener los datos del formulario
$email = $_POST['email'];
$contrasena = $_POST['contrasena'];

// Consulta para verificar si el usuario existe
$sql = "SELECT id, nombre_usuario, correo, contrasena FROM usuarios WHERE correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    
    // Verificar la contraseña
    if (hash('sha256', $contrasena) === $usuario['contrasena']) {
        // Iniciar sesión y redirigir al index.php
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
        header("Location: TRABAJOINGENIERIA/index.php");
        exit();
    } else {
        // Contraseña incorrecta
        echo "<script>alert('Contraseña incorrecta'); window.location.href='sesion.php';</script>";
    }
} else {
    // Usuario no encontrado
    echo "<script>alert('Usuario no encontrado'); window.location.href='sesion.php';</script>";
}

$stmt->close();
$conn->close();
?>
