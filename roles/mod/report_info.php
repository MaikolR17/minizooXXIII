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
</head>
<body>

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

    
</body>
</html>