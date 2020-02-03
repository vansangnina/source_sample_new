<?php	if(!defined('SOURCE')){ die("Error"); }

switch($act){
	case "capnhat":
		get_gioithieu();
		$template = "setting/item_add";
		break;
	case "save":
		save_gioithieu();
		break;
		
	default:
		$template = "index";
}

function get_gioithieu(){
	global $d, $item;

	$sql = "select * from #_setting limit 0,1";
	$d->query($sql);
	$item = $d->fetch_array();
}

function save_gioithieu(){
	global $d;
	$file_name=images_name($_FILES['file']['name']);
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=setting&act=capnhat");
		
	if($photo = upload_image("file", IMG_TYPE, UPLOAD_IMAGE,$file_name)){
		$data['photo'] = $photo;	
	}
	$data= process_quote($_POST['data']);

	$data['lang'] = $_POST['lang'];
	

	$data['thu2'] = $_POST['thu2'];
	$data['chunhat'] = $_POST['chunhat'];
	$data['tenph'] = $_POST['tenph'];
	$data['dienthoaiph'] = $_POST['dienthoaiph'];
	$data['emailph'] = $_POST['emailph'];
	$data['ngoaigio'] = $_POST['ngoaigio'];
	$data['datve'] = $_POST['datve'];
	upload_image("dongdau", 'png', '../upload/','watermark');
	$data['giolamviec'] = $_POST['giolamviec'];
	$data['googlemap'] = $_POST['googlemap'];
	$data['dienthoai'] = $_POST['dienthoai'];
	$data['email'] = $_POST['email'];
	$data['website'] = $_POST['website'];
	
	$data['facebook'] = $_POST['facebook'];
	$data['toado'] = $_POST['toado'];
	$data['hotline'] = $_POST['hotline'];
	
	$data['analytics'] = $d->escape_str($_POST['analytics']);
	$data['vchat'] = $d->escape_str($_POST['vchat']);
	$data['meta'] = $d->escape_str($_POST['meta']);
	$data['script_top'] = $d->escape_str($_POST['script_top']);
	$data['script_bottom'] = $d->escape_str($_POST['script_bottom']);

	$data['title'] = $_POST['title'];
	$data['keywords'] = $_POST['keywords'];
	$data['description'] = $_POST['description'];							
							
	$d->reset();
	$d->setTable('setting');
	if($d->update($data))
		header("Location:index.php?com=setting&act=capnhat");
	else
		transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=setting&act=capnhat");
}

?>