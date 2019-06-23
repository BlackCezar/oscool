<?php 

// $pdo = new PDO('mysql:host=localhost;dbname=oscool;charset=utf8', 'root', 'root');
$pdo = new PDO('mysql:host=kraycenter.ru;dbname=a0274741_psih;charset=utf8', 'a0274741', 'wuecpesica');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$result = $pdo->query("SELECT * FROM `$_GET[table]`");
$result = $result->fetchAll();
print(json_encode($result));