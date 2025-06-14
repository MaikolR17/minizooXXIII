<header class="encabezado" role="banner">
    <a href="index.php" class="logo-link">
      <div class="logo">
        <strong>MiniZoo</strong><span>Juan XXIII</span>
      </div>
    </a>

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
      <input id="buscar" type="text" placeholder="Busca una especie, sección o evento">
    </form>

    <!-- Botón de modo oscuro -->
    <button id="modo-oscuro-toggle" class="btn-darkmode" aria-pressed="false">
      <i class="fas fa-moon" aria-hidden="true"></i> 
    </button>
  </header>