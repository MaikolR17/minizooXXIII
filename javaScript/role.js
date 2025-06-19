document.addEventListener("DOMContentLoaded",()=>{
    const manage = document.getElementById("link_1");
    const reports = document.getElementById("link_2");
    const history = document.getElementById("link_3");
    const about = document.getElementById("link_4");
    const logout = document.getElementById("link_5");
    const menuToggle = document.getElementById("menu-toggle");
    const searchBar = document.getElementById("search");

    const body = document.querySelector("body");
    const footer = document.querySelector("footer");

    /*Ocultar elementos */
    about.style.display = "none";
    menuToggle.style.display = "none";
    searchBar.style.display = "none";

    /*Ajustar texto y enlace de elementos */
    manage.textContent = "Gestionar";
    manage.href = "https://juanxxiiizoo.infinityfreeapp.com/login/login_panel.php";

    reports.textContent = "Reportes";
    reports.href = "https://juanxxiiizoo.infinityfreeapp.com/roles/mod/reports.php";
    
    history.textContent = "Historial de registros";
    history.href = "https://juanxxiiizoo.infinityfreeapp.com/roles/admin/historyList.php";

    logout.textContent = "Cerrar Sesion";
    logout.href = "https://juanxxiiizoo.infinityfreeapp.com/login/logout.php";

    if(body.offsetHeight > window.innerHeight * 0.80){
        footer.style.position = "relative";
        footer.style.bottom = "";
    }
});