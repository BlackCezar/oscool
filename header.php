<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Кулинария и все о ней</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/d3d1019b40.js"></script>
</head>
<body>
    <header>
        <div class="img">
            <img src="images/1.jpg" alt="">
        </div>
        <div>
            <div class="title">Курсы и рецепты кулинарии от колледжа отрослевых технологий</div>
            <nav>
                <li><a href="/index.php">Главная</a></li>
                <li><a href="/receps.php">Рецепты</a></li>
                <li><a href="/lessons.php">Уроки</a></li>
                <li><a href="#">Сайт колледжа</a></li>
            </nav>
        </div>
        <?php if (!$_SESSION['auth']) {?>
            <div class="auth">
                <input type="text" id="login" placeholder="№ зачетки">
                <input type="password" id="password" placeholder="Пароль">
                <img src="images/eye.png" onclick="showPass(this)" class="eye" alt="">
                <div>
                    <a href="/reg.php">Регистрация</a>
                    <button onclick="auth()">Войти</button>
                </div>
            </div>
            <?php } else { ?>
                <div class="auth" style="justify-content: center;
align-items: center;">
                    <span>Добрый день, <?php echo $_SESSION['user']['name']; ?></span>
                    <a href="/php/exit.php">Выйти</a>
                </div>
            <?php } ?>
        <script>
            function auth() {
                let fd = new FormData();
                fd.append('id', document.getElementById('login').value);
                fd.append('pass', document.getElementById('password').value);
                fetch('/php/auth.php',{
                    method: "POST",
                    body: fd
                }).then(r => r.json()).then(r => {
                    if (r.status != 200) {
                        alert('Данные неверны')  
                    } else location.reload();
                })
            }
        </script>
    </header>
    <main>
        <div class="content">