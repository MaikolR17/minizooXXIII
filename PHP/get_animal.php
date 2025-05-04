<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $file = '../species.json';
    if (file_exists($file)) {
        $species = json_decode(file_get_contents($file), true);
        foreach ($species as $specie) {
            if ($specie['id'] === $id) {
                header('Content-Type: application/json');
                echo json_encode($specie);
                exit;
            }
        }
    }
}
http_response_code(404);
echo json_encode(null);
?>