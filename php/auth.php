<?php
session_start();

        $pdo = new PDO('mysql:host=kraycenter.ru;dbname=a0274741_psih;charset=utf8', 'a0274741', 'wuecpesica');
    // $pdo = new PDO('mysql:host=localhost;dbname=oscool;charset=utf8', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    ini_set('display_errors','On');
    error_reporting('E_ALL');
    if ($_POST['id'] == 'root' && $_POST['pass'] == 'root') {
        $_SESSION['auth'] = true;
        $_SESSION['admin'] = true;
        print(json_encode(['status' => 200]));
    } else {
        $result = $pdo->query('SELECT * FROM `users`');
        $result = $result->fetchAll();
        foreach($result as $user) {
            if ($user['id'] == $_POST['id']) {
                if ($user['pass'] == $_POST['pass']) {
                    $_SESSION['auth'] = true;
                    $_SESSION['user'] = $user;
                    print(json_encode(['status' => 200]));
                    break;
                } 
            }  
        }
        if (!$_SESSION['auth']) print(json_encode(['status' => 401]));

    }
      