<?php
session_start(); // Inicia la sesión

include 'db.php'; // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = $conn->prepare("SELECT * FROM productos WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $producto = $result->fetch_assoc();

    if ($producto) {
        // Si el producto existe, lo agregamos al carrito
        $producto_id = $producto['id'];
        $titulo = $producto['titulo'];
        $precio = $producto['precio'];
        $imagen = $producto['imagen']; // Asegúrate de que esta columna exista en la base de datos
        $cantidad = 1; // Por defecto, agregar 1 unidad del producto

        // Verificamos si el producto ya está en el carrito
        if (isset($_SESSION['carrito'][$producto_id])) {
            // Si ya está, aumentamos la cantidad
            $_SESSION['carrito'][$producto_id]['cantidad']++;
        } else {
            // Si no está, lo agregamos al carrito con todos sus detalles
            $_SESSION['carrito'][$producto_id] = [
                'titulo' => $titulo,
                'precio' => $precio,
                'imagen' => $imagen, // Guardamos la imagen
                'cantidad' => $cantidad
            ];
        }
    }
}

// Redirigimos al carrito después de agregar el producto
header('Location: carrito.php');
exit;
?>
