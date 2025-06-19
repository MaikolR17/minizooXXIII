<?php
    session_start();
    if(!isset($_SESSION['access'])){
        header("Location: ../../login/login_panel.php");
    }

    require_once "../../login/conex.php";

    $conex = new ConexionDB();
    $conex->conectar();
    $conn = $conex->conex;

    $sql = "SELECT * FROM peticiones";
    $rs = $conn->query($sql);
    if($rs && $rs->num_rows > 0){
        while($row = $rs->fetch_assoc()){
            $reports[] = $row;
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Reportes</title>
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
    </style>
</head>
<body>
    <h1>Aqui puedes ver todos los reportes de los moderadores</h1>

    <div class="button-container">
        <button id="btn-pending">Ver reportes pendientes</button>
        <button id="btn-all">Ver todos los reportes</button>
    </div>

    <!-- Tabla de reportes pendientes -->
    <div id="pendingTable">
        <?php include "pending_table.php"; ?>
    </div>

    <!-- Tabla de todos los reportes -->
    <div id="allTable" style="display: none;">
        <?php include "all_table.php"; ?>
    </div>

    <script>
        document.getElementById('btn-pending').addEventListener('click', function() {
            document.getElementById('pendingTable').style.display = 'block';
            document.getElementById('allTable').style.display = 'none';
        });

        document.getElementById('btn-all').addEventListener('click', function() {
            document.getElementById('pendingTable').style.display = 'none';
            document.getElementById('allTable').style.display = 'block';
        });
    </script>
</body>
</html>
