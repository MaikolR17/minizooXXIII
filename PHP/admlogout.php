<?php
session_start();
session_destroy();
header("Location: admlogin.php");
exit;
?>