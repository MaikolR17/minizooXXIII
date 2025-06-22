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
            header("Location: ../login/login_panel.php");
            exit;
        }
    }

    if(!isset($_SESSION['access']) || $_SESSION['id_role'] !=3 ){
        header("Location: ../login/login_panel.php");
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
    <title>Revision de especies</title>
    
    <link rel="stylesheet" href="../../CSS/admin.css">
    <link rel="stylesheet" href="../../CSS/header.css" />
    <link rel="stylesheet" href="../../CSS/footer.css" /> 
    <link rel="stylesheet" href="../../CSS/header_role.css" />
    <link rel="stylesheet" href="../../CSS/footer_role.css" /> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Logo de pestaña -->
    <link rel="icon" type="image/png" href="https://juanxxiiizoo.infinityfreeapp.com/img/LogoPNG.png">
    
</head>
<body>
    <!--Encabezado-->
    <?php include "../../resources/header.php"; ?>

    <div class="container">
    <!-- Botón para alternar modo oscuro -->
    <button id="btn-darkmode">Modo Oscuro</button>
    <h1 id="titleForm">Formulario de Revision</h1>
    
    <!-- Formulario para agregar, modificar o eliminar especie -->
    <form action="report_process.php" method="POST" enctype="multipart/form-data" id="animal-form">
        <!-- Contenedor de la caja de alertas, donde se informan errores y acciones completadas correctamente -->
        <?php include "../../resources/cont_alert.php";?>
        
        <select name="" id="func" style="display: none;">
            <option value="update" selected>Update</option>
        </select>
        <label for="list-species" id="species-label">Elija un animal registrado:</label>
        <select name="list-species" id="list-species">
            <option value="" disabled selected> --Seleccione una especie-- </option>
            <?php foreach ($list_species as $specie): ?>
                <option value="<?= htmlspecialchars($specie['id']) ?>">
                    <?= htmlspecialchars($specie['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="place" class="input-label">Recinto:</label>
        <input type="number" name = "place" id="place" readonly>
        <label for="name" class="input-label">Nombre Común:</label>
        <input type="text" name="name" id="name" readonly>
        <label for="alt_name" class="input-label">Nombre Alternativo:</label> 
        <input type="text" name="alt_name" id="alt_name" readonly>
        <label for="scient_name" class="input-label">Nombre científico:</label>
        <input type="text" name="scient_name" id="scient_name" readonly>
        <label for="specie_order" class="input-label">Orden:</label>
        <input type="text" name="specie_order" id="specie_order" readonly>
        <label for="family" class="input-label">Familia:</label>
        <input type="text" name="family" id="family" readonly>
        <label for="description" class="input-label">Descripción:</label>
        <textarea name="description" id="description" rows="4" cols="50" readonly></textarea>
        <label for="ecology" class="input-label">Ecología:</label>
        <textarea name="ecology" id="ecology" rows="4" cols="50" readonly></textarea>
        <label for="distribution" class="input-label">Distribución:</label>
        <textarea name="distribution" id="distribution" rows="4" cols="50" readonly></textarea>
        <!--Formulario de reporte-->
        <h2 id="titleForm">Ingrese su reporte:</h2>
        <label for="subject">Asunto:</label>
        <input type="text" id="subject" name="subject" required>
        <label for="report">Escriba aqui su reporte completo:</label>
        <textarea name="report" id="report" rows="4" cols="50"></textarea>
        <label for="img" class="input-label">Adjuntar imagen(Opcional):</label>
        <input type="file" name="img" id="img">
        
        <button type="submit" id="submit-btn">Enviar reporte</button>
    </form>
    </div>

    <!--Pie de pagina-->
    <?php include "../../resources/footer.php";?>

    <script src="../../javaScript/role.js"></script>

    <script type="module" src="../../javaScript/admin.js"></script>
</body>
</html>