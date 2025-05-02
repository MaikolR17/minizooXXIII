// Selección de elementos
const menuToggle = document.getElementById('menu-toggle');
const navLinks = document.getElementById('nav-links');

// Alternar visibilidad del menú
menuToggle.addEventListener('click', () => {
  navLinks.classList.toggle('active');

  // Cambiar ícono entre "barras" y "X"
  const icon = menuToggle.querySelector('i');
  icon.classList.toggle('fa-bars');
  icon.classList.toggle('fa-times');
});

// Cerrar menú al hacer clic en un enlace (modo móvil)
document.querySelectorAll('.nav-links a').forEach(link => {
  link.addEventListener('click', () => {
    navLinks.classList.remove('active');
    const icon = menuToggle.querySelector('i');
    icon.classList.remove('fa-times');
    icon.classList.add('fa-bars');
  });
});