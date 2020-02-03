<?php
	session_start();
	@define ( '_lib' , '../../libraries/');

	include_once _lib."config.php";
	$d = new database($config['database']);
	include_once _lib."constant.php";
	include_once _lib."functions.php";
	include_once _lib."library.php";
	include_once _lib."pclzip.php";
	$com = (isset($_REQUEST['com'])) ? addslashes($_REQUEST['com']) : "";
	$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";	
	
	check_role_admin($_SESSION['login']['role']);
	$table = strip_tags($_POST['table']);
	$id = (int)$_POST['id'];
	$value = (int)$_POST['value'];

	$data['soluong'] = $value;
	$d->reset();
	$d->setTable($table);
	$d->setWhere('id', $id);
	$d->update($data);


?>
	
	