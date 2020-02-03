<?php  
	session_start();
	@define ( '_lib' , '../libraries/');
	@define ( '_source' , '../sources/');
	$lang="vi";
	include_once _lib."config.php";
	include_once _lib."functions.php";
	$d = new database($config['database']);
	include_once _source."lang_$lang.php";
	if(!empty($_POST) && isset($_POST['recaptcha_response_contact'])){
		$recaptcha_response = $_POST['recaptcha_response_contact'];
	    $ch = curl_init();

		curl_setopt_array($ch, array(
		    CURLOPT_URL => $api_url,
		    CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		    CURLOPT_CUSTOMREQUEST => "POST",
		    CURLOPT_POSTFIELDS => array(
		       'secret' => $secret_key,
		       'response' => $recaptcha_response,
		    ) 
		));
		$recaptcha = curl_exec($ch);

		curl_close($recaptcha);

	    $recaptcha = json_decode($recaptcha);
	    if($recaptcha->score >= 0.5 && $recaptcha->action=='contact') {

			include_once "../phpMailer/class.phpmailer.php";	
			$mail = new PHPMailer();
			include _lib.'config_mailserver.php'; 
			
			$d->query("select ten_$lang,email from table_setting");
			$row_setting = $d->fetch_array();
			
			
			$mail->AddAddress($row_setting['email'],$row_setting['ten_'.$lang]);
			
			/*=====================================
			 * THIET LAP NOI DUNG EMAIL
	 		*=====================================*/

			//Thiết lập tiêu đề
			$mail->Subject    = '[Thư đăng ký nhận báo giá '.$_POST['name'].']';
			$mail->IsHTML(true);
			//Thiết lập định dạng font chữ
			$mail->CharSet = "utf-8";	
			$body = '<table>';
			$body .= '
				<tr> 
					<th colspan="2">&nbsp;</th>
				</tr>

				<tr>
					<th colspan="2">Thư liên hệ từ website <a href="http://'.$config_url.'">'.$config_url.'</a></th>
				</tr>

				<tr>
					<th colspan="2">&nbsp;</th>
				</tr>

				<tr>
					<th>Họ tên :</th><td>'.$_POST['name'].'</td>
				</tr>

				<tr>
					<th>Điện thoại :</th><td>'.$_POST['phone'].'</td>
				</tr>';
			$body .= '</table>';

			$data1['ten'] = $d->escape_str($_POST['name']);
			$data1['dienthoai'] = $d->escape_str($_POST['phone']);
			$data1['email'] = "Đang cập nhật";
			$data1['noidung'] = "Đang cập nhật";
			$data1['tieude'] = "Đăng ký nhận thông tin";
			$data1['diachi'] = "Đang cập nhật";
			$data1['ngaytao'] = time();
			$d->setTable('contact');
			$d->insert($data1);
			$mail->Body = $body;
			if($mail->Send()){	
				echo 1;
			}else{
				echo 0;
			}
		}else{
			echo 2;
		}
	}
?>