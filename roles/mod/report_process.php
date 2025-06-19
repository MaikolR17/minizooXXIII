<?php
    require_once "../../login/conex.php";

    session_start();

    $conex = new ConexionDB();
    $conex->conectar();
    $conn = $conex->conex;
    
    if($_SERVER['REQUEST_METHOD']!== "POST"){
        header("Location: ../../login/login_panel.php");
        exit;
    }

    
    if(isset($_POST['id'])){
        $id = intval($_POST['id']) ?? 0;

        $sql = "UPDATE peticiones SET completed = 1 WHERE id ="."'".$id."'";
        $rs = mysqli_query($conn, $sql);
        if(!$rs){
            setError("No se pudo guardar el reporte en la base de datos.","mod.php");
        }

        setSuccess("Reporte marcado como completado","mod.php");
    }

    $report = [
        "username" => $_SESSION['username'],
        "subject" => trim($_POST['subject']),
        "description" => trim($_POST['report'])
    ];
    
    
    if(isset($_FILES['img'])){
        $img = saveImage();
        $report['img'] = $img;
    }

    foreach($report as $key => $value){
        $keys[] = $key;
        $values[] = $value;
    }

    $sql = "INSERT INTO peticiones (".implode(",",$keys).") VALUES (".implode(",",$values).")";
    $rs = mysqli_query($conn, $sql);

    if($rs){
        setSuccess("Reporte almacenado en la base de datos correctamente","mod.php");
    }else{
        setError("No se pudo almacenar el reporte en la base de datos","mod.php");
    }

    //funcion para guardar imagen
    function saveImage() {
        if ($_FILES['img']['error'] !== 0) {
            setError("No se recibió ninguna imagen válida.","mod.php");
        }

        $temp = $_FILES['img']['tmp_name'];
        $name = basename($_FILES['img']['name']);
        $uniqueName = $name;

        $location = 'img/' . $uniqueName;

        $allowed = ['image/jpeg', 'image/png', 'image/gif'];
        $max = 5 * 1024 * 1024;

        if (!in_array($_FILES['img']['type'], $allowed)) {
            setError("Formato de imagen no permitido. Solo JPG, PNG y GIF.","mod.php");
        }

        if ($_FILES['img']['size'] > $max) {
            setError("La imagen excede el tamaño máximo de 5MB.","mod.php");
        }

        if (!is_dir('img')) {
            mkdir('img', 0777, true);
        }

        if (!move_uploaded_file($temp, $location)) {
            setError("Error al guardar la imagen.","mod.php");
        }

        return $location;
    }
    
?>