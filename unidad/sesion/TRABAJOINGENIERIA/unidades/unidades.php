<?php
$host = 'localhost'; 
$user = 'root'; 
$password = ''; 
$dbname = 'trabajoing'; 

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para seleccionar datos de la tabla unidad
$consulta = "SELECT * FROM unidad";
$resultado = $conn->query($consulta);

// Verificar si hubo un error en la consulta
if ($resultado === false) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Unidades</title>
    <link rel="stylesheet" href="unidades/unidades.css">
    <link rel="stylesheet" href="unidades/unidades.css?v=<?php echo time(); ?>">
</head>
<body>

<h1>Lista de Unidades</h1>

<button onclick="toggleForm()">Añadir Nueva Unidad</button>

<div id="add-form" class="form-container" style="display: none;">
    <h2 id="form-title">Añadir Nueva Unidad</h2>
    <form id="nuevaUnidadForm" onsubmit="return false;">
        <input type="hidden" name="id" id="unidad-id">
        <label>Nombre de Unidad:</label>
        <input type="text" name="nombre" required><br>
        <label>Marca:</label>
        <input type="text" name="marca" required><br>
        <label>Modelo:</label>
        <input type="text" name="modelo" required><br>
        <label>Año:</label>
        <input type="number" name="anio" required><br>
        <label>Color:</label>
        <input type="text" name="color" required><br>
        <label>Número de Placa:</label>
        <input type="text" name="numero_placa" required><br>
        <label>Estado:</label>
        <select name="estado" required>
            <option value="Disponible">Disponible</option>
            <option value="En Uso">En Uso</option>
            <option value="Mantenimiento">Mantenimiento</option>
        </select><br>
        <input type="button" id="submit-btn" onclick="agregarUnidad()" value="Añadir">
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre de Unidad</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Año</th>
            <th>Color</th>
            <th>Número de Placa</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="tabla-unidades">
        <?php while ($row = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['marca']; ?></td>
                <td><?php echo $row['modelo']; ?></td>
                <td><?php echo $row['anio']; ?></td>
                <td><?php echo $row['color']; ?></td>
                <td><?php echo $row['numero_placa']; ?></td>
                <td><?php echo $row['estado']; ?></td>
                <td>
                    <button onclick="editarUnidad(<?php echo $row['id']; ?>)">Editar</button>
                    <button onclick="borrarUnidad(<?php echo $row['id']; ?>)">Borrar</button>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<script>
    function toggleForm() {
        const form = document.getElementById("add-form");
        form.style.display = form.style.display === "none" ? "block" : "none";
        document.getElementById("form-title").innerText = "Añadir Nueva Unidad"; // Reset form title
        document.getElementById("unidad-id").value = ''; // Reset ID
        document.getElementById("submit-btn").value = "Añadir"; // Reset button text
    }

    function agregarUnidad() {
        const form = document.getElementById('nuevaUnidadForm');
        const formData = new FormData(form);

        fetch('unidades/nuevoc.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Mostrar mensaje de éxito o error
            if (data.includes("añadida exitosamente") || data.includes("actualizada exitosamente")) {
                form.reset(); // Limpiar el formulario solo si se añade o actualiza correctamente
                cargarUnidades(); // Recargar la tabla de unidades
                toggleForm(); // Cerrar el formulario
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function editarUnidad(id) {
        fetch(`unidades/editar.php?id=${id}`) // Cambiado 'obtener.php' a 'editar.php'
            .then(response => response.json())
            .then(data => {
                document.getElementById('unidad-id').value = data.id;
                document.querySelector('input[name="nombre"]').value = data.nombre;
                document.querySelector('input[name="marca"]').value = data.marca;
                document.querySelector('input[name="modelo"]').value = data.modelo;
                document.querySelector('input[name="anio"]').value = data.anio;
                document.querySelector('input[name="color"]').value = data.color;
                document.querySelector('input[name="numero_placa"]').value = data.numero_placa;
                document.querySelector('select[name="estado"]').value = data.estado;

                document.getElementById("form-title").innerText = "Editar Unidad";
                document.getElementById("submit-btn").value = "Actualizar"; // Change button text to update
                toggleForm(); // Show the form
            })
            .catch(error => console.error('Error:', error));
    }

    function borrarUnidad(id) {
        if (confirm("¿Estás seguro de que quieres borrar esta unidad?")) {
            fetch('unidades/borrar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // Mostrar mensaje de éxito o error
                cargarUnidades(); // Recargar la tabla de unidades
            })
            .catch(error => console.error('Error:', error));
        }
    }

    function cargarUnidades() {
        fetch('unidades/unidades.php') // Asegúrate de que este archivo devuelve el HTML de la tabla
            .then(response => response.text())
            .then(data => {
                document.getElementById('tabla-unidades').innerHTML = data;
            });
    }
</script>

</body>
</html>
