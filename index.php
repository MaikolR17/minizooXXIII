<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MiniZoo Juan XXIII</title>
  <link rel="stylesheet" href="CSS/index.css" />
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
    <h1>Bienvenido al MiniZoo Juan XXIII</h1>
    <p>Explora la biodiversidad del planeta en un solo lugar. Más de 60 especies te esperan para descubrirlas.</p>
    
    <section class="galeria-animales" aria-label="Galería de animales del zoológico">
  <?php
  $jsonPath = 'species.json';

  if (file_exists($jsonPath)) {
      $jsonContent = file_get_contents($jsonPath);
      $speciesList = json_decode($jsonContent, true);

      if (!empty($speciesList)) {
          foreach ($speciesList as $animal) {
              $id = htmlspecialchars($animal["id"]);
              $name = htmlspecialchars($animal["name"]);
              $scient_name = htmlspecialchars($animal["scient_name"]);
              $description = htmlspecialchars($animal["description"]);

              $shortDescription = strlen($description) > 100
                  ? substr($description, 0, 100) . '...'
                  : $description;

              echo '<article class="tarjeta-animal"';
              echo ' data-id="' . $id . '"';
              echo ' data-name="' . strtolower($name) . '"';
              echo ' data-scientific="' . strtolower($scient_name) . '">';
              
              echo '<h3>' . $name . '</h3>';
              echo '<p>' . $shortDescription . '</p>';

              if (isset($animal["img"]) && !empty($animal["img"])) {
                  echo '<img src="' . htmlspecialchars($animal["img"]) . '" alt="' . $name . '">';
                  echo '<img src="' . htmlspecialchars($animal["qr"]) . '" alt="Código QR">';
              }

              echo '<br><a href="'.$animal['url'].'" aria-label="Más información sobre '.$animal['name'].'"><i class="fas fa-info-circle saber-mas" aria-hidden="true"></i></a>';
              echo '</article>';
              echo '<p id="noResults" style="text-align:center; color:#777; margin-top:20px; display:none;">No se encontraron coincidencias 🐾</p>';
          }
      } else {
          echo '<p style="text-align:center; color:#777; margin-top: 20px;"> No hay animalitos para mostrar por el momento 🦥</p>';
      }
  } else {
      echo '<p style="text-align:center; color:#777; margin-top: 20px;">⚠️ Archivo de especies no encontrado ⚠️</p>';
  }
  ?>
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

  <!-- JavaScript -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.querySelector(".busqueda input");
    const animalCards = document.querySelectorAll(".tarjeta-animal");
    const noResultsMessage = document.getElementById("noResults");

    searchInput.addEventListener("input", () => {
      const searchTerm = searchInput.value.trim().toLowerCase();
      let hasMatch = false;

      animalCards.forEach(card => {
        const name = card.dataset.name;
        const scientific = card.dataset.scientific;
        const id = card.dataset.id.toLowerCase();

        const matches = name.includes(searchTerm) || scientific.includes(searchTerm) || id.includes(searchTerm);

        card.style.display = matches ? "block" : "none";
        if (matches) hasMatch = true;
      });

      noResultsMessage.style.display = hasMatch ? "none" : "block";
    });
    });
  </script>


<script src="javaScript/mainpagejs.js"></script>

</body>
</html>
