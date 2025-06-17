<?php
    require_once "conex.php";
    $db = new ConexionDB();
    $db->conectar();

    if(!$db){
        echo json_encode(
            [
                "error" => "No se pudo conectar a la base de datos"
            ]
        );
    }

    $conn = $db->getConexion();

    $id_rol = isset($_GET['id_rol'])? $_GET['id_rol']: "";
    
    if(!empty($request)){
        $sql = "SELECT username from users WHERE id_rol= ? ORDER BY username ASC";
        
    }

?>