<?php	if(!defined('SOURCE')) { die("Error"); }

switch($act){
	case "man":
		get_items();
		$template = "download/items";
		break;
	case "add":
		$template = "download/item_add";
		break;
	case "edit":
		get_item();
		$template = "download/item_add";
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
	global $d, $items, $paging,$page,$type;
	
	if(!empty($_POST)){
		$multi=$_REQUEST['multi'];
		$id_array=$_POST['iddel'];
		$count=count($id_array);
		
		if($multi=='del'){
			for($i=0;$i<$count;$i++){	
				$d->reset();
				$d->query("select photo,thumb,file from #_download where id='".$id_array[$i]."'");	
				if($d->num_rows()==1){
					$download = $d->fetch_array();
					delete_file(UPLOAD_IMAGE.$download['photo']);
					delete_file(UPLOAD_IMAGE.$download['thumb']);
					delete_file(UPLOAD_FILE.$download['file']);

					$sql = "delete from table_download where id = ".$id_array[$i]."";
					$d->query($sql) or die("Not query sqlUPDATE_ORDER");
				}					
			}
			redirect("index.php?com=download&act=man&type=".$type);			
		}				
	}
	
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_download ";
	$where .= " where type='".$type."' ";

	if($keyword!='')
	{
		
		$where.=" and ten_vi LIKE '%$keyword%'";
		$link_add .= "&keyword=".$keyword;
	}
	$where .=" order by id desc";

	$sql = "select * from $where $limit";
	$d->query($sql);
	$items = $d->result_array();

	$url = "index.php?com=download&act=man&type=".$type."".$link_add;
	$paging = pagination($where,$per_page,$page,$url);		
}

function get_item(){
	global $d, $item,$type;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=download&act=man&type=".$type);
	
	$sql = "select * from #_download where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=download&act=man&type=".$type);
	$item = $d->fetch_array();
}

function save_item(){
	global $d,$type;
	$file_name=images_name($_FILES['file']['name']);
	$file_download=images_name($_FILES['file_download']['name']);
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=download&act=man&type=".$type);
	$id = isset($_POST['id']) ? (int)$_POST['id'] : "";
	$data=process_quote($_POST['data']);
	if($id){ // cap nhat
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_IMAGE,$file_name)){
			$data['photo'] = $photo;	
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_IMAGE,$file_name,STYLE_THUMB);
			$d->reset();		
			$d->setTable('download');
			$d->setWhere('id', $id);
			$d->select("photo,thumb");
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_IMAGE.$row['photo']);	
				delete_file(UPLOAD_IMAGE.$row['thumb']);				
			}
		}

		if($file_d = upload_image("file_download",FILE_TYPE, UPLOAD_FILE,$file_download)){
			$data['file'] = $file_d;	
			$d->reset();
			$d->setTable('download');
			$d->setWhere('id', $id);
			$d->select("file");
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_FILE.$row['file']);				
			}
		}

		
		$data['id_list'] = (int)$_POST['id_list'];
		$data['url'] = $d->escape_str($_POST['url']);
		$data['type'] = $type;
		$data['stt'] = $_POST['num'];
		$data['hienthi'] = isset($_POST['active']) ? 1 : 0;
		$data['ngaysua'] = time();
		
		$d->setTable('download');
		$d->setWhere('id', $id);
		if($d->update($data))
			header("Location:index.php?com=download&act=man&type=".$type);
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=download&act=man&type=".$type);
	}else{ // them moi
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_IMAGE,$file_name)){
			$data['photo'] = $photo;	
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_IMAGE,$file_name,STYLE_THUMB);	
		}
		if($file_d = upload_image("file_download", FILE_TYPE, UPLOAD_FILE,$file_download)){
			$data['file'] = $file_d;
		}
		$data['id_list'] = (int)$_POST['id_list'];
		$data['url'] = $d->escape_str($_POST['url']);
		$data['type'] = $type;
		$data['stt'] = $_POST['num'];
		$data['hienthi'] = isset($_POST['active']) ? 1 : 0;
		$data['ngaytao'] = time();
		
		$d->setTable('download');
		if($d->insert($data))
			header("Location:index.php?com=download&act=man&type=".$type);
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=download&act=man&type=".$type);
	}
}

function delete_item(){
	global $d,$type;
	
	if(isset($_GET['id'])){
		$id =  (int)$_GET['id'];
		
		
		$d->reset();
		$sql = "select id,photo,thumb,file from #_download where id='".$id."'";
		$d->query($sql);
		
		if($d->num_rows()==1){
			$download = $d->fetch_array();
			delete_file(UPLOAD_IMAGE.$download['photo']);
			delete_file(UPLOAD_IMAGE.$download['thumb']);
			delete_file(UPLOAD_FILE.$download['file']);
		}
		$sql = "delete from #_download where id='".$id."'";
		if($d->query($sql))
			header("Location:index.php?com=download&act=man&type=".$type);
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=download&act=man&type=".$type);
	}else transfer("Không nhận được dữ liệu", "index.php?com=download&act=man&type=".$type);
}
#--------------------------------------------------------------------------------------------- photo
?>