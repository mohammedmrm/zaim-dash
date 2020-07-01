<?php
session_start();
session_destroy();
setcookie('username_d','', time() + (86400 * 30), "/");
setcookie('password_d','', time() + (86400 * 30), "/");
header("location: ../login.php");
?>