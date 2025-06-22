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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Información del reporte de <?=htmlspecialchars($rs['username'])?></title>
    <link rel="stylesheet" href="../../CSS/footer.css" />   
    <link rel="stylesheet" href="../../CSS/header_role.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="icon" type="image/png" href="https://juanxxiiizoo.infinityfreepp.com/img/LogoPNG.png" />
    <style>
        /* Estilo global del body NO cambia fondo ni color texto */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #fff; /* blanco para toda la página */
            color: #222; /* texto oscuro normal */
        }

        /* SOLO el contenedor del reporte tiene fondo verde claro y texto verde */
        .report-info-container {
            max-width: 700px;
            background-color: #e8f5e9; /* verde claro */
            margin: 40px auto;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.2);
            color: #2e7d32; /* verde oscuro para textos dentro */
        }

        /* Inputs y textarea dentro del contenedor con estilo verde */
        .report-info-container input[readonly],
        .report-info-container textarea[readonly] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #a5d6a7;
            border-radius: 8px;
            background-color: #f1f8f3;
            font-size: 16px;
            color: #2e7d32;
            resize: none;
            box-sizing: border-box;
            font-family: inherit;
        }

        .report-info-container textarea[readonly] {
            min-height: 120px;
        }

        /* Imagen con estilo dentro del contenedor */
        .report-info-container img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(46,125,50,0.25);
            display: block;
        }

        /* Párrafo para texto pequeño dentro del contenedor */
        .report-info-container p {
            font-size: 14px;
            color: #2e7d32;
            margin-top: 0;
            margin-bottom: 25px;
            font-style: italic;
        }

        /* Botón dentro del contenedor */
        .report-info-container button {
            background-color: #2e7d32;
            color: white;
            font-size: 16px;
            font-weight: 600;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .report-info-container button:hover {
            background-color: #1b5e20;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(27, 94, 32, 0.5);
        }
    </style>
</head>
<body>

    <!--Encabezado-->
    <?php include "../../resources/header.php"; ?>

    <!-- Contenedor exclusivo con fondo verde claro y texto verde -->
    <div class="report-info-container">
        <form action="report_info.php" method="POST">
            <input type="hidden" name="id" value="<?=$rs['id']?>" />
            <input type="text" readonly value="<?=htmlspecialchars($rs['subject'])?>" />
            <textarea readonly><?=htmlspecialchars($rs['description'])?></textarea>

            <?php if(!is_null($rs['img'])): ?>
                <img src="<?=htmlspecialchars($rs['img']);?>" alt="Imagen adjunta del reporte" />
                <p>Imagen de reporte adjunta</p>
            <?php endif; ?>

            <?php if($_SESSION['id_role'] == '2'): ?>
                <button type="submit">Marcar como completado</button>
            <?php endif; ?>
        </form>
    </div>

    <!--Pie de página-->
    <?php include "../../resources/footer.php";?>

    <script src="../../javaScript/role.js"></script>
</body>
</html>
