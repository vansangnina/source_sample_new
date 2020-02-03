<?php	if(!defined('SOURCE')) { die("Error"); }
switch($act){

	case "man_list":
		get_lists();
		$template = "alt/list/items";
		break;
	case "add_list":		
		$template = "alt/list/item_add";
		break;
	case "edit_list":		
		get_list();
		$template = "alt/list/item_add";
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
		$template = "alt/cat/items";
		break;
	case "add_cat":		
		$template = "alt/cat/item_add";
		break;
	case "edit_cat":		
		get_cat();
		$template = "alt/cat/item_add";
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
		$template = "alt/item/items";
		break;
	case "add_item":		
		$template = "alt/item/item_add";
		break;
	case "edit_item":		
		get_item();
		$template = "alt/item/item_add";
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
		$template = "alt/sub/items";
		break;
	case "add_sub":		
		$template = "alt/sub/item_add";
		break;
	case "edit_sub":		
		get_sub();
		$template = "alt/sub/item_add";
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
		$template = "alt/man/items";
		break;
	case "add":		
		$template = "alt/man/item_add";
		break;
	case "edit":		
		get_man();
		$template = "alt/man/item_add";
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
	global $d, $items, $paging,$page, $id_list,$id_cat,$keyword,$type;
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_place_street";

	if($id_list>0)
	{
		$where.=" where id_list = ".$id_list;
	}
	if($id_cat>0)
	{
		$where.=" where id_cat = ".$id_cat;
	}
	if(!empty($keyword))
	{
		$where.=" where ten LIKE '%$keyword%'";
	}
	$where .=" order by id desc";

	$sql = "select * from $where $limit";
	$d->query($sql);
	$items = $d->result_array();
	$url = "index.php?com=alt&act=man&type=".$type.$link_add;
	$paging = pagination($where,$per_page,$page,$url);	
}

function get_man(){
	global $d, $item;
	$id = (int)(isset($_GET['id'])) ? (int)$_GET['id'] : "";
	if(!$id){
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);	
	}
	$sql = "select * from #_place_street where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0){ transfer("Dữ liệu không có thực", $_SESSION['links_re']); }
	$item = $d->fetch_array();	
}

function save_man(){
	global $d,$config,$type;
	
	if(empty($_POST)){ transfer("Không nhận được dữ liệu", $_SESSION['links_re']); }
	$id = (int)(isset($_POST['id'])) ? (int)$_POST['id'] : "";
	if($id){
		$data['stt'] = (int)$_POST['stt'];
		$data['id_list'] = (int)$_POST['id_list'];
		$data['id_cat'] = (int)$_POST['id_cat'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ten'] = $d->escape_str($_POST['ten']);
		$data['ngaysua'] = time();
		$d->reset();
		$d->setTable('place_street');
		$d->setWhere('id', $id);
		if($d->update($data)){
			transfer("Cập nhật dữ liệu thành công", $_SESSION['links_re']);
		}
		else{
			transfer("Cập nhật dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}else{
		$data['stt'] = (int)$_POST['stt'];
		$data['id_list'] = (int)$_POST['id_list'];
		$data['id_cat'] = (int)$_POST['id_cat'];
		$data['ten'] = $d->escape_str($_POST['ten']);
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->setTable('place_street');
		if($d->insert($data)){
			transfer("Lưu dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Lưu dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}
}

function delete_man(){
	global $d;
	

	if(isset($_GET['id'])){
		$id =  (int)$_GET['id'];

		$d->reset();
		$sql = "select id,photo,thumb from #_chinhanh_photo where id_chinhanh='".$id."'";
		$d->query($sql);
		$photo_lq = $d->result_array();
		if(count($photo_lq)>0){
			for($i=0;$i<count($photo_lq);$i++){
				delete_file(UPLOAD_BRANCH.$photo_lq[$i]['photo']);
				delete_file(UPLOAD_BRANCH.$photo_lq[$i]['thumb']);
			}
		}
		$sql = "delete from #_chinhanh_photo where id_chinhanh='".$id."'";
		$d->query($sql);


		$d->reset();
		$sql = "select id,photo,thumb from #_chinhanh where id='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0){

			while($row = $d->fetch_array()){
				delete_file(UPLOAD_BRANCH.$row['photo']);
				delete_file(UPLOAD_BRANCH.$row['thumb']);
			}
			$sql = "delete from #_chinhanh where id='".$id."'";
			$d->query($sql);
		}
		if($d->query($sql)){
			transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	} elseif (isset($_GET['listid'])==true){

		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  (int)$idTin;	

			$d->reset();
			$sql = "select id,photo,thumb from #_chinhanh_photo where id_chinhanh='".$id."'";
			$d->query($sql);
			$photo_lq = $d->result_array();
			if(count($photo_lq)>0){
				for($j=0;$j<count($photo_lq);$j++){
					delete_file(UPLOAD_BRANCH.$photo_lq[$j]['photo']);
					delete_file(UPLOAD_BRANCH.$photo_lq[$j]['thumb']);
				}
			}
			$sql = "delete from #_chinhanh_photo where id_chinhanh='".$id."'";
			$d->query($sql);

			$d->reset();
			$sql = "select id,photo,thumb from #_chinhanh where id='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0){
				while($row = $d->fetch_array()){
					delete_file(UPLOAD_BRANCH.$row['photo']);
					delete_file(UPLOAD_BRANCH.$row['thumb']);
				}
				$sql = "delete from #_chinhanh where id='".$id."'";
				$d->query($sql);
			}
		}
		transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}


#=================List===================

function get_lists(){
	global $d, $items, $paging,$page,$keyword,$type;
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	
	$where = " #_place_city";
	

	if(!empty($keyword))
	{
		$where.=" where ten LIKE '%$keyword%'";
	}
	$where .=" order by stt desc,id asc";

	$sql = "select * from $where $limit";
	$d->query($sql);
	$items = $d->result_array();
    
    $url = "index.php?com=alt&act=man_list&type=".$type.$link_add;
	$paging = pagination($where,$per_page,$page,$url);
}

function get_list(){
	global $d, $item;

	$id = (int)(isset($_GET['id'])) ? (int)$_GET['id'] : "";
	if(!$id){
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
	
	$sql = "select * from #_place_city where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) { transfer("Dữ liệu không có thực", $_SESSION['links_re']);}
	$item = $d->fetch_array();
}

function save_list(){
	global $d,$type;
	
	
	if(empty($_POST)){ transfer("Không nhận được dữ liệu", "index.php?com=alt&act=man_list&type=".$type); }
	$id = (int)(isset($_POST['id'])) ? (int)$_POST['id'] : "";
	if($id){
		$data['ten'] = $d->escape_str($_POST['ten']);
		$data['tenkhongdau'] = changeTitle($data['ten']);
		$data['stt'] = (int)$_POST['stt'];
		$data['phiship'] = str_replace(',','',$_POST['phiship']);
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		$d->reset();
		$d->setTable('place_city');
		$d->setWhere('id', $id);
		if($d->update($data)){
			transfer("Cập nhật dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Cập nhật dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}else{
		
		$data['ten'] = $d->escape_str($_POST['ten']);
		$data['tenkhongdau'] = changeTitle($data['ten']);
		$data['phiship'] = str_replace(',','',$_POST['phiship']);
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->reset();
		$d->setTable('place_city');
		if($d->insert($data)){
			transfer("Lưu dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Lưu dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}
}

function delete_list(){
	global $d;
	
	if(isset($_GET['id'])){
		$id =  (int)$_GET['id'];
		$d->reset();
		$sql = "select id from #_place_city where id='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0){
			$sql = "delete from #_place_city where id='".$id."'";
			$d->query($sql);
		}
		if($d->query($sql)){
			transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	} elseif (isset($_GET['listid'])==true){
		$listid = explode(",", strip_tags($_GET['listid'])); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  (int)$idTin;		
			$d->reset();
			$sql = "select id from #_place_city where id='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0){
				$sql = "delete from #_place_city where id='".$id."'";
				$d->query($sql);
			}
		}
		transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}

#=================cat===================

function get_cats(){
	global $d, $items, $paging,$page,$id_list,$keyword,$type;


	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_place_dist where 1=1";

	if(!empty($keyword))
	{
		$where.=" and ten_vi LIKE '%$keyword%'";
	}
	if($id_list>0)
	{
		$where.=" and id_list=".$id_list;
	}

	$where .=" order by id desc";

	$sql = "select * from $where $limit";
	$d->query($sql);
	$items = $d->result_array();


	$url = "index.php?com=alt&act=man_cat&type=".$type.$link_add;
	$paging = pagination($where,$per_page,$page,$url);
}

function get_cat(){
	global $d, $item;

	$id = isset($_GET['id']) ? (int)$_GET['id'] : "";
	if(!$id){
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
	
	$sql = "select * from #_place_dist where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0){ transfer("Dữ liệu không có thực", $_SESSION['links_re']);}
	$item = $d->fetch_array();
}

function save_cat(){
	global $d;
	if(empty($_POST)){ transfer("Không nhận được dữ liệu", $_SESSION['links_re']);}
	$id = isset($_POST['id']) ? (int)$_POST['id'] : "";
	if($id){
		$data['id_list'] = (int)$_POST['id_list'];
		$data['ten'] = $d->escape_str($_POST['ten']);
		$data['tenkhongdau'] = changeTitle($data['ten']);
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		$d->reset();
		$d->setTable('place_dist');
		$d->setWhere('id', $id);
		if($d->update($data)){
			transfer("Cập nhật dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Cập nhật dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}else{
		$data['id_list'] = (int)$_POST['id_list'];
		$data['ten'] = $d->escape_str($_POST['ten']);
		$data['tenkhongdau'] = changeTitle($data['ten']);
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->reset();
		$d->setTable('place_dist');
		if($d->insert($data)){
			transfer("Lưu dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Lưu dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}
}

function delete_cat(){
	global $d;
	
	if(isset($_GET['id'])){
		$id =  (int)$_GET['id'];
		$d->reset();
		$sql = "select id from #_place_dist where id='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0){
			$sql = "delete from #_place_dist where id='".$id."'";
			$d->query($sql);
		}
		if($d->query($sql)){
			transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	} elseif (isset($_GET['listid'])==true){
		$listid = explode(",", $d->escape_str($_GET['listid'])); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  (int)$idTin;		
			$d->reset();
			$sql = "select id from #_place_dist where id='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0){
				$sql = "delete from #_place_dist where id='".$id."'";
				$d->query($sql);
			}
		}
		transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}
#=================Item===================

function get_items(){
	global $d, $items, $paging,$page,$keyword,$id_list,$id_cat,$type;

	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	$url = "index.php?com=alt&act=man_item";
	
	$where = " #_place_ward where 1=1";

	if(!empty($keyword))
	{
		$where.=" and ten LIKE '%$keyword%'";
	}
	if($id_list>0)
	{
		$where.=" and id_list=".$id_list;
	}
	if($id_cat>0)
	{
		$where.=" and id_cat=".$id_cat;
		
	}

	$where .=" order by id desc";

	$sql = "select * from $where $limit";
	$d->query($sql);
	$items = $d->result_array();

	$url = "index.php?com=alt&act=man_item&type=".$type.$link_add;
	$paging = pagination($where,$per_page,$page,$url);
}

function get_item(){
	global $d, $item;

	$id = isset($_GET['id']) ? (int)$_GET['id'] : "";
	if(!$id){
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
	
	
	$sql = "select * from #_place_ward where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0){ transfer("Dữ liệu không có thực", $_SESSION['links_re']);}
	$item = $d->fetch_array();
}

function save_item(){
	global $d;
	
	if(empty($_POST)){ transfer("Không nhận được dữ liệu", $_SESSION['links_re']);}
	$id = isset($_POST['id']) ? (int)$_POST['id'] : "";
	if($id){
		$data['id_list'] = (int)$_POST['id_list'];
		$data['id_cat'] = (int)$_POST['id_cat'];
		$data['ten'] = $d->escape_str($_POST['ten']);
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		$d->reset();
		$d->setTable('place_ward');
		$d->setWhere('id', $id);
		if($d->update($data)){
			transfer("Cập nhật dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Cập nhật dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}else{
		$data['id_list'] = (int)$_POST['id_list'];
		$data['id_cat'] = (int)$_POST['id_cat'];
		$data['ten'] = $d->escape_str($_POST['ten']);
		
		$data['stt'] = (int)$_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->reset();
		$d->setTable('place_ward');
		if($d->insert($data)){
			transfer("Lưu dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Lưu dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	}
}

function delete_item(){
	global $d;
	
	if(isset($_GET['id'])){
		$id =  (int)$_GET['id'];
		$d->reset();
		$sql = "select id from #_place_ward where id='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0){
			$sql = "delete from #_place_ward where id='".$id."'";
			$d->query($sql);
		}
		if($d->query($sql)){
			transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
		}else{
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
		}
	} elseif (isset($_GET['listid'])==true){
		$listid = explode(",", $d->escape_str($_GET['listid'])); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  (int)$idTin;		
			$d->reset();
			$sql = "select id from #_place_ward where id='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0){
				$sql = "delete from #_place_ward where id='".$id."'";
				$d->query($sql);
			}
		}
		transfer("Xóa dữ liệu thành công", $_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}
#=================Sub===================


?>