<?php	if(!defined('SOURCE')) { die("Error"); }
switch($act){
	case "capnhat":
		get_info();
		$template = "info/item_add";
		break;
	case "save":
		save_info();
		break;		
	default:
		$template = "index";
}


function get_info(){
	global $d, $item,$type;
	$sql = "select * from #_info where type='$type' limit 0,1";	
	$d->query($sql);
	$item = $d->fetch_array();
	
}

function save_info(){
	global $d,$type,$curPage;
	$file_name=images_name($_FILES['file']['name']);

	$d->reset();
	$sql = "select * from #_info where type='".$type."' ";	
	$d->query($sql);
	$row_item = $d->result_array();

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=info&act=capnhat&type=".$type);
	$data=process_quote($_POST['data']);
	if(count($row_item )>0){

		
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_IMAGE,$file_name)){
			$data['photo'] = $photo;	
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_IMAGE,$file_name,STYLE_THUMB);	
			$d->setTable('info');
			$d->setWhere('type', $type);
			$d->select("photo,thumb");
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_IMAGE.$row['photo']);	
				delete_file(UPLOAD_IMAGE.$row['thumb']);				
			}
		}

	
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		
		
		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
		
		$data['stt'] = (int) $_POST['stt'];
		
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		
		$data['ngaysua'] = time();
		$d->setTable('info');
		$d->setWhere('type', $type);
		if($d->update($data))
			redirect("index.php?com=info&act=capnhat&curPage=".$curPage."&type=".$type);
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=info&act=capnhat&type=".$type);
	}else{
		if($photo = upload_image("file", IMG_TYPE, UPLOAD_IMAGE,$file_name)){
			$data['photo'] = $photo;		
			$data['thumb'] = create_thumb($data['photo'], WIDTH_THUMB, HEIGHT_THUMB, UPLOAD_IMAGE,$file_name,STYLE_THUMB);
		}		

		
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
		$data['type'] = $type;

		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
				
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;

		$data['ngaytao'] = time();
		$d->setTable('info');
		if($d->insert($data))
		{			
			redirect("index.php?com=info&act=capnhat&type=".$type);
		}
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=info&act=capnhat&type=".$type);
	}
}

?>