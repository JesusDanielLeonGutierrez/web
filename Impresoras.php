<?php
include 'db.php'; // Conexión a la base de datos

// Obtener el nombre del archivo actual sin extensión
$archivo_actual = pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_FILENAME);

// Normalizar el nombre para hacer la búsqueda en la base de datos
$archivo_actual = str_replace("-", " ", $archivo_actual); 

// Buscar la categoría cuyo nombre contiene la palabra clave del archivo actual
$stmt = $conn->prepare("SELECT id, nombre FROM categorias WHERE LOWER(nombre) LIKE CONCAT('%', ?, '%')");
$stmt->bind_param("s", $archivo_actual);
$stmt->execute();
$result = $stmt->get_result();
$categoria = $result->fetch_assoc();

if (!$categoria) {
    die("Categoría no encontrada.");
}

$categoria_id = $categoria['id'];
$categoria_nombre = $categoria['nombre']; // Solo el nombre sin emoji

// Obtener los productos de esta categoría
$stmt = $conn->prepare("SELECT * FROM productos WHERE categoria_id = ?");
$stmt->bind_param("i", $categoria_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/conductores.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($categoria_nombre); ?></title>
</head>
<body>

<h4>Lista de <?php echo htmlspecialchars($categoria_nombre); ?></h4>
<div class="container">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card">
            <a href="producto.php?id=<?php echo $row['id']; ?>">
                <img src="img/<?php echo htmlspecialchars($row['imagen']); ?>" alt="Imagen de <?php echo htmlspecialchars($row['titulo']); ?>">
                <h3><?php echo htmlspecialchars($row['titulo']); ?></h3>
                <p class="price">Precio: $<?php echo number_format($row['precio'], 2); ?></p>
            </a>
        </div>
    <?php endwhile; ?>
</div>

 <!--Whatsapp-->
 <div class="btn-whatsapp">
        <a href="https://wa.me/+5217225723784/?text=Hola, necesito una cotizacion" target="_blank">
            <img src="img/whatsapp.png" width="80" height="80">
        </a>
    </div>


     <!-- Incluir el footer -->
  <?php include 'footer.php'; ?>
</body>
</html>
