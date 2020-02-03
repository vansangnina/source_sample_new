<?php	if(!defined('SOURCE')){ die("Error"); }
switch($act){

	
	case "man":
		get_mans();
		$template = "lang/items";
		break;
	case "add":		
		$template = "lang/item_add";
		break;
	case "edit":
		get_man();
		$template = "lang/item_add";
		break;
	case "save":
		save_man();
		break;
	case "delete":
		delete_man();
		break;	
	#============================================================

	default:
		$template = "index";
}

#====================================
function get_mans(){
	global $d, $items, $paging,$page,$keyword;
	
	
	
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_lang ";
	$where .= " where type='lang'";

	if($keyword!='')
	{
		
		$where.=" and define='".$keyword."'";
		$link_add .= "&keyword=".$keyword;
	}
	$where .=" order by id desc";

	$sql = "select define,lang_vi,lang_en,hienthi,id from $where $limit";
	$d->query($sql);
	$items = $d->result_array();

	$url = "index.php?com=lang&act=man".$link_add;
	$paging = pagination($where,$per_page,$page,$url);	
}
function get_man(){
	global $d, $item;

	$id = isset($_GET['id']) ? (int)$_GET['id'] : "";
	if(!$id)
	transfer($_SESSION['links_re']);
	
	$sql = "select * from #_lang where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", $_SESSION['links_re']);
	$item = $d->fetch_array();
}
function save_man(){
	global $d,$config;
	if(empty($_POST)) transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	$id = isset($_POST['id']) ? (int)$_POST['id'] : "";
	if($id){
		
		$data['lang_vi'] = $d->escape_str($_POST['lang_vi']);
		$data['lang_en'] = $d->escape_str($_POST['lang_en']);
		//$data['define'] = $_POST['define'];
		$data['type'] = "lang";
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		$d->setTable('lang');
		$d->setWhere('id', $id);
		if($d->update($data)){
			redirect($_SESSION['links_re']);
		}else{
			transfer("Cập nhật dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}else{
		$data['lang_vi'] = $d->escape_str($_POST['lang_vi']);
		$data['lang_en'] = $d->escape_str($_POST['lang_en']);
		$data['define'] = $_POST['define'];
		$data['type'] = "lang";
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->setTable('lang');
		if($d->insert($data)){
			redirect($_SESSION['links_re']);
		}else{
			transfer("Lưu dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}
}
function delete_man(){
	global $d;
	
	if(isset($_GET['id'])){
		$id =  (int)$_GET['id'];
		$d->reset();
		$sql = "select id from #_lang where id='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0){
			$sql = "delete from #_lang where id='".$id."'";
			if($d->query($sql))
				redirect($_SESSION['links_re']);
			else
				transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}
		
	} elseif (isset($_GET['listid'])==true){
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  (int)$idTin;		
			$d->reset();
			$sql = "select id from #_lang where id='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0){
				$sql = "delete from #_lang where id='".$id."'";
				$d->query($sql);
			}
		}
		redirect($_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}
?>