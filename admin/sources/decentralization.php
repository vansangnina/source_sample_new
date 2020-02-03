<?php	if(!defined('SOURCE')) { die("Error"); }

switch($act){
	case "man":
		get_items();
		$template = "decentralization/items";
		break;
	case "add":
		$template = "decentralization/item_add";
		break;
	case "edit":
		get_item();
		$template = "decentralization/item_add";
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
	global $d, $items, $paging,$page;
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_phanquyen order by stt ";
	$d->reset();
	$d->query("select * from $where $limit");
	$items = $d->result_array();

	$url = getCurrentPageURL();

	$paging = pagination($where,$per_page,$page,$url);

}

function get_item(){
	global $d, $item;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	if($id==0){
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
	$d->reset();
	$d->query("select * from #_phanquyen where id='".$id."'");
	if($d->num_rows()==0) {
		transfer("Dữ liệu không có thực", $_SESSION['links_re']);
	}
	$item = $d->fetch_array();
}

function save_item(){
	global $d;
	
	if(empty($_POST)) {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
	
	if($id > 0){

		if(!empty($_POST['permiss'])){
			$data['permission'] = strip_tags(implode(',',$_POST['permiss']));
		}
		$data['ten'] = $d->escape_str($_POST['ten']);
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		$d->reset();
		$d->setTable('phanquyen');
		$d->setWhere('id', $id);
		if($d->update($data)){
			transfer("Dữ liệu đã được cập nhật", $_SESSION['links_re']);
		}
		else{
			transfer("Cập nhật dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}else{
		if(!empty($_POST['permiss'])){
			$data['permission'] = strip_tags(implode(',',$_POST['permiss']));
		}
		$data['ten'] = $d->escape_str($_POST['ten']);
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->reset();
		$d->setTable('phanquyen');
		if($d->insert($data)){
			transfer("Dữ liệu đã được lưu", $_SESSION['links_re']);
		}
		else{
			transfer("Lưu dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}
}

function delete_item(){
	global $d;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	if($id > 0){
		$sql = "delete from #_phanquyen where id='".$id."'";
		if($d->query($sql)){
			transfer("Dữ liệu đã được xóa", $_SESSION['links_re']);
		}
		else{
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}


?>