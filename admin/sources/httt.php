<?php	if(!defined('SOURCE')) { die("Error"); }
switch($act){

	case "man":
		get_items();
		$template = "httt/items";
		break;
	case "add":		
		$template = "httt/item_add";
		break;
	case "edit":		
		get_item();
		$template = "httt/item_add";
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
	global $d, $items, $paging,$page,$type,$keyword;
	
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_httt ";

	$where .= "  ";
	
	if($keyword!='')
	{
		
		$where.=" where and ten_vi LIKE '%$keyword%'";
		$link_add .= "&keyword=".$keyword;
	}
	$where .=" order by id desc";

	$sql = "select * from $where $limit";
	$d->query($sql);
	$items = $d->result_array();

	$url = "index.php?com=httt&act=man&type=".$type."".$link_add;
	$paging = pagination($where,$per_page,$page,$url);		
	
}

function get_item(){
	global $d, $item,$ds_tags,$type;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=httt&act=man&type=".$type);	
	$sql = "select * from #_httt where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=httt&act=man&type=".$type);
	$item = $d->fetch_array();	
}

function save_item(){
	global $d,$type,$curPage;
	$file_name=images_name($_FILES['file']['name']);

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=httt&act=man&type=".$type);
	$id = isset($_POST['id']) ? (int)$_POST['id'] : "";
	$data=process_quote($_POST['data']);
	if($id){
		if($photo = upload_image("file", 'jpg|png|gif|JPG|jpeg|JPEG', UPLOAD_IMAGE,$file_name)){
			$data['photo'] = $photo;	
			$data['thumb'] = create_thumb($data['photo'], 295, 195, UPLOAD_IMAGE,$file_name,1);		
			$d->setTable('httt');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_IMAGE.$row['photo']);	
				delete_file(UPLOAD_IMAGE.$row['thumb']);				
			}
		}
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		
		$d->setTable('httt');
		$d->setWhere('id', $id);
		if($d->update($data))
			redirect("index.php?com=httt&act=man&curPage=".$curPage."&type=".$type);
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=httt&act=man&type=".$type);
	}else{
		if($photo = upload_image("file", 'jpg|png|gif|JPG|jpeg|JPEG', UPLOAD_IMAGE,$file_name)){
			$data['photo'] = $photo;		
			$data['thumb'] = create_thumb($data['photo'], 295, 195, UPLOAD_IMAGE,$file_name,1);		
		}		

		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
	
		$d->setTable('httt');
		if($d->insert($data))
		{			
			redirect("index.php?com=httt&act=man&type=".$type);
		}
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=httt&act=man&type=".$type);
	}
}

function delete_item(){
	global $d,$type,$curPage;
	
	if(isset($_GET['id'])){
		$id =  (int)$_GET['id'];
		$d->reset();
		$sql = "select id from #_httt where id='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(UPLOAD_IMAGE.$row['photo']);
				delete_file(UPLOAD_IMAGE.$row['thumb']);
			}
			$sql = "delete from #_httt where id='".$id."'";
			$d->query($sql);
		}
		if($d->query($sql))
			redirect("index.php?com=httt&act=man&curPage=".$curPage."&type=".$type);
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=httt&act=man&curPage=".$curPage."&type=".$type);
	} elseif (isset($_GET['listid'])==true){
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  (int)$idTin;		
			$d->reset();
			$sql = "select id from #_httt where id='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0){
				while($row = $d->fetch_array()){
					delete_file(UPLOAD_IMAGE.$row['photo']);
					delete_file(UPLOAD_IMAGE.$row['thumb']);
				}
				$sql = "delete from #_httt where id='".$id."'";
				$d->query($sql);
			}
		}
		redirect("index.php?com=httt&act=man&curPage=".$curPage."&type=".$type);
	} else {
		transfer("Không nhận được dữ liệu", "index.php?com=httt&act=man&curPage=".$curPage."&type=".$type);
	}


}


?>