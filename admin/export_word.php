<?php
	session_start();
    date_default_timezone_set('Asia/Ho_Chi_Minh'); //Set múi giờ mặc định
	@define ( '_lib' , '../libraries/');
	include_once _lib."config.php";
	include_once _lib."constant.php";
	include_once _lib."functions.php";
	include_once _lib."library.php";
	
	$login_name = 'NINACO';
	
	if((!isset($_SESSION[$login_name]) || $_SESSION[$login_name]==false) && $act!="login"){
		redirect("index.php?com=user&act=login");
	}
	
	$d = new database($config['database']);
	$d->reset();
	//get id
	$id_order= intval($_GET['id']);
	if($id_order<=0){
		transfer("Không có dữ liệu","index.php?com=order&act=man");
		exit();
	}
	//get order 
	$sql="select * from #_order where id='$id_order'";
	$d->query($sql);
	$row_detail=$d->fetch_array();
	if($row_detail==null){
		transfer("Dữ liệu không có thực hoặc đã xóa","index.php?com=order&act=man");
		exit();
	}
	//get company info
	$sql = "select * from #_setting limit 0,1";
	$d->query($sql);
	$row_setting= $d->fetch_array();
	//get time
	$now = time();
	$ngay = "Ngày ".date("d",$now)." Tháng ".date("m",$now)." Năm ".date("Y",$now);
	//create
	require_once 'PHPWord.php';
	$PHPWord = new PHPWord();	
	//load template
	$document = $PHPWord->loadTemplate('donhang.docx');
	//set value company
	$document->setValue('{tencty}', $row_setting["ten_vi"]);
	$document->setValue('{diachicty}', $row_setting["diachi_vi"]);
	$document->setValue('{ngayht}', $ngay);
	//set value customer
	$document->setValue('{hotenkh}', $row_detail["hoten"]);
	$document->setValue('{dienthoaikh}', $row_detail["dienthoai"]);
	$document->setValue('{emailkh}', $row_detail["email"]);
	$document->setValue('{diachikh}', $row_detail["diachi"]);
	$document->setValue('{noidungkh}', $row_detail["noidung"]);
	//get order detail
	$sql="select * from #_order_detail where id_order=".$id_order;
	$d->query($sql);
	$row_order = $d->result_array();
	$data =  array();
	$total_price = 0;
	$total_count = 0;
	for ($i=0,$count=count($row_order); $i < $count; $i++) { 
		$data["stt"][$i] = $i+1;
		$data["name"][$i] = $row_order[$i]["ten"];
		$total_count += $soluong = $row_order[$i]["soluong"];
		$data["sl"][$i] = number_format($soluong);
		$gia = $row_order[$i]["gia"];
		$data["dg"][$i] = number_format($gia);
		$total_price += $thanhtien = $gia*$soluong ;
		$data["tt"][$i] = number_format($thanhtien);
	}
	//set value row table
	$document->cloneRow('TB', $data);
	//set value total
	$document->setValue('{tongsolg}', number_format($total_count));
	$document->setValue('{congtien}', number_format($total_price));
	$document->setValue('{thanhtien}', number_format($total_price));
	$document->setValue('{tongtienchu}', convert_number_to_words($total_price));
	//save file
	//$filename = "Don_Hang_".time().".docx";
	$filename = "Don_Hang_".time().".docx";
	$document->save($filename);
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.$filename);
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: '. filesize($filename));
	flush();
	readfile($filename);
	unlink($filename);

?>