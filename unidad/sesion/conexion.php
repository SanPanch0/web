<?php
$host = "localhost"; // o el host de tu servidor
$usuario = "root";   // tu usuario de la base de datos
$contrasena = "";    // tu contraseña de la base de datos
$dbname = "trabajoing"; // el nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($host, $usuario, $contrasena, $dbname);

// Verificar si hay errores de conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
