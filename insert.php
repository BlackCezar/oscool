<?php 
session_start();
try {
    // $pdo = new PDO('mysql:host=localhost;dbname=oscool;charset=utf8', 'root', 'root');
    $pdo = new PDO('mysql:host=kraycenter.ru;dbname=a0274741_psih;charset=utf8', 'a0274741', 'wuecpesica');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    ini_set('display_errors','On');
    error_reporting('E_ALL');
    $error = "";


        $img_path = getImgPath();
        $video_path = getVideoPath();
        if ($error != "" || ($img_path == "" & $_FILES['img_src']["size"] > 0) || ($video_path == "" && $_FILES['video_src']["size"] > 0)) {
            print(json_encode(['status' => 500, 'reason' => $error]));
        } else {
            $result = $pdo->prepare("INSERT INTO `receps` (`id`, `name`, `desc`, `video_src`, `lesson_id`, `ingridents`, `img_src`, `makelist`) VALUES (NULL, '$_POST[name]', '$_POST[desc]', '$video_path', '$_POST[lesson_id]', '$_POST[ingridents]', '$img_path', '$_POST[makelist]')");
            $result = $result->execute();
            if ($result) {
                print(json_encode(['status' => 201, 'r' => [
                    'id' => $pdo->lastInsertId(),
                    'name' => $_POST['name'],
                    'desc' => $_POST['desc'],
                    'lesson_id' => $_POST['lesson_id'],
                    'makelist' => $_POST['makelist'],
                    'ingridents' => $_POST['ingridents'],
                    'video_src' => $video_path,
                    'img_src' => $img_path
                ]]));
            } else print(json_encode(['status' => 500, 'reason' => 'Ошибка при записи']));
        }
        // print(json_encode(['errors' => $error ]));
} catch (PDOException $e) {
    json_encode(['status' => 500, 'reason' => $e]);
}


function getImgPath() {
    if ($_FILES["img_src"]["name"] != "") {
        $name = basename($_FILES["img_src"]["name"]);
        $tmp_name = $_FILES["img_src"]["tmp_name"];
        $uploaddir = '/app/uploads/img/';
        if (move_uploaded_file($tmp_name, $uploaddir . $name)) {
            return "/uploads/img/" . $name;
        } else {
            if ($_FILES['img_src']["size"] > 0) $error = $_FILES["img_src"]["error"] || "Не загрузилось изображение";
            return "";
        }
    }
}

function getVideoPath() {
    if ($_FILES["video_src"]["name"] != "") {
        $name = basename($_FILES["video_src"]["name"]);
        $tmp_name = $_FILES["video_src"]["tmp_name"];
        $uploaddir = '/app/uploads/video/';
        if (move_uploaded_file($tmp_name, $uploaddir . $name)) {
            return "/uploads/video/" . $name;
        } else {
            if ($_FILES['video_src']["size"] > 0) $error = $_FILES["video_src"]["error"] || "Не загрузилось видео";
            return "";
        }
    }
}

