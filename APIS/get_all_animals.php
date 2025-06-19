<?php
require_once '../login/conex.php';
$conex = new ConexionDB();
$conex->conectar();
$conn = $conex->conex;

header('Content-Type: application/json');

if (!isset($_GET['attribute'])) {
    echo json_encode(['error' => 'Atributo no especificado']);
    exit;
}

$attribute = $_GET['attribute'];
$query1 = "SELECT ".$attribute." FROM especies";
$stmt1 = $conn->prepare($query1);
$stmt1->execute();
$result1 = $stmt1->get_result();

if(is_numeric($_GET['id'])){
    $id = intval($_GET['id']);
    $query2 = "SELECT * FROM especies WHERE id = ?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
}

$data = [];
$data[0] = isset($data[0]) ? (array) $data[0] : [];
if(isset($result2)){
    if (($result1 && $result1->num_rows > 0) && ($result2 && $result2->num_rows > 0)) {
        while ($fila1 = $result1->fetch_row()) {
            $data[0] = array_merge($data[0],$fila1);
        }
        while($fila2 = $result2->fetch_assoc()){
            $data[1] = $fila2;
        }
        echo json_encode($data);
    }else{
        echo json_encode(['error' => 'Especie no encontrada']);
    }
}else if($result1 && $result1->num_rows > 0) {
    while ($fila1 = $result1->fetch_row()) {
            $data[0] = array_merge($data[0],$fila1);
    }
    echo json_encode($data);
}else{
    echo json_encode(['error' => 'Especie no encontrada']);
}
?>