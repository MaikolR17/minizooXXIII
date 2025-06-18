<?php
  require_once "../roles/manager/manage_user.php";
  require_once "conex.php";

  session_start();

  $conex = new ConexionDB();
  $conex->conectar();
  $conn = $conex->conex;

  if(isset($_SESSION['access'])){
    UserManagement::checkActive($_SESSION['user_id'],$conn);  
  }

if(isset($_SESSION['access'])){
  // Redirigir según rol
  switch ($_SESSION['id_role']) {
      case 1:
          header("Location: ../roles/manager/manage_rol.php"); break;
      case 2:
          header("Location: ../roles/admin/admin.php"); break;
      case 3:
          header("Location: ..roles/mod/mod.php"); break;
  }
  exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión</title>
</head>
<body>
  <h2>Iniciar sesión</h2>

  <?php if (!empty($error)): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
  <?php endif; ?>

  <form action="login.php" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    
    <label>Usuario:</label>
    <input type="text" name="username" required><br><br>
    
    <label>Contraseña:</label>
    <input type="password" name="key" required><br><br>
    
    <button type="submit">Entrar</button>
  </form>
</body>
</html>
