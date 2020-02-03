<?php 
	session_start();
	@define ( 'LIBRARIES' , '../../libraries/');
	include_once LIBRARIES."config.php";
	$d = new database($config['database']);
	include_once LIBRARIES."constant.php";
	include_once LIBRARIES."functions.php";
	
	check_role_admin($_SESSION['login']['role']);

	if (isset($_POST["level"])) {
		$level = (int)$_POST["level"];
		$table = (string)$_POST["table"];
		$id = (int)$_POST["id"];
		$type = (string)$_POST["type"];
		switch ($level) {
			case '0':{
				$id_temp= "id_list";
				break;
			}
			case '1':{
				$id_temp= "id_cat";
				break;
			}
			case '2':{
				$id_temp= "id_item";
				break;
			}
			default:
				echo 'error ajax'; exit();
				break;
		}
		$d->reset();
		$d->query("select id,ten_vi from ".$table." where $id_temp=".$id." and type='".$type."' order by stt");
		$result = $d->result_array();
		$str='<option>Chọn danh mục</option>';
		foreach ($result as $key => $row) {
			if($row["id"]==(int)@$id_select)
				$selected="selected";
			else 
				$selected="";
			$str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten_vi"].'</option>';	
		}
		echo  $str;		
	}
?>
