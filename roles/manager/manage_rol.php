
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
    require_once "manage_user.php";
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

    if(!isset($_SESSION['access']) || $_SESSION['id_role'] !=1 ){
        header("Location: ../../login/login_panel.php");
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestion de usuarios</title>
    <link rel="stylesheet" href="../../CSS/admlogin.css">
    <!-- Logo de pestaña -->
    <link rel="icon" type="image/png" href="img/LogoPNG.png">
</head>
<body>

    <form method="POST" action="rol_db_manage.php">
        <!--Incluir alerta de error/acierto-->
        <?php include "../../resources/cont_alert.php";?>
        <h1>Formulario de gestion de roles</h1>

        <label for="func">¿Que acción quieres realizar?</label>
        <select name="func" id="func">
            <option value="add">Crear Usuario</option>
            <option value="update">Modificar rol de usuario</option>
            <option value="delete">Eliminar usuario</option>
        </select>
        <label for="username">Nombre del usuario</label>
        <input type="text" name="username" placeholder="Usuario nuevo" id="username" required>
        <label for="password">Contraseña del usuario</label>
        <input type="text" name="key" placeholder="Contraseña" id="password" required>
        <label for="role_list">Seleccione el rol:</label>
        <select name="id_role" id="role_list" required>
            <option value="" selected disabled>--Seleccione una opcion--</option>
            <option value="1">Supervisor</option>
            <option value="2">Administrador</option>
            <option value="3">Moderador</option>
        </select>
        <label for="user_list">Seleccione el usuario:</label>
        <select name="user" id="user_list" disabled>
            <option value="" selected disabled>--Seleccione una opcion--</option>
        </select>
        <label for="new_role">Seleccione nuevo rol para el usuario:</label>
        <select name="new_role" id="new_role" disabled>
            <option value="" selected disabled>--Seleccione una opcion</option>
            <option value="1">Supervisor</option>
            <option value="2">Administrador</option>
            <option value="3">Moderador</option>
        </select>

        <button type="submit" id="submit-btn">Crear usuario</button>
    </form>

    <script src="../../javaScript/manage_rol.js"></script>
</body>
</html>