<!-- admin.php -->
<?php 
session_start();
// Verificar si el usuario tiene acceso, si no redirigir al login
if (!isset($_SESSION["access"])) {
    header("Location: admlogin.php");
    exit;
}

// Cargar la lista de especies desde el archivo JSON
$file = '../species.json';
$list_species = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="../CSS/admin.css">
</head>
<body>
    <!-- Botón para alternar modo oscuro -->
    <button id="btn-darkmode">Modo Oscuro</button>
    <h1 id="titleForm">Formulario de Especies</h1>
    
    <!-- Formulario para agregar, modificar o eliminar especie -->
    <form action="CRUD.php" method="POST" enctype="multipart/form-data" id="animal-form">
        <!-- Contenedor de la caja de alertas, donde se informan errores y acciones completadas correctamente -->
        <div class="cont-alert">
            <?php
            // Mostrar mensajes de estado (éxito/error)
            if (isset($_SESSION['status'])) {
                if ($_SESSION['status'] === "error") {
                    echo "<p class=\"error\">".$_SESSION['message'].'</p>';
                } else {
                    echo "<p class=\"success\">".$_SESSION['message'].'</p>';
                }
                unset($_SESSION['status']);
                unset($_SESSION['message']);
            }
            ?>
        </div>
        
        <!-- Selección de la lista de acción a realizar -->
        <label for="functionality">¿Qué acción quieres realizar?</label>
        <select name="functionality" id="func" required>
            <option value="add">Agregar</option>
            <option value="update">Modificar</option>
            <option value="delete">Eliminar</option>
            <option value="downloadQR">Descargar QR</option>
        </select>
        
        <!-- Selección de especie para modificar o eliminar -->
        <label for="list-species" id="species-label">Elija un animal registrado:</label>
        <select name="list-species" id="list-species" disabled>
            <option value="" disabled selected> --Seleccione una especie-- </option>
            <?php foreach ($list_species as $specie): ?>
                <option value="<?= htmlspecialchars($specie['id']) ?>">
                    <?= htmlspecialchars($specie['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Campos para ingresar o modificar los datos -->
        <label for="place" class="input-label">Recinto:</label>
        <input type="number" name = "place" id="place">
        <label for="name" class="input-label">Nombre Común:</label>
        <input type="text" name="name" id="name">
        <label for="alt_name" class="input-label">Nombre Alternativo:</label> 
        <input type="text" name="alt_name" id="alt_name">
        <label for="scient_name" class="input-label">Nombre científico:</label>
        <input type="text" name="scient_name" id="scient_name">
        <label for="order" class="input-label">Orden:</label>
        <input type="text" name="order" id="order">
        <label for="family" class="input-label">Familia:</label>
        <input type="text" name="family" id="family">
        <label for="description" class="input-label">Descripción:</label>
        <textarea name="description" id="description" rows="4" cols="50"></textarea>
        <label for="ecology" class="input-label">Ecología:</label>
        <textarea name="ecology" id="ecology" rows="4" cols="50"></textarea>
        <label for="distribution" class="input-label">Distribución:</label>
        <textarea name="distribution" id="distribution" rows="4" cols="50"></textarea>
        <label for="img" class="input-label">Imagen de Referencia:</label>
        <input type="file" name="img" id="img">
        
        <button type="submit" id="submit-btn">Agregar Especie</button>
    </form>

    <script src="../javaScript/admin.js"></script>
</body>
</html>