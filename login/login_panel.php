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
          header("Location: ../roles/mod/mod.php"); break;
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
  <!-- Logo de pestaña -->
  <link rel="icon" type="image/png" href="../img/LogoPNG.png">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../CSS/admlogin.css" />
  <link rel="stylesheet" href="../CSS/header_role.css" />
  <link rel="stylesheet" href="../CSS/footer.css" />
</head>
<body>
  <!--Encabezado-->
  <?php include "../resources/header.php"; ?>

  

  
    <div class="container">
  <form action="login.php" method="POST">
      <?php if (!empty($error)): ?>
      <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <h2>Iniciar sesión</h2>
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    
    <label>Usuario:</label>
    <input type="text" name="username" required><br><br>
    
    <label>Contraseña:</label>
    <input type="password" name="key" required><br><br>
    
    <button type="submit">Entrar</button>
  </form>
  </div>

  <!--Pie de pagina-->
  <?php include "../resources/footer.php";?>
  <script src="../javaScript/panel_login.js"></script>
</body>
</html>
