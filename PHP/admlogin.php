<?php 
session_start();

function admlogin($adminName){
    $_SESSION['access'] = true;
    $_SESSION['admin'] = $adminName;
    header("Location: admin.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] === "POST") {
    if($_POST["key"] === "0405_Oscar") {
        admlogin("Oscar Fretes");
    }else if($_POST["key"] === "5456_Yosy"){
        admlogin("Yoselyn Fretes");
    }else if($_POST["key"] === "1289_Ceraso"){
        admlogin("Jonathan Ceraso");
    }else if($_POST["key"] === "2037_Jazmin"){
        admlogin("Jazmin Fernandez");
    }else if($_POST["key"] === "5868_Emanuel"){
        admlogin("Emanuel Castelvi");
    }else if($_POST["key"] === "4235_Alexix"){
        admlogin("Alexis Franco");
    }else if($_POST["key"] === "8821_Admin07"){
        admlogin("Admin07");
    }else if($_POST["key"] === "6697_Admin08"){
        admlogin("Admin08");
    }else if($_POST["key"] === "7275_Admin09"){
        admlogin("Admin09");
    }else if($_POST['key'] === "Made-By-LASI-2025"){
        $_SESSION['access'] = true;
        $_SESSION['admin'] = "Anonimo";
        header("Location: admin.php");
        exit;
    }
    else {
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
