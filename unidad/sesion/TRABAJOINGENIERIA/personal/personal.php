<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Consulta para obtener los datos de la tabla 'personal'
$sql = "SELECT * FROM personal";
$result = $conn->query($sql);

// Verificar si hay errores en la consulta
if ($result === false) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Personal</title>
    <link rel="stylesheet" href="personal/personal.css">
    <link rel="stylesheet" href="personal/personal.css?v=<?php echo time(); ?>">
    <script src="personal/personal.js" defer></script>
</head>
<body>

<h1>Lista de Personal</h1>

<button onclick="toggleForm()">Añadir Nuevo Personal</button>

<div id="add-form" class="form-container" style="display: none;">
    <h2>Añadir Nuevo Personal</h2>
    <form id="nuevoPersonalForm" enctype="multipart/form-data">
        <label>Nombre Completo:</label>
        <input type="text" name="nombre_completo" required><br>
        <label>DNI:</label>
        <input type="text" name="dni" required><br>
        <label>Número Celular:</label>
        <input type="text" name="numero_celular" required><br>
        
        <label>Tipo:</label>
        <select name="tipo" id="tipo" required onchange="toggleLicenseFields()">
            <option value="Conductor">Conductor</option>
            <option value="Estiba">Estiba</option>
            <option value="Embalador">Embalador</option>
        </select><br>

        <div id="licencia-fields" style="display: none;">
            <label>Licencia de Conducir:</label>
            <input type="text" name="licencia_conducir"><br>
            <label>Clase de Licencia:</label>
            <select name="clase_licencia">
                <option value="">Seleccionar</option>
                <option value="A1B">A1B</option>
                <option value="A3C">A3C</option>
            </select><br>
        </div>

        <label>Dirección:</label>
        <input type="text" name="direccion" required><br>
        <label>Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" required><br>
        <label>Fecha de Ingreso:</label>
        <input type="date" name="fecha_ingreso" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Estado:</label>
        <select name="estado" required>
            <option value="Activo">Activo</option>
            <option value="Inactivo">Inactivo</option>
        </select><br>

        <label>Imagen:</label>
        <input type="file" name="imagen" accept="image/*"><br>
        
        <input type="button" onclick="agregarPersonal()" value="Añadir">
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Imagen</th>
            <th>Nombre Completo</th>
            <th>DNI</th>
            <th>Número Celular</th>
            <th>Tipo</th>
            <th>Licencia de Conducir</th>
            <th>Clase de Licencia</th>
            <th>Dirección</th>
            <th>Fecha de Nacimiento</th>
            <th>Fecha de Ingreso</th>
            <th>Email</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="tabla-personal">
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><img src="images/<?php echo $row['imagen']; ?>" alt="Imagen" width="50" height="50"></td>
                <td><?php echo $row['nombre_completo']; ?></td>
                <td><?php echo $row['dni']; ?></td>
                <td><?php echo $row['numero_celular']; ?></td>
                <td><?php echo $row['tipo']; ?></td>
                <td><?php echo $row['licencia_conducir']; ?></td>
                <td><?php echo $row['clase_licencia']; ?></td>
                <td><?php echo $row['direccion']; ?></td>
                <td><?php echo $row['fecha_nacimiento']; ?></td>
                <td><?php echo $row['fecha_ingreso']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['estado']; ?></td>
                <td>
                    <a href="personal/editar.php?edit=<?php echo $row['id']; ?>">Editar</a>
                    <a href="personal/eliminar.php?id=<?php echo $row['id']; ?>" onclick="return confirm('¿Está seguro de eliminar este registro?');">Borrar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

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

    function toggleForm() {
        const formContainer = document.getElementById('add-form');
        formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
    }
</script>

<?php $conn->close(); ?>

</body>
</html>
