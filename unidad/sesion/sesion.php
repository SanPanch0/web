
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="sesion.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar sesión</h2>
        <form action="validar_sesion.php" method="POST">
    <label for="email">Correo electrónico</label>
    <input type="email" name="email" id="email" required>

    <label for="contrasena">Contraseña</label>
    <input type="password" name="contrasena" id="contrasena" required>

    <button type="submit">Iniciar sesión</button>
</form>

    </div>
</body>
</html>
