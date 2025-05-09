<?php
include('db.php');  // Incluye el archivo de conexión

// Obtener el término de búsqueda desde la URL
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Si hay un término de búsqueda
if ($query) {
    // Prepara la consulta para buscar productos que coincidan con el término ingresado
    $query = "%$query%";  // Prepara el término de búsqueda para usarlo con LIKE
    $sql = "SELECT * FROM productos WHERE titulo LIKE ? OR descripcion LIKE ?";
    
    // Preparar la consulta y vincular los parámetros
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $query, $query);  // Vincula los parámetros (tipo string)
    
    // Ejecutar la consulta
    $stmt->execute();
    $result = $stmt->get_result();  // Obtener los resultados

    // Guardar los productos en un array
    $productos = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $productos = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <!-- Importar los estilos -->
    <link rel="stylesheet" href="css/buscar.css">  <!-- Asegúrate de que la ruta sea correcta -->
</head>
<body>

<?php include 'navbar.php'; ?>


<!-- Mostrar los resultados de la búsqueda -->
<div class="search-results">
    <?php if (count($productos) > 0): ?>
        <?php foreach ($productos as $producto): ?>
            <div class="producto-card">
                <img src="img/<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['titulo']; ?>">
                <h3><?php echo $producto['titulo']; ?></h3>
                <p>Precio: $<?php echo $producto['precio']; ?></p>
                <a href="producto.php?id=<?php echo $producto['id']; ?>">Ver más</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No se encontraron resultados para "<?php echo htmlspecialchars($query); ?>"</p>
    <?php endif; ?>
</div>

</body>
</html>
