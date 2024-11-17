<?php
// Datos de conexión
$servername = "localhost"; // Cambia si es necesario
$username = "root"; // Cambia por tu usuario de la base de datos
$password = ""; // Sin contraseña (vacío)
$dbname = "trabajoing"; // Cambia por el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
