<?php
session_start();
include('db.php');

// Asegurarse de que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Obtener las categorías de la base de datos
$query_cat = "SELECT * FROM categorias";
$result_cat = mysqli_query($conn, $query_cat);

// Obtener la categoría seleccionada desde la URL
$categoria_filtro = isset($_GET['categoria']) ? $_GET['categoria'] : '';

// Obtener los productos con o sin filtro
$query_productos = "SELECT p.id, p.titulo, p.precio, p.descripcion, p.cantidad, c.nombre AS categoria, p.imagen 
                    FROM productos p 
                    INNER JOIN categorias c ON p.categoria_id = c.id";
if ($categoria_filtro) {
    $query_productos .= " WHERE p.categoria_id = '$categoria_filtro'";
}
$result_productos = mysqli_query($conn, $query_productos);

// Manejar la adición de un nuevo producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar'])) {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $precio = mysqli_real_escape_string($conn, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $cantidad = mysqli_real_escape_string($conn, $_POST['cantidad']);
    $categoria_id = mysqli_real_escape_string($conn, $_POST['categoria']);

    $imagen = $_FILES['imagen']['name'];
    $ruta_imagen = "img/" . basename($imagen);
    
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen)) {
        $query_insert = "INSERT INTO productos (titulo, precio, descripcion, cantidad, categoria_id, imagen) 
                         VALUES ('$titulo', '$precio', '$descripcion', '$cantidad', '$categoria_id', '$imagen')";
        if (mysqli_query($conn, $query_insert)) {
            echo "<script>alert('Producto agregado con éxito.'); window.location='productos.php';</script>";
        } else {
            echo "<script>alert('Error al agregar el producto: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Error al subir la imagen.');</script>";
    }
}

// Manejar la edición de un producto (permitir cambiar imagen, no categoría)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar'])) {
    $id_producto = $_POST['id_producto'];
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $precio = mysqli_real_escape_string($conn, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $cantidad = mysqli_real_escape_string($conn, $_POST['cantidad']);

    if (!empty($_FILES['imagen']['name'])) {
        $nueva_imagen = $_FILES['imagen']['name'];
        $ruta_nueva_imagen = "img/" . basename($nueva_imagen);

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_nueva_imagen)) {
            $query_update = "UPDATE productos SET 
                             titulo = '$titulo', 
                             precio = '$precio', 
                             descripcion = '$descripcion', 
                             cantidad = '$cantidad',
                             imagen = '$nueva_imagen'
                             WHERE id = '$id_producto'";
        } else {
            echo "<script>alert('Error al subir la nueva imagen.');</script>";
            exit;
        }
    } else {
        $query_update = "UPDATE productos SET 
                         titulo = '$titulo', 
                         precio = '$precio', 
                         descripcion = '$descripcion', 
                         cantidad = '$cantidad' 
                         WHERE id = '$id_producto'";
    }

    if (mysqli_query($conn, $query_update)) {
        echo "<script>alert('Producto actualizado con éxito.'); window.location='productos.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el producto: " . mysqli_error($conn) . "');</script>";
    }
}

// Manejar la eliminación de un producto
if (isset($_GET['eliminar_id'])) {
    $id_producto = $_GET['eliminar_id'];
    $query_delete = "DELETE FROM productos WHERE id = '$id_producto'";

    if (mysqli_query($conn, $query_delete)) {
        echo "<script>alert('Producto eliminado con éxito.'); window.location='productos.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el producto: " . mysqli_error($conn) . "');</script>";
    }
}

// Verificar si se pasa el ID del producto para editar
if (isset($_GET['editar_id'])) {
    $id_producto = $_GET['editar_id'];
    $query_producto = "SELECT * FROM productos WHERE id = '$id_producto'";
    $result_producto = mysqli_query($conn, $query_producto);
    $producto = mysqli_fetch_assoc($result_producto);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/producto.css">
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
                <h2 style="text-align: center;">Productos</h2>
                <button class="btn-flotante" onclick="abrirModal()">+ Agregar Producto</button>
            </header>

            <table>
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Título</th>
                        <th>Precio</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Categoría</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_productos)) { ?>
                        <tr>
                            <td><img src="img/<?php echo $row['imagen']; ?>" class="img-producto"></td>
                            <td><?php echo $row['titulo']; ?></td>
                            <td>$<?php echo number_format($row['precio'], 2); ?></td>
                            <td><?php echo $row['descripcion']; ?></td>
                            <td><?php echo $row['cantidad']; ?></td>
                            <td><?php echo $row['categoria']; ?></td>
                            <td>
                                <a href="productos.php?editar_id=<?php echo $row['id']; ?>">
                                    <button class="btn-modificar">Modificar</button>
                                </a>
                                <a href="productos.php?eliminar_id=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">
                                    <button class="btn-eliminar">Eliminar</button>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Modal Agregar -->
            <div id="modal" class="modal" style="display: none;">
                <div class="modal-contenido">
                    <span class="cerrar" onclick="cerrarModal()">&times;</span>
                    <h2>Agregar Producto</h2>
                    <form action="productos.php" method="POST" enctype="multipart/form-data">
                        <label for="titulo">Título:</label>
                        <input type="text" name="titulo" required>

                        <label for="precio">Precio:</label>
                        <input type="text" name="precio" required>

                        <label for="descripcion">Descripción:</label>
                        <textarea name="descripcion" required></textarea>

                        <label for="cantidad">Cantidad:</label>
                        <input type="number" name="cantidad" required>

                        <label for="categoria">Categoría:</label>
                        <select name="categoria" required>
                            <option value="">Selecciona una categoría</option>
                            <?php while ($row_cat = mysqli_fetch_assoc($result_cat)) { ?>
                                <option value="<?php echo $row_cat['id']; ?>"><?php echo $row_cat['nombre']; ?></option>
                            <?php } ?>
                        </select>

                        <label for="imagen">Imagen:</label>
                        <input type="file" name="imagen" accept="image/*" required>

                        <input type="submit" name="agregar" value="Agregar Producto">
                    </form>
                </div>
            </div>

            <!-- Modal Editar -->
            <div id="modalEditar" class="modal" style="<?php echo isset($producto) ? 'display: flex;' : 'display: none;'; ?>">
                <div class="modal-contenido">
                    <span class="cerrar" onclick="cerrarModalEditar()">&times;</span>
                    <h2>Modificar Producto</h2>
                    <form action="productos.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_producto" value="<?php echo $producto['id']; ?>">

                        <label for="titulo">Título:</label>
                        <input type="text" name="titulo" value="<?php echo $producto['titulo']; ?>" required>

                        <label for="precio">Precio:</label>
                        <input type="text" name="precio" value="<?php echo $producto['precio']; ?>" required>

                        <label for="descripcion">Descripción:</label>
                        <textarea name="descripcion" required><?php echo $producto['descripcion']; ?></textarea>

                        <label for="cantidad">Cantidad:</label>
                        <input type="number" name="cantidad" value="<?php echo $producto['cantidad']; ?>" required>

                        <input type="hidden" name="categoria" value="<?php echo $producto['categoria_id']; ?>">

                        <label>Imagen actual:</label><br>
                        <img src="img/<?php echo $producto['imagen']; ?>" class="img-producto"><br>

                        <label for="imagen">Cambiar imagen (opcional):</label>
                        <input type="file" name="imagen" accept="image/*">

                        <input type="submit" name="editar" value="Modificar Producto">
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        function abrirModal() {
            document.getElementById('modal').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modal').style.display = 'none';
        }

        function cerrarModalEditar() {
            document.getElementById('modalEditar').style.display = 'none';
        }
    </script>
</body>
</html>
