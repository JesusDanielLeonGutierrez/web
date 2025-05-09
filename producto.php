<?php
session_start(); // Inicia la sesión para poder acceder al carrito

include 'db.php'; // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = $conn->prepare("SELECT * FROM productos WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $producto = $result->fetch_assoc();

    if (!$producto) {
        echo "Producto no encontrado.";
        exit;
    }
} else {
    echo "ID de producto no especificado.";
    exit;
}
?>
<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($producto['titulo']); ?></title>
    <link rel="stylesheet" href="css/producto1.css">
</head>
<body>
    <div class="producto-container">
        <!-- Contenedor de imagen -->
        <div class="producto-imagen">
            <img src="img/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="Imagen del producto">
        </div>
        <!-- Contenedor de información -->
        <div class="producto-info">
            <h5><?php echo htmlspecialchars($producto['titulo']); ?></h5>
            <p class="precio"><strong>Precio:</strong> $<?php echo number_format($producto['precio'], 2); ?></p>
            <p class="descripcion"><strong>Descripción:</strong> <?php echo nl2br(htmlspecialchars($producto['descripcion'])); ?></p>
            <p><strong>Cantidad disponible:</strong> <?php echo $producto['cantidad']; ?></p>

            <!-- Botón para agregar al carrito -->
            <a href="agregar_carrito.php?id=<?php echo $producto['id']; ?>" class="btn-agregar-carrito">Agregar al carrito</a>

            <!-- Enlace para volver a la tienda -->
            <a href="index.php">Volver a la tienda</a>
        </div>

        <!-- Whatsapp -->
        <div class="btn-whatsapp2">
            <a href="https://wa.me/+5217225723784/?text=Hola, necesito una cotizacion" target="_blank">
                <img src="img/whatsapp.png" width="80" height="80">
            </a>
        </div>
        
    </div>
     <!-- Incluir el footer -->
  <?php include 'footer.php'; ?>
</body>
</html>
