<?php
    require_once "../../login/conex.php";

    session_start();

    $conex = new ConexionDB();
    $conex->conectar();
    $conn = $conex->conex;

    if(!isset($_GET['id'])){
        header("Location: ../../login/login_panel.php");
        exit;
    }

    $id = $_GET['id'];

    $sql = "SELECT * FROM peticiones WHERE id='".intval($id)."'";
    $exec = mysqli_query($conn,$sql);
    if($exec){
        $rs = $exec->fetch_assoc();
    }else{
        header("Location: ../../login/login_panel.php");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informacion del reporte de <?=htmlspecialchars($rs['username'])?></title>
    <link rel="stylesheet" href="../../CSS/footer.css" />   
    <link rel="stylesheet" href="../../CSS/header_role.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Logo de pestaña -->
    <link rel="icon" type="image/png" href="https://juanxxiiizoo.infinityfreepp.com/img/LogoPNG.png">
</head>
<body>

    <!--Encabezado-->
    <?php include "../../resources/header.php"; ?>

    <!--Cuerpo del reporte-->
    <div class="report-info-container">
        <form action="report_info.php" method="POST">
            <input type="hidden" name="id" value="<?=$rs['id']?>">
            <input type="text" readonly value="<?=htmlspecialchars($rs['subject'])?>">
            <textarea name="" id="description" readonly><?=htmlspecialchars($rs['description'])?></textarea>
            <?php
                if(!is_null($rs['img'])): 
            ?>
            <img src="<?=htmlspecialchars($rs['img']);?>" alt="imagen-reporte">
            <p>Imagen de reporte adjunta</p>
            <?php endif;

            ?>
            
            <?php if($_SESSION['id_role'] == '2'):?>
            <!--Boton de envio exclusivo para administradores-->
            <button type="submit">Marcar como completado</button>
            <?php endif;?>
        </form>
    </div>

    <!--Pie de pagina-->
    <?php include "../../resources/footer.php";?>

    <script src="../../javaScript/role.js"></script>
      
</body>
</html>