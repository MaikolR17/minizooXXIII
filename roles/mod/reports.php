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
    <link rel="stylesheet" href="../../CSS/footer.css" />   
    <link rel="stylesheet" href="../../CSS/header_role.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/png" href="https://juanxxiiizoo.infinityfreepp.com/img/LogoPNG.png">

    <style>
        /* Tablas */
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

        .container {
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        /* Botones de navegación */
        .button-container {
            margin: 30px 0;
            text-align: center;
        }

        .button-container button {
            margin: 0 10px;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            color: white;
            transition: background-color 0.3s ease;
        }

        .button-active {
            background-color: #2e7d32; /* verde oscuro activo */
        }

        .button-inactive {
            background-color: #66bb6a; /* verde claro inactivo */
        }

        .button-container button:hover:not(.button-active) {
            background-color: #388e3c;
        }

        .visible {
            display: block;
            width: 100%;
        }

        .hidden {
            display: none;
        }

        /* Botón "Ver reporte" */
        .table-action-button {
            display: inline-block;
            padding: 8px 16px;
            background-color: #4caf50;
            color: white;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .table-action-button:hover {
            background-color: #388e3c;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Botón "Marcar completado" */
        .complete-button {
            padding: 8px 16px;
            background-color: #2e7d32;
            color: white;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .complete-button:hover {
            background-color: #1b5e20;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <!-- Encabezado -->
    <?php include "../../resources/header.php"; ?>

    <div class="container">
        <h1>Aquí puedes ver todos los reportes de los moderadores</h1>

        <div class="button-container">
            <button id="btn-pending" class="button-active">Ver reportes pendientes</button>
            <button id="btn-all" class="button-inactive">Ver todos los reportes</button>
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

    <!-- Pie de página -->
    <?php include "../../resources/footer.php"; ?>

    <script>
        const btnPending = document.getElementById('btn-pending');
        const btnAll = document.getElementById('btn-all');
        const pendingTable = document.getElementById('pending_table');
        const allTable = document.getElementById('all_table');

        btnPending.addEventListener('click', () => {
            pendingTable.classList.remove("hidden");
            pendingTable.classList.add("visible");
            allTable.classList.remove("visible");
            allTable.classList.add("hidden");

            btnPending.classList.add("button-active");
            btnPending.classList.remove("button-inactive");

            btnAll.classList.add("button-inactive");
            btnAll.classList.remove("button-active");
        });

        btnAll.addEventListener('click', () => {
            allTable.classList.remove("hidden");
            allTable.classList.add("visible");
            pendingTable.classList.remove("visible");
            pendingTable.classList.add("hidden");

            btnAll.classList.add("button-active");
            btnAll.classList.remove("button-inactive");

            btnPending.classList.add("button-inactive");
            btnPending.classList.remove("button-active");
        });
    </script>

    <script src="../../javaScript/role.js"></script>
</body>
</html>
