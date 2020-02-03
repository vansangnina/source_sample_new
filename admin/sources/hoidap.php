<?php	if(!defined('SOURCE')) { die("Error"); }
switch($act){

	case "man":
		get_items();
		$template = "hoidap/man/items";
		break;
	case "add":		
		$template = "hoidap/man/item_add";
		break;
	case "edit":		
		get_item();
		$template = "hoidap/man/item_add";
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
	
	$where = " #_hoidap ";

	
	if($keyword!='')
	{
		
		$where.=" where  ten LIKE '%$keyword%'";
		$link_add .= "&keyword=".$keyword;
	}
	$where .=" order by id desc";

	$sql = "select ten,id,stt,hienthi,tieude,email,ngaytao from $where $limit";
	$d->query($sql);
	$items = $d->result_array();

	$url = "index.php?com=hoidap&act=man&type=".$type."".$link_add;
	$paging = pagination($where,$per_page,$page,$url);		
	
}

function get_item(){
	global $d, $item,$ds_tags,$type;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=hoidap&act=man&type=".$type);	
	$sql = "select * from #_hoidap where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=hoidap&act=man&type=".$type);
	$item = $d->fetch_array();	

	

}

function save_item(){
	global $d,$type,$curPage;
	$file_name=images_name($_FILES['file']['name']);

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=hoidap&act=man&type=".$type);
	$id = isset($_POST['id']) ? (int)$_POST['id'] : "";
	
	if($id){
		$data['ten'] = $d->escape_str($_POST['ten']);
		$data['dienthoai'] = $d->escape_str($_POST['dienthoai']);
		$data['email'] = $d->escape_str($_POST['email']);
		$data['diachi'] = $d->escape_str($_POST['diachi']);
		$data['tieude'] = $d->escape_str($_POST['tieude']);
		$data['cauhoi'] = $d->escape_str($_POST['cauhoi']);
		$data['traloi'] = $d->escape_str($_POST['traloi']);
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		
		$d->setTable('hoidap');
		$d->setWhere('id', $id);
		if($d->update($data))
			redirect("index.php?com=hoidap&act=man&curPage=".$curPage."&type=".$type);
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=hoidap&act=man&type=".$type);
	}else{
			

		$data['ten'] = $d->escape_str($_POST['ten']);
		$data['dienthoai'] = $d->escape_str($_POST['dienthoai']);
		$data['email'] = $d->escape_str($_POST['email']);
		$data['diachi'] = $d->escape_str($_POST['diachi']);
		$data['tieude'] = $d->escape_str($_POST['tieude']);
		$data['cauhoi'] = $d->escape_str($_POST['cauhoi']);
		$data['traloi'] = $d->escape_str($_POST['traloi']);
		
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->setTable('hoidap');
		if($d->insert($data))
		{			
			redirect("index.php?com=hoidap&act=man&type=".$type);
		}
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=hoidap&act=man&type=".$type);
	}
}

function delete_item(){
	global $d,$type,$curPage;
	if(isset($_GET['id'])){
		$id =  (int)$_GET['id'];
		$d->reset();
		$sql = "select id from #_hoidap where id='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0){

			$sql = "delete from #_hoidap where id='".$id."'";
			$d->query($sql);
		}
		if($d->query($sql))
			redirect("index.php?com=hoidap&act=man&curPage=".$curPage."&type=".$type);
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=hoidap&act=man&curPage=".$curPage."&type=".$type);
	} elseif (isset($_GET['listid'])==true){
		$listid = explode(",",$_GET['listid']);
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i];
			$id =  (int)$idTin;
			$d->reset();
			$sql = "select id from #_hoidap where id='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0){
				$sql = "delete from #_hoidap where id='".$id."'";
				$d->query($sql);
			}
		}
		redirect("index.php?com=hoidap&act=man&curPage=".$curPage."&type=".$type);
	} else {
		transfer("Không nhận được dữ liệu", "index.php?com=hoidap&act=man&curPage=".$curPage."&type=".$type);
	}


}


?>