<?php include 'navbar.php'; ?>


<!DOCTYPE html>
<html lang="es">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barra de Búsqueda</title>
    <link rel="stylesheet" href="css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>

<!-- Botón hamburguesa para móviles -->
<button class="menu-toggle" onclick="toggleSidebar()">☰</button>


    <!-- Carrousel -->
    <link href="css/styles.css" rel="stylesheet">

    <div class="container">
    <div id="carousel1" class="carousel slide" data-bs-ride="carousel">
        <!-- Diapositivas -->
        <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="img/imagen.jpg" alt="">
            <div class="carousel-caption">
            <h3>título 1</h3>
            <p>Descripción de la imagen.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="img/descarga1.jpeg" alt="">
            <div class="carousel-caption">
            <h3>título 2</h3>
            <p>Descripción de la imagen.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="img/descarga2.jpeg" alt="">
            <div class="carousel-caption">
            <h3>título 3</h3>
            <p>Descripción de la imagen.</p>
            </div>
        </div>
        </div>
        <!-- Botones de desplazamiento a izquierda y derecha -->      
        <a class="carousel-control-prev" href="#carousel1" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel1" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
        </a>
    </div>
    </div>

     <!--Whatsapp-->
     <div class="btn-whatsapp">
        <a href="https://wa.me/+5217225723784/?text=Hola, necesito una cotizacion" target="_blank">
            <img src="img/whatsapp.png" width="80" height="80">
        </a>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<form action="cotizaciones.php" method="post">
  <label for="nombre">Nombre:</label><br>
  <input type="text" id="nombre" name="nombre" required><br><br>

  <label for="correo">Correo Electrónico:</label><br>
  <input type="email" id="correo" name="correo" required><br><br>

  <label for="asunto">Asunto:</label><br>
  <input type="text" id="asunto" name="asunto" required><br><br>

  <label for="mensaje">Mensaje:</label><br>
  <textarea id="mensaje" name="mensaje" rows="5" required></textarea><br><br>

  <button type="submit">Enviar</button>
</form>

<?php if (isset($_GET['enviado'])): ?>
  <p style="color: green;">Tu mensaje ha sido enviado correctamente.</p>
<?php endif; ?>




  <!-- Incluir el footer -->
  <?php include 'footer.php'; ?>

  <script>
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('active');
}
</script>



</body>
</html>
