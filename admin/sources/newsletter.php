<?php if(!defined('SOURCE')){ die("Error"); }




switch($act){
	case "man":
		get_mails();
		$template = "newsletter/items";
		break;
	
	case "add":

		$template = "newsletter/item_add";
		break;
	
	case "edit":
		get_mail();
		$template = "newsletter/item_add";
		break;	
		
	case "send":
		send();
		break;
	
	case "save":
		save_mail();
		break;	
	
	case "delete":
		delete();
		break;	

		
	default:
		$template = "index";
}

function get_mails(){
	global $d, $items;

	$sql = "select * from #_newsletter order by id desc";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu chưa khởi tạo.", "index.php");
	$items = $d->result_array();
}

function get_mail(){
	global $d, $item;
	$id = isset($_GET['id']) ? (int)$_GET['id']: "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=newsletter&act=man");
	
	$sql = "select * from #_newsletter where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=newsletter&act=man");
	$item = $d->fetch_array();
}

function save_mail(){
	global $d;
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=newsletter&act=man");
	$id = isset($_POST['id']) ? (int)$_POST['id'] : "";
	if($id){

		$data['email'] = $_POST['email'];
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		
		$d->setTable('newsletter');
		$d->setWhere('id', $id);
		if($d->update($data))
				redirect("index.php?com=newsletter&act=man");
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=newsletter&act=man");
	}else{
		
		
		$data['email'] = $_POST['email'];
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		
		$d->setTable('newsletter');
		if($d->insert($data))
			redirect("index.php?com=newsletter&act=man");
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=newsletter&act=man");
	}
}


function delete(){
	global $d;
	if(isset($_GET['id'])){
		$id =  (int)$_GET['id'];
		$sql = "delete from #_newsletter where id='".$id."'";
		$d->query($sql);
		if($d->query($sql))
			redirect("index.php?com=newsletter&act=man");
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=newsletter&act=man");
	}else transfer("Không nhận được dữ liệu", "index.php?com=newsletter&act=man");
	
		
}


function send(){
	global $d,$config;
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=newsletter&act=man");
	$d->reset();
	$d->setTable('setting');
	$d->select("ten_vi");
	$row_setting = $d->fetch_array();

	
	
	if(isset($_POST['listid'])){
		
		
		include_once "../phpMailer/class.phpmailer.php";	
		$mail = new PHPMailer();
		include _lib.'config_mailserver.php';


		$listid = explode(",",$_POST['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  (int)$idTin;		
			$d->reset();
			$d->query("select email from #_newsletter where id='".$id."'");
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				$mail->AddAddress($row['email'], $company_mail['ten_vi']);
			}
		}
		/*=====================================
		 * THIET LAP NOI DUNG EMAIL
 		*=====================================*/

		//Thiết lập tiêu đề
		$mail->Subject    = '['.$_POST['ten_vi'].']';
		$mail->IsHTML(true);
		//Thiết lập định dạng font chữ
		$mail->CharSet = "utf-8";	
		$body = $_POST['noidung_vi'];
		
		$mail->Body = $body;
		if($_FILES['file']['name']){
			$mail->AddAttachment($_FILES['file']['tmp_name'],$_FILES['file']['name']);
		}
		if($mail->Send())
			transfer("Thông tin đã được gửi đi.", "index.php?com=newsletter&act=man");
		else
			transfer("Hệ thống bị lỗi, xin thử lại sau.", "index.php?com=newsletter&act=man");
	
	}
	
}

?>