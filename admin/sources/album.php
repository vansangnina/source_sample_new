<?php	if(!defined('SOURCE')) { die("Error"); }
switch($act){
	case "man_list":
		get_lists();
		$template = "album/list/items";
		break;
	case "add_list":		
		$template = "album/list/item_add";
		break;
	case "edit_list":		
		get_list();
		$template = "album/list/item_add";
		break;
	case "save_list":
		save_list();
		break;
	case "delete_list":
		delete_list();
		break;	

	#===================================================
	case "man":
		get_mans();
		$template = "album/man/items";
		break;
	case "add":		
		$template = "album/man/item_add";
		break;
	case "edit":		
		get_man();
		$template = "album/man/item_add";
		break;
	case "save":
		save_man();
		break;
		
	case "delete":
		delete_man();
		break;	

	default:
		$template = "index";
}

#====================================

function get_mans(){
	global $d,$lang,$type,$id_list,$items,$keyword,$paging,$page;
	
	
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;

	$where = " #_album where type='".$type."'";
	
	if($id_list!=0){
		$where.=" and id_list = ".$id_list;
	}
	
	if($keyword!=""){
		$where.=" and ten_vi LIKE '%".$keyword."%'";
	}
	$where .=" order by id desc";

	$d->reset();
	$d->query("select id,ten_$lang as ten,hienthi,noibat,type,id_list,stt from $where $limit");
	$items = $d->result_array();

	$url = getCurrentPageURL();
	$paging = pagination($where,$per_page,$page,$url);		
	
}

function get_man(){
	global $d, $type, $item, $ds_tags, $ds_photo;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	if($id==0){
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);	
	}
	$d->reset();
	$d->query("select * from #_album where id='".$id."'");
	if($d->num_rows()==0){
		transfer("Dữ liệu không có thực", $_SESSION['links_re']);
	}
	$item = $d->fetch_array();	

	$d->reset();
	$d->query("select id,photo from #_album_photo where id_album='".$id."' and type='".$type."' order by stt,id desc ");
	$ds_photo = $d->result_array();	
}

function save_man(){
	global $d,$type;
	$file_name = images_name($_FILES['file']['name']);
	if(empty($_POST)) {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
	$data = process_quote($_POST['data']);
	if($id > 0){
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_ALBUM,$file_name)){
			$data['photo'] = $photo;	
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_ALBUM,$file_name,STYLE_THUMB);		
			$d->setTable('album');
			$d->setWhere('id', $id);
			$d->select("thumb,photo");
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_ALBUM.$row['photo']);	
				delete_file(UPLOAD_ALBUM.$row['thumb']);				
			}
		}
		$data['id_list'] = (int)$_POST['id_list'];
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		$d->reset();
		$d->setTable('album');
		$d->setWhere('id', $id);
		if($d->update($data)){
			if (isset($_FILES['files'])) {
	            for($i=0;$i<count($_FILES['files']['name']);$i++){
	            	if($_FILES['files']['name'][$i]!=''){

						$file['name'] = $_FILES['files']['name'][$i];
						$file['type'] = $_FILES['files']['type'][$i];
						$file['tmp_name'] = $_FILES['files']['tmp_name'][$i];
						$file['error'] = $_FILES['files']['error'][$i];
						$file['size'] = $_FILES['files']['size'][$i];
					    $file_name = images_name($_FILES['files']['name'][$i]);
						$photo = upload_photos($file, IMG_TYPE, UPLOAD_ALBUM,$file_name);
						$data1['photo'] = $photo;
						$data1['thumb'] = create_thumb($data1['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_ALBUM,$file_name,STYLE_THUMB);
						$data1['stt'] = (int)$_POST['stthinh'][$i];
						$data1['type'] = $$type;	
						$data1['id_album'] = $id;
						$data1['hienthi'] = 1;
						$d->setTable('album_photo');
						$d->insert($data1);
					}
				}
	        }
			transfer("Cập nhật dữ liệu thành công", $_SESSION['links_re']);
		}
		else{
			transfer("Cập nhật dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}else{
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_ALBUM,$file_name)){
			$data['photo'] = $photo;		
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_ALBUM,$file_name,STYLE_THUMB);		
		}		
		$data['id_list'] = (int)$_POST['id_list'];	
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['type'] = $type;
		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->setTable('album');
		$idInsert = $d->insert($data);
		if($idInsert>0){
			if (isset($_FILES['files'])) {
	            for($i=0;$i<count($_FILES['files']['name']);$i++){
	            	if($_FILES['files']['name'][$i]!=''){

						$file['name'] = $_FILES['files']['name'][$i];
						$file['type'] = $_FILES['files']['type'][$i];
						$file['tmp_name'] = $_FILES['files']['tmp_name'][$i];
						$file['error'] = $_FILES['files']['error'][$i];
						$file['size'] = $_FILES['files']['size'][$i];
					    $file_name = images_name($_FILES['files']['name'][$i]);
						$photo = upload_photos($file, IMG_TYPE, UPLOAD_ALBUM,$file_name);
						$data1['photo'] = $photo;
						$data1['thumb'] = create_thumb($data1['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_ALBUM,$file_name,STYLE_THUMB);
						$data1['stt'] = (int)$_POST['stthinh'][$i];
						$data1['type'] = $type;	
						$data1['id_album'] = $idInsert;
						$data1['hienthi'] = 1;
						$d->setTable('album_photo');
						$d->insert($data1);
					}
				}
	        }
			transfer("Lưu dữ liệu thành công",$_SESSION['links_re']);
		}
		else{
			transfer("Lưu dữ liệu thất bại",$_SESSION['links_re']);
		}
	}
}

function delete_man(){
	global $d;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	$strId = isset($_GET['listid']) ? strip_tags($_GET['listid']) : "";
	if($id > 0){
		$d->reset();
		$d->query("select id,photo,thumb from #_album_photo where id_album='".$id."'");
		$photo_lq = $d->result_array();
		if(count($photo_lq)>0){
			for($i=0;$i<count($photo_lq);$i++){
				delete_file(UPLOAD_ALBUM.$photo_lq[$i]['photo']);
				delete_file(UPLOAD_ALBUM.$photo_lq[$i]['thumb']);
			}
		}
		$d->reset();
		$d->query("delete from #_album_photo where id_album='".$id."'");

		$d->reset();
		$d->query("select id,photo,thumb from #_album where id='".$id."'");
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(UPLOAD_ALBUM.$row['photo']);
				delete_file(UPLOAD_ALBUM.$row['thumb']);
			}
			$d->reset();
			$d->query("delete from #_album where id='".$id."'");

			transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	} elseif ($strId!=""){
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$id = (int)$listid[$i]; 
			$d->reset();
			$d->query("select id,photo,thumb from #_album_photo where id_album='".$id."'");
			$photo_lq = $d->result_array();
			if(count($photo_lq)>0){
				for($j=0;$j<count($photo_lq);$j++){
					delete_file(UPLOAD_ALBUM.$photo_lq[$j]['photo']);
					delete_file(UPLOAD_ALBUM.$photo_lq[$j]['thumb']);
				}
			}	
			$d->query("delete from #_album_photo where id_album='".$id."'");

			$d->reset();
			$d->query("select id,photo,thumb from #_album where id='".$id."'");
			if($d->num_rows()>0){
				while($row = $d->fetch_array()){
					delete_file(UPLOAD_ALBUM.$row['photo']);
					delete_file(UPLOAD_ALBUM.$row['thumb']);
				}
				$d->query("delete from #_album where id='".$id."'");
			}
		}
		transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}


#=================List===================

function get_lists(){
	global $d, $items,$type,$lang,$keyword, $paging,$page;

	
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where .= " #_album_list where type='".$type."' ";

	if($_REQUEST['keyword']!=''){
		$where.=" and ten_vi LIKE '%".$keyword."%'";
	}
	$where .=" order by stt,id desc";

	$d->reset();
	$d->query("select id,ten_$lang as ten,hienthi,stt,type from $where $limit");
	$items = $d->result_array();
    
    $url = getCurrentPageURL();
	$paging = pagination($where,$per_page,$page,$url);
}

function get_list(){
	global $d, $item;

	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	if($id == 0){
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
	
	$d->reset();
	$d->query("select * from #_album_list where id='".$id."'");
	if($d->num_rows()==0) {
		transfer("Dữ liệu không có thực", $_SESSION['links_re']);
	}
	$item = $d->fetch_array();
}

function save_list(){
	global $d,$type;

	$file_name = images_name($_FILES['file']['name']);
	
	if(empty($_POST)) transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
	$data = process_quote($_POST['data']);
	if($id > 0){
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_ALBUM,$file_name)){
			$data['photo'] = $photo;
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_ALBUM,$file_name,STYLE_THUMB);
			$d->setTable('album_list');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_ALBUM.$row['photo']);
				delete_file(UPLOAD_ALBUM.$row['thumb']);
			}
		}
		
		$data['links'] = $d->escape_str($_POST['links']);
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
		$data['stt'] =(int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		$d->reset();
		$d->setTable('album_list');
		$d->setWhere('id', $id);
		if($d->update($data)){
			transfer("Cập nhật dữ liệu thành công", $_SESSION['links_re']);
		}
		else{
			transfer("Cập nhật dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}else{
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_ALBUM,$file_name)){
			$data['photo'] = $photo;
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_ALBUM,$file_name,STYLE_THUMB);
		}
		
		$data['links'] = $d->escape_str($_POST['links']);
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
		$data['stt'] =(int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$data['type'] = $type;
		$d->setTable('album_list');
		$idInsert = $d->insert($data);
		if($idInsert > 0){
			transfer("Lưu dữ liệu thành công", $_SESSION['links_re']);
		}
		else{
			transfer("Lưu dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}
}

function delete_list(){
	global $d;

	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	$strId = isset($_GET['listid']) ? strip_tags($_GET['listid']) : "";

	if($id > 0){
		$d->reset();
		$d->query("select id,photo,thumb from #_album_list where id='".$id."'");
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(UPLOAD_ALBUM.$row['photo']);
				delete_file(UPLOAD_ALBUM.$row['thumb']);
			}
			$d->reset();
			$d->query("delete from #_album_list where id='".$id."'");

			transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	} elseif ($strId!=""){
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i < count($listid) ; $i++){
			$id = (int)$listid[$i]; 	
			$d->reset();
			$d->query("select id,photo,thumb from #_album_list where id='".$id."'");
			if($d->num_rows()>0){
				while($row = $d->fetch_array()){
					delete_file(UPLOAD_ALBUM.$row['photo']);
					delete_file(UPLOAD_ALBUM.$row['thumb']);
				}
				$d->reset();
				$d->query("delete from #_album_list where id='".$id."'");
			}
		}
		transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}
#====================================

?>