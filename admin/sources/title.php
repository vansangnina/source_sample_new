<?php	if(!defined('SOURCE')){ die("Error"); }
switch($act){
	case "capnhat":
		get_info();
		$template = "title/item_add";
		break;
	case "save":
		save_info();
		break;		
	default:
		$template = "index";
}


function get_info(){
	global $d, $item;
	$type = $_GET['type'];

	$sql = "select * from #_title where type='$type' limit 0,1";	
	$d->query($sql);
	$item = $d->fetch_array();
	
}

function save_info(){
	global $d,$type,$curPage;
	$file_name = images_name($_FILES['file']['name']);

	$d->reset();
	$sql = "select * from #_title where type='".$type."' ";	
	$d->query($sql);
	$row_item = $d->result_array();

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=title&act=capnhat&type=".$type);

	if(count($row_item)>0){
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_SEO,$file_name)){
			$data['photo'] = $photo;	
			$data['thumb'] = create_thumb($data['photo'], 300, 300, UPLOAD_SEO,$file_name,1);	
			$d->setTable('title');
			$d->setWhere('type', $type);
			$d->select("photo,thumb");
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_SEO.$row['photo']);	
				delete_file(UPLOAD_SEO.$row['thumb']);				
			}
		}
		$data['title'] = $_POST['title'];
		$data['keywords'] = $_POST['keywords'];
		$data['description'] = $_POST['description'];
		$data['ngaysua'] = time();
		$d->setTable('title');
		$d->setWhere('type', $type);
		if($d->update($data))
			redirect("index.php?com=title&act=capnhat&curPage=".$curPage."&type=".$type);
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=title&act=capnhat&type=".$type);
	}else{
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_SEO,$file_name)){
			$data['photo'] = $photo;		
			$data['thumb'] = create_thumb($data['photo'], 300, 300, UPLOAD_SEO,$file_name,1);
		}	
		$data['type'] = $_GET['type'];
		$data['title'] = $_POST['title'];
		$data['keywords'] = $_POST['keywords'];
		$data['description'] = $_POST['description'];
		$data['ngaytao'] = time();
		$d->setTable('title');
		if($d->insert($data))
		{			
			redirect("index.php?com=title&act=capnhat&type=".$type);
		}
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=title&act=capnhat&type=".$type);
	}
}

?>