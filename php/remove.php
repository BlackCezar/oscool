<?php 
try {
    // $pdo = new PDO('mysql:host=localhost;dbname=oscool;charset=utf8', 'root', 'root');
    $pdo = new PDO('mysql:host=kraycenter.ru;dbname=a0274741_psig;charset=utf8', 'a0274741', 'wuecpesica');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  
        $id = intval($_GET['id']);
        $table = $_GET['table'];
        $stmt = $pdo->prepare( "DELETE FROM `$table` WHERE `id` = $id" );
        $res = $stmt->execute();
        if ($res) {
            print(json_encode(['status' => 200, 'r' => $res]));
        } else print(json_encode(['status' => 500, 'reason' => 'Ошибка при записи']));
            

} catch (PDOException $e) {
    print_r(json_encode(['status' => 500, 'reason' => $e]));
}
