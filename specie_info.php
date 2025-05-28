<?php
require_once 'PHP/conex.php';
$conex = new ConexionDB();
$conex->conectar();
$conn = $conex->conex;

// Si no se accede por medio de GET
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

// Consulta SQL para obtener los datos de la especie
$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM especies WHERE id = ?");
$stmt->bind_param("i", $id); // "i" porque es un entero
$stmt->execute();
$result = $stmt->get_result();
$specie = $result->fetch_all(MYSQLI_ASSOC);


// Validar que exista la especie
if (!$specie) {
    echo "<p style='text-align:center; color:red;'>⚠️ Especie no encontrada ⚠️</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=htmlspecialchars($specie[0]['name'])?></title>
    <link rel="stylesheet" href="CSS/specie_info.css">
</head>
<body>
    <main>
        <h1><?=htmlspecialchars($specie[0]['name'])?></h1>
        <h2><?=htmlspecialchars($specie[0]['alt_name'])?></h2>
        <h3><?=htmlspecialchars($specie[0]['scient_name'])?></h3>
        <div class="info_container">
            <div class="img_order_family">
                <img src="<?=htmlspecialchars($specie[0]['img'])?>" alt="<?=htmlspecialchars($specie[0]['name'])?>">
                <p><strong>ORDEN: </strong><?=htmlspecialchars(strtoupper($specie[0]['specie_order']))?></p>
                <p><strong>FAMILIA: </strong><?=htmlspecialchars(strtoupper($specie[0]['family']))?></p>
            </div>
            <div class="large_text">
                <p id="description"><?=htmlspecialchars($specie[0]['description'])?></p>
                <h3>ECOLOGÍA</h3>
                <p id="ecology"><?=htmlspecialchars($specie[0]['ecology'])?></p>
                <h3>DISTRIBUCIÓN</h3>
                <p id="distribution"><?=htmlspecialchars($specie[0]['distribution'])?></p>
            </div>
        </div>
    </main>
</body>
</html>
