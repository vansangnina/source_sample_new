<?php 
	session_start();
	@define ( 'LIBRARIES' , '../../libraries/');
	include_once LIBRARIES."config.php";
	$d = new database($config['database']);
	include_once LIBRARIES.'functions.php';
	
	check_role_admin($_SESSION['login']['role']);
	if(isset($_POST["id"])){
		$table = strip_tags($_POST["bang"]);
		$value = $_POST["value"];
		$id = (int)$_POST["id"];
		$sql = "update ".$table." SET ".$_POST["type"]."=".$value." WHERE  id = ".$id."";
		$d->reset();
		$data = $d->query($sql);
	}
?>