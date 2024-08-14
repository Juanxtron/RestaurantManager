<?php
$servername = "localhost";
$username = "root"; // Tu nombre de usuario de MySQL
$password = "Jpcc380606*."; // Tu contraseña de MySQL
$dbname = "mydb"; // Asegúrate de que esta sea la base de datos que estás utilizando

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
