<?php 
try {
    // $pdo = new PDO('mysql:host=localhost;dbname=oscool;charset=utf8', 'root', 'root');
    $pdo = new PDO('mysql:host=kraycenter.ru;dbname=a0274741_psih;charset=utf8', 'a0274741', 'wuecpesica');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    ini_set('display_errors','On');
    error_reporting('E_ALL');
    $error = "";

        if ($_POST['table'] == "lessons") {
            
            $result = $pdo->prepare("INSERT INTO $_POST[table] (`id`, `name`, `date`, `time`, `audit`, `povar`, `status`, `users_id`) VALUES (NULL, '$_POST[name]', '$_POST[date]', '$_POST[time]', '$_POST[audit]', '$_POST[povar]', NULL, '')");
            $result = $result->execute();
            
            if ($result) {
                print(json_encode(['status' => 201, 'r' => [
                    'id' => $pdo->lastInsertId(),
                    'name' => $_POST['name'],
                    'time' => $_POST['time'],
                    'date' => $_POST['date'],
                    'audit' => $_POST['audit'],
                    'povar' => $_POST['povar']
                ]]));   
            } else print(json_encode(['status' => 500, 'reason' => 'Ошибка при записи, ' . $pdo->errorInfo()]));
        } else if ($_POST['table'] == 'povars'){
            $result = $pdo->prepare("INSERT INTO $_POST[table] (`id`, `fio`) VALUES (NULL, '$_POST[fio]')");
            $result = $result->execute();
            if ($result) {
                print(json_encode(['status' => 201, 'r' => [
                    'id' => $pdo->lastInsertId(),
                    'fio' => $_POST['fio'],
                ]]));
            } else print(json_encode(['status' => 500, 'reason' => 'Ошибка при записи']));
        } else if ($_POST['table'] == 'users') {
            $result = $pdo->prepare("INSERT INTO `$_POST[table]` (`id`, `fname`, `name`, `groop`, `pass`, `receps`) VALUES ('$_POST[id]', '$_POST[fname]', '$_POST[name]', '$_POST[groop]', '$_POST[pass]', '')");
            $result = $result->execute();
            if ($result) {
                $_SESSION['auth'] = true;
                $_SESSION['user'] = $_POST;
                print(json_encode(['status' => 201, 'r' => [
                    'id' => $pdo->lastInsertId(),
                    'fio' => $_POST['fio'],
                ]]));
            } else print(json_encode(['status' => 500, 'reason' => 'Ошибка при записи']));
        }
} catch (PDOException $e) {
    print_r(json_encode(['status' => 500, 'reason' => $e]));
}

