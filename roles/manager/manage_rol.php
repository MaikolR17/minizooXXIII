<?php
    require_once "manage_user.php";
    require_once "../../login/conex.php";

    session_start();

    $conex = new ConexionDB();
    $conex->conectar();
    $conn = $conex->conex;

    if (isset($_SESSION['access'])) {
        if (!UserManagement::checkActive($_SESSION['user_id'], $conn)) {
            header("Location: ../../login/login_panel.php");
            exit;
        }
    }

    if (!isset($_SESSION['access']) || $_SESSION['id_role'] != 1) {
        header("Location: ../../login/login_panel.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../../CSS/admlogin.css">
    <!-- Logo de pestaña -->
    <link rel="icon" type="image/png" href="img/LogoPNG.png">
</head>
<body>

    <form method="POST" action="rol_db_manage.php">
        <h1>Gestión de Roles de Usuario</h1>

        <!-- Alertas -->
        <div class="alert-container">
            <?php include "../../resources/cont_alert.php"; ?>
        </div>

        <!-- Acción a realizar -->
        <div class="form-group">
            <label for="func">¿Qué acción quieres realizar?</label>
            <select name="func" id="func" required>
                <option value="add">Crear Usuario</option>
                <option value="update">Modificar rol de usuario</option>
                <option value="delete">Eliminar usuario</option>
            </select>
        </div>

        <!-- Crear usuario -->
        <div class="form-group">
            <label for="username">Nombre del usuario:</label>
            <input type="text" name="username" id="username" placeholder="Ej: jlopez" required>
        </div>

        <div class="form-group">
            <label for="password">Contraseña del usuario:</label>
            <input type="password" name="key" id="password" placeholder="Contraseña segura" required>
        </div>

        <div class="form-group">
            <label for="role_list">Rol asignado:</label>
            <select name="id_role" id="role_list" required>
                <option value="" disabled selected>--Seleccione un rol--</option>
                <option value="1">Supervisor</option>
                <option value="2">Administrador</option>
                <option value="3">Moderador</option>
            </select>
        </div>

        <!-- Modificar / Eliminar usuario -->
        <div class="form-group">
            <label for="user_list">Usuario existente:</label>
            <select name="user" id="user_list" disabled>
                <option value="" disabled selected>--Seleccione un usuario--</option>
            </select>
        </div>

        <div class="form-group">
            <label for="new_role">Nuevo rol para el usuario:</label>
            <select name="new_role" id="new_role" disabled>
                <option value="" disabled selected>--Seleccione un nuevo rol--</option>
                <option value="1">Supervisor</option>
                <option value="2">Administrador</option>
                <option value="3">Moderador</option>
            </select>
        </div>

        <button type="submit" id="submit-btn">Crear usuario</button>
    </form>

    <script src="../../javaScript/manage_rol.js"></script>
</body>
</html>
