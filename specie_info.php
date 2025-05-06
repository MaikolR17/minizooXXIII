<?php
    //si no se accede por medio de get 
    if(!isset($_GET['id'])){
        header("Location: index.php");
        exit;
    }
    //capturar el id de la especie por medio de get
    $id = $_GET['id'];
    $species = json_decode(file_get_contents('species.json'),true)?  : [];
    //seleccionar la especie que coincida con el id capturado
    $specie = array_filter($species, fn($animal)=> $animal['id'] == $id);
    if(empty($specie)){
        header("Location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=htmlspecialchars($specie[0]['name'])?></title>
</head>
<body>
    <main>
        <h1><?=htmlspecialchars($specie[0]['name'])?></h1>
        <h2><?=htmlspecialchars($specie[0]['alt_name'])?></h2>
        <h3><?=htmlspecialchars($specie[0]['scient_name'])?></h3>
        <div class = "info_container">
            <div class = "img_order_family">
                <img src="<?=htmlspecialchars($specie[0]['img'])?>" alt="<?=htmlspecialchars($specie[0]['name'])?>">
                <p><strong>ORDEN: </strong><?=htmlspecialchars(strtoupper($specie[0]['order']))?></p>
                <p><strong>FAMILIA: </strong><?=htmlspecialchars(strtoupper($specie[0]['family']))?></p>
            </div>
            <div class ="large_text">
                <p id ="description"><?=htmlspecialchars($specie[0]['description'])?></p>
                <h3>ECOLOGIA</h3>
                <p id="ecology"><?=htmlspecialchars($specie[0]['ecology'])?></p>
                <h3>DISTRIBUCiÓN</h3>
                <p id = "distribution"><?=htmlspecialchars($specie[0]['distribution'])?></p>
            </div>
        </div>
    </main>
</body>
</html>