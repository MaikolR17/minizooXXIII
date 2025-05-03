<?php
session_start();
session_destroy();
header("Location: adm-login.php");
exit;
?>