<?php if(!defined('SOURCE')){ die("Error"); }
switch($act){
	case "man":
		get_items();
		$template = "yahoo/items";
		break;
	case "add":
		$template = "yahoo/item_add";
		break;
	case "edit":
		get_item();
		$template = "yahoo/item_add";
		break;
	case "save":
		save_item();
		break;
	case "delete":
		delete_item();
		break;
		
	default:
		$template = "index";
}


function get_items(){
	global $d, $items,$paging,$page;
	
	if(!empty($_POST)){
		$multi=$_REQUEST['multi'];
		$id_array=$_POST['iddel'];
		$count=count($id_array);
		if($multi=='show'){
			for($i=0;$i<$count;$i++){
				$sql = "UPDATE table_yahoo SET hienthi =1 WHERE  id = ".$id_array[$i]."";
				$d->query($sql) or die("Not query sqlUPDATE_ORDER");				
			}
			redirect("index.php?com=yahoo&act=man");			
		}
		
		if($multi=='hide'){
			for($i=0;$i<$count;$i++){
				$sql = "UPDATE table_yahoo SET hienthi =0 WHERE  id = ".$id_array[$i]."";
				$d->query($sql) or die("Not query sqlUPDATE_ORDER");				
			}
			redirect("index.php?com=yahoo&act=man");			
		}
		
		if($multi=='del'){
			for($i=0;$i<$count;$i++){							
				$sql = "delete from table_yahoo where id = ".$id_array[$i]."";
				$d->query($sql) or die("Not query sqlUPDATE_ORDER");			
							
			}
			redirect("index.php?com=yahoo&act=man");			
		}				
	}
	
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_yahoo ";
	$where .= " where id <> 0";	

	$where.=" order by id desc ";				
	
	$sql = "select * from $where $limit";		
	$d->query($sql);
	$items = $d->result_array();
	$url = getCurrentPageURL();
	$paging = pagination($where,$per_page,$page,$url);		
}

function get_item(){
	global $d, $item;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=yahoo&act=man");
	
	$sql = "select * from #_yahoo where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=yahoo&act=man");
	$item = $d->fetch_array();
}

function save_item(){
	global $d;
	
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=yahoo&act=man");
	$id = isset($_POST['id']) ? (int)$_POST['id'] : "";

	$data=process_quote($_POST['data']);
	if($id){ // cap nhat
		
		$data['dienthoai'] = $d->escape_str($_POST['dienthoai']);
		$data['email'] = $d->escape_str($_POST['email']);
		$data['yahoo'] = $d->escape_str($_POST['yahoo']);
		$data['skype'] = $d->escape_str($_POST['skype']);
		$data['stt'] = (int)$_POST['num'];
		$data['hienthi'] = isset($_POST['active']) ? 1 : 0;
		$data['ngaysua'] = time();
		
		$d->setTable('yahoo');
		$d->setWhere('id', $id);
		if($d->update($data))
			header("Location:index.php?com=yahoo&act=man");
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=yahoo&act=man");
	}else{ // them moi
		$data['dienthoai'] = $d->escape_str($_POST['dienthoai']);
		$data['email'] = $d->escape_str($_POST['email']);
		$data['yahoo'] = $d->escape_str($_POST['yahoo']);
		$data['skype'] = $d->escape_str($_POST['skype']);
		$data['stt'] = (int)$_POST['num'];
		$data['hienthi'] = isset($_POST['active']) ? 1 : 0;
		$data['ngaytao'] = time();
		
		$d->setTable('yahoo');
		if($d->insert($data))
			header("Location:index.php?com=yahoo&act=man");
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=yahoo&act=man");
	}
}

function delete_item(){
	global $d;
	
	if(isset($_GET['id'])){
		$id =  (int)$_GET['id'];
		
		
		// xoa item
		$sql = "delete from #_yahoo where id='".$id."'";
		if($d->query($sql))
			header("Location:index.php?com=yahoo&act=man");
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=yahoo&act=man");
	}else transfer("Không nhận được dữ liệu", "index.php?com=yahoo&act=man");
}
#--------------------------------------------------------------------------------------------- photo
?>