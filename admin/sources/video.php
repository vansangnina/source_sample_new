<?php	if(!defined('SOURCE')){ die("Error"); }
switch($act){

	case "man":
		get_items();
		$template = "video/items";
		break;
	case "add":		
		$template = "video/item_add";
		break;
	case "edit":		
		get_item();
		$template = "video/item_add";
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
	
	$where = " #_video ";

	$where .= " where type='".$type."' ";
	
	if($keyword!='')
	{
		$keyword=addslashes($keyword);
		$where.=" and ten_vi LIKE '%$keyword%'";
		$link_add .= "&keyword=".$keyword;
	}
	$where .=" order by id desc";

	$sql = "select ten_vi,id,stt,hienthi,noibat from $where $limit";
	$d->query($sql);
	$items = $d->result_array();

	$url = "index.php?com=video&act=man&type=".$type."".$link_add;
	$paging = pagination($where,$per_page,$page,$url);		
	
}

function get_item(){
	global $d, $item,$ds_tags,$type;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=video&act=man&type=".$type);	
	$sql = "select * from #_video where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=video&act=man&type=".$type);
	$item = $d->fetch_array();	
}

function save_item(){
	global $d;
	$file_name=images_name($_FILES['file']['name']);

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=video&act=man&type=".$type);
	$id = isset($_POST['id']) ? (int)$_POST['id'] : "";
	
	if($id){
		
		
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_VIDEO,$file_name)){
			$data['photo'] = $photo;	
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_VIDEO,$file_name,_style_thumb);		
			$d->setTable('video');
			$d->setWhere('id', $id);
			$d->select("photo,thumb");
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_VIDEO.$row['photo']);	
				delete_file(UPLOAD_VIDEO.$row['thumb']);				
			}
		}


		$data['ten_vi'] = $d->escape_str($_POST['ten_vi']);
		$data['tenkhongdau'] = isset($_POST['tenkhongdau']) ? $_POST['tenkhongdau'] : changeTitle($data['ten_vi']);
		$data['ten_en'] = $d->escape_str($_POST['ten_en']);
		$data['links'] = $_POST['links'];
		
		$data['title'] = $_POST['title'];
		$data['keywords'] = $_POST['keywords'];
		$data['description'] = $_POST['description'];
		
		$data['stt'] = $_POST['stt'];
		
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		
		$data['ngaysua'] = time();
		$d->setTable('video');
		$d->setWhere('id', $id);
		if($d->update($data))
			redirect("index.php?com=video&act=man&curPage=".$curPage."&type=".$type);
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=video&act=man&type=".$type);
	}else{
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_VIDEO,$file_name)){
			$data['photo'] = $photo;		
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_VIDEO,$file_name,_style_thumb);		
		}else{
			$urlImage = "https://img.youtube.com/vi/".youtobi($_POST['links'])."/sddefault.jpg";
			$arrCheck = getimagesize($urlImage);
			if($arrCheck){
				$file_name = fns_Rand_digit(0,9,15);
				$nameImg = $file_name.".jpg";
				if (!copy($urlImage, UPLOAD_VIDEO.$nameImg)){
					if (!move_uploaded_file($urlImage,UPLOAD_VIDEO.$nameImg)){
						return false;
					}
				}
				$data['photo'] = $nameImg;	
				$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_VIDEO,$file_name,_style_thumb);
			}
		}		

		$data['ten_vi'] = $d->escape_str($_POST['ten_vi']);
		$data['tenkhongdau'] = isset($_POST['tenkhongdau']) ? $_POST['tenkhongdau'] : changeTitle($data['ten_vi']);
		$data['links'] = $_POST['links'];
		$data['ten_en'] = $d->escape_str($_POST['ten_en']);
		$data['type'] = $type;

		$data['title'] = $_POST['title'];
		$data['keywords'] = $_POST['keywords'];
		$data['description'] = $_POST['description'];
		
		$data['stt'] = $_POST['stt'];
		
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->setTable('video');
		if($d->insert($data))
		{			
			redirect("index.php?com=video&act=man&type=".$type);
		}
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=video&act=man&type=".$type);
	}
}

function delete_item(){
	global $d;
	
	if(isset($_GET['id'])){
		$id =  (int)$_GET['id'];
		$d->reset();
		$sql = "select id,photo,thumb from #_video where id='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(UPLOAD_VIDEO.$row['photo']);
				delete_file(UPLOAD_VIDEO.$row['thumb']);
			}
			$sql = "delete from #_video where id='".$id."'";
			$d->query($sql);
		}
		if($d->query($sql))
			redirect("index.php?com=video&act=man&curPage=".$curPage."&type=".$type);
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=video&act=man&curPage=".$curPage."&type=".$type);
	} elseif (isset($_GET['listid'])==true){
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  (int)$idTin;		
			$d->reset();
			$sql = "select id,photo,thumb from #_video where id='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0){
				while($row = $d->fetch_array()){
					delete_file(UPLOAD_VIDEO.$row['photo']);
					delete_file(UPLOAD_VIDEO.$row['thumb']);
				}
				$sql = "delete from #_video where id='".$id."'";
				$d->query($sql);
			}
		}
		redirect("index.php?com=video&act=man&curPage=".$curPage."&type=".$type);
	} else {
		transfer("Không nhận được dữ liệu", "index.php?com=video&act=man&curPage=".$curPage."&type=".$type);
	}


}


?>