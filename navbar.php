<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // ✅ Solo inicia la sesión si no está activa
}

// Contar la cantidad total de productos en el carrito
$cantidad = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $cantidad += $item['cantidad'];
    }
}
?>

<!-- Agregar FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<!-- Contenedor de búsqueda Fijo -->
<div class="search-container">
    <!-- Logo -->
    <div class="logo-container">
        <link rel="stylesheet" href="css/index.css">
        <a href="index.php">
            <img src="img/th.jpeg" alt="Logo" class="logo">
        </a>
    </div>

    <!-- Buscador -->
    <form action="buscar.php" method="GET" class="search-inner">
        <button type="button" class="categories-btn" onclick="toggleSidebar()">☰ Categorías</button>
        <input type="text" id="search-input" class="search-input" placeholder="Busca por categoría, producto, marca..." name="query" value="">
        <button type="submit" class="search-btn">🔍</button>
    </form>

    <!-- Carrito -->
    <div class="cart-container">
        <a href="carrito.php" class="cart-btn">
            <i class="fas fa-shopping-cart"></i>
            <span id="cart-count" class="cart-count"><?php echo $cantidad; ?></span> <!-- Contador dinámico -->
        </a>
    </div>
</div>

<!-- Menú lateral -->
<div id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <h2>Categorías</h2>
        <button class="close-btn" onclick="toggleSidebar()">✖</button>
    </div>
    <ul>
        <li><a href="Adhesivos.php" onclick="toggleSidebar()">🧴 Adhesivos y lubricantes</a></li>
        <li><a href="Impresoras.php" onclick="toggleSidebar()">🖨️ Refacciones de Impresoras</a></li>
        <li><a href="Herramientas.php" onclick="toggleSidebar()">🧵 Herramientas de Confección</a></li> 
    </ul>
</div>

<!-- Script para abrir/cerrar barra lateral -->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        sidebar.classList.toggle("active");
    }
</script>
