<?php
session_start();
session_destroy();

header("Location: ../frontend/tela_login.php");
exit;
?>

