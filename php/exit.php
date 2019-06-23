<?php 
session_start();
unset($_SESSION['admin']);
unset($_SESSION['auth']);
unset($_SESSION['user']);
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = '../index.php';
header("Location: http://$host$uri/$extra");
exit;