<?php
require_once 'conex.php';
$conex = new ConexionDB();
$conex->conectar();
$conn = $conex->conex;

header('Content-Type: application/json');

if (!isset($_GET['attribute'])) {
    echo json_encode(['error' => 'Atributo no especificado']);
    exit;
}

$attribute = $_GET['attribute'];

$query = "SELECT ".$attribute." FROM especies";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($result && $result->num_rows > 0) {
    while ($fila = $result->fetch_row()) {
        $data = array_merge($data,$fila);
    }
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Especie no encontrada']);
}
?>