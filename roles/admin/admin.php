<!-- admin.php -->
<?php 
    require_once "../manager/manage_user.php";
    require_once "../../login/conex.php";

    session_start();

    $conex = new ConexionDB();
    $conex->conectar();
    $conn = $conex->conex;

    if(isset($_SESSION['access'])){
        if(!UserManagement::checkActive($_SESSION['user_id'],$conn)){
            header("Location: ../../login/login_panel.php");
            exit;
        }
    }

    if(!isset($_SESSION['access']) || $_SESSION['id_role'] !=2 ){
        header("Location: ../../login/login_panel.php");
    }

// Leer las especies desde la base de datos
$list_species = [];

$conex = new ConexionDB();
$conex->conectar();
$conn = $conex->conex;

$sql = "SELECT id, name FROM especies ORDER BY name ASC"; 
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $list_species[] = $row;
    }
} else {
    $list_species = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de especies</title>
    <link rel="stylesheet" href="../../CSS/admin.css">
    <!-- Logo de pestaña -->
    <link rel="icon" type="image/png" href="img/LogoPNG.png">
</head>
<body>
    <!-- Botón para alternar modo oscuro -->
    <button id="btn-darkmode">Modo Oscuro</button>
    <h1 id="titleForm">Formulario de Especies</h1>
    
    <!-- Formulario para agregar, modificar o eliminar especie -->
    <form action="../PHP/CRUD.php" method="POST" enctype="multipart/form-data" id="animal-form">
        <!-- Contenedor de la caja de alertas, donde se informan errores y acciones completadas correctamente -->
        <?php include "../../resources/cont_alert.php";?>
        
        <!-- Selección de la lista de acción a realizar -->
        <label for="functionality">¿Qué acción quieres realizar?</label>
        <select name="functionality" id="func" required>
            <option value="add">Agregar</option>
            <option value="update">Modificar</option>
            <option value="delete">Eliminar</option>
        </select>
        
        <!-- Selección de especie para modificar o eliminar -->
        <label for="list-species" id="species-label">Elija un animal registrado:</label>
        <select name="list-species" id="list-species" onchange="loadAnimal(this.value)"disabled>
            <option value="" disabled selected> --Seleccione una especie-- </option>
            <?php foreach ($list_species as $specie): ?>
                <option value="<?= htmlspecialchars($specie['id']) ?>">
                    <?= htmlspecialchars($specie['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="place" class="input-label">Recinto:</label>
        <input type="number" name = "place" id="place" data-valid="true">
        <label for="name" class="input-label">Nombre Común:</label>
        <input type="text" name="name" id="name" data-valid="false" required>
        <label for="alt_name" class="input-label">Nombre Alternativo:</label> 
        <input type="text" name="alt_name" id="alt_name" data-valid="true">
        <label for="scient_name" class="input-label">Nombre científico:</label>
        <input type="text" name="scient_name" id="scient_name" data-valid="true">
        <label for="specie_order" class="input-label">Orden:</label>
        <input type="text" name="specie_order" id="specie_order" data-valid="false" required>
        <label for="family" class="input-label">Familia:</label>
        <input type="text" name="family" id="family" data-valid="false" required>
        <label for="description" class="input-label">Descripción:</label>
        <textarea name="description" id="description" rows="4" cols="50" data-valid="false" required></textarea>
        <label for="ecology" class="input-label">Ecología:</label>
        <textarea name="ecology" id="ecology" rows="4" cols="50" data-valid="false" required></textarea>
        <label for="distribution" class="input-label">Distribución:</label>
        <textarea name="distribution" id="distribution" rows="4" cols="50" data-valid="false" required></textarea>
        <label for="img" class="input-label">Imagen de Referencia:</label>
        <input type="file" name="img" id="img" data-valid="false">
        
        <!--Agregar textarea exclusivo para moderadores-->
        <button type="submit" id="submit-btn">Agregar Especie</button>
    </form>

    <script type="module" src="../../javaScript/admin.js"></script>
    <script type="module" src="../../javaScript/client_side_validation.js"></script>
</body>
</html>