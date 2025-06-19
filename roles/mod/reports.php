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
    if($rs && $rs->num_rows >0){
        while($row = $rs->fetch_assoc()){
            $reports[]=$row;
        }
    }

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <!-- Logo de pestaña -->
    <link rel="icon" type="image/png" href="img/LogoPNG.png">
</head>
<body>
    <h1>Aqui puedes ver todos los reportes de los moderadores</h1>
    <div><a href="#">Ver reportes pendientes</a><a href="#">Ver todos los reportes</a></div>

    <!--Tabla de reportes pendientes-->
    <?php include "pendingTable.php";?>
</body>
</html>