<?php
include 'conexion.php';

// Consultar la lista de clientes
$sql = "SELECT * FROM cliente";
$result = $conn->query($sql);

// Manejar el envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_completo = $_POST['nombre_completo'];
    $numero_celular = $_POST['numero_celular'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $tipo = $_POST['tipo'];
    $dni = $_POST['dni'] ?? null;
    $ruc = $_POST['ruc'] ?? null;
    $fecha_registro = $_POST['fecha_registro'];
    $estado = $_POST['estado'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? null;
    $razon_social = $_POST['razon_social'] ?? null;
    $sexo = $_POST['sexo'] ?? null;
    $referencia_direccion = $_POST['referencia_direccion'];
    $fecha_ultima_compra = $_POST['fecha_ultima_compra'];

    // Preparar la consulta
    $stmt = $conn->prepare("INSERT INTO cliente (nombre_completo, numero_celular, direccion, email, tipo, dni, ruc, fecha_registro, estado, fecha_nacimiento, razon_social, sexo, referencia_direccion, fecha_ultima_compra) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssss", $nombre_completo, $numero_celular, $direccion, $email, $tipo, $dni, $ruc, $fecha_registro, $estado, $fecha_nacimiento, $razon_social, $sexo, $referencia_direccion, $fecha_ultima_compra);

    if ($stmt->execute()) {
        echo "<script>alert('Nuevo cliente añadido exitosamente');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    
    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nuevo Cliente</title>
    <script src="cliente/cliente.js"></script>
    <script>
        function toggleForm() {
            const form = document.getElementById("nuevoClienteForm");
            form.style.display = form.style.display === "none" ? "block" : "none";
        }
    </script>
    <style>
        #nuevoClienteForm {
            display: none; /* Ocultar el formulario por defecto */
        }
    </style>
</head>
<body>

<h2>Clientes</h2>
<button onclick="toggleForm()">Añadir Cliente</button>

<div id="nuevoClienteForm">
    <h3>Añadir Nuevo Cliente</h3>
    <form method="POST">
        <label>Nombre Completo:</label>
        <input type="text" name="nombre_completo" required><br>

        <label>Número Celular:</label>
        <input type="text" name="numero_celular" required><br>

        <label>Dirección:</label>
        <input type="text" name="direccion" required><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Tipo:</label>
        <select name="tipo" required>
            <option value="Persona Natural">Persona Natural</option>
            <option value="Persona Jurídica">Persona Jurídica</option>
        </select><br>

        <label>DNI:</label>
        <input type="text" name="dni"><br>

        <label>RUC:</label>
        <input type="text" name="ruc"><br>

        <label>Fecha de Registro:</label>
        <input type="date" name="fecha_registro" value="<?php echo date('Y-m-d'); ?>" required><br>

        <label>Estado:</label>
        <select name="estado" required>
            <option value="Activo">Activo</option>
            <option value="Inactivo">Inactivo</option>
        </select><br>

        <label>Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento"><br>

        <label>Razón Social:</label>
        <input type="text" name="razon_social"><br>

        <label>Sexo:</label>
        <select name="sexo">
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            <option value="Otro">Otro</option>
        </select><br>

        <label>Referencia Dirección:</label>
        <input type="text" name="referencia_direccion"><br>

        <label>Fecha Última Compra:</label>
        <input type="date" name="fecha_ultima_compra"><br>

        <button type="submit">Añadir Cliente</button>
    </form>
</div>

<h3>Lista de Clientes</h3>
<table border="1">
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
    </tr>
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
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
