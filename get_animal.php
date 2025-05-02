<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $archivo = 'especies.json';
    if (file_exists($archivo)) {
        $animales = json_decode(file_get_contents($archivo), true);
        foreach ($animales as $animal) {
            if ($animal['id'] === $id) {
                header('Content-Type: application/json');
                echo json_encode($animal);
                exit;
            }
        }
    }
}
http_response_code(404);
echo json_encode(null);
?>