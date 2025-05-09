<?php
session_start();
require_once 'db.php'; // Asegúrate de que este archivo conecta correctamente a la base de datos

// Si llegan datos desde index.php, los guarda
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = htmlspecialchars(trim($_POST["nombre"] ?? ''));
    $correo = filter_var(trim($_POST["correo"] ?? ''), FILTER_SANITIZE_EMAIL);
    $asunto = htmlspecialchars(trim($_POST["asunto"] ?? ''));
    $mensaje = htmlspecialchars(trim($_POST["mensaje"] ?? ''));

    if (!empty($nombre) && filter_var($correo, FILTER_VALIDATE_EMAIL) && !empty($asunto) && !empty($mensaje)) {
        $stmt = $conn->prepare("INSERT INTO cotizaciones (nombre, correo, asunto, mensaje) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $correo, $asunto, $mensaje);
        $stmt->execute();
        $stmt->close();

     
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizaciones</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/cotizaciones.css">
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
            <h3 style="text-align: center;">Listado de Cotizaciones</h3>
            <table border="1" cellpadding="8">
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Asunto</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                </tr>
                <?php
                $result = $conn->query("SELECT * FROM cotizaciones ORDER BY fecha DESC");

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['nombre']}</td>
                                <td>{$row['correo']}</td>
                                <td>{$row['asunto']}</td>
                                <td>{$row['mensaje']}</td>
                                <td>{$row['fecha']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay cotizaciones registradas.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
