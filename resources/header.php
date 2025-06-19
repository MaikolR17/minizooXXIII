<header class="encabezado" role="banner">
  <a href="index.php" class="logo-link" aria-label="Ir a la página de inicio">
    <img src="img/LogoPNG.png" alt="Logo del Zoológico Juan XXIII" class="logo-img">
    <div class="logo" bis_skin_checked="1">
        <strong>MiniZoo</strong><span>Juan XXIII</span>
    </div>
  </a>

    <button class="menu-toggle" id="menu-toggle" aria-label="Abrir menú de navegación" aria-expanded="false" aria-controls="nav-links">
      <i class="fas fa-bars"></i>
    </button>

    <nav class="nav-links" id="nav-links" role="navigation" aria-label="Menú principal">
      <a href="#contacto">Contacto</a>
      <a href="#ubicacion">Ubicación</a>
      <a href="#redes">Redes</a>
      <a href="#acerca-de-nosotros">Acerca de nosotros</a>
      <a href="login/login_panel.php" class="btn-admin">Administrador</a>
    </nav>

      <?php if (empty($hideSearchBar)): ?>
    <form class="busqueda" role="search" aria-label="Buscar en el sitio">
      <label for="buscar" class="sr-only">Buscar</label>
      <i class="fas fa-search" aria-hidden="true"></i>
      <input id="buscar" type="text" placeholder="Busca una especie...">
    </form>
  <?php endif; ?>

  </header>
