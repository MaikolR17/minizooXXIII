<?php
session_start();
require_once 'conex.php';

$conex = new ConexionDB();
$conex->conectar();
$conn = $conex->conex;

// Verificar token CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['error'] = 'Token CSRF inválido.';
    header("Location: login_panel.php");
    exit;
}

// Limpiar entradas
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['key'] ?? '');
$ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

// Validar entradas
if (empty($username) || empty($password)) {
    $_SESSION['error'] = 'Todos los campos son obligatorios.';
    header("Location: login_panel.php");
    exit;
}

// Buscar usuario
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Verificar contraseña
$is_valid = $user && password_verify($password, $user['key']);
$status = $is_valid ? 'success' : 'failed';
$user_id = $is_valid ? $user['id'] : null;

// Registrar intento en tabla logins
$log_sql = "INSERT INTO logins (user_id, ip_address, status) VALUES (?, ?, ?)";
$log_stmt = $conn->prepare($log_sql);
$log_stmt->bind_param("iss", $user_id, $ip, $status);
$log_stmt->execute();

if ($is_valid) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['id_role'];

    // Redirigir según rol
    switch ($user['id_role']) {
        case 1:
            header("Location: manage_rol.php"); break;
        case 2:
            header("Location: admin.php"); break;
        default:
            header("Location: login_panel.php");
    }
    exit;
} else {
    $_SESSION['error'] = "Usuario o clave incorrectos.";
    header("Location: login_panel.php");
    exit;
}
