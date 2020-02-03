<?php	if(!defined('SOURCE')){ die("Error"); }
switch($act){
	case "man_list":
		get_lists();
		$template = "branch/list/items";
		break;
	case "add_list":		
		$template = "branch/list/item_add";
		break;
	case "edit_list":		
		get_list();
		$template = "branch/list/item_add";
		break;
	case "save_list":
		save_list();
		break;
	case "delete_list":
		delete_list();
		break;	
	#===================================================
	case "man_cat":
		get_cats();
		$template = "branch/cat/items";
		break;
	case "add_cat":		
		$template = "branch/cat/item_add";
		break;
	case "edit_cat":		
		get_cat();
		$template = "branch/cat/item_add";
		break;
	case "save_cat":
		save_cat();
		break;
	case "delete_cat":
		delete_cat();
		break;	
	#===================================================
	case "man_item":
		get_items();
		$template = "branch/item/items";
		break;
	case "add_item":		
		$template = "branch/item/item_add";
		break;
	case "edit_item":		
		get_item();
		$template = "branch/item/item_add";
		break;
	case "save_item":
		save_item();
		break;
	case "delete_item":
		delete_item();
		break;
	#===================================================
	case "man_sub":
		get_subs();
		$template = "branch/sub/items";
		break;
	case "add_sub":		
		$template = "branch/sub/item_add";
		break;
	case "edit_sub":		
		get_sub();
		$template = "branch/sub/item_add";
		break;
	case "save_sub":
		save_sub();
		break;
	case "delete_sub":
		delete_sub();
		break;	
	#===================================================
	case "man":
		get_mans();
		$template = "branch/man/items";
		break;
	case "add":		
		$template = "branch/man/item_add";
		break;
	case "edit":		
		get_man();
		$template = "branch/man/item_add";
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

	global $d, $items,$type,$lang,$keyword,$id_list,$id_cat,$id_item,$id_sub,$paging,$page;
	
	$per_page = 10; 
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_chinhanh where type='".$type."' ";

	if($id_list > 0){
		$where.=" and id_list = '".$id_list."'";
	}
	if($id_cat > 0){
		$where.=" and id_cat = '".$id_cat."'";
	}
	if($id_item > 0){
		$where.=" and id_item = '".$id_item."'";
	}
	if($id_sub > 0){
		$where.=" and id_sub = '".$id_sub."'";
	}
	if($keyword!=""){
		$where.=" and ten_vi LIKE '%".$keyword."%'";
	}
	$where .=" order by id desc";

	$d->reset();
	$d->query("select ten_$lang as ten,id,stt,hienthi,id_list,id_cat,noibat,id_item,id_sub from $where $limit");
	$items = $d->result_array();


	$url = getCurrentPageURL();
	$paging = pagination($where,$per_page,$page,$url);		
	
}

function get_man(){

	global $d,$type,$item,$ds_tags,$ds_photo;

	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	if($id==0){
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);	
	}
	$d->reset();
	$d->query("select * from #_chinhanh where id='".$id."'");
	if($d->num_rows()==0) {
		transfer("Dữ liệu không có thực", $_SESSION['links_re']);
	}
	$item = $d->fetch_array();	

	$d->reset();
	$d->query("select * from #_chinhanh_photo where id_chinhanh='".$id."' and type='".$type."' order by stt,id desc");
	$ds_photo = $d->result_array();	
}

function save_man(){

	global $d,$type,$config;

	$file_name = images_name($_FILES['file']['name']);

	if(empty($_POST)) {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
	$data = process_quote($_POST['data']);
	
	if($id > 0){
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_BRANCH,$file_name)){

			$data['photo'] = $photo;	
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_BRANCH,$file_name,STYLE_THUMB);		
			$d->setTable('chinhanh');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_BRANCH.$row['photo']);	
				delete_file(UPLOAD_BRANCH.$row['thumb']);				
			}
		}

	    $data['id_list'] = (int)$_POST['id_list'];	
		$data['id_cat'] = (int)$_POST['id_cat'];
		$data['id_item'] = (int)$_POST['id_item'];
		$data['id_sub'] = (int)$_POST['id_sub'];
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['giaban'] = str_replace(',','',$_POST['giaban']);
		$data['giacu'] = str_replace(',','',$_POST['giacu']);
		$data['masp'] = $d->escape_str($_POST['masp']);

		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
		$data['stt'] = (int)$_POST['stt'];

		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		$d->reset();
		$d->setTable('chinhanh');
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

						$photo = upload_photos($file, IMG_TYPE , UPLOAD_BRANCH,$file_name);
						$data1['photo'] = $photo;
						$data1['thumb'] = create_thumb($data1['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_BRANCH,$file_name,STYLE_THUMB);	
						$data1['stt'] = (int)$_POST['stthinh'][$i];
						$data1['type'] = $type;	
						$data1['id_chinhanh'] = $id;
						$data1['hienthi'] = 1;
						$d->setTable('chinhanh_photo');
						$d->insert($data1);
					}
				}
	        }

			transfer("Cập nhật dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Cập nhật dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}else{
		if($photo = upload_image("file", IMG_TYPE , UPLOAD_BRANCH,$file_name)){
			$data['photo'] = $photo;		
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_BRANCH,$file_name,STYLE_THUMB);
		}		
		
	    $data['id_list'] = (int)$_POST['id_list'];	
		$data['id_cat'] = (int)$_POST['id_cat'];
		$data['id_item'] = (int)$_POST['id_item'];
		$data['id_sub'] = (int)$_POST['id_sub'];
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['giacu'] = str_replace(',','',$_POST['giacu']);
		$data['giaban'] = str_replace(',','',$_POST['giaban']);
		$data['masp'] = $d->escape_str($_POST['masp']);

		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] =$d->escape_str( $_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
		$data['type'] = $type;
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->reset();
		$d->setTable('chinhanh');
		$idInsert = $d->insert($data);
		if($idInsert > 0){	
			if (isset($_FILES['files'])) {
	            for($i=0;$i<count($_FILES['files']['name']);$i++){
	            	if($_FILES['files']['name'][$i]!=''){

						$file['name'] = $_FILES['files']['name'][$i];
						$file['type'] = $_FILES['files']['type'][$i];
						$file['tmp_name'] = $_FILES['files']['tmp_name'][$i];
						$file['error'] = $_FILES['files']['error'][$i];
						$file['size'] = $_FILES['files']['size'][$i];
					    $file_name = images_name($_FILES['files']['name'][$i]);

						$photo = upload_photos($file, IMG_TYPE , UPLOAD_BRANCH,$file_name);
						$data1['photo'] = $photo;
						$data1['thumb'] = create_thumb($data1['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_BRANCH,$file_name,STYLE_THUMB);
						$data1['stt'] = (int)$_POST['stthinh'][$i];
						$data1['type'] = $type;	
						$data1['id_chinhanh'] = $idInsert;
						$data1['hienthi'] = 1;
						$d->setTable('chinhanh_photo');
						$d->insert($data1);
					}
				}
	        }

			transfer("Lưu dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Lưu dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}
}

function delete_man(){
	global $d;
	

	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	$strId = isset($_GET['listid']) ? strip_tags($_GET['listid']) : "";
	if($id > 0){
		$d->reset();
		$d->query("select id,photo,thumb from #_chinhanh_photo where id_chinhanh='".$id."'");
		$photo_lq = $d->result_array();
		if(count($photo_lq)>0){
			for($i=0;$i<count($photo_lq);$i++){
				delete_file(UPLOAD_BRANCH.$photo_lq[$i]['photo']);
				delete_file(UPLOAD_BRANCH.$photo_lq[$i]['thumb']);
			}
		}
		$d->reset();
		$d->query("delete from #_chinhanh_photo where id_chinhanh='".$id."'");


		$d->reset();
		$d->query("select id,photo,thumb from #_chinhanh where id='".$id."'");
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(UPLOAD_BRANCH.$row['photo']);
				delete_file(UPLOAD_BRANCH.$row['thumb']);
			}

			$d->reset();
			$d->query("delete from #_chinhanh where id='".$id."'");


			transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}

	} elseif ($strId!=""){

		$listid = explode(",", $d->escape_str($_GET['listid'])); 
		for ($i=0 ; $i<count($listid) ; $i++){

			$id = (int)$listid[$i]; 

			$d->reset();
			$d->query("select id,photo,thumb from #_chinhanh_photo where id_chinhanh='".$id."'");
			$photo_lq = $d->result_array();
			if(count($photo_lq)>0){
				for($j=0;$j<count($photo_lq);$j++){
					delete_file(UPLOAD_BRANCH.$photo_lq[$j]['photo']);
					delete_file(UPLOAD_BRANCH.$photo_lq[$j]['thumb']);
				}
			}
			$d->reset();
			$d->query("delete from #_chinhanh_photo where id_chinhanh='".$id."'");

			$d->reset();
			$d->query("select id,photo,thumb from #_chinhanh where id='".$id."'");
			if($d->num_rows()>0){
				while($row = $d->fetch_array()){
					delete_file(UPLOAD_BRANCH.$row['photo']);
					delete_file(UPLOAD_BRANCH.$row['thumb']);
				}
				$d->reset();
				$d->query("delete from #_chinhanh where id='".$id."'");
			}
		}
		transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}


}


#=================List===================

function get_lists(){

	global $d,$type,$items,$lang,$keyword,$paging,$page;

	
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	

	$where .= " #_chinhanh_list where type='".$type."'";

	if($keyword!=""){
		$where.=" and ten_vi LIKE '%".$keyword."%'";

	}
	$where .=" order by stt,id desc";

	$d->reset();
	$d->query("select ten_$lang as ten,id,stt,hienthi from $where $limit");
	$items = $d->result_array();
    

    $url = getCurrentPageURL();

	$paging = pagination($where,$per_page,$page,$url);
}

function get_list(){
	global $d, $item;


	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	if($id==0){
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
	
	$d->reset();
	$d->query("select * from #_chinhanh_list where id='".$id."'");
	if($d->num_rows()==0){
		transfer("Dữ liệu không có thực", $_SESSION['links_re']);
	}

	$item = $d->fetch_array();
}

function save_list(){
	global $d,$type;

	$file_name = images_name($_FILES['file']['name']);
	$file_quangcao = images_name($_FILES['file']['quangcao']);
	
	if(empty($_POST)) {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
	$data = process_quote($_POST['data']);

	if($id > 0){
		if($photo = upload_image("file", IMG_TYPE , UPLOAD_BRANCH,$file_name)){

			$data['photo'] = $photo;
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_BRANCH,$file_name,STYLE_THUMB);	
			$d->setTable('chinhanh_list');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_BRANCH.$row['photo']);

				delete_file(UPLOAD_BRANCH.$row['thumb']);
			}
		}

		

		$data['links'] = (string)$_POST['links'];
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		$d->reset();
		$d->setTable('chinhanh_list');
		$d->setWhere('id', $id);
		if($d->update($data)){
			transfer("Cập nhật dữ liệu thành công",$_SESSION['links_re']);
		}else{
			transfer("Cập nhật dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}else{

		if($photo = upload_image("file", IMG_TYPE , UPLOAD_BRANCH,$file_name)){
			$data['photo'] = $photo;
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_BRANCH,$file_name,STYLE_THUMB);	
		}
		

		$data['links'] = (string)$_POST['links'];
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$data['type'] = $type;
		$d->reset();

		$d->setTable('chinhanh_list');
		if($d->insert($data)){
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
		$d->query("select id,photo,thumb,quangcao,quangcao_thumb from #_chinhanh_list where id='".$id."'");
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(UPLOAD_BRANCH.$row['photo']);
				delete_file(UPLOAD_BRANCH.$row['thumb']);
			}

			$d->reset();
			$d->query("delete from #_chinhanh_list where id='".$id."'");
			transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}

	} elseif ($strId!=""){
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$id = (int)$listid[$i]; 	

			$d->reset();
			$d->query("select id,photo,thumb,quangcao,quangcao_thumb from #_chinhanh_list where id='".$id."'");
			if($d->num_rows()>0){
				while($row = $d->fetch_array()){
					delete_file(UPLOAD_BRANCH.$row['photo']);
					delete_file(UPLOAD_BRANCH.$row['thumb']);
				}
				$d->reset();
				$d->query("delete from #_chinhanh_list where id='".$id."'");
			}
		}
		transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}

#=================cat===================

function get_cats(){

	global $d, $items,$lang,$keyword,$id_list,$type,$paging,$page;


	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;

	
	$where = " #_chinhanh_cat where type='".$type."' ";

	if($keyword!=""){
		$where.=" and ten_vi LIKE '%".$keyword."%'";
	}
	if($id_list > 0){
		$where.=" and id_list='".$id_list."'";

	}

	$where .=" order by id desc";

	$d->reset();
	$d->query("select ten_$lang as ten,id,stt,hienthi,id_list from $where $limit");
	$items = $d->result_array();


	$url = getCurrentPageURL();

	$paging = pagination($where,$per_page,$page,$url);
}

function get_cat(){
	global $d, $item;


	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	if($id==0){
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
	
	$d->reset();
	$d->query("select * from #_chinhanh_cat where id='".$id."'");
	if($d->num_rows()==0) {
		transfer("Dữ liệu không có thực", $_SESSION['links_re']);
	}

	$item = $d->fetch_array();
}

function save_cat(){
	global $d,$type;

	$file_name = images_name($_FILES['file']['name']);
	
	if(empty($_POST)) {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
	$data = process_quote($_POST['data']);
	if($id > 0){
		if($photo = upload_image("file",IMG_TYPE , UPLOAD_BRANCH,$file_name)){

			$data['photo'] = $photo;
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_BRANCH,$file_name,STYLE_THUMB);
			$d->setTable('chinhanh_cat');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_BRANCH.$row['photo']);

				delete_file(UPLOAD_BRANCH.$row['thumb']);
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
		$d->setTable('chinhanh_cat');
		$d->setWhere('id', $id);
		if($d->update($data)){
			transfer("Cập nhật dữ liệu thành công", $_SESSION['links_re']);

		}
		else{
			transfer("Cập nhật dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}else{
		if($photo = upload_image("file", IMG_TYPE , UPLOAD_BRANCH,$file_name)){
			$data['photo'] = $photo;
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_BRANCH,$file_name,STYLE_THUMB);
		}
		$data['id_list'] = (int)$_POST['id_list'];
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
		$data['type'] = $type;
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->reset();
		$d->setTable('chinhanh_cat');
		if($d->insert($data)){
			transfer("Lưu dữ liệu thành công", $_SESSION['links_re']);
		}
		else{
			transfer("Lưu dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}
}

function delete_cat(){
	global $d;
	

	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	$strId = isset($_GET['listid']) ? strip_tags($_GET['listid']) ? "";
	if($id > 0){
		$d->reset();
		$d->query("select id,photo,thumb from #_chinhanh_cat where id='".$id."'");
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(UPLOAD_BRANCH.$row['photo']);
				delete_file(UPLOAD_BRANCH.$row['thumb']);
			}

			$d->reset();
			$d->query("delete from #_chinhanh_cat where id='".$id."'");

			transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}

	} elseif ($strId!=""){
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$id = (int)$listid[$i]; 	
			$d->reset();
			$d->query("select id,photo,thumb from #_chinhanh_cat where id='".$id."'");
			if($d->num_rows()>0){
				while($row = $d->fetch_array()){
					delete_file(UPLOAD_BRANCH.$row['photo']);
					delete_file(UPLOAD_BRANCH.$row['thumb']);
				}
				$d->reset();
				$d->query("delete from #_chinhanh_cat where id='".$id."'");
			}
		}
		transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}
#=================Item===================

function get_items(){

	global $d, $items,$lang,$id_list,$id_cat,$type, $paging,$page;


	$per_page = 10; 
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;


	

	$where .= " #_chinhanh_item where type='".$type."' ";

	if($keyword!=""){
		$where.=" and ten_vi LIKE '%".$keyword."%'";
	}
	if($id_list > 0){
		$where.=" and id_list='".$id_list."'";
	}
	if($id_cat > 0){
		$where.=" and id_cat='".$id_cat."'";

	}

	$where .=" order by id desc";

	$d->reset();
	$d->query("select ten_$lang as ten,id,stt,hienthi,id_list,id_cat from $where $limit");
	$items = $d->result_array();


	$url = getCurrentPageURL();
	$paging = pagination($where,$per_page,$page,$url);
}

function get_item(){
	global $d, $item;


	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	if($id==0){
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
	$d->query("select * from #_chinhanh_item where id='".$id."'");
	if($d->num_rows()==0){ 
		transfer("Dữ liệu không có thực", $_SESSION['links_re']);
	}
	$item = $d->fetch_array();
}

function save_item(){
	global $d,$type;


	$file_name = images_name($_FILES['file']['name']);
	
	if(empty($_POST)) {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
	$data = process_quote($_POST['data']);
	if($id > 0){
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_BRANCH,$file_name)){
			$data['photo'] = $photo;
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_BRANCH,$file_name,STYLE_THUMB);
			$d->setTable('chinhanh_item');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_BRANCH.$row['photo']);
				delete_file(UPLOAD_BRANCH.$row['thumb']);
			}
		}
		$data['id_list'] = (int)$_POST['id_list'];
		$data['id_cat'] = (int)$_POST['id_cat'];
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);

		$data['title'] = $dd->escape_str($_POST['title']);
		$data['keywords'] = $dd->escape_str($_POST['keywords']);
		$data['description'] = $dd->escape_str($_POST['description']);
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		$d->reset();
		$d->setTable('chinhanh_item');
		$d->setWhere('id', $id);
		if($d->update($data)){
			transfer("Cập nhật dữ liệu thành công", $_SESSION['links_re']);

		}
		else{
			transfer("Cập nhật dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}else{
		if($photo = upload_image("file", IMG_TYPE , UPLOAD_BRANCH,$file_name)){
			$data['photo'] = $photo;
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_BRANCH,$file_name,STYLE_THUMB);
		}
		$data['id_list'] = (int)$_POST['id_list'];
		$data['id_cat'] = (int)$_POST['id_cat'];
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
		$data['type'] = $type;
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->reset();
		$d->setTable('chinhanh_item');
		if($d->insert($data)){
			transfer("Lưu dữ liệu thành công", $_SESSION['links_re']);

		}
		else{
			transfer("Lưu dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}
}

function delete_item(){
	global $d;

	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	$strId = isset($_GET['listid']) ? strip_tags($_GET['listid']) ? "";
	if($id  > 0){
		$d->reset();
		$d->query("select id,photo,thumb from #_chinhanh_item where id='".$id."'");
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(UPLOAD_BRANCH.$row['photo']);
				delete_file(UPLOAD_BRANCH.$row['thumb']);
			}

			$d->reset();
			$d->query("delete from #_chinhanh_item where id='".$id."'");
			transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}

	} elseif ($strId!=""){
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$id = (int)$listid[$i];	
			$d->reset();
			$d->query("select id,photo,thumb from #_chinhanh_item where id='".$id."'");
			if($d->num_rows()>0){
				while($row = $d->fetch_array()){
					delete_file(UPLOAD_BRANCH.$row['photo']);
					delete_file(UPLOAD_BRANCH.$row['thumb']);
				}
				$d->reset();
				$d->query("delete from #_chinhanh_item where id='".$id."'");
			}
		}
		transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}
#=================Sub===================

function get_subs(){

	global $d, $items,$type,$lang,$id_list,$id_cat,$id_item, $keyword,$paging,$page;

	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;


	$where = " #_chinhanh_sub where type='".$type."' ";

	if($keyword!=""){
		$where.=" and ten_vi LIKE '%".$keyword."%'";
	}
	if($id_list > 0){
		$where.=" and id_list='".$id_list."'";
	}
	if($id_cat > 0){
		$where.=" and id_cat='".$id_cat."'";
	}
	if($id_item > 0){
		$where.=" and id_item='".$id_item."'";
	}
	$where .=" order by id desc";

	$d->reset();
	$d->query("select ten_$lang as ten,id,stt,hienthi,id_list,id_cat,id_item from $where $limit");
	$items = $d->result_array();


	$url = getCurrentPageURL();
	$paging = pagination($where,$per_page,$page,$url);
}

function get_sub(){
	global $d, $item;


	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	if($id==0){
		transfer("Không nhận được dữ liệu",$_SESSION['links_re']);
	}
	$d->query( "select * from #_chinhanh_sub where id='".$id."'");
	if($d->num_rows()==0) {
		transfer("Dữ liệu không có thực", $_SESSION['links_re']);
	}
	$item = $d->fetch_array();
}

function save_sub(){
	global $d,$type;

	$file_name = images_name($_FILES['file']['name']);
	if(empty($_POST)) {
		transfer("Không nhận được dữ liệu",$_SESSION['links_re'] );
	}
	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
	$data = process_quote($_POST['data']);
	if($id > 0){
		if($photo = upload_image("file", IMG_TYPE , UPLOAD_BRANCH,$file_name)){
			$data['photo'] = $photo;	
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_BRANCH,$file_name,STYLE_THUMB);	
			$d->setTable('chinhanh_sub');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_BRANCH.$row['photo']);	
				delete_file(UPLOAD_BRANCH.$row['thumb']);				
			}
		}
		$data['id_list'] = (int)$_POST['id_list'];
		$data['id_cat'] = (int)$_POST['id_cat'];
		$data['id_item'] = (int)$_POST['id_item'];
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		$d->reset();
		$d->setTable('chinhanh_sub');
		$d->setWhere('id', $id);
		if($d->update($data)){
			transfer("Cập nhật dữ liệu thành công", $_SESSION['links_re']);

		}
		else{
			transfer("Cập nhật dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}else{
		if($photo = upload_image("file", IMG_TYPE , UPLOAD_BRANCH,$file_name)){
			$data['photo'] = $photo;
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_BRANCH,$file_name,STYLE_THUMB);
		}
		$data['id_list'] = (int)$_POST['id_list'];
		$data['id_cat'] = (int)$_POST['id_cat'];
		$data['id_item'] = (int)$_POST['id_item'];
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
		$data['type'] = $type;
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->reset();
		$d->setTable('chinhanh_sub');
		if($d->insert($data)){
			transfer("Lưu dữ liệu thành công", $_SESSION['links_re']);

		}
		else{
			transfer("Lưu dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}
}

function delete_sub(){
	global $d;

	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	$strId = isset($_GET['listid']) ? strip_tags($_GET['listid']) : "";
	if($id > 0){
		$d->reset();
		$d->query("select id,photo,thumb from #_chinhanh_sub where id='".$id."'");
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(UPLOAD_BRANCH.$row['photo']);
				delete_file(UPLOAD_BRANCH.$row['thumb']);
			}

			$d->reset();
			$d->query("delete from #_chinhanh_sub where id='".$id."'");

			transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}

	} elseif ($strId!=""){
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$id = (int)$listid[$i]; 	
			$d->reset();
			$d->query("select id,photo,thumb from #_chinhanh_sub where id='".$id."'");
			if($d->num_rows()>0){
				while($row = $d->fetch_array()){
					delete_file(UPLOAD_BRANCH.$row['photo']);
					delete_file(UPLOAD_BRANCH.$row['thumb']);
				}
				$d->reset();
				$d->query("delete from #_chinhanh_sub where id='".$id."'");
			}
		}
		transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}
?>