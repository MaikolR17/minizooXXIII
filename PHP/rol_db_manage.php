<?php
session_start();
require_once 'conex.php';

$conex = new ConexionDB();
$conex->conectar();
$conn = $conex->conex;

$username = $_POST['username'];
$password = $_POST['key']; // Asegurate de cifrar esto en el futuro con password_hash

//modificar este archivo, que es que esta fallando en logica
$sql = "SELECT * FROM users WHERE username = ? AND `key` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['id_role'];

    // Registrar intento exitoso
    $ip = $_SERVER['REMOTE_ADDR'];
    $log_sql = "INSERT INTO logins (user_id, ip_address, status) VALUES (?, ?, 'success')";
    $log_stmt = $conn->prepare($log_sql);
    $log_stmt->bind_param("is", $user['id'], $ip);
    $log_stmt->execute();

    header("Location: login.php"); // redirigí según rol
    exit;
} else {
    // Registrar intento fallido
    $log_sql = "INSERT INTO logins (user_id, ip_address, status) VALUES (0, ?, 'failed')";
    $log_stmt = $conn->prepare($log_sql);
    $ip = $_SERVER['REMOTE_ADDR'];
    $log_stmt->bind_param("s", $ip);
    $log_stmt->execute();

    echo "Usuario o contraseña incorrecta.";
}
?>
