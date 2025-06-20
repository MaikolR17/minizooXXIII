  // Selección de elementos del DOM
  const menuToggle = document.getElementById('menu-toggle');
  const navLinks = document.getElementById('nav-links');
  const darkModeToggle = document.getElementById('modo-oscuro-toggle');

  // Alternar visibilidad del menú hamburguesa
  menuToggle.addEventListener('click', () => {
    const isActive = navLinks.classList.toggle('active');

    // Cambiar ícono entre "barras" y "X"
    const icon = menuToggle.querySelector('i');
    icon.classList.toggle('fa-bars', !isActive);
    icon.classList.toggle('fa-times', isActive);

    // Actualizar atributo aria-expanded
    menuToggle.setAttribute('aria-expanded', isActive.toString());
  });

  // Cerrar menú al hacer clic en un enlace (modo móvil)
  document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', () => {
      navLinks.classList.remove('active');

      const icon = menuToggle.querySelector('i');
      icon.classList.remove('fa-times');
      icon.classList.add('fa-bars');

      menuToggle.setAttribute('aria-expanded', 'false');
    });
  });

  /*
  // Alternar modo oscuro
  darkModeToggle.addEventListener('click', () => {
    const isDark = document.body.classList.toggle('dark-mode');

    // Actualizar atributo aria-pressed
    darkModeToggle.setAttribute('aria-pressed', isDark.toString());

    // Cambiar icono opcionalmente
    const icon = darkModeToggle.querySelector('i');
    icon.classList.toggle('fa-moon', !isDark);
    icon.classList.toggle('fa-sun', isDark);
  }); */

  const body = document.querySelector("body");
    const footer = document.querySelector("footer");
    if(body.offsetHeight > window.innerHeight){
            footer.style.position = "relative";
            footer.style.bottom = "";
    }else{
      footer.style.position = "relative";
    }
        

  /*Cargar pagina cuando las imagenes esenciales esten cargadas */
  const images = document.querySelectorAll(".high-priority");
  const imagePromises = Array.from(images).map(img => {
      return new Promise(resolve => {
        //creacion de imagen temporal para evitar errrores al recargar la pagina
          const tempImg = new Image();
          tempImg.src = img.src;

          tempImg.onload = resolve;
          tempImg.onerror = resolve; // Para manejar errores
      });
  });
  //mostrar pagina cuando se carguen las imagenes esenciales
  Promise.all(imagePromises).then(() => {
      document.body.classList.add("visible");
  });



