<?php 
session_start();
if ($_SESSION['auth'] == true) {
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'index.php';
	header("Location: http://$host$uri/$extra");
	exit;
}

include('header.php');
?>
<link rel="stylesheet" href="css/reg.css">
<h2>Заполните форму регистриации</h2>
<form>

	<label>№ Зачеткной книжки</label>
	<input type="number" name="id" placeholder="0134">
	<label>Фамилия</label>    
	<input type="text" name="fname" placeholder="Иванов">
	<label>Имя</label>
	<input type="text" name="name" placeholder="Иван">
	<label>Группа</label>
	<input type="text" name="groop" placeholder="9ПКС-33">
	<label>Пароль</label>
	<input type="password" name="pass" placeholder="12dfebae">
	<label>Подтверждение пароля</label>
	<input type="password" id="sp" placeholder="12dfebae">
</form>
<div class="error" hidden>Пароли не совпадают</div>
<button id="reg" onclick="send()">Зарегистрироваться</button>

<script>
	function send() {
		let fd = new FormData(document.forms[0]);
	fd.append('table', 'users')
	if (fd.get('pass') != document.getElementById('sp').value) {
		document.querySelector('.error').removeAttribute('hidden');
		return false;
	} else document.querySelector('.error').setAttribute('hidden', 'true')
	fetch('/php/insertPv.php', {
			method: 'POST',
			body: fd
	}).then(r => r.json()).then(r => {
		if (r.status == 201) {
			window.location = '/index.php'
		}
		});
	}
	

</script>
<?php include('footer.php');

