<?php if(!defined('SOURCE')){ die("Error"); }
switch($act){
	case "man_list":
		get_lists();
		$template = "product/list/items";
		break;
	case "add_list":		
		$template = "product/list/item_add";
		break;
	case "edit_list":		
		get_list();
		$template = "product/list/item_add";
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
		$template = "product/cat/items";
		break;
	case "add_cat":		
		$template = "product/cat/item_add";
		break;
	case "edit_cat":		
		get_cat();
		$template = "product/cat/item_add";
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
		$template = "product/item/items";
		break;
	case "add_item":		
		$template = "product/item/item_add";
		break;
	case "edit_item":		
		get_item();
		$template = "product/item/item_add";
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
		$template = "product/sub/items";
		break;
	case "add_sub":		
		$template = "product/sub/item_add";
		break;
	case "edit_sub":		
		get_sub();
		$template = "product/sub/item_add";
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
		$template = "product/man/items";
		break;
	case "add":		
		$template = "product/man/item_add";
		break;
	case "edit":		
		get_man();
		$template = "product/man/item_add";
		break;
	case "save":
		save_man();
		break;
		
	case "delete":
		delete_man();
		break;	
	
	case "man_properties":
		get_properties();
		$template = "product/properties/items";
		break;
	case "add_properties":
		$template = "product/properties/item_add";
		break;
	case "save_properties":
		save_properties();
		break;
	case "edit_properties":
		edit_properties();
		$template = "product/properties/item_add";
		break;
	case "delete_properties":
		delete_properties();
		break;
	default:
		$template = "index";
}

#====================================

function get_mans(){
	global $d,$type,$lang,$id_list,$id_cat,$id_item,$id_sub,$keyword,$items,$paging,$page;
	
	
	$per_page = 15; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_product ";
	$where .= " where type='".$type."' ";

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
	
	if($keyword!=''){
		$where.=" and ten_vi LIKE '%".$keyword."%'";
	}
	$where .=" order by id desc";

	$sql = "select ten_$lang as ten ,id,stt,hienthi,id_list,id_cat,noibat,id_item,photo,id_sub,banchay,soluong,new,km from $where $limit";
	$d->query($sql);
	$items = $d->result_array();

	$url = getCurrentPageURL();
	$paging = pagination($where,$per_page,$page,$url);		
	
}

function get_man(){
	global $d,$type, $item,$ds_tags,$ds_photo;
	$id = (int)(isset($_GET['id'])) ? (int)$_GET['id'] : 0;
	if($id==0)
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);

	$d->reset();
	$d->query("select * from #_product where id='".$id."'");
	if($d->num_rows()==0) 
		transfer("Dữ liệu không có thực", $_SESSION['links_re']);
	$item = $d->fetch_array();	

	$d->reset();
	$d->query("select * from #_product_photo where id_product='".$id."' and type='".$type."' order by stt,id desc ");
	$ds_photo = $d->result_array();	
}

function save_man(){
	global $d,$type;

	$file_name = images_name($_FILES['file']['name']);

	if(empty($_POST)) {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
	$id = (int)(isset($_POST['id'])) ? (int)$_POST['id'] : 0;
	$data = process_quote($_POST['data']);
	if($id > 0){
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_PRODUCT,$file_name)){
			$data['photo'] = $photo;
			//dongdauanh($photo,UPLOAD_PRODUCT);	
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_PRODUCT,$file_name,STYLE_THUMB);	
			$d->setTable('product');
			$d->setWhere('id', $id);
			$d->select("photo,thumb");
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_PRODUCT.$row['photo']);	
				delete_file(UPLOAD_PRODUCT.$row['thumb']);				
			}
		}

	    $data['id_list'] = (int)$_POST['id_list'];	
		$data['id_cat'] = (int)$_POST['id_cat'];
		$data['id_item'] = (int)$_POST['id_item'];
		$data['id_sub'] = (int)$_POST['id_sub'];
		$data['id_loaihinh'] = (int)$_POST['id_loaihinh'];
		$data['rate'] = (int)$_POST['rate'];
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['giaban'] = str_replace(',','',$_POST['giaban']);
		$data['giacu'] = str_replace(',','',$_POST['giacu']);
		$data['soluong'] = str_replace(',','',$_POST['soluong']);
		$data['masp'] = $d->escape_str($_POST['masp']);
		$data['tags'] = implode(',',$_POST['tags']);
		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		$d->reset();
		$d->setTable('product');
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
						$photo = upload_photos($file, IMG_TYPE, UPLOAD_PRODUCT,$file_name);
						$data1['photo'] = $photo;
						//dongdauanh($data1['photo'],UPLOAD_PRODUCT);
						$data1['thumb'] = create_thumb($data1['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_PRODUCT,$file_name,STYLE_THUMB);
						$data1['stt'] = (int)$_POST['stthinh'][$i];
						$data1['type'] = $type;	
						$data1['id_product'] = $id;
						$data1['hienthi'] = 1;
						$d->setTable('product_photo');
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
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_PRODUCT,$file_name)){
			$data['photo'] = $photo;
			//dongdauanh($data['photo'],UPLOAD_PRODUCT);		
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_PRODUCT,$file_name,STYLE_THUMB);	
		}		
		
	    $data['id_list'] = (int)$_POST['id_list'];	
		$data['id_cat'] = (int)$_POST['id_cat'];
		$data['id_item'] = (int)$_POST['id_item'];
		$data['id_sub'] = (int)$_POST['id_sub'];
		$data['id_loaihinh'] = (int)$_POST['id_loaihinh'];
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['rate'] = (int)$_POST['rate'];
		$data['giacu'] = str_replace(',','',$_POST['giacu']);
		$data['soluong'] = str_replace(',','',$_POST['soluong']);
		$data['giaban'] = str_replace(',','',$_POST['giaban']);
		$data['masp'] = $d->escape_str($_POST['masp']);
		if($_POST['tags']){
			$data['tags'] = implode(',',$_POST['tags']);
		}
		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
		$data['type'] = $type;
		$data['stt'] = (int)$_POST['stt'];
		
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->setTable('product');
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
						$photo = upload_photos($file, IMG_TYPE , UPLOAD_PRODUCT,$file_name);
						$data1['photo'] = $photo;
						//dongdauanh($data1['photo'],UPLOAD_PRODUCT);
						$data1['thumb'] = create_thumb($data1['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_PRODUCT,$file_name,STYLE_THUMB);
						$data1['stt'] = (int)$_POST['stthinh'][$i];
						$data1['type'] = $type;	
						$data1['id_product'] = $idInsert;
						$data1['hienthi'] = 1;
						$d->setTable('product_photo');
						$d->insert($data1);
					}
				}
	        }
			transfer("Cập nhật dữ liệu thành công", $_SESSION['links_re']);
		}
		else{
			transfer("Lưu dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}
}

function delete_man(){
	global $d;
	
	$id = (int)(isset($_GET['id'])) ? (int)$_GET['id'] : 0;
	$strId = isset($_GET['listid']) ? strip_tags($_GET['listid']) : '';
	if($id > 0){
		$d->reset();
		$d->query("select id,photo,thumb from #_product_photo where id_product='".$id."'");
		if($d->num_rows() > 0){
			$photo_lq = $d->result_array();
			for($i=0;$i<count($photo_lq);$i++){
				delete_file(UPLOAD_PRODUCT.$photo_lq[$i]['photo']);
				delete_file(UPLOAD_PRODUCT.$photo_lq[$i]['thumb']);
			}
		}
		$$d->reset();
		$d->query("delete from #_product_photo where id_product='".$id."'");

		$d->reset();
		$d->query("select id,photo,thumb from #_product where id='".$id."'");
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(UPLOAD_PRODUCT.$row['photo']);
				delete_file(UPLOAD_PRODUCT.$row['thumb']);
			}
			$d->reset();
			$d->query("delete from #_product where id='".$id."'");

			transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}elseif($strId!=''){

		$listid = explode(",",$strId); 
		for ($i=0 ; $i < count($listid) ; $i++){
			$id = (int)$listid[$i]; 
			$d->reset();
			$d->query("select id,photo,thumb from #_product_photo where id_product='".$id."'");
			if($d->num_rows() > 0){
				$photo_lq = $d->result_array();
				for($j=0;$j<count($photo_lq);$j++){
					delete_file(UPLOAD_PRODUCT.$photo_lq[$j]['photo']);
					delete_file(UPLOAD_PRODUCT.$photo_lq[$j]['thumb']);
				}
			}
			$d->reset();
			$d->query("delete from #_product_photo where id_product='".$id."'");

			$d->reset();
			$d->query("select id,photo,thumb from #_product where id='".$id."'");
			if($d->num_rows()>0){
				while($row = $d->fetch_array()){
					delete_file(UPLOAD_PRODUCT.$row['photo']);
					delete_file(UPLOAD_PRODUCT.$row['thumb']);
				}
				$d->reset();
				$d->query("delete from #_product where id='".$id."'");
			}
		}
		transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}
#=================List===================

function get_lists(){
	global $d, $items,$lang,$type,$keyword,$paging,$page;


	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_product_list where type='".$type."'";

	if($keyword!=""){
		$where.=" and ten_vi LIKE '%".$keyword."%'";
	}
	$where .=" order by stt,id desc";

	$sql = "select ten_$lang as ten,id,stt,hienthi,noibat from $where $limit";
	$d->query($sql);
	$items = $d->result_array();
    
    $url = getCurrentPageURL();
	$paging = pagination($where,$per_page,$page,$url);
}

function get_list(){
	global $d, $item,$type;

	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	if($id==0){
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
	
	$d->query("select * from #_product_list where id='".$id."'");
	if($d->num_rows()==0) {
		transfer("Dữ liệu không có thực", $_SESSION['links_re']);
	}
	$item = $d->fetch_array();
}

function save_list(){
	global $d,$type;
	
	$file_name=images_name($_FILES['file']['name']);
	$file_quangcao=images_name($_FILES['file']['quangcao']);
	
	if(empty($_POST)) {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
	$data = process_quote($_POST['data']);
	if($id > 0){
		if($photo = upload_image("file", IMG_TYPE , UPLOAD_PRODUCT,$file_name)){
			$data['photo'] = $photo;
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_PRODUCT,$file_name,STYLE_THUMB);	
			$d->setTable('product_list');
			$d->setWhere('id', $id);
			$d->select("photo,thumb");
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_PRODUCT.$row['photo']);
			}
		}
		if($quangcao = upload_image("quangcao", IMG_TYPE, UPLOAD_PRODUCT,$file_quangcao)){
			$data['quangcao'] = $quangcao;	
			$data['quangcao_thumb'] = create_thumb($data['quangcao'], WIDTH_THUMB_QC, HEIGHT_THUMB_QC, UPLOAD_PRODUCT,$file_quangcao,STYLE_THUMB);		
			$d->setTable('product_list');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_PRODUCT.$row['quangcao']);	
				delete_file(UPLOAD_PRODUCT.$row['quangcao_thumb']);				
			}
		}

		
		$data['links'] = $d->escape_str($_POST['links']);
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		$d->reset();
		$d->setTable('product_list');
		$d->setWhere('id', $id);
		if($d->update($data)){
			transfer("Cập nhật dữ liệu thành công", $_SESSION['links_re']);
		}
		else{
			transfer("Cập nhật dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}else{
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_PRODUCT,$file_name)){
			$data['photo'] = $photo;
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_PRODUCT,$file_name,STYLE_THUMB);	
		}
		if($quangcao = upload_image("quangcao", IMG_TYPE, UPLOAD_PRODUCT,$file_quangcao)){
			$data['quangcao'] = $quangcao;	
			$data['quangcao_thumb'] = create_thumb($data['quangcao'], WIDTH_THUMB_QC, HEIGHT_THUMB_QC, UPLOAD_PRODUCT,$file_quangcao,STYLE_THUMB);		
		}
		
		$data['links'] = $d->escape_str($_POST['links']);
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$data['type'] = $type;
		$d->setTable('product_list');
		$idInsert = $d->insert($data);
		if($idInsert > 0){
			transfer("Thêm dữ liệu thành công", $_SESSION['links_re']);
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
		$d->query("select id,photo,thumb from #_product_list where id='".$id."'");
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(UPLOAD_PRODUCT.$row['photo']);
				delete_file(UPLOAD_PRODUCT.$row['thumb']);
				delete_file(UPLOAD_PRODUCT.$row['quangcao']);
				delete_file(UPLOAD_PRODUCT.$row['quangcao_thumb']);
			}
			$d->reset();
			$d->query("delete from #_product_list where id='".$id."'");
			transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}elseif($strId!=''){
		$listid = explode(",",$strId); 
		for ($i=0 ; $i < count($listid) ; $i++){
			$id = (int)$listid[$i]; 	
			$d->reset();
			$d->query("select id,photo,thumb from #_product_list where id='".$id."'");
			if($d->num_rows()>0){
				while($row = $d->fetch_array()){
					delete_file(UPLOAD_PRODUCT.$row['photo']);
					delete_file(UPLOAD_PRODUCT.$row['thumb']);
					delete_file(UPLOAD_PRODUCT.$row['quangcao']);
					delete_file(UPLOAD_PRODUCT.$row['quangcao_thumb']);
				}
				$d->reset();
				$d->query("delete from #_product_list where id='".$id."'");
			}
		}
		transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}

#=================cat===================
function get_cats(){
	global $d, $items,$id_list,$type,$lang,$keyword,$paging,$page;

	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	
	$where = " #_product_cat where type='".$type."' ";

	
	if($keyword!=''){
		$where.=" and ten_vi LIKE '%".$keyword."%'";
	}
	if($id_list > 0){
		$where.=" and id_list='".$id_list."'";
	}

	$where .=" order by id desc";
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
	
	$$d->reset();
	$d->query("select * from #_product_cat where id='".$id."'");
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
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_PRODUCT,$file_name)){
			$data['photo'] = $photo;
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_PRODUCT,$file_name,STYLE_THUMB);
			$d->setTable('product_cat');
			$d->setWhere('id', $id);
			$d->select("photo,thumb");
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_PRODUCT.$row['photo']);
				delete_file(UPLOAD_PRODUCT.$row['thumb']);
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
		$d->setTable('product_cat');
		$d->setWhere('id', $id);
		if($d->update($data)){
			transfer("Cập nhật dữ liệu thành công", $_SESSION['links_re']);
		}
		else{
			transfer("Cập nhật dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}else{
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_PRODUCT,$file_name)){
			$data['photo'] = $photo;
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_PRODUCT,$file_name,STYLE_THUMB);
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
		$d->setTable('product_cat');
		$idInsert = $d->insert($data);
		if($idInsert > 0){
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
	$strId = isset($_GET['listid']) ? strip_tags($_GET['listid']) : "";
	if($id > 0){
		$d->reset();
		$d->query("select id,photo,thumb from #_product_cat where id='".$id."'");
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(UPLOAD_PRODUCT.$row['photo']);
				delete_file(UPLOAD_PRODUCT.$row['thumb']);
			}
			$d->reset();
			$d->query("delete from #_product_cat where id='".$id."'");

			transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	} elseif ($strId!=""){
		$listid = explode(",",$strId); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$id = (int)$listid[$i]; 		
			$d->reset();
			$d->query("select id,photo,thumb from #_product_cat where id='".$id."'");
			if($d->num_rows()>0){
				while($row = $d->fetch_array()){
					delete_file(UPLOAD_PRODUCT.$row['photo']);
					delete_file(UPLOAD_PRODUCT.$row['thumb']);
				}
				$d->reset();
				$d->query("delete from #_product_cat where id='".$id."'");
			}
		}
		transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}
#=================Item===================
function get_items(){
	global $d, $items,$type,$lang,$id_list,$id_cat,$keyword,$paging,$page;

	
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_product_item ";
	$where .= " where type='".$type."' ";

	if($keyword!=''){
		$where.=" and ten_vi LIKE '%".$keyword."%'";
	}
	if($id_list > 0){
		$where.=" and id_list='".$id_list."'";
	}
	if($id_cat > 0){
		$where.=" and id_cat='".$id_cat."'";
	}

	$where .=" order by id desc";

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
	
	$d->reset();
	$d->query("select * from #_product_item where id='".$id."'");
	if($d->num_rows()==0) {
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

		if($photo = upload_image("file", IMG_TYPE, UPLOAD_PRODUCT,$file_name)){
			$data['photo'] = $photo;
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_PRODUCT,$file_name,STYLE_THUMB);
			$d->setTable('product_item');
			$d->setWhere('id', $id);
			$d->select("photo,thumb");
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_PRODUCT.$row['photo']);
				delete_file(UPLOAD_PRODUCT.$row['thumb']);
			}
		}
		$data['id_list'] = (int)$_POST['id_list'];
		$data['id_cat'] = (int)$_POST['id_cat'];
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		$d->reset();
		$d->setTable('product_item');
		$d->setWhere('id', $id);
		if($d->update($data)){
			transfer("Cập nhật dữ liệu thành công", $_SESSION['links_re']);
		}
		else{
			transfer("Cập nhật dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}else{
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_PRODUCT,$file_name)){
			$data['photo'] = $photo;
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_PRODUCT,$file_name,STYLE_THUMB);
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
		$d->setTable('product_item');
		$idInsert = $d->insert($data);
		if($idInsert > 0){
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
	$strId = isset($_GET['listid']) ? strip_tags($_GET['listid']) : "";
	if($id > 0){
		$d->reset();
		$d->query("select id,photo,thumb from #_product_item where id='".$id."'");
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(UPLOAD_PRODUCT.$row['photo']);
				delete_file(UPLOAD_PRODUCT.$row['thumb']);
			}
			$d->reset();
			$d->query("delete from #_product_item where id='".$id."'");

			transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	} elseif ($strId!=""){
		$listid = explode(",",$strId); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$id = (int)$listid[$i]; 	
			$d->reset();
			$d->query("select id,photo,thumb from #_product_item where id='".$id."'");
			if($d->num_rows()>0){
				while($row = $d->fetch_array()){
					delete_file(UPLOAD_PRODUCT.$row['photo']);
					delete_file(UPLOAD_PRODUCT.$row['thumb']);
				}
				$d->reset();
				$d->query("delete from #_product_item where id='".$id."'");
			}
		}
		transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}
#=================Sub===================

function get_subs(){
	global $d, $items,$lang,$id_list,$id_cat,$id_item,$type,$keyword,$paging,$page;


	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_product_sub where type='".$type."'";

	if($keyword!=''){
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
	if($id > 0){
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
	
	$sql = "select * from #_product_sub where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) {
		transfer("Dữ liệu không có thực", $_SESSION['links_re']);
	}
	$item = $d->fetch_array();
}

function save_sub(){
	global $d,$type;
	$file_name = images_name($_FILES['file']['name']);
	if(empty($_POST)) {
		transfer("Không nhận được dữ liệu",$_SESSION['links_re']);
	}
	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
	$data=process_quote($_POST['data']);
	if($id > 0){
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_PRODUCT,$file_name)){
			$data['photo'] = $photo;	
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_PRODUCT,$file_name,STYLE_THUMB);	
			$d->setTable('product_sub');
			$d->setWhere('id', $id);
			$d->select("photo,thumb");
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_PRODUCT.$row['photo']);	
				delete_file(UPLOAD_PRODUCT.$row['thumb']);				
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
		$d->setTable('product_sub');
		$d->setWhere('id', $id);
		if($d->update($data)){
			transfer("Cập nhật dữ liệu thành công", $_SESSION['links_re']);
		}
		else{
			transfer("Cập nhật dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}else{
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_PRODUCT,$file_name)){
			$data['photo'] = $photo;
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_PRODUCT,$file_name,STYLE_THUMB);
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
		$d->setTable('product_sub');
		$idInsert = $d->insert($data);
		if($idInsert > 0){
			transfer("Lưu dữ liệu thành công",$_SESSION['links_re']);
		}
		else{
			transfer("Lưu dữ liệu bị lỗi",$_SESSION['links_re']);
		}
	}
}

function delete_sub(){
	global $d;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	$strId = isset($_GET['listid']) ? strip_tags($_GET['listid']) : "";
	if($id > 0){
		$d->reset();
		$d->query("select id,photo,thumb from #_product_sub where id='".$id."'");
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(UPLOAD_PRODUCT.$row['photo']);
				delete_file(UPLOAD_PRODUCT.$row['thumb']);
			}
			$d->reset();
			$d->query("delete from #_product_sub where id='".$id."'");

			transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	} elseif ($strId!=""){
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$id = (int)$listid[$i]; 		
			$d->reset();
			$d->query("select id,photo,thumb from #_product_sub where id='".$id."'");
			if($d->num_rows()>0){
				while($row = $d->fetch_array()){
					delete_file(UPLOAD_PRODUCT.$row['photo']);
					delete_file(UPLOAD_PRODUCT.$row['thumb']);
				}
				$d->reset();
				$d->query("delete from #_product_sub where id='".$id."'");
			}
		}
		transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}
#====================================

function get_properties(){
	global $d,$lang, $items,$keyword,$type,$paging,$page;

	$idProduct = isset($_GET['id_product']) ? (int)$_GET['id_product'] : 0;

	$d->reset();
	$d->query("select id from #_product where id='".$id_product."'");
	if($d->num_rows()==0){
		transfer("Dữ liệu liệu không có thực", $_SESSION['links_re']);
	}

	$per_page = 15; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;

	
	$where = "#_product_properties where type='".$type."' and id_product='".$idProduct."'";

	if($keyword!=""){
		$where.=" and ten_vi LIKE '%".$keyword."%'";
	}
	$where .=" order by id desc";

	$d->reset();
	$d->query("select id,stt,hienthi,ten_$lang as ten,type from $where $limit");
	$items = $d->result_array();

	$url = getCurrentPageURL();
	$paging = pagination($where,$per_page,$page,$url);	
}

function edit_properties(){
	global $d, $item;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	if($id==0){
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);	
	}
	$d->reset();
	$d->query("select * from #_product_properties where id='".$id."'");
	if($d->num_rows()==0) {
		transfer("Dữ liệu không có thực", $_SESSION['links_re']);
	}
	$item = $d->fetch_array();	
}
function save_properties(){
	global $d,$type;
	$file_name = images_name($_FILES['file']['name']);

	if(empty($_POST)) {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
	$idProduct = isset($_GET['id_product']) ? (int)$_GET['id_product'] : 0;
	$data = process_quote($_POST['data']);
	if($id > 0){

		if($photo = upload_image("file", IMG_TYPE, UPLOAD_PRODUCT,$file_name)){
			$data['photo'] = $photo;
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_PRODUCT,$file_name,STYLE_THUMB);	
			$d->setTable('product_properties');
			$d->setWhere('id', $id);
			$d->select("photo,thumb");
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_PRODUCT.$row['photo']);	
				delete_file(UPLOAD_PRODUCT.$row['thumb']);				
			}
		}
		$data['colorId'] = (int)$_POST['colorId'];
		$data['sizeId'] = (int)$_POST['sizeId'];
		$data['color'] = $_POST['color'];
		$data['giaban'] = str_replace(',','',$_POST['giaban']);
		$data['giacu'] = str_replace(',','',$_POST['giacu']);
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		$d->reset();
		$d->setTable('product_properties');
		$d->setWhere('id',$id);
		if($d->update($data)){
			transfer("Cập nhật dữ liệu thành công", $_SESSION['links_re']);
		}
		else{
			transfer("Cập nhật dữ liệu bị lỗi", $_SESSION['links_re']);
		}
		
	}else{
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_PRODUCT,$file_name)){
			$data['photo'] = $photo;		
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_PRODUCT,$file_name,STYLE_THUMB);	
		}	
		$data['colorId'] = (int)$_POST['colorId'];
		$data['sizeId'] = (int)$_POST['sizeId'];
		$data['id_product'] = $idProduct;
		$data['color'] = $_POST['color'];
		$data['giaban'] = str_replace(',','',$_POST['giaban']);
		$data['giacu'] = str_replace(',','',$_POST['giacu']);
		$data['stt'] = (int)$_POST['stt'];
		$data['type'] = $type;
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->setTable('product_properties');
		$idInsert = $d->insert($data);
		if($idInsert > 0){
			transfer("Lưu dữ liệu thành công", $_SESSION['links_re']);
		}
		else{
			transfer("Lưu dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}
}
function delete_properties(){
	global $d;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	$strId = isset($_GET['idcolor']) ? strip_tags($_GET['idcolor']) : "";
	if($id > 0){
		$d->reset();
		$d->query("select id,photo,thumb from #_product_properties where id='".$id."'");
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(UPLOAD_PRODUCT.$row['photo']);
				delete_file(UPLOAD_PRODUCT.$row['thumb']);
			}
			$d->reset();
			$d->query("delete from #_product_properties where id='".$id."'");

			transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}elseif ($strId!=""){
		$listid = explode(",",$_GET['idcolor']); 
		for ($i=0 ; $i < count($listid) ; $i++){
			$id = (int)$listid[$i]; 	
			$d->reset();
			$d->query("select id,photo,thumb from #_product_properties where id='".$id."'");
			if($d->num_rows()>0){
				while($row = $d->fetch_array()){
					delete_file(UPLOAD_PRODUCT.$row['photo']);
					delete_file(UPLOAD_PRODUCT.$row['thumb']);
				}
				$d->reset();
				$d->query("delete from #_product_properties where id='".$id."'");
			}
		}
		transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}
?>