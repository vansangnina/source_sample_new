
<?php	if(!defined('SOURCE')) { die("Error"); }

switch($act){
	case "man":
		get_items();
		$template = "com/items";
		break;
	case "add":
		$template = "com/item_add";
		break;
	case "edit":
		get_item();
		$template = "com/item_add";
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
	global $d, $items, $paging;

	$sql = "select * from #_com order by id asc";
	$d->query($sql);
	$items = $d->result_array();
}

function get_item(){
	global $d, $item;
	$id = isset($_GET['id']) ? (int)($_GET['id']) : "";
	if(!$id){
		transfer("Không nhận được dữ liệu", "index.php?com=com&act=man");
	}
	
	$sql = "select * from #_com where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=com&act=man");
	$item = $d->fetch_array();
}

function save_item(){
	global $d,$type;

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=com&act=man");
	$id = isset($_POST['id']) ? (int)($_POST['id']) : "";
	if($id){
		
		$data['ten'] = $d->escape_str($_POST['ten']);
		$data['ten_com'] = $d->escape_str($_POST['ten_com']);
		$data['act_com'] = $d->escape_str($_POST['act_com']);
		$data['type'] = $type;
		$data['act'] = $d->escape_str($_POST['act']);
		$data['danhmuc'] = isset($_POST['danhmuc']) ? 1 : 0;

		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$d->reset();
		$d->setTable('com');
		$d->setWhere('id', $id);
		if($d->update($data)){
			transfer("Dữ liệu đã được cập nhật", "index.php?com=com&act=man");
		}else{
			transfer("Cập nhật dữ liệu bị lỗi ", "index.php?com=com&act=man");
		}
	}else{

		$data['ten'] = $d->escape_str($_POST['ten']);
		$data['ten_com'] = $d->escape_str($_POST['ten_com']);
		$data['act_com'] = $d->escape_str($_POST['act_com']);
		$data['type'] = $type;
		$data['act'] = $d->escape_str($_POST['act']);

		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['danhmuc'] = isset($_POST['danhmuc']) ? 1 : 0;
		$d->reset();
		$d->setTable('com');
		if($d->insert($data)){
			transfer("Dữ liệu đã được lưu", "index.php?com=com&act=man");
		}else{
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=com&act=man");
		}
	}
}

function delete_item(){
	global $d;
	if(isset($_GET['id'])){
			$id =  (int)($_GET['id']);
			$sql = "delete from #_com where id='".$id."'";
			$d->query($sql);
		if($d->query($sql)){
			transfer("Xóa dữ liệu thành công", "index.php?com=com&act=man");
		}else{
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=com&act=man");
		}
	}else {transfer("Không nhận được dữ liệu", "index.php?com=com&act=man");}
?>
