<?php
$host = "localhost";
$usuario = "root"; // Cambia según tu configuración
$password = "";
$bd = "servicios"; // Tu base de datos

$conn = new mysqli($host, $usuario, $password, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
