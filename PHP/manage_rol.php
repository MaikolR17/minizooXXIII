
<!--
En este formulario, se podra añadir staff al programa.
Clave | Nombre de usuario
 2025 | Made-By-LASI-2do
 0405 | Oscar Fretes
 5456 | Yoselyn Fretes
 1289 | Jonathan Ceraso
 2037 | Jazmin Fernandez
 5868 | Emanuel Castelvi
 4235 | Alexis Franco
 8821 | Fernando Salcedo
 6697 | Adrihan Diaz
 7275 | Sebastian Stumps
 0025 | Soledad Caballero
-->

<?php
require_once 'conex.php';

$conex = new ConexionDB();
$conex->conectar();
$conn = $conex->conex;

$roles = [];
$sql = "SELECT id, nombre FROM roles";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $roles[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Access</title>
    <link rel="stylesheet" href="../CSS/admlogin.css">
</head>
<body>
    <h2>Ingrese la clave para acceder al panel de administración:</h2>

    <form method="POST" action="rol_db_manage.php">
        <input type="text" name="username" placeholder="Usuario nuevo" required>
        <input type="text" name="key" placeholder="Contraseña" required>
        <select name="id_role" required>
            <option value="">Seleccione un rol</option>
            <option value="1">Supervisor</option>
            <option value="2">Administrador</option>
        </select>

        <button type="submit">Crear usuario</button>
    </form>
</body>
</html>