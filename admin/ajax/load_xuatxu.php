<?php  
	session_start();
	@define ( '_lib' , '../../libraries/');
	include_once _lib."config.php";
	$d = new database($config['database']);
	include_once _lib."constant.php";
	include_once _lib."functions.php";
	
	check_role_admin($_SESSION['login']['role']);
	if(!empty($_POST)){
		$id = (int)$_POST['id'];
		$d->reset();
		$d->setTable("product_list");
		$d->setWhere("id",$id);
		$d->select("xuatxu");
		$xuatxu = $d->fetch_array();
		if($xuatxu['xuatxu']!=''){
			$d->reset();
			$d->query("select ten_vi,id from #_tags where id IN(".$xuatxu['xuatxu'].") and hienthi=1 order by stt,id desc");
			$arr_xuatxu = $d->result_array();
			echo "<option>Chọn xuất xứ</option>";
			foreach ($arr_xuatxu as $key => $value) { 
?>
	<option value="<?=$value['id']?>"><?=$value['ten_vi']?></option>
<?php
			}
		}

	}
?>