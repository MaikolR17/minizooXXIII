<?php
session_start();

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

  <?php if ($error): ?>
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
