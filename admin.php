<?php include('header.php'); 
if ($_SESSION['admin'] != true) {
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'index.php';
	header("Location: http://$host$uri/$extra");
	exit;
}?>

<link rel="stylesheet" href="css/admin.css">

    <div class="tabs">
    	<input id="tab1" type="radio" name="tabs" checked>
    	<label for="tab1" title="Вкладка 1"><i class="far fa-plus-square" style="margin-right: 1vw;"></i>Создать рецепт</label>
 
		<input id="tab2" type="radio" name="tabs">
		<label for="tab2" title="Вкладка 2"><i class="fas fa-list" style="margin-right: 1vw;"></i>Рецепты</label>
 
		<input id="tab3" type="radio" name="tabs">
		<label for="tab3" title="Вкладка 3"><i class="far fa-plus-square" style="margin-right: 1vw;"></i>Добавить урок</label>
 
		<input id="tab4" type="radio" name="tabs">
		<label for="tab4" title="Вкладка 4"><i class="fas fa-list" style="margin-right: 1vw;"></i>Уроки</label>
	
		<input id="tab5" type="radio" name="tabs">
		<label for="tab5" title="Вкладка 5"><i class="fas fa-user" style="margin-right: 1vw;"></i>Повара</label>
		<?php include('admin-receps.html'); ?>
		
		<?php include('admin-lessons.html'); ?>
    
		<?php include('admin-povars.html'); ?>
	</div>
</div>

<script src="js/vue.js"></script>
<script src="js/admin.js"></script>
<?php include('footer.php');