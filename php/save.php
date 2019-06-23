<?php 
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
try {
    // $pdo = new PDO('mysql:host=localhost;dbname=oscool;charset=utf8', 'root', 'root');
    $pdo = new PDO('mysql:host=kraycenter.ru;dbname=a0274741_psih;charset=utf8', 'a0274741', 'wuecpesica');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare($_POST['sql']);
        $stmt = $stmt->execute();
        
        if ($stmt) {
            print_r(json_encode(['status' => 200, 'r' => $stmt]));
        } else print_r(json_encode(['status' => 500, 'reason' => 'Ошибка при сохранении']));

} catch (PDOException $e) {
    print_r(json_encode(['status' => 500, 'reason' => $e]));
}
