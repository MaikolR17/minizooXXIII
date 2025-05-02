<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Zoológico - Natural Life</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>

  <!-- ENCABEZADO -->
  <header class="encabezado">
    <div class="logo">
      <strong>Zoo</strong><span>Natural Life</span>
    </div>

    <!-- Ícono hamburguesa (solo visible en móviles) -->
    <div class="menu-toggle" id="menu-toggle">
      <i class="fas fa-bars"></i>
    </div>

    <!-- Menú de navegación -->
    <nav class="nav-links" id="nav-links">
      <a href="#contacto">Contacto</a>
      <a href="#ubicacion">Ubicación</a>
      <a href="#redes">Redes</a>
      <a href="#acerca-de-nosotros">Acerca de nosotros</a>
    </nav>

    <!-- Barra de búsqueda -->
    <div class="busqueda">
      <i class="fas fa-search"></i>
      <input type="text" placeholder="Busca una especie, sección o evento" />
    </div>

    <!-- Acciones (idioma, login, boletos) -->
    <div class="acciones">
      <i class="fas fa-globe"></i>
      <a href="#">Iniciar sesión</a>
      <a href="#" class="btn-primario">¡Compra boletos!</a>
    </div>
  </header>

  <!-- SECCIÓN PRINCIPAL -->
  <header>
    <h1>Acerca de Zoo Natural Life</h1>
  </header>
  <section class="contenido">
    <article class="seccion">
      <h2>Nuestra Historia</h2>
      <p>
        Zoo Natural Life fue fundado en 2005 con el objetivo de crear un espacio donde la naturaleza y el ser humano pudieran encontrarse en armonía.
        Desde entonces, hemos crecido hasta albergar más de 150 especies de animales, todas ellas cuidadas con los más altos estándares de bienestar animal.
        Nuestro compromiso con la conservación y la educación ambiental ha sido reconocido a nivel nacional.
      </p>
    </article>

    <article class="seccion">
      <h2>Nuestra Misión</h2>
      <p>
        Nuestra misión es proteger y conservar la biodiversidad mediante el cuidado responsable de animales, la educación de nuestros visitantes y el apoyo a programas de investigación y rescate de especies en peligro.
        Creemos que a través del conocimiento y la conexión emocional con los animales, podemos inspirar a las personas a cuidar nuestro planeta.
      </p>
    </article>
  </section>

  <!-- PIE DE PÁGINA -->
  <footer>
    <p>&copy; 2025 Zoo Natural Life. Todos los derechos reservados.</p>
  </footer>

  <!-- JavaScript -->
  <script src="script.js"></script>
</body>
</html>
