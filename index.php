<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Zoológico - Natural Life</title>
  <link rel="stylesheet" href="CSS/index.css" />
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
  <section class="seccion-principal">
    <h1>Bienvenido al MiniZoo Juan XXIII</h1>
    <p>Explora la biodiversidad del planeta en un solo lugar. Más de 60 especies te esperan para descubrirlas.</p>

<!-- Galería de animales
<div class="galeria-animales">
  <div class="tarjeta-animal">
    <img src="https://placehold.co/300x200?text=León" alt="León" />
    <h3>León</h3>
    <p>El rey de la sabana africana, símbolo de fuerza y liderazgo.</p>
    <a href="#"><i class="fas fa-info-circle saber-mas"></i></a>
  </div>
  <div class="tarjeta-animal">
    <img src="https://placehold.co/300x200?text=Elefante" alt="Elefante" />
    <h3>Elefante</h3>
    <p>El mamífero terrestre más grande del mundo, inteligente y social.</p>
    <a href="#"><i class="fas fa-info-circle saber-mas"></i></a>
  </div>
  <div class="tarjeta-animal">
    <img src="https://placehold.co/300x200?text=Pingüino" alt="Pingüino" />
    <h3>Pingüino</h3>
    <p>Aves marinas simpáticas que habitan en climas fríos.</p>
    <a href="#"><i class="fas fa-info-circle saber-mas"></i></a>
  </div>
  <div class="tarjeta-animal">
    <img src="https://placehold.co/300x200?text=Jirafa" alt="Jirafa" />
    <h3>Jirafa</h3>
    <p>El animal más alto del mundo con un cuello inconfundible.</p>
    <a href="#"><i class="fas fa-info-circle saber-mas"></i></a>
  </div>
  <div class="tarjeta-animal">
    <img src="https://placehold.co/300x200?text=Oso+Polar" alt="Oso Polar" />
    <h3>Oso Polar</h3>
    <p>Gran depredador del Ártico, adaptado al frío extremo.</p>
    <a href="#"><i class="fas fa-info-circle saber-mas"></i></a>
  </div>
  <div class="tarjeta-animal">
    <img src="https://placehold.co/300x200?text=Cebra" alt="Cebra" />
    <h3>Cebra</h3>
    <p>Con sus distintivas rayas blancas y negras, vive en sabanas africanas.</p>
    <a href="#"><i class="fas fa-info-circle saber-mas"></i></a>
  </div>
  <div class="tarjeta-animal">
    <img src="https://placehold.co/300x200?text=Tigre" alt="Tigre" />
    <h3>Tigre</h3>
    <p>Majestuoso felino de Asia con un pelaje naranja rayado.</p>
    <a href="#"><i class="fas fa-info-circle saber-mas"></i></a>
  </div>
  <div class="tarjeta-animal">
    <img src="https://placehold.co/300x200?text=Flamenco" alt="Flamenco" />
    <h3>Flamenco</h3>
    <p>Con su plumaje rosa y patas largas, destaca en humedales.</p>
    <a href="#"><i class="fas fa-info-circle saber-mas"></i></a>
  </div>
  <div class="tarjeta-animal">
    <img src="https://placehold.co/300x200?text=Camello" alt="Camello" />
    <h3>Camello</h3>
    <p>Adaptado al desierto, puede pasar días sin agua.</p>
    <a href="#"><i class="fas fa-info-circle saber-mas"></i></a>
  </div>
  <div class="tarjeta-animal">
    <img src="https://placehold.co/300x200?text=Mono" alt="Mono" />
    <h3>Mono</h3>
    <p>Curioso y ágil, habita en selvas tropicales y sabanas.</p>
    <a href="#"><i class="fas fa-info-circle saber-mas"></i></a>
  </div>
</div>
-->
    
<div class="galeria-animales">
  <?php
  $jsonPath = 'species.json';

  // verificar si el archivo existe
  if (file_exists($jsonPath)) {
      $jsonContent = file_get_contents($jsonPath);
      $speciesList = json_decode($jsonContent, true);

      // verificar si hay especies en el JSON
      if (!empty($speciesList)) {
          foreach ($speciesList as $animal) {
              //VERIFICAR LUEGO CON LOS DATOS DEL JSON REAL!!!!!!!!!!!!!!!!!!!!!
              $name = htmlspecialchars($animal["name"]);
              $description = htmlspecialchars($animal["description"]);

              // acortar la descripción si es más larga de 100 caracteres y a;adir puntos suspensivos
              $shortDescription = strlen($description) > 100
                  ? substr($description, 0, 100) . '...'
                  : $description;

              echo '<div class="tarjeta-animal">';
              echo '<h3>' . $name . '</h3>';
              echo '<p>' . $shortDescription . '</p>';
              // verifica si hay imagen
              if (isset($animal["img"]) && !empty($animal["img"])) {
                  echo '<img src="' . htmlspecialchars($animal["img"]) . '" alt="' . $name . '">';
                  echo '<img src="' . $animal['qr'] . '" alt="Código QR">';
              }
              echo '</div>';
          }
      } else {
          // si no hay especies en el JSON
          echo '<p style="text-align:center; color:#777; margin-top: 20px;"> No hay animalitos para mostrar por el momento 🦥</p>';
      }
  } else {
      // si no se encuentra el archivo
      echo '<p style="text-align:center; color:#777; margin-top: 20px;">⚠️ Archivo de especies no encontrado ⚠️</p>';
  }
  ?>
</div>

  </section>

  <!-- PIE DE PÁGINA -->
  <footer class="footer" id="contacto">
    <div class="footer-info">
      <p><strong>Contacto:</strong> (123) 456-7890 | info@zoonaturallife.com</p>
      <p><strong>Ubicación:</strong> Av. de los Animales 123, Ciudad Natural</p>
      <p id="redes"><strong>Redes:</strong>
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
      </p>
      <p id="acerca-de-nosotros"><strong>Acerca de nosotros:</strong> Somos un zoológico dedicado a la conservación, educación y el bienestar animal.</p>
    </div>
    <p class="copyright">&copy; 2025 Zoológico Natural Life. Todos los derechos reservados.</p>
  </footer>

  <!-- JavaScript -->
  <script src="javaScript/mainpagejs.js"></script>

</body>
</html>
