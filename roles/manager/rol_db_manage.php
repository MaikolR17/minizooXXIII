<?php
session_start();
require_once '../../login/conex.php';
require_once 'manage_user.php';
require_once "../../resources/server_alert.php";

$conex = new ConexionDB();
$conex->conectar();
$conn = $conex->conex;

if($_SERVER['REQUEST_METHOD']!== 'POST'){
    header("Location: manage_rol.php");
    exit;
}

$username = trim($_POST['username'] ?? "");
$password = trim($_POST['key'] ?? ""); // Asegurate de cifrar esto en el futuro con password_hash
$role_id = intval($_POST['id_role']) ?? "";
$id = intval($_POST['user']) ?? "";
$new_role = intval($_POST['new_role']) ?? "";

if(!empty($password)){
    $hash = password_hash($password,PASSWORD_DEFAULT);
}

$action = $_POST['func'];
switch($action){
    case "add":
        if(!UserManagement::addUser($username,$hash,$role_id,$conn)) setError("No se pudo agregar el nuevo usuario","manage_rol.php");
        setSuccess("Nuevo usuario agregado correctamente.","manage_rol.php");
        break;
    case "update":
        if(!UserManagement::updateUser($new_role,$id,$conn)) setError("No se pudo actualizar el usuario","manage_rol.php");
        setSuccess("Rol del usuario actualizado correctamente","manage_rol.php");
        break;
    case "delete":
        if(!UserManagement::deleteUser($id,$conn)) setError("No se pudo eliminar el usuario","manage_rol.php");
        setSuccess("Usuario eliminado correctamente","manage_rol.php");
        break;
    default:
        echo "Se que no me vas a leer :D";
    }

?>
