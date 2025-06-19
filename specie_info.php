<?php
require_once 'login/conex.php';
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

$place = $specie[0]['place'];

$stmt = $conn->prepare("SELECT id,name FROM especies WHERE place = ?");
$stmt->bind_param("i",$place);
$stmt->execute();
$result = $stmt->get_result();

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
    <link rel="stylesheet" href="CSS/header.css">
    <link rel="stylesheet" href="CSS/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <!--Encabezado-->
    <?php $hideSearchBar = true; ?> <!--Variable auxiliar para ocultar la barra de busqueda-->
    <?php include "resources/header.php";?>

    <!--Seccion principal-->
    <main>
        <h1><?=htmlspecialchars($specie[0]['name'])?></h1>
        <h2><?=htmlspecialchars($specie[0]['alt_name'])?></h2>
        <h3><?=htmlspecialchars($specie[0]['scient_name'])?></h3>
        <div class="info_container">
            <div class="img_order_family">
                <img src="<?="https://juanxxiiizoo.infinityfreeapp.com/".htmlspecialchars($specie[0]['img'])?>" alt="<?=htmlspecialchars($specie[0]['name'])?>">
                <p><strong>ORDEN: </strong><?=htmlspecialchars(mb_strtoupper($specie[0]['specie_order']))?></p>
                <p><strong>FAMILIA: </strong><?=htmlspecialchars(mb_strtoupper($specie[0]['family']))?></p>
                <p><strong>RECINTO: </strong>
                    <?php
                        if($result->num_rows > 1) {
                            echo "Esta especie habita en su jaula junto con las siguientes especies:</p>";
                            echo "<ul>";
                            while($animal = $result->fetch_assoc()){
                                if($animal['name'] !== $specie[0]['name']){
                                    echo '<li><a href="' . "https://juanxxiiizoo.infinityfreeapp.com/specie_info.php?id=".$animal['id']. '" >'.$animal['name'].'</a></li>';
                                }
                            }
                            echo "</ul>";
                        }else{
                            echo "Esta especie solo habita con animales de su misma especie en su jaula</p>";
                        } 
                    ?>
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
    
    <!--Boton de compartir exclusivo para usuarios del programa Mini-Zoo-JAVA-->
    <div class="share-buton-container">
        <?php
            if (isset($_GET['ref'])){
                echo '<button type="button" id="share-button"><i class="fa fa-share"></i><span>Compartir<span></button>';
            }
        ?>
    </div>

    <!--Pie de pagina-->
    <?php include "resources/footer.php";?>
    <!--Cargar imagenes y luego mostra pagina-->
    <script>
        window.addEventListener('load', () => {
            document.body.classList.add('visible');
        });
    </script>
    <!--Script del boton de compartir-->
    <script src="javaScript/specie_info.js"></script>
</body>
</html>
