<!--Alerta para visualizar aciertos y errores-->
<div class="cont-alert">
    <?php
    // Mostrar mensajes de estado (éxito/error)
    if (isset($_SESSION['status'])) {
        if ($_SESSION['status'] === "error") {
            echo "<p class=\"error\">".$_SESSION['message'].'</p>';
        } else {
            echo "<p class=\"success\">".$_SESSION['message'].'</p>';
        }
        unset($_SESSION['status']);
        unset($_SESSION['message']);
    }
    ?>
</div>