<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si se ha pasado un ID para editar
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    // Consulta para obtener los datos del cliente
    $sql = "SELECT * FROM cliente WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Cliente no encontrado.");
    }

    $cliente = $result->fetch_assoc();
} else {
    die("ID de cliente no especificado.");
}

// Procesar la actualización del cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_completo = $_POST['nombre_completo'];
    $numero_celular = $_POST['numero_celular'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $tipo = $_POST['tipo'];
    $dni = $_POST['dni'];
    $ruc = $_POST['ruc'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $estado = $_POST['estado'];
    $referencia_direccion = $_POST['referencia_direccion'];
    $fecha_ultima_compra = $_POST['fecha_ultima_compra'];

    // Consulta para actualizar los datos del cliente
    $sql_update = "UPDATE cliente SET nombre_completo=?, numero_celular=?, direccion=?, email=?, tipo=?, dni=?, ruc=?, fecha_nacimiento=?, estado=?, referencia_direccion=?, fecha_ultima_compra=? WHERE id=?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssssssssssi", $nombre_completo, $numero_celular, $direccion, $email, $tipo, $dni, $ruc, $fecha_nacimiento, $estado, $referencia_direccion, $fecha_ultima_compra, $id);
    
    if ($stmt_update->execute()) {
        echo "Cliente actualizado con éxito.";
        header("Location: ../index.php"); // Redirigir a la lista de clientes después de la actualización
        exit();
    } else {
        echo "Error al actualizar cliente: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="../cliente/cliente.css">
</head>
<body>

<h1>Editar Cliente</h1>

<form method="POST" id="editarClienteForm">
    <label>Nombre Completo:</label>
    <input type="text" name="nombre_completo" value="<?php echo $cliente['nombre_completo']; ?>" required><br>

    <label>Número Celular:</label>
    <input type="text" name="numero_celular" value="<?php echo $cliente['numero_celular']; ?>" required><br>

    <label>Dirección:</label>
    <input type="text" name="direccion" value="<?php echo $cliente['direccion']; ?>" required><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo $cliente['email']; ?>" required><br>

    <label>Tipo:</label>
    <select name="tipo" required onchange="toggleAdditionalFields()">
        <option value="Persona Natural" <?php echo $cliente['tipo'] == 'Persona Natural' ? 'selected' : ''; ?>>Persona Natural</option>
        <option value="Persona Jurídica" <?php echo $cliente['tipo'] == 'Persona Jurídica' ? 'selected' : ''; ?>>Persona Jurídica</option>
    </select><br>

    <div id="natural-fields" style="<?php echo $cliente['tipo'] == 'Persona Natural' ? '' : 'display: none;'; ?>">
        <label>DNI:</label>
        <input type="text" name="dni" value="<?php echo $cliente['dni']; ?>"><br>
        <label>Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" value="<?php echo $cliente['fecha_nacimiento']; ?>"><br>
        <label>Sexo:</label>
        <select name="sexo">
            <option value="Masculino" <?php echo $cliente['sexo'] == 'Masculino' ? 'selected' : ''; ?>>Masculino</option>
            <option value="Femenino" <?php echo $cliente['sexo'] == 'Femenino' ? 'selected' : ''; ?>>Femenino</option>
            <option value="Otro" <?php echo $cliente['sexo'] == 'Otro' ? 'selected' : ''; ?>>Otro</option>
        </select><br>
    </div>

    <div id="juridica-fields" style="<?php echo $cliente['tipo'] == 'Persona Jurídica' ? '' : 'display: none;'; ?>">
        <label>RUC:</label>
        <input type="text" name="ruc" value="<?php echo $cliente['ruc']; ?>"><br>
        <label>Razón Social:</label>
        <input type="text" name="razon_social" value="<?php echo $cliente['razon_social']; ?>"><br>
    </div>

    <label>Estado:</label>
    <select name="estado" required>
        <option value="Activo" <?php echo $cliente['estado'] == 'Activo' ? 'selected' : ''; ?>>Activo</option>
        <option value="Inactivo" <?php echo $cliente['estado'] == 'Inactivo' ? 'selected' : ''; ?>>Inactivo</option>
    </select><br>

    <label>Referencia de Dirección:</label>
    <input type="text" name="referencia_direccion" value="<?php echo $cliente['referencia_direccion']; ?>"><br>

    <label>Fecha de Última Compra:</label>
    <input type="date" name="fecha_ultima_compra" value="<?php echo $cliente['fecha_ultima_compra']; ?>"><br>

    <input type="submit" value="Actualizar Cliente">
</form>

<script>
    function toggleAdditionalFields() {
        const tipoSelect = document.querySelector('select[name="tipo"]');
        const naturalFields = document.getElementById('natural-fields');
        const juridicaFields = document.getElementById('juridica-fields');
        
        if (tipoSelect.value === 'Persona Natural') {
            naturalFields.style.display = 'block';
            juridicaFields.style.display = 'none';
        } else {
            naturalFields.style.display = 'none';
            juridicaFields.style.display = 'block';
        }
    }
</script>

</body>
</html>

<?php $conn->close(); ?>
