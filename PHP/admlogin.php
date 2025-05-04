<?php 
session_start();

$right_key = "Made-By-LASI-2025";

if($_SERVER["REQUEST_METHOD"] === "POST") {
    if($_POST["key"] === $right_key) {
        $_SESSION["access"] = true;
        header("Location: ../PHP/admin.php");
        exit;
    } else {
        $wrongkey = "Clave Incorrecta";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access</title>
    <link rel="stylesheet" href="../CSS/admlogin.css">
</head>
<body>
    <h2>Ingrese la clave para acceder al panel de administración: </h2>
    <form method="post">
        <input type="password" name="key" required>
        <button type="submit">Acceder</button>
    </form>
    <?php if (isset($wrongkey)) echo "<p>$wrongkey</p>"; ?>
</body>
</html>
