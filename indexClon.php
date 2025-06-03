<html lang="es"><head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MiniZoo Juan XXIII</title>
  <link rel="stylesheet" href="CSS/index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

  <!-- ENCABEZADO -->
  <header class="encabezado" role="banner">
    <div class="logo">
      <strong>MiniZoo</strong><span>Juan XXIII</span>
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
      <input id="buscar" type="text" placeholder="Busca una especie, sección o evento">
    </form>

    <!-- Botón de modo oscuro -->
    <button id="modo-oscuro-toggle" class="btn-darkmode" aria-pressed="false">
      <i class="fas fa-moon" aria-hidden="true"></i> 
    </button>
  </header>

  <!-- SECCIÓN PRINCIPAL -->
  <main class="seccion-principal" role="main">
    <h1>Bienvenido al MiniZoo Juan XXIII</h1>
    <p>Explora la biodiversidad del planeta en un solo lugar. Más de 60 especies te esperan para descubrirlas.</p>
    
    <section class="galeria-animales" aria-label="Galería de animales del zoológico">
                    </a></article><article class="tarjeta-animal" data-id="36" data-name="yacaré negro" data-scientific="caiman yacaré"><h3>Yacaré negro</h3><p>Es un reptil acuático. Los ojos y las fosas nasales están proyectadas hacia arriba sobre el dorso ...</p><img src="https://juanxxiiizoo.infinityfreeapp.com/img/yacare_negro.jpg" alt="Yacaré negro"><a href="specie_info.php?id=36" aria-label="Más información sobre Yacaré negro">
                      <i class="fas fa-info-circle saber-mas" aria-hidden="true"></i>
                    </a></article><article class="tarjeta-animal" data-id="37" data-name="koati" data-scientific="nasua"><h3>Koati</h3><p>El dorso es de color pardo amarillento a marrón oscuro, casi negro, mientras que la zona ventral pu...</p><img src="https://juanxxiiizoo.infinityfreeapp.com/img/coati.jpg" alt="Koati"><a href="specie_info.php?id=37" aria-label="Más información sobre Koati">
                      <i class="fas fa-info-circle saber-mas" aria-hidden="true"></i>
                    </a></article><article class="tarjeta-animal" data-id="38" data-name="anaconda" data-scientific="eunectes murinus"><h3>Anaconda</h3><p>Es la serpiente más grande del Chaco. Tiene una fila de manchas obscuras a lo largo del dorso, de c...</p><img src="https://juanxxiiizoo.infinityfreeapp.com/img/anaconda.jpg" alt="Anaconda"><a href="specie_info.php?id=38" aria-label="Más información sobre Anaconda">
                      <i class="fas fa-info-circle saber-mas" aria-hidden="true"></i>
                    </a></article><article class="tarjeta-animal" data-id="39" data-name="jaguar" data-scientific="panthera onca"><h3>Jaguar</h3><p>Es el felino más grande de América. Su pelaje es amarillo leonado con manchas negras en forma de r...</p><img src="https://juanxxiiizoo.infinityfreeapp.com/img/Jaguar.png" alt="Jaguar"><a href="specie_info.php?id=39" aria-label="Más información sobre Jaguar">
                      <i class="fas fa-info-circle saber-mas" aria-hidden="true"></i>
                    </a></article><article class="tarjeta-animal" data-id="40" data-name="lechuza de campanario" data-scientific="tyto alba"><h3>Lechuza de Campanario</h3><p>Se distingue por su característico disco facial blanco en forma de corazón, rodeado por un borde o...</p><img src="https://juanxxiiizoo.infinityfreeapp.com/img/Lechuza.png" alt="Lechuza de Campanario"><a href="specie_info.php?id=40" aria-label="Más información sobre Lechuza de Campanario">
                      <i class="fas fa-info-circle saber-mas" aria-hidden="true"></i>
                    </a></article><article class="tarjeta-animal" data-id="41" data-name="iguana negra" data-scientific="salvator merianae"><h3>Iguana Negra</h3><p>Es uno de los lagartos más grandes de su género. Los machos pueden alcanzar hasta 1,3 metros de lo...</p><img src="https://juanxxiiizoo.infinityfreeapp.com/img/Tejú Hu.jpg" alt="Iguana Negra"><a href="specie_info.php?id=41" aria-label="Más información sobre Iguana Negra">
                      <i class="fas fa-info-circle saber-mas" aria-hidden="true"></i>
                    </a></article><p id="noResults" style="text-align:center; color:#777; margin-top:20px; display:none;">No se encontraron coincidencias 🐾</p>    </section>
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
    <p class="copyright">© 2025 Zoológico Natural Life. Todos los derechos reservados.</p>
  </footer>

  <!-- JavaScript -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.querySelector(".busqueda input");
    const animalCards = document.querySelectorAll(".tarjeta-animal");
    const noResultsMessage = document.getElementById("noResults");
    const darkModeToggle = document.getElementById("modo-oscuro-toggle");
    const body = document.body;

    // Aplicar preferencias guardadas al cargar la página
    const darkMode = localStorage.getItem("modoOscuro");
    if (darkMode === "true") {
      body.classList.add("modo-oscuro");
      darkModeToggle.setAttribute("aria-pressed", "true");
    }

    // Guardar preferencia cuando el usuario activa o desactiva modo oscuro
    darkModeToggle.addEventListener("click", () => {
      const isDark = body.classList.toggle("modo-oscuro");
      localStorage.setItem("modoOscuro", isDark);
      darkModeToggle.setAttribute("aria-pressed", isDark.toString());
    });

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




</body></html>