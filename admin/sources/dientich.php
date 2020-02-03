<?php	if(!defined('SOURCE')) { die("Error"); }
switch($act){

	case "man":
		get_items();
		$template = "dientich/items";
		break;
	case "add":		
		$template = "dientich/item_add";
		break;
	case "edit":		
		get_item();
		$template = "dientich/item_add";
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
	
#====================================

function get_items(){
	global $d, $items,$keyword,$lang, $paging,$page;
	
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_dientich ";
	

	if($keyword!=""){
		$where.=" and ten_vi LIKE '%".$keyword."%'";
	}
	$where .=" order by id desc";

	$d->reset();
	$d->query("select ten_$lang as ten,id,stt,hienthi from $where $limit");
	$items = $d->result_array();

	$url = getCurrentPageURL();
	$paging = pagination($where,$per_page,$page,$url);		
	
}

function get_item(){
	global $d, $item,$ds_tags;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	if($id==0){
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);	
	}
	$d->reset();
	$d->query("select * from #_dientich where id='".$id."'");
	if($d->num_rows()==0) {
		transfer("Dữ liệu không có thực", $_SESSION['links_re']);
	}
	$item = $d->fetch_array();	
}

function save_item(){
	global $d;
	$file_name = images_name($_FILES['file']['name']);

	if(empty($_POST)){
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
	$data = process_quote($_POST['data']);
	if($id > 0){
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['dientichtu'] = str_replace(',','',$_POST['dientichtu']);
		$data['dientichden'] = str_replace(',','',$_POST['dientichden']);
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		$d->reset();
		$d->setTable('dientich');
		$d->setWhere('id', $id);
		if($d->update($data)){
			transfer("Cập nhật dữ liệu thành công",$_SESSION['links_re']);
		}
		else{
			transfer("Cập nhật dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}else{
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['dientichtu'] = str_replace(',','',$_POST['dientichtu']);
		$data['dientichden'] = str_replace(',','',$_POST['dientichden']);
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->setTable('dientich');
		if($d->insert($data)){			
			transfer("Lưu dữ liệu thành công", $_SESSION['links_re']);
		}
		else{
			transfer("Lưu dữ liệu bị lỗi",  $_SESSION['links_re']);
		}
	}
}

function delete_item(){
	global $d;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	$strId = isset($_GET['listid']) ? strip_tags($_GET['listid']) : "";
	if($id > 0){
		$d->reset();
		$d->query("select id,photo,thumb from #_dientich where id='".$id."'");
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(UPLOAD_IMAGE.$row['photo']);
				delete_file(UPLOAD_IMAGE.$row['thumb']);
			}
			$d->reset();
			$d->query("delete from #_dientich where id='".$id."'");

			transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	} elseif ($strId!=""){
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$id = (int)$listid[$i]; 	
			$d->reset();
			$d->query("select id,photo,thumb from #_dientich where id='".$id."'");
			if($d->num_rows()>0){
				while($row = $d->fetch_array()){
					delete_file(UPLOAD_IMAGE.$row['photo']);
					delete_file(UPLOAD_IMAGE.$row['thumb']);
				}
				$d->reset();
				$d->query("delete from #_dientich where id='".$id."'");
			}
		}
		transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}


?>