<?php
session_start();

// Si se presiona el botón "Vaciar carrito"
if (isset($_POST['vaciar'])) {
    unset($_SESSION['carrito']);
    header("Location: carrito.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de compras</title>
    <link rel="stylesheet" href="css/carrito.css">
</head>
<body>

<?php
if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
    $carrito = $_SESSION['carrito'];
    $total = 0;
    echo "<h2>Carrito de compras</h2>";
    echo "<table>";
    echo "<tr><th>Imagen</th><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Total</th></tr>";

    foreach ($carrito as $producto_id => $detalle) {
        $total_producto = $detalle['precio'] * $detalle['cantidad'];
        $total += $total_producto;

        echo "<tr>";
        echo "<td><img src='img/" . htmlspecialchars($detalle['imagen']) . "'></td>";
        echo "<td>" . htmlspecialchars($detalle['titulo']) . "</td>";
        echo "<td>$" . number_format($detalle['precio'], 2) . "</td>";
        echo "<td>" . $detalle['cantidad'] . "</td>";
        echo "<td>$" . number_format($total_producto, 2) . "</td>";
        echo "</tr>";
    }

    echo "<tr><td colspan='4'><strong>Total</strong></td><td><strong>$" . number_format($total, 2) . "</strong></td></tr>";
    echo "</table>";

    // Botones centrados: Pagar y Vaciar
    echo "<div class='boton-container'>";
    echo "<a href='checkout.php' class='boton-link boton-verde'>Proceder al pago</a>";

    echo "<form method='POST' style='display:inline;'>
            <button type='submit' name='vaciar' class='boton-rojo'>Vaciar carrito</button>
          </form>";
    echo "</div>";
} else {
    echo "<p class='carrito-vacio'>El Carrito está vacío.</p>";
}

// Botón siempre visible abajo a la izquierda
echo "<a href='index.php' class='boton-link boton-negro boton-regresar'>Regresar a la tienda</a>";
?>

</body>
</html>
