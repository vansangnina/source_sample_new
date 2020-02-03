<?php
		session_start();
	@define ( '_lib' , '../../libraries/');

	include_once _lib."config.php";
	$d = new database($config['database']);
	include_once _lib."constant.php";
	include_once _lib."functions.php";
	include_once _lib."library.php";
	include_once _lib."pclzip.php";

	
	check_role_admin($_SESSION['login']['role']);
	$id=(int)$_POST['id'];
	$table=strip_tags($_POST['table']);
	$links=$_POST['links'];

	$d->reset();
	$sql = "select id,photo,thumb from #_$table where id='".$id."'";
	$d->query($sql);
	$row = $d->result_array();

	if(count($row)>0){
		for($i=0;$i<count($row);$i++){
			delete_file('../'.$links.$row[$i]['photo']);
			delete_file('../'.$links.$row[$i]['thumb']);
		}
		$sql = "delete from #_$table where id='".$id."'";
		$d->query($sql);
	}
	
?>
