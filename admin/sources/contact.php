<?php	if(!defined('SOURCE')) { die("Error"); }
switch($act){

	case "man":
		get_items();
		$template = "contact/man/items";
		break;
	case "add":		
		$template = "contact/man/item_add";
		break;
	case "edit":		
		get_item();
		$template = "contact/man/item_add";
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
	global $d, $items, $paging,$page,$type;
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_contact ";

	
	if($keyword!='')
	{
		
		$where.=" and ten LIKE '%$keyword%'";
		$link_add .= "&keyword=".$keyword;
	}
	$where .=" order by id desc";

	$sql = "select ten,id,stt,hienthi,view,tieude,email,ngaytao from $where $limit";
	$d->query($sql);
	$items = $d->result_array();

	$url = "index.php?com=contact&act=man&type=".$type."".$link_add;
	$paging = pagination($where,$per_page,$page,$url);		
	
}

function get_item(){
	global $d, $item,$ds_tags;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=contact&act=man&type=".$type);	
	$sql = "select * from #_contact where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=contact&act=man&type=".$type);
	$item = $d->fetch_array();	

	$sqlUPDATE_ORDER = "UPDATE table_contact SET view =1 WHERE  id = ".$id."";
	$d->query($sqlUPDATE_ORDER);

}

function save_item(){
	global $d,$type,$curPage;
	$file_name=images_name($_FILES['file']['name']);

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=contact&act=man&type=".$type);
	$id = isset($_POST['id']) ? (int)$_POST['id'] : "";
	
	if($id){

		$data['ghichu'] = $_POST['ghichu'];
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		
		$d->setTable('contact');
		$d->setWhere('id', $id);
		if($d->update($data))
			redirect("index.php?com=contact&act=man&curPage=".$curPage."&type=".$type);
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=contact&act=man&type=".$type);
	}else{
			

		$data['ghichu'] = $_POST['ghichu'];
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->setTable('contact');
		if($d->insert($data))
		{			
			redirect("index.php?com=contact&act=man&type=".$type);
		}
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=contact&act=man&type=".$type);
	}
}

function delete_item(){
	global $d;
	
	if(isset($_GET['id'])){
		$id =  (int)$_GET['id'];
		$d->reset();
		$sql = "select id,photo,thumb from #_contact where id='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0){
			$sql = "delete from #_contact where id='".$id."'";
			$d->query($sql);
		}
		if($d->query($sql))
			redirect("index.php?com=contact&act=man&curPage=".$curPage."&type=".$type);
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=contact&act=man&curPage=".$curPage."&type=".$type);
	} elseif (isset($_GET['listid'])==true){
		$listid = explode(",",$_GET['listid']);
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i];
			$id =  (int)$idTin;
			$d->reset();
			$sql = "select id,photo,thumb from #_contact where id='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0){
				$sql = "delete from #_contact where id='".$id."'";
				$d->query($sql);
			}
		}
		redirect("index.php?com=contact&act=man&curPage=".$curPage."&type=".$type);
	} else {
		transfer("Không nhận được dữ liệu", "index.php?com=contact&act=man&curPage=".$curPage."&type=".$type);
	}


}


?>