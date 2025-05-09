<?php
session_start();

// Asegurarse de que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Incluir conexión a la base de datos
include('db.php');

// Verificar si se ha enviado el formulario para crear la categoría
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Si se está creando una nueva categoría
    if (isset($_POST['nombre_categoria']) && !empty($_POST['nombre_categoria'])) {
        // Recibir y limpiar el nombre de la categoría
        $nombre_categoria = mysqli_real_escape_string($conn, $_POST['nombre_categoria']);

        // Insertar la nueva categoría en la base de datos
        $query = "INSERT INTO categorias (nombre) VALUES ('$nombre_categoria')";
        if (mysqli_query($conn, $query)) {
            echo "Categoría creada exitosamente.";
        } else {
            echo "Error al crear la categoría: " . mysqli_error($conn);
        }
    }
    // Si se está eliminando una categoría
    elseif (isset($_POST['eliminar_categoria']) && !empty($_POST['eliminar_categoria'])) {
        $id_categoria = $_POST['eliminar_categoria'];

        // Eliminar la categoría de la base de datos
        $query = "DELETE FROM categorias WHERE id = '$id_categoria'";
        if (mysqli_query($conn, $query)) {
            echo "Categoría eliminada con éxito.";
        } else {
            echo "Error al eliminar la categoría: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías</title>
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

        <div class="main-content">
            <h2>Categorías</h2>

            <!-- Formulario para crear una nueva categoría -->
            <form method="POST" action="categorias.php">
                <label for="nombre_categoria">Nombre de la categoría:</label>
                <input type="text" id="nombre_categoria" name="nombre_categoria" required>
                <button type="submit">Crear categoría</button>
            </form>

            <div class="categorias">
                <?php
                // Mostrar las categorías existentes
                $query = "SELECT * FROM categorias";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="card">';
                        echo '<h3>' . $row['nombre'] . '</h3>';
                        // Formulario para eliminar una categoría
                        echo '<form method="POST" action="categorias.php">';
                        echo '<input type="hidden" name="eliminar_categoria" value="' . $row['id'] . '">';
                        echo '<button type="submit">Eliminar</button>';
                        echo '</form>';
                        echo '</div>';
                    }
                } else {
                    echo 'No hay categorías disponibles.';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
