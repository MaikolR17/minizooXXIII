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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MiniZoo Juan XXIII</title>
  <link rel="stylesheet" href="CSS/index.css">
  <link rel="stylesheet" href="CSS/header.css">
  <link rel="stylesheet" href="CSS/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <?php
    if($resultImg->num_rows > 0) {
      while($animal = $resultImg->fetch_assoc()){
        echo '<link rel="preload" href="'.$animal['img'].'" as="image">';
      }
    }
  ?>
</head>
<body>

  <?php include "resources/header.php"; ?>

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

  <?php include "resources/footer.php";?>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.querySelector(".busqueda input");
    const animalCards = document.querySelectorAll(".tarjeta-animal");
    const noResultsMessage = document.getElementById("noResults");
    const body = document.body;

    // --- LÓGICA DE MODO OSCURO AUTOMÁTICO ---
    // Función simplificada para aplicar o quitar la clase 'dark-mode'
    function setDarkMode(isDark) {
      if (isDark) {
        body.classList.add("dark-mode");
      } else {
        body.classList.remove("dark-mode");
      }
    }

    // Detectar la preferencia del sistema
    const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)');

    // Aplicar el tema inicial basado en la preferencia del sistema
    setDarkMode(prefersDarkMode.matches);

    // Escuchar cambios en la preferencia del sistema para actualizar el tema dinámicamente
    prefersDarkMode.addEventListener('change', (e) => {
      setDarkMode(e.matches);
    });
    // --- FIN DE LA LÓGICA DE MODO OSCURO ---

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