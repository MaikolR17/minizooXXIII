<?php
    session_start();
    if(!isset($_SESSION['access'])){
        header("Location: ../../login/login_panel.php");
    }

    require_once "../../login/conex.php";

    $conex = new ConexionDB();
    $conex->conectar();
    $conn = $conex->conex;

    //consultar todas las peticiones
    $sql = "SELECT * FROM peticiones";
    $rs = $conn->query($sql);
    if($rs && $rs->num_rows > 0){
        while($row = $rs->fetch_assoc()){
            $reports[] = $row;
        }
    }

    //consultar solo peticiones pendientes
    $pending = $conn->query("SELECT * FROM peticiones WHERE completed = 0");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Reportes</title>
    <!-- Logo de pestaña -->
    <link rel="stylesheet" href="../../CSS/footer.css" />   
    <link rel="stylesheet" href="../../CSS/header_role.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Logo de pestaña -->
    <link rel="icon" type="image/png" href="https://juanxxiiizoo.infinityfreepp.com/img/LogoPNG.png">
    <style>
        /* CSS para las tablas */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
            font-family: Arial, sans-serif;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px 12px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .all-reports-container, .pending-reports-container {
            margin-top: 20px;
        }

        /* CSS para los botones */
        .button-container {
            margin-bottom: 20px;
        }

        .button-container button {
            margin-right: 10px;
            padding: 10px 15px;
            border: none;
            background-color: #3498db;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .button-container button:hover {
            background-color: #2980b9;
        }
        .visible{
            display: block;
        }
        .hidden{
            display: none;
        }
    </style>
</head>
<body>

    <!--Encabezado-->
    <?php include "../../resources/header.php"; ?>

    <div class="container">
        <h1>Aqui puedes ver todos los reportes de los moderadores</h1>
    

        <div class="button-container">
            <button id="btn-pending">Ver reportes pendientes</button>
            <button id="btn-all">Ver todos los reportes</button>
        </div>

        <!-- Tabla de reportes pendientes -->
        <div id="pending_table" class="visible">
            <?php include "pending_table.php"; ?>
        </div>

        <!-- Tabla de todos los reportes -->
        <div id="all_table" class="hidden">
            <?php include "all_table.php"; ?>
        </div>
    </div>

    <!--Pie de pagina-->
    <?php include "../../resources/footer.php";?>

    <script>
        document.getElementById('btn-pending').addEventListener('click', function() {
            document.getElementById('pending_table').classList.remove("hidden");
            document.getElementById('all_table').classList.remove("visible");

            document.getElementById('pending_table').classList.add("visible");
            document.getElementById('all_table').classList.add("hidden");
        });

        document.getElementById('btn-all').addEventListener('click', function() {
            document.getElementById('all_table').classList.remove("hidden");
            document.getElementById('pending_table').classList.remove("visible");

            document.getElementById('all_table').classList.add("visible");
            document.getElementById('pending_table').classList.add("hidden");
        });
    </script>
    <script src="../../javaScript/role.js"></script>
</body>
</html>
