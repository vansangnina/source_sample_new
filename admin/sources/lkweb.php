<?php	if(!defined('SOURCE')){ die("Error"); }


switch($act){
	case "man":
		get_items();
		$template = "lkweb/items";
		break;
	case "add":
		$template = "lkweb/item_add";
		break;
	case "edit":
		get_item();
		$template = "lkweb/item_add";
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
	global $d, $items,$paging,$page,$type;
	
	if(!empty($_POST)){
		$multi=$_REQUEST['multi'];
		$id_array=$_POST['iddel'];
		$count=count($id_array);
		if($multi=='show'){
			for($i=0;$i<$count;$i++){
				$sql = "UPDATE table_lkweb SET hienthi =1 WHERE  id = ".$id_array[$i]."";
				$d->query($sql) or die("Not query sqlUPDATE_ORDER");				
			}
			redirect("index.php?com=lkweb&act=man");			
		}
		
		if($multi=='hide'){
			for($i=0;$i<$count;$i++){
				$sql = "UPDATE table_lkweb SET hienthi =0 WHERE  id = ".$id_array[$i]."";
				$d->query($sql) or die("Not query sqlUPDATE_ORDER");				
			}
			redirect("index.php?com=lkweb&act=man");			
		}
		
		if($multi=='del'){
			for($i=0;$i<$count;$i++){		
				$d->setTable('lkweb');
				$d->setWhere('id', $id_array[$i]);
				$d->select("photo,thumb");
				if($d->num_rows()>0){
					$row = $d->fetch_array();
					delete_file(UPLOAD_IMAGE.$row['photo']);	
					delete_file(UPLOAD_IMAGE.$row['thumb']);				
				}					
				$sql = "delete from table_lkweb where id = ".$id_array[$i]."";
				$d->query($sql) or die("Not query sqlUPDATE_ORDER");			
							
			}
			redirect("index.php?com=lkweb&act=man&type=".$type);			
		}				
	}
	
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_lkweb ";
	$where .= " where id <> 0 and type='".$type."'";	
	
	$where.=" order by id desc ";				
	
	$sql = "select * from $where $limit";		
	$d->query($sql);
	$items = $d->result_array();
	$url = getCurrentPageURL();
	$paging = pagination($where,$per_page,$page,$url);			
}

function get_item(){
	global $d, $item,$type;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=lkweb&act=man&type=".$type);
	
	$sql = "select * from #_lkweb where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=lkweb&act=man&type=".$type);
	$item = $d->fetch_array();
}

function save_item(){
	global $d,$type;
	$file_name=images_name($_FILES['file']['name']);
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=lkweb&act=man&type=".$type);
	$id = isset($_POST['id']) ? (int)$_POST['id'] : "";
	$data=process_quote($_POST['data']);
	if($id){ // cap nhat
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_IMAGE,$file_name)){
			$data['photo'] = $photo;	
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_IMAGE,$file_name,STYLE_THUMB);		
			$d->setTable('lkweb');
			$d->setWhere('id', $id);
			$d->select("photo,thumb");
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_IMAGE.$row['photo']);	
				delete_file(UPLOAD_IMAGE.$row['thumb']);				
			}
		}

		
		$data['url'] = $_POST['url'];
		$data['type'] = $type;
		$data['stt'] = $_POST['num'];
		$data['hienthi'] = isset($_POST['active']) ? 1 : 0;
		$data['ngaysua'] = time();
		
		$d->setTable('lkweb');
		$d->setWhere('id', $id);
		if($d->update($data))
			header("Location:index.php?com=lkweb&act=man&type=".$type);
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=lkweb&act=man&type=".$type);
	}else{ // them moi
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_IMAGE,$file_name)){
			$data['photo'] = $photo;	
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_IMAGE,$file_name,STYLE_THUMB);	
		}	
		$data['url'] = $_POST['url'];
		$data['type'] = $type;
		$data['stt'] = $_POST['num'];
		$data['hienthi'] = isset($_POST['active']) ? 1 : 0;
		$data['ngaytao'] = time();
		
		$d->setTable('lkweb');
		if($d->insert($data))
			header("Location:index.php?com=lkweb&act=man&type=".$type);
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=lkweb&act=man&type=".$type);
	}
}

function delete_item(){
	global $d,$type;
	
	if(isset($_GET['id'])){
		$id =  (int)$_GET['id'];
		$d->setTable('lkweb');
		$d->setWhere('id', $id);
		$d->select("photo,thumb");
		if($d->num_rows()>0){
			$row = $d->fetch_array();
			delete_file(UPLOAD_IMAGE.$row['photo']);	
			delete_file(UPLOAD_IMAGE.$row['thumb']);				
		}
		
		// xoa item
		$sql = "delete from #_lkweb where id='".$id."'";
		if($d->query($sql))
			header("Location:index.php?com=lkweb&act=man&type=".$type);
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=lkweb&act=man&type=".$type);
	}else transfer("Không nhận được dữ liệu", "index.php?com=lkweb&act=man&type=".$type);
}
#--------------------------------------------------------------------------------------------- photo
?>