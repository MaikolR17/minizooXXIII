<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acerca del Curso</title>
  <link rel="stylesheet" href="../CSS/aboutphp.css">
  <!-- Logo de pestaña -->
  <link rel="icon" type="image/png" href="img/LogoPNG.png">
</head>
<body>
  <?php include "../resources/header.php";?>

  <section class="contenido">
    <article class="seccion">
      <h2>Su Historia</h2>
      <p>
       Esta generación de estudiantes de Análisis de Sistemas Informáticos surge desde el año 2024,
        caracterizándose por ser un grupo numeroso y diverso de personas que persiguen una meta en común,
        además, por ser reconocidos por presentar proyectos electrónicos, programados de manera impresionante
       como una prótesis de mano robótica mediante Arduino y C++; así también una cámara para rodados con grabación automática de su trayecto
       utilizando la tecnología del 3D en el mencionado año destacandoles por su capacidad  e innovación en la comunidad. 
      
      </p>
    </article>

    <article class="seccion">
      <h2>El Objetivo con este trabajo </h2>
      <ol>
        <li>Crear una aplicación móvil y/o web interactiva y educativa que permita a los visitantes y entusiastas del zoológico explorar y aprender sobre la vida silvestre de manera divertida y accesible</li>
        
          <li>Proporcionar una experiencia de visitante más informativa y atractiva.</li>
          <li>Fomentar la educación y la conciencia sobre la conservación de la vida silvestre.</li>
          <li>Incrementar la participación y la interacción de los visitantes con el zoológico.</li>
          <li>Ofrecer una plataforma para que los visitantes compartan y promuevan el zoológico</li>
        
</ol>
    </article>
  </section>

  <?php include "../resources/footer.php";?>
  <script>
    document.addEventListener("DOMContentLoaded",()=>{ 
      document.getElementById("menu-toggle").style.display = "none";
      document.getElementById("search").style.display = "none";
    });
  </script>
  <script src="../javaScript/role.js"></script>
</body>
</html>
