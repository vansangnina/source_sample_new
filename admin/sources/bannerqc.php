<?php	if(!defined('SOURCE')){ die("Error"); }


switch($act){
	case "update":
		get_banner();
		$template = "bannerqc/banner_add";
		break;
	case "save":
		save_banner();
		break;
	default:
		$template = "index";
}


function get_banner(){
	global $d, $item,$type;
	$d->reset();
	$d->query("select * from #_photo where type='".$type."'");

	$item = $d->fetch_array();
}

function save_banner(){
	global $d,$config,$type;

	foreach ($config['lang'] as $key => $value) {
		$file_name[$key] = images_name($_FILES['file_'.$key]['name']);
	}

	$d->reset();
	$d->query("select * from #_photo where type='".$type."'");
	$item = $d->fetch_array();
	$id = (int)$item['id'];

	
	if($id > 0){ 
		foreach ($config['lang'] as $key => $value) {

			if($photo = upload_image("file_".$key, IMG_TYPE , UPLOAD_IMAGE,$file_name[$key])){

				$data['photo_'.$key] = $photo;
				$data['thumb_'.$key] = create_thumb($data['photo_'.$key], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_IMAGE,$file_name[$key],STYLE_THUMB);
				$d->setTable('photo');
				$d->setWhere('id', $id);
				$d->setWhere('type',$type);
				$d->select("photo_$key,thumb_$key");
				$row = $d->fetch_array();
				delete_file(UPLOAD_IMAGE.$row['photo_'.$key]);
				delete_file(UPLOAD_IMAGE.$row['thumb_'.$key]);
			}
		}
		$data['link'] = $_POST['link'];

		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$d->reset();
		$d->setTable('photo');
		$d->setWhere('id', $id);
		$d->setWhere('type',$_GET['type']);
		if($d->update($data)){
			transfer("Cập nhật dữ liệu thành công", "index.php?com=bannerqc&act=capnhat&type=".$type."");
		}
		else{
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=bannerqc&act=capnhat&type=".$type."");
		}
	}else{ 
		foreach ($config['lang'] as $key => $value) {
			if($photo = upload_image("file_".$key, IMG_TYPE, UPLOAD_IMAGE,$file_name[$key])){
				$data['photo_'.$key] = $photo; 
				$data['thumb_'.$key] = create_thumb($data['photo_'.$key], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_IMAGE,$file_name[$key],STYLE_THUMB);
			}
		}
		$data['link'] = $_POST['link'];
		$data['type'] = $type;

		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$d->reset();
		$d->setTable('photo');
		if($d->insert($data)){
			transfer("Lưu dữ liệu thành công","index.php?com=bannerqc&act=capnhat&type=".$type."");
		}
		else{
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=bannerqc&act=capnhat&type=".$type."");
		}
	
	}
}

?>