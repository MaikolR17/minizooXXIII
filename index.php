<?php
require_once 'PHP/conex.php'; // Asegúrate de que esta ruta sea correcta

$conex = new ConexionDB();

if (!$conex->conectar()) {
    die("❌ Error de conexión: " . $conex->getError());
}

$conn = $conex->getConexion();
//obtener klas 12 primeras imagenes en orden alfabetico
$sql= "SELECT img FROM especies ORDER BY name ASC LIMIT 12";
$resultImg = $conn->query($sql);

$sql = "SELECT * FROM especies ORDER BY name ASC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Mini Zoológico Juan XXIII - Encarnación</title>
  <meta name="description" content="Explora el Mini Zoológico Juan XXIII en Encarnación. Información detallada y fotos de más de 60 especies de fauna sudamericana para educación y recreación familiar." />
  <meta name="author" content="Mini Zoológico Juan XXIII" />
  <meta name="robots" content="index, follow" />

  <!-- URL canónica -->
  <link rel="canonical" href="https://juanxxiiizoo.infinityfreeapp.com" />

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://juanxxiiizoo.infinityfreeapp.com" />
  <meta property="og:title" content="Mini Zoológico Juan XXIII - Encarnación" />
  <meta property="og:description" content="Explora el Mini Zoológico Juan XXIII en Encarnación. Información detallada y fotos de más de 60 especies de fauna sudamericana para educación y recreación familiar." />
  <meta property="og:image" content="https://juanxxiiizoo.infinityfreeapp.com/img/Logo2.jpeg" /> <!--verificar la url a la imagen-->

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:url" content="https://juanxxiiizoo.infinityfreeapp.com" />
  <meta name="twitter:title" content="Mini Zoológico Juan XXIII - Encarnación" />
  <meta name="twitter:description" content="Explora el Mini Zoológico Juan XXIII en Encarnación. Información detallada y fotos de más de 60 especies de fauna sudamericana para educación y recreación familiar." />
  <meta name="twitter:image" content="https://juanxxiiizoo.infinityfreeapp.com/img/Logo2.jpeg" /> <!--verificar la url a la imagen-->

  <!-- Estilos -->
  <link rel="stylesheet" href="CSS/index.css" />
  <link rel="stylesheet" href="CSS/header.css" />
  <link rel="stylesheet" href="CSS/footer.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
  <?php
    if($resultImg->num_rows > 0) {
      while($animal = $resultImg->fetch_assoc()){
        echo '<link rel="preload" href="'.$animal['img'].'" as="image">';
      }
    }
  ?>

</head>

<body>

  <!-- ENCABEZADO -->
  <?php include "resources/header.php"; ?>

  <!-- SECCIÓN PRINCIPAL -->
  <main class="seccion-principal" role="main">
    <h1>Bienvenido al MiniZoo Juan XXIII</h1>
    <p>Explora la biodiversidad del planeta en un solo lugar. Más de 60 especies te esperan para descubrirlas.</p>
    
    <section class="galeria-animales" aria-label="Galería de animales del zoológico">
      <?php
      if ($result->num_rows > 0) {
        $count = 0;
          while ($animal = $result->fetch_assoc()) {
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
      
              if (!empty($animal["img"])) {
                echo '<img ';
                if($count < 12){
                  echo 'fetchpriority="high" ';
                  $count++;
                }else{
                  echo 'fetchpriority="low" ';
                } 
                echo 'src="' . $animal['img'] . '" alt="' . $name . '">';
              }
              
              $id = urlencode($animal['id']);
              echo '<a href="specie_info.php?id=' . $id . '" class="boton-info" aria-label="Más información sobre ' . $name . '">
                      <i class="fas fa-info-circle saber-mas" aria-hidden="true"></i>
                      <span>Ver detalles</span>
                    </a>';
              echo '</article>';
          }
          echo '<p id="noResults" style="text-align:center; color:#777; margin-top:20px; display:none;">No se encontraron coincidencias 🐾</p>';
        } else {
          echo '<p style="text-align:center; color:#777; margin-top: 20px;"> No hay animalitos para mostrar por el momento 🦥</p>';
        }
      ?>
    </section>
  </main>

  <!-- PIE DE PÁGINA -->
  <?php include "resources/footer.php";?>

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

<!-- script para mostrar página solo cuando todo se haya cargado (incluyendo imágenes) -->
<script>
    window.addEventListener('load', () => {
      document.body.classList.add('visible');
    });
</script>
</body>
</html>
