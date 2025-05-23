<?php
require_once 'conex.php';
$conex = new ConexionDB();
$conex->conectar();
$conn = $conex->conex;

header('Content-Type: application/json');

if (!isset($_GET['atribute'])) {
    echo json_encode(['error' => 'Atributo no especificado']);
    exit;
}

$atribute = $_GET['atribute'];

$query = "SELECT ".$atribute." FROM especies";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $atribute);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Especie no encontrada']);
}
?>