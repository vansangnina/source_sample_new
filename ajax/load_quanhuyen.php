<?php
	session_start();
	@define ( '_lib' , '../libraries/');
	@define ( '_source' , '../sources/');
    $lang = "vi";
	include_once _lib."config.php";
	include_once _lib."functions.php";
	$d = new database($config['database']);
	include_once _source."lang_$lang.php";
	
	$id_list = (int)$_POST['id'];
	$d->reset();
	$d->query("select ten_$lang as ten,id from #_place_dist where hienthi=1 and id_list ='".$id_list."' order by id asc");
	$quanhuyen = $d->result_array();
	echo "<option value=''>Quận huyện</option>";
	foreach ($quanhuyen as $key => $value) {
		echo "<option value='".$value['id']."'>".$value['ten']."</option>";
	}
?>