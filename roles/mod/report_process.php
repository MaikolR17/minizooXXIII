<?php
    require_once "../../login/conex.php";

    session_start();

    $conex = new ConexionDB();
    $conex->conectar();
    $conn = $conex->conex;
    
    if($_SERVER['REQUEST_METHOD']!== "POST" || !isset($_GET['id'])){
        header("Location: ../../login/login_panel.php");
    }

    
    $id = intval($_GET['id']) ?? 0;

    $sql = "UPDATE peticiones SET completed = 1 WHERE id ="."'".$id."'";
    $rs = mysqli_query($conn, $sql);
    if(!$rs){
        setError("No se pudo guardar el reporte en la base de datos.","mod.php");
    }

    


    
?>