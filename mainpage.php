<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Zoológico - Natural Life</title>
  <link rel="stylesheet" href="mainpagecss.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>

  <!-- ENCABEZADO -->
  <header class="encabezado" role="banner">
    <div class="logo">
      <strong>Zoo</strong><span>Natural Life</span>
    </div>

    <!-- Botón menú hamburguesa para móviles -->
    <button class="menu-toggle" id="menu-toggle" aria-label="Abrir menú de navegación" aria-expanded="false" aria-controls="nav-links">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navegación principal -->
    <nav class="nav-links" id="nav-links" role="navigation" aria-label="Menú principal">
      <a href="#contacto">Contacto</a>
      <a href="#ubicacion">Ubicación</a>
      <a href="#redes">Redes</a>
      <a href="#acerca-de-nosotros">Acerca de nosotros</a>
    </nav>

    <!-- Barra de búsqueda -->
    <form class="busqueda" role="search" aria-label="Buscar en el sitio">
      <label for="buscar" class="sr-only">Buscar</label>
      <i class="fas fa-search" aria-hidden="true"></i>
      <input id="buscar" type="text" placeholder="Busca una especie, sección o evento" />
    </form>

    <!-- Acciones de usuario -->
    <div class="acciones" role="group" aria-label="Acciones de usuario">
      <i class="fas fa-globe" aria-hidden="true"></i>
      <a href="#">Iniciar sesión</a>
      <a href="#" class="btn-primario">¡Compra boletos!</a>
    </div>

    <!-- Botón de modo oscuro -->
    <button id="modo-oscuro-toggle" class="btn-darkmode" aria-pressed="false">
      <i class="fas fa-moon" aria-hidden="true"></i> Modo oscuro
    </button>
  </header>

  <!-- SECCIÓN PRINCIPAL -->
  <main class="seccion-principal" role="main">
    <h1>Bienvenido a Zoo Natural Life</h1>
    <p>Explora la biodiversidad del planeta en un solo lugar. Más de 200 especies te esperan para descubrirlas.</p>

    <!-- Galería de animales -->
    <section class="galeria-animales" aria-label="Galería de animales del zoológico">
     
      <!-- Repite esta tarjeta para cada animal -->
      <article class="tarjeta-animal">
        <img src="https://placehold.co/300x200?text=León" alt="León" />
        <h3>León</h3>
        <p>El rey de la sabana africana, símbolo de fuerza y liderazgo.</p>
        <a href="#" aria-label="Más información sobre el león"><i class="fas fa-info-circle saber-mas" aria-hidden="true"></i></a>
      </article>
     
      <!-- ... resto de animales igual ... -->
    </section>
  </main>

  <!-- PIE DE PÁGINA -->
  <footer class="footer" role="contentinfo" id="contacto">
    <div class="footer-info">
      <p><strong>Contacto:</strong> <a href="tel:+1234567890">(123) 456-7890</a> | <a href="mailto:info@zoonaturallife.com">info@zoonaturallife.com</a></p>
      <p id="ubicacion"><strong>Ubicación:</strong> Av. de los Animales 123, Ciudad Natural</p>
      <p id="redes"><strong>Redes:</strong>
        <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
      </p>
      <p id="acerca-de-nosotros"><strong>Acerca de nosotros:</strong> Somos un zoológico dedicado a la conservación, educación y el bienestar animal.</p>
    </div>
    <p class="copyright">&copy; 2025 Zoológico Natural Life. Todos los derechos reservados.</p>
  </footer>

  <script src="mainpagejs.js"></script>
</body>
</html>
