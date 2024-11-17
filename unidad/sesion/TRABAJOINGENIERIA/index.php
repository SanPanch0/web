<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Servicios - Mudanzas y Transportes Ayala</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <!-- Contenedor de imagen y título -->
        <div class="profile-img">
            <img src="persona1.jpg" alt="Imagen de perfil">
        </div>
        <h2>Menú</h2>
        <ul>
            <li onclick="loadContent('cronograma/cronograma.html', 'cronograma/cronograma.css', 'cronograma/cronograma.js')">
                <i class="fas fa-calendar-alt"></i> Cronograma
            </li>
            <li onclick="loadContent('cliente/cliente.php', 'cliente/cliente.css', 'cliente/cliente.js')">
                <i class="fas fa-user-plus"></i> Nuevo Cliente
            </li>
            <li onclick="loadContent('unidades/unidades.php', 'unidades/unidades.css', 'unidades/unidades.js')">
                <i class="fas fa-boxes"></i> Unidades
            </li>
            <li onclick="loadContent('personal/personal.php', 'personal/personal.css', 'personal/personal.js')">
                <i class="fas fa-user-tie"></i> Personal
            </li>
            <li onclick="confirmLogout()">
                <i class="fas fa-shield-alt"></i> Cerrar sesión
            </li>
        </ul>
    </div>

    <div id="content-area" class="content">
        <!-- Aquí se carga el contenido dinámico -->
    </div>

    <script src="script.js"></script>

    <script>
        // Función para mostrar el mensaje de confirmación de cierre de sesión
        function confirmLogout() {
            // Mostrar un cuadro de confirmación
            const confirmation = confirm("¿Estás seguro de que deseas cerrar sesión?");
            if (confirmation) {
                // Si el usuario confirma, redirigir a la URL especificada
                window.location.href = "http://127.0.0.1/unidad/";
            }
        }

        // Función para cargar contenido dinámicamente (manteniendo el comportamiento actual)
        function loadContent(html, css, js) {
            // Aquí iría tu lógica para cargar el contenido en la página
            const contentArea = document.getElementById("content-area");
            contentArea.innerHTML = "Cargando contenido...";

            // Suponiendo que el contenido será cargado por AJAX o algún otro método.
        }
    </script>
</body>
</html>
