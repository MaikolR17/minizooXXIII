<?php
    require_once "../../login/conex.php";
    $db = new ConexionDB();
    $db->conectar();

    if(!$db){
        echo json_encode(
            [
                "error" => "No se pudo conectar a la base de datos"
            ]
        );
        exit;
    }

    $conn = $db->getConexion();

    $id_role = isset($_GET['id_role'])? intval($_GET['id_role']): "";
    
    if(!empty($id_role)){
        $sql = "SELECT username,id from users WHERE id_role= ? ORDER BY username ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$id_role);
        $stmt->execute();
        $rs = $stmt->get_result();

        if($rs && $rs->num_rows > 0){
            $data = $rs->fetch_all(MYSQLI_ASSOC);
            echo json_encode($data,JSON_PRETTY_PRINT);
            exit;
        }
        //respuesta si no se encuentran datos
        echo json_encode(
            [
                "error" => "No se encontraron datos"
            ]
        );
        exit;
    }

    //respuesta si no se recibe un get
    echo json_encode(
        [
            "error" => "Peticion indefinida"
        ]
    );

?>