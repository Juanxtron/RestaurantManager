<?php
$servername = "localhost";
$username = "root"; // Cambia esto por tu nombre de usuario de MySQL
$password = "Jpcc380606*."; // Cambia esto por tu contraseña de MySQL
$dbname = "mydb";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully to the database";
}
?>
