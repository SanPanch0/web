<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Consulta para obtener los datos de la tabla 'cliente'
$sql = "SELECT * FROM cliente";
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
    <title>Gestión de Clientes</title>
    <!-- Enlace a la hoja de estilos CSS -->
    <link rel="stylesheet" href="cliente/cliente.css">
</head>
<body>

<h1>Lista de Clientes</h1>

<button onclick="toggleForm()">Añadir Nuevo Cliente</button>

<div id="add-form" class="form-container" style="display: none;">
    <h2>Añadir Nuevo Cliente</h2>
    <form id="nuevoClienteForm">
        <label>Nombre Completo:</label>
        <input type="text" name="nombre_completo" required><br>
        <label>Número Celular:</label>
        <input type="text" name="numero_celular" required><br>
        <label>Dirección:</label>
        <input type="text" name="direccion" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        
        <label>Tipo:</label>
        <select name="tipo" id="tipo" required onchange="toggleAdditionalFields()">
            <option value="Persona Natural">Persona Natural</option>
            <option value="Persona Jurídica">Persona Jurídica</option>
        </select><br>

        <div id="natural-fields">
            <label>DNI:</label>
            <input type="text" name="dni"><br>
            <label>Fecha de Nacimiento:</label>
            <input type="date" name="fecha_nacimiento"><br>
            <label>Sexo:</label>
            <select name="sexo">
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="Otro">Otro</option>
            </select><br>
        </div>

        <div id="juridica-fields" style="display: none;">
            <label>RUC:</label>
            <input type="text" name="ruc"><br>
            <label>Razón Social:</label>
            <input type="text" name="razon_social"><br>
        </div>

        <label>Estado:</label>
        <select name="estado" required>
            <option value="Activo">Activo</option>
            <option value="Inactivo">Inactivo</option>
        </select><br>
        <label>Referencia de Dirección:</label>
        <input type="text" name="referencia_direccion"><br>
        <label>Fecha de Última Compra:</label>
        <input type="date" name="fecha_ultima_compra"><br>

        <input type="button" onclick="agregarCliente()" value="Añadir">
    </form>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Número Celular</th>
                <th>Dirección</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>DNI</th>
                <th>RUC</th>
                <th>Fecha de Registro</th>
                <th>Estado</th>
                <th>Fecha de Nacimiento</th>
                <th>Razón Social</th>
                <th>Sexo</th>
                <th>Referencia Dirección</th>
                <th>Fecha Última Compra</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tabla-clientes">
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre_completo']; ?></td>
                    <td><?php echo $row['numero_celular']; ?></td>
                    <td><?php echo $row['direccion']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['tipo']; ?></td>
                    <td><?php echo $row['dni']; ?></td>
                    <td><?php echo $row['ruc']; ?></td>
                    <td><?php echo $row['fecha_registro']; ?></td>
                    <td><?php echo $row['estado']; ?></td>
                    <td><?php echo $row['fecha_nacimiento']; ?></td>
                    <td><?php echo $row['razon_social']; ?></td>
                    <td><?php echo $row['sexo']; ?></td>
                    <td><?php echo $row['referencia_direccion']; ?></td>
                    <td><?php echo $row['fecha_ultima_compra']; ?></td>
                    <td>
                        <a href="cliente/editar.php?edit=<?php echo $row['id']; ?>">Editar</a>
                        <a href="cliente/eliminar.php?id=<?php echo $row['id']; ?>" onclick="return confirm('¿Está seguro de eliminar este registro?');">Borrar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    function toggleAdditionalFields() {
        const tipoSelect = document.getElementById('tipo');
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

    function toggleForm() {
        const formContainer = document.getElementById('add-form');
        formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
    }
</script>

<?php $conn->close(); ?>

</body>
</html>
