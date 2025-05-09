<?php
session_start();

// Asegurarse de que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Menú</h2>
            <ul>
                <li><a href="admin.php">Ventas</a></li>
                <li><a href="categorias.php">Categorías</a></li>
                <li><a href="productos.php">Inventario</a></li>
                <li><a href="cotizaciones.php">Cotizaciones</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
                
            </ul>
        </div>

        <div class="content">
            <header>
                <h1>Bienvenido al Dashboard - Administrador</h1>
            </header>

           
</body>
</html>
