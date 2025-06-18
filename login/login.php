<?php
require_once "conex.php";
$conex = new ConexionDB();
$conex->conectar();
$conn = $conex->conex;

session_start();

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: login_panel.php");
    exit;
}
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

//verificar si la tabla de usuarios esta vacia y asignar el primer registro como rol Supervisor
$sql = "SELECT COUNT(*) AS total FROM users";
$rs = mysqli_query($conn,$sql);
if($rs){  
    $row = mysqli_fetch_assoc($rs);  
        if($row['total'] == 0){   
            $hash = password_hash($password,PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username,user_key,id_role) VALUES (?,?,1)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss",$username,$hash);
            if($stmt->execute()){
                echo "realizado con exito";
            }else{
                setError("Ocurrio un error en la base de datos","login_panel.php");
            }

        }
}

// Buscar usuario
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Verificar contraseña
$is_valid = $user && password_verify($password, $user['user_key']);
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
    $_SESSION['id_role'] = intval($user['id_role']);
    $_SESSION['access'] = true;
    header("Location: login_panel.php");
    exit;

} else {
    $_SESSION['error'] = "Usuario o clave incorrectos.";
    header("Location: login_panel.php");
    exit;
}
?>
