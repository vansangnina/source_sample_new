<?php	if(!defined('SOURCE')){ die("Error"); }
switch($act){
	case "man_photo":
		get_photos();
		$template = "photo/photos";
		break;
	case "add_photo":		
		$template = "photo/photo_add";
		break;
	case "edit_photo":
		get_photo();
		$template = "photo/photo_edit";
		break;
	case "save_photo":
		save_photo();
		break;
	case "delete_photo":
		delete_photo();
		break;			
	default:
		$template = "index";
}
function get_photos(){
	global $d, $items,$paging,$page,$type;
	if(!empty($_POST)){
		$multi=$_REQUEST['multi'];
		$id_array=$_POST['iddel'];
		$count=count($id_array);
		if($multi=='show'){
			for($i=0;$i<$count;$i++){
				$sql = "UPDATE table_photo SET hienthi =1 WHERE  id = ".$id_array[$i]."";
				$d->query($sql) or die("Not query sqlUPDATE_ORDER");				
			}
			redirect("index.php?com=photo&act=man_photo&type=".$type);			
		}
		if($multi=='hide'){
			for($i=0;$i<$count;$i++){
				$sql = "UPDATE table_photo SET hienthi =0 WHERE  id = ".$id_array[$i]."";
				$d->query($sql) or die("Not query sqlUPDATE_ORDER");				
			}
			redirect("index.php?com=photo&act=man_photo&type=".$type);			
		}
		if($multi=='del'){
			for($i=0;$i<$count;$i++){
				$sql = "select id,photo_vi,photo_en,thumb_vi,thumb_en from #_photo where id= ".$id_array[$i]."";
				$d->query($sql);
				if($d->num_rows()>0){
					while($row = $d->fetch_array()){
						delete_file(UPLOAD_IMAGE.$row['photo_vi']);
						delete_file(UPLOAD_IMAGE.$row['photo_en']);
						delete_file(UPLOAD_IMAGE.$row['thumb_vi']);
						delete_file(UPLOAD_IMAGE.$row['thumb_en']);
					}
				}
				$sql = "delete from table_photo where id = ".$id_array[$i]."";
				$d->query($sql) or die("Not query sqlUPDATE_ORDER");			
			}
			redirect("index.php?com=photo&act=man_photo&type=".$type);			
		}				
	}
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	$where = " #_photo ";
	$where .= " where id <> 0";		
	if($type!='')
	{
		$where.=" and type='".$type."'";
	}
	$where.=" order by stt,id desc ";				
	$sql = "select * from $where $limit";		
	$d->query($sql);
	$items = $d->result_array();
	$url = getCurrentPageURL();
	$paging = pagination($where,$per_page,$page,$url);
}
function get_photo(){
	global $d, $item, $list_cat,$type;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : "";
	if(!$id)
	transfer("Không nhận được dữ liệu", "index.php?com=photo&act=man_photo&type=".$type);
	$d->setTable('photo');
	$d->setWhere('id', $id);
	$d->select();
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=photo&act=man_photo&type=".$type);
	$item = $d->fetch_array();	
}
function save_photo(){
	global $d,$config,$type;
	$file_name=fns_Rand_digit(0,9,15);
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=photo&act=man_photo&type=".$type);
	$id = isset($_POST['id']) ? (int)$_POST['id']: "";
	$data=process_quote($_POST['data']);
	if($id){
		foreach ($config['lang'] as $key => $value) {
			if($photo = upload_image("file_".$key, IMG_TYPE, UPLOAD_IMAGE,$file_name.$key)){
				$data['photo_'.$key] = $photo;
				$data['thumb_'.$key] = create_thumb($data['photo_'.$key], WIDTH_THUMB, HEIGHT_THUMB , UPLOAD_IMAGE,$file_name.$key,STYLE_THUMB);	
				$d->setTable('photo');
				$d->setWhere('id', $id);
				$d->select("photo_$key,thumb_$key");
				if($d->num_rows()>0){
					$row = $d->fetch_array();
					delete_file(UPLOAD_IMAGE.$row['photo_'.$key]);
					delete_file(UPLOAD_IMAGE.$row['thumb_'.$key]);
				}
			}
		}
		$data['stt'] = $_POST['stt'];
		$data['id_list'] = (int)$_POST['id_list'];
		$data['link'] = $_POST['link'];
		$data['type'] = $_POST['type'];	
		$data['hienthi'] = isset($_POST['active']) ? 1 : 0;
		$d->reset();
		$d->setTable('photo');
		$d->setWhere('id', $id);
		if(!$d->update($data)) 
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=photo&act=man_photo&type=".$type);
		redirect("index.php?com=photo&act=man_photo&type=".$type);
	}else{ 		
		$upload_image=false;
		foreach ($config['lang'] as $key => $value) {
			if($data['photo_'.$key] = upload_image("file_".$key, IMG_TYPE, UPLOAD_IMAGE,$file_name.$key)){		
				$data['thumb_'.$key] = create_thumb($data['photo_'.$key], WIDTH_THUMB, HEIGHT_THUMB , UPLOAD_IMAGE,$file_name.$key.'thumb',STYLE_THUMB);
				$upload_image=true;	
				$data['ten_'.$key] = $_POST['ten_'.$key];	
				$data['mota_'.$key] = $_POST['mota_'.$key];
			}
		}
		$data['stt'] = $_POST['stt'];
		$data['id_list'] = (int)$_POST['id_list'];
		$data['link'] = $_POST['link'];	
		$data['type'] = $_POST['type'];									
		$data['hienthi'] = isset($_POST['active']) ? 1 : 0;																	
		$d->setTable('photo');
		if(!$d->insert($data)) 
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=photo&act=man_photo&type=".$type);
		redirect("index.php?com=photo&act=man_photo&type=".$type);
	}
}
function delete_photo(){
	global $d,$type;
	if(isset($_GET['id'])){
		$id =  (int)$_GET['id'];
		$d->setTable('photo');
		$d->setWhere('id', $id);
		$d->select();
		if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=photo&act=man_photo&type=".$type);
		$row = $d->fetch_array();
		delete_file(UPLOAD_IMAGE.$row['photo_vi']);
		delete_file(UPLOAD_IMAGE.$row['thumb_vi']);
		delete_file(UPLOAD_IMAGE.$row['photo_en']);
		delete_file(UPLOAD_IMAGE.$row['thumb_en']);
		if($d->delete())
			redirect("index.php?com=photo&act=man_photo&type=".$type);
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=photo&act=man_photo&type=".$type);
	}else transfer("Không nhận được dữ liệu", "index.php?com=photo&act=man_photo&type=".$type);
}
?>	