<?php	if(!defined('SOURCE')){ die("Error"); }
switch($act){
	case "man_list":
		get_lists();
		$template = "properties/list/items";
		break;
	case "add_list":		
		$template = "properties/list/item_add";
		break;
	case "edit_list":		
		get_list();
		$template = "properties/list/item_add";
		break;
	case "save_list":
		save_list();
		break;
	case "delete_list":
		delete_list();
		break;	

	case "man":
		get_mans();
		$template = "properties/man/items";
		break;
	case "add":		
		$template = "properties/man/item_add";
		break;
	case "edit":		
		get_man();
		$template = "properties/man/item_add";
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
	global $d, $items, $paging,$page,$type;
	
	#----------------------------------------------------------------------------------------
	
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_properties ";
	$where .= " where id<>0 and type='".$type."'";

	if($keyword!='')
	{
		
		$where.=" and ten_vi LIKE '%$keyword%'";
		$link_add .= "&keyword=".$keyword;
	}
	$where .=" order by stt,id desc";

	$sql = "select id,id_list,ten_vi,hienthi,stt from $where $limit";
	$d->query($sql);
	$items = $d->result_array();

	$url = "index.php?com=properties&act=man&type=".$type."".$link_add."&type=".$type;
	$paging = pagination($where,$per_page,$page,$url);		
		
}

function get_man(){
	global $d, $item,$ds_tags,$ds_photo,$type;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=properties&act=man&type=".$type);	
	$sql = "select * from #_properties where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=properties&act=man&type=".$type);
	$item = $d->fetch_array();	
}

function save_man(){
	global $d,$curPage,$type;
	$file_name=images_name($_FILES['file']['name']);
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=properties&act=man&type=".$type);
	$id = isset($_POST['id']) ? (int)$_POST['id'] : "";
	$data = process_quote($_POST['data']);
	if($id){
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_IMAGE,$file_name)){
			$data['photo'] = $photo;	
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_IMAGE,$file_name,STYLE_THUMB);		
			$d->setTable('properties');
			$d->setWhere('id', $id);
			$d->select("photo,thumb");
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_IMAGE.$row['photo']);	
				delete_file(UPLOAD_IMAGE.$row['thumb']);				
			}
		}
		

		$data['id_list'] = (int)$_POST['id_list'];
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['type'] = $_POST['type'];
		$data['ngaysua'] = time();

		$d->setTable('properties');
		$d->setWhere('id', $id);
		if($d->update($data)){

			
			redirect("index.php?com=properties&act=man&curPage=".$curPage."&type=".$type);
		}
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=properties&act=man&type=".$type);
	}else{
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_IMAGE,$file_name)){
			$data['photo'] = $photo;		
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_IMAGE,$file_name,STYLE_THUMB);		
		}

		
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['id_list'] = (int)$_POST['id_list'];
		$data['type'] = $_POST['type'];
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->setTable('properties');

		if($d->insert($data))
		{			
			redirect("index.php?com=properties&act=man&type=".$type);
		}
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=properties&act=man&type=".$type);
	}
}

function delete_man(){
	global $d,$type,$curPage;
	

	if(isset($_GET['id'])){
		$id =  (int)$_GET['id'];
		$d->reset();
		$sql = "select photo,thumb,id from #_properties where id='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(UPLOAD_IMAGE.$row['photo']);
				delete_file(UPLOAD_IMAGE.$row['thumb']);
			}
			$sql = "delete from #_properties where id='".$id."'";
			$d->query($sql);
		}

		if($d->query($sql))
			redirect("index.php?com=properties&act=man&curPage=".$curPage."&type=".$type);
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=properties&act=man&curPage=".$curPage."&type=".$type);
	} elseif (isset($_GET['listid'])==true){

		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  (int)$idTin;	
			$d->reset();
			$sql = "select id,photo,thumb from #_properties where id='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0){
				while($row = $d->fetch_array()){
					delete_file(UPLOAD_IMAGE.$row['photo']);
					delete_file(UPLOAD_IMAGE.$row['thumb']);
				}
				$sql = "delete from #_properties where id='".$id."'";
				$d->query($sql);
			}
			if(!$d->query($sql)){
				transfer("Xóa dữ liệu bị lỗi", "index.php?com=properties&act=man&curPage=".$curPage."&type=".$type);
			}
			
		}
		redirect("index.php?com=properties&act=man&curPage=".$curPage."&type=".$type);
	} else {
		transfer("Không nhận được dữ liệu", "index.php?com=properties&act=man&curPage=".$curPage."&type=".$type);
	}


}


function get_lists(){
	global $d, $items, $paging,$page,$curPage,$type;
	
	#----------------------------------------------------------------------------------------
	
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_properties_list ";
	$where .= " where id<>0 and type='".$type."'";

	if($keyword!='')
	{
		
		$where.=" and ten_vi LIKE '%$keyword%'";
		$link_add .= "&keyword=".$keyword;
	}
	$where .=" order by stt,id desc";

	$sql = "select id,ten_vi,hienthi,stt from $where $limit";
	$d->query($sql);
	$items = $d->result_array();

	$url = "index.php?com=properties&act=man_list".$link_add."&type=".$type;
	$paging = pagination($where,$per_page,$page,$url);		
		
}

function get_list(){
	global $d, $item,$ds_tags,$ds_photo,$type;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=properties&act=man_list&type=".$type);	
	$sql = "select * from #_properties_list where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=properties&act=man_list&type=".$type);
	$item = $d->fetch_array();	
}

function save_list(){
	global $d,$type,$curPage;
	$file_name=images_name($_FILES['file']['name']);
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=properties&act=man_list&type=".$type);
	$id = isset($_POST['id']) ? (int)$_POST['id'] : "";
	$data = process_quote($_POST['data']);
	if($id){
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_IMAGE,$file_name)){
			$data['photo'] = $photo;	
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_IMAGE,$file_name,STYLE_THUMB);		
			$d->setTable('properties_list');
			$d->setWhere('id', $id);
			$d->select("photo,thumb");
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_IMAGE.$row['photo']);	
				delete_file(UPLOAD_IMAGE.$row['thumb']);				
			}
		}
		
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['type'] = $_POST['type'];
		$data['ngaysua'] = time();

		$d->setTable('properties_list');
		$d->setWhere('id', $id);
		if($d->update($data)){
			redirect("index.php?com=properties&act=man_list&curPage=".$curPage."&type=".$type);
		}
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=properties&act=man_list&type=".$type);
	}else{
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_IMAGE,$file_name)){
			$data['photo'] = $photo;		
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_IMAGE,$file_name,STYLE_THUMB);		
		}

		
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['type'] = $_POST['type'];
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->setTable('properties_list');

		if($d->insert($data))
		{			
			redirect("index.php?com=properties&act=man_list&type=".$type);
		}
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=properties&act=man_list&type=".$type);
	}
}

function delete_list(){
	global $d,$type,$curPage;
	

	if(isset($_GET['id'])){
		$id =  (int)$_GET['id'];
		$d->reset();
		$sql = "select photo,thumb,id from #_properties_list where id='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(UPLOAD_IMAGE.$row['photo']);
				delete_file(UPLOAD_IMAGE.$row['thumb']);
			}
			$sql = "delete from #_properties_list where id='".$id."'";
			$d->query($sql);
		}

		if($d->query($sql))
			redirect("index.php?com=properties&act=man_list&curPage=".$curPage."&type=".$type);
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=properties&act=man_list&curPage=".$curPage."&type=".$type);
	} elseif (isset($_GET['listid'])==true){

		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  (int)$idTin);	
			$d->reset();
			$sql = "select id,photo,thumb from #_properties_list where id='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0){
				while($row = $d->fetch_array()){
					delete_file(UPLOAD_IMAGE.$row['photo']);
					delete_file(UPLOAD_IMAGE.$row['thumb']);
				}
				$sql = "delete from #_properties_list where id='".$id."'";
				$d->query($sql);
			}
			if(!$d->query($sql)){
				transfer("Xóa dữ liệu bị lỗi", "index.php?com=properties&act=man_list&curPage=".$curPage."&type=".$type);
			}
			
		}
		redirect("index.php?com=properties&act=man_list&curPage=".$curPage."&type=".$type);
	} else {
		transfer("Không nhận được dữ liệu", "index.php?com=properties&act=man_list&curPage=".$curPage."&type=".$type);
	}


}

?>