<?php	if(!defined('SOURCE')) { die("Error"); }
switch($act){
	case "capnhat":
		get_gioithieu();
		$template = "footer/item_add";
		break;
	case "save":
		save_gioithieu();
		break;

		
	default:
		$template = "index";
}
function fns_Rand_digit($min,$max,$num)
	{
		$result='';
		for($i=0;$i<$num;$i++){
			$result.=rand($min,$max);
		}
		return $result;	
	}

function get_gioithieu(){
	global $d, $item;

	$sql = "select * from #_footer limit 0,1";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu chưa khởi tạo.", "index.php");
	$item = $d->fetch_array();
}

function save_gioithieu(){
	global $d;
	$file_name=fns_Rand_digit(0,9,5);
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=footer&act=capnhat");
	if($photo = upload_image("file", 'jpg|png|gif|JPG|jpeg|JPEG',UPLOAD_IMAGE,$file_name)){
			$data['photo'] = $photo;
			$d->setTable('footer');			
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(UPLOAD_IMAGE.$row['photo']);
			}
		}
	
	$data['mota'] = $d->escape_str($_POST['mota']);
	$data['noidung'] = $d->escape_str($_POST['noidung']);
	$d->reset();
	$d->setTable('footer');
	if($d->update($data))
		transfer("Dữ liệu được cập nhật", "index.php?com=footer&act=capnhat");
	else
		transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=footer&act=capnhat");
}

?>