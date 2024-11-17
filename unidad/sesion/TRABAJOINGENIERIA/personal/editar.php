<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Inicializar variables para los datos
$personal = null;

// Verificar si se ha pasado un ID a editar
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    
    // Consulta para obtener los datos del personal por ID
    $sql = "SELECT * FROM personal WHERE id = $id";
    $result = $conn->query($sql);
    
    // Verificar si hay errores en la consulta
    if ($result === false) {
        die("Error en la consulta: " . $conn->error);
    }
    
    // Obtener los datos del personal
    $personal = $result->fetch_assoc();
}

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre_completo = $_POST['nombre_completo'];
    $dni = $_POST['dni'];
    $numero_celular = $_POST['numero_celular'];
    $tipo = $_POST['tipo'];
    $licencia_conducir = $_POST['licencia_conducir'] ?? null;
    $clase_licencia = $_POST['clase_licencia'] ?? null;
    $direccion = $_POST['direccion'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $email = $_POST['email'];
    $estado = $_POST['estado'];

    // Verificar si se subió una nueva imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Obtener los datos de la imagen
        $imagen_nombre = basename($_FILES['imagen']['name']);
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_destino = 'images/' . $imagen_nombre;
        
        // Mover la imagen a la carpeta de imágenes
        move_uploaded_file($imagen_tmp, $imagen_destino);
        
        // Actualizar la consulta para incluir la nueva imagen
        $sql = "UPDATE personal SET nombre_completo = ?, dni = ?, numero_celular = ?, tipo = ?, licencia_conducir = ?, clase_licencia = ?, direccion = ?, fecha_nacimiento = ?, fecha_ingreso = ?, email = ?, estado = ?, imagen = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssssi", $nombre_completo, $dni, $numero_celular, $tipo, $licencia_conducir, $clase_licencia, $direccion, $fecha_nacimiento, $fecha_ingreso, $email, $estado, $imagen_nombre, $id);
    } else {
        // Si no se subió una nueva imagen, mantener la imagen actual
        $sql = "UPDATE personal SET nombre_completo = ?, dni = ?, numero_celular = ?, tipo = ?, licencia_conducir = ?, clase_licencia = ?, direccion = ?, fecha_nacimiento = ?, fecha_ingreso = ?, email = ?, estado = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssssi", $nombre_completo, $dni, $numero_celular, $tipo, $licencia_conducir, $clase_licencia, $direccion, $fecha_nacimiento, $fecha_ingreso, $email, $estado, $id);
    }
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir a personal.php después de la actualización exitosa
        header("location: http://127.0.0.1/unidad/sesion/TRABAJOINGENIERIA/");
        exit(); // Asegurarse de detener el script después de la redirección
    } else {
        $message = "Error al actualizar el registro: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Personal</title>
    <link rel="stylesheet" href="personal/personal.css">
</head>
<body>

<h1>Editar Personal</h1>

<?php if (isset($message)): ?>
    <p><?php echo $message; ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Nombre Completo:</label>
    <input type="text" name="nombre_completo" value="<?php echo $personal['nombre_completo']; ?>" required><br>
    
    <label>DNI:</label>
    <input type="text" name="dni" value="<?php echo $personal['dni']; ?>" required><br>
    
    <label>Número Celular:</label>
    <input type="text" name="numero_celular" value="<?php echo $personal['numero_celular']; ?>" required><br>
    
    <label>Tipo:</label>
    <select name="tipo" id="tipo" required onchange="toggleLicenseFields()">
        <option value="Conductor" <?php echo $personal['tipo'] === 'Conductor' ? 'selected' : ''; ?>>Conductor</option>
        <option value="Estiba" <?php echo $personal['tipo'] === 'Estiba' ? 'selected' : ''; ?>>Estiba</option>
        <option value="Embalador" <?php echo $personal['tipo'] === 'Embalador' ? 'selected' : ''; ?>>Embalador</option>
    </select><br>

    <div id="licencia-fields" style="<?php echo $personal['tipo'] === 'Conductor' ? 'display: block;' : 'display: none;'; ?>">
        <label>Licencia de Conducir:</label>
        <input type="text" name="licencia_conducir" value="<?php echo $personal['licencia_conducir']; ?>"><br>
        
        <label>Clase de Licencia:</label>
        <select name="clase_licencia">
            <option value="">Seleccionar</option>
            <option value="A1B" <?php echo $personal['clase_licencia'] === 'A1B' ? 'selected' : ''; ?>>A1B</option>
            <option value="A3C" <?php echo $personal['clase_licencia'] === 'A3C' ? 'selected' : ''; ?>>A3C</option>
        </select><br>
    </div>

    <label>Dirección:</label>
    <input type="text" name="direccion" value="<?php echo $personal['direccion']; ?>" required><br>
    
    <label>Fecha de Nacimiento:</label>
    <input type="date" name="fecha_nacimiento" value="<?php echo $personal['fecha_nacimiento']; ?>" required><br>
    
    <label>Fecha de Ingreso:</label>
    <input type="date" name="fecha_ingreso" value="<?php echo $personal['fecha_ingreso']; ?>" required><br>
    
    <label>Email:</label>
    <input type="email" name="email" value="<?php echo $personal['email']; ?>" required><br>
    
    <label>Estado:</label>
    <select name="estado" required>
        <option value="Activo" <?php echo $personal['estado'] === 'Activo' ? 'selected' : ''; ?>>Activo</option>
        <option value="Inactivo" <?php echo $personal['estado'] === 'Inactivo' ? 'selected' : ''; ?>>Inactivo</option>
    </select><br>

    <!-- Campo para la imagen -->
    <label>Imagen:</label>
    <input type="file" name="imagen" accept="image/*"><br>
    
    <!-- Mostrar imagen actual -->
    <?php if (!empty($personal['imagen'])): ?>
        <p>Imagen Actual: <img src="images/<?php echo $personal['imagen']; ?>" width="100" height="100"></p>
    <?php endif; ?>

    <input type="submit" value="Actualizar">
</form>

<script>
    function toggleLicenseFields() {
        const tipoSelect = document.getElementById('tipo');
        const licenciaFields = document.getElementById('licencia-fields');
        
        if (tipoSelect.value === 'Conductor') {
            licenciaFields.style.display = 'block'; // Muestra los campos de licencia
        } else {
            licenciaFields.style.display = 'none'; // Oculta los campos de licencia
        }
    }
</script>

</body>
</html>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>
