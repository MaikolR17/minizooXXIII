<?php
require_once '../../login/conex.php';
$conex = new ConexionDB();
$conex->conectar();
$conn = $conex->conex;

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'ID no especificado']);
    exit;
}

$id = intval($_GET['id']);

$query = "SELECT * FROM especies WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Especie no encontrada']);
}
?>