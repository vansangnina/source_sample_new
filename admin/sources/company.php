<<<<<<< HEAD
<?php	if(!defined('SOURCE')){ die("Error");}
=======
<?php	if(!defined('SOURCE')) { die("Error"); }

>>>>>>> developer
switch($act){
	case "update":
		get_company();
		$template = "company/item_add";
		break;
	case "save":
		save_company();
		break;		
	default:
		$template = "index";
}

function get_company(){
	global $d,$type, $item;
	$d->reset();	
	$d->query("select * from #_company where type='".$type."' limit 0,1");
	$item = $d->fetch_array();
}

function save_company(){
	global $d,$type;
	$file_name = images_name($_FILES['file']['name']);

	$d->reset();
	$d->query("select * from #_company where type='".$type."'");
	$row_item = $d->result_array();

	if(empty($_POST)) {
		transfer("Không nhận được dữ liệu", "index.php?com=company&act=update&type=".$type);
	}

	$data = process_quote($_POST['data']);
	
	if(count($row_item )>0){

		if($photo = upload_image("img", 'jpg|png|gif|JPG|jpeg|JPEG', _upload_company,$file_name)){
			$data['photo'] = $photo;	
			$data['thumb'] = create_thumb($data['photo'], 295, 195, UPLOAD_COMPANY,$file_name,1);		
			$d->setTable('baiviet');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_COMPANY.$row['photo']);	
				delete_file(UPLOAD_COMPANY.$row['thumb']);				
			}
		}

		$data['tenkhongdau'] = changeTitle($data['ten_vi']);
	
		
		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
		
		$data['stt'] = (int)$_POST['stt'];
		
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		
		$data['ngaysua'] = time();
		$d->reset();
		$d->setTable('company');
		$d->setWhere('type', $type);
		if($d->update($data)){
			transfer("Cập nhật dữ liệu thành công", "index.php?com=company&act=capnhat&type=".$type);
		}else{
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=company&act=capnhat&type=".$type);
		}
	}else{
		if($photo = upload_image("img", 'jpg|png|gif|JPG|jpeg|JPEG', UPLOAD_COMPANY,$file_name)){
			$data['photo'] = $photo;		
			$data['thumb'] = create_thumb($data['photo'], 295, 195, UPLOAD_COMPANY,$file_name,1);		
		}		

	
		$data['tenkhongdau'] = changeTitle($data['ten_vi']);

		$data['type'] = $type;

		$data['title'] = $d->escape_str($_POST['title']);
		$data['keywords'] = $d->escape_str($_POST['keywords']);
		$data['description'] = $d->escape_str($_POST['description']);
				
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;

		$data['ngaytao'] = time();
		$d->reset();
		$d->setTable('company');
		if($d->insert($data)){			
			transfer("Lưu dữ liệu thành công", "index.php?com=company&act=capnhat&type=".$type);
		}else{
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=company&act=capnhat&type=".$type);
		}
	}
}

?>