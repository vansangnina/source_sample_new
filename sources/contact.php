<?php if(!defined('SOURCE')){ die("Error"); }
		
	$d->reset();
	$d->query("select noidung_$lang,title,keywords,description from #_company where type='lienhe' ");
	$row_detail = $d->fetch_array();
	$title_bar = LIENHE;
	$keywords_bar = $row_setting['keywords'];
	$description_bar = $row_setting['description'];
	if(!empty($_POST) && isset($_POST['recaptcha_response_contact'])){
			
		$recaptcha_response = $_POST['recaptcha_response_contact'];
	    $ch = curl_init();

		curl_setopt_array($ch,array(
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
			$file_name = images_name($_FILES['file']['name']);
			if($file_att = upload_image("file", 'doc|docx|pdf|rar|zip|ppt|pptx|DOC|DOCX|PDF|RAR|ZIP|PPT|PPTX|xls|xlsx|jpg|png|gif|JPG|PNG|GIF', UPLOAD_IMAGE_L,$file_name)){
				$data1['photo'] = $file_att;
				
			}

			include_once "phpMailer/class.phpmailer.php";	
			$mail = new PHPMailer();
			include LIBRARIES.'config_mailserver.php';
			
			$mail->AddAddress($row_setting['email'],$row_setting['ten_'.$lang]);
			
			/*=====================================
			 * THIET LAP NOI DUNG EMAIL
	 		*=====================================*/

			//Thiết lập tiêu đề
			$mail->Subject    = '[Thư liên hệ từ '.$_POST['ten'].']';
			$mail->IsHTML(true);
			//Thiết lập định dạng font chữ
			$mail->CharSet = "utf-8";	
			$body = '<table>';
			$body .= '
				<tr> 
					<th colspan="2">&nbsp;</th>
				</tr>

				<tr>
					<th colspan="2">Thư liên hệ từ website <a href="'.$http.$config_url.'">www.'.$config_url.'</a></th>
				</tr>

				<tr>
					<th colspan="2">&nbsp;</th>
				</tr>

				<tr>
					<th>Họ tên :</th><td>'.$_POST['ten'].'</td>
				</tr>

				<tr>
					<th>Điện thoại :</th><td>'.$_POST['dienthoai'].'</td>
				</tr>

				<tr>
					<th>Email :</th><td>'.$_POST['email'].'</td>
				</tr>
				
			
				<tr>
					<th>Nội dung :</th><td>'.$_POST['noidung'].'</td>
				</tr>';
			$body .= '</table>';

			$data1['ten'] = $d->escape_str($_POST['ten']);
			$data1['diachi'] = $d->escape_str($_POST['diachi']);
			$data1['dienthoai'] = $d->escape_str($_POST['dienthoai']);
			$data1['email'] = $d->escape_str($_POST['email']);
			$data1['tieude'] = $d->escape_str($_POST['tieude']);
			$data1['noidung'] = $d->escape_str($_POST['noidung']);
			$data1['stt'] = (int)$_POST['stt'];
			$data1['type'] = "contact";
			$data1['ngaytao'] = time();
			$d->setTable('contact');
			$d->insert($data1);

				
			$mail->Body = $body;

			if($data1['photo']){
				$mail->AddAttachment(UPLOAD_IMAGE_L.$data1['photo']);
			}
		
			
			if($mail->Send()){	
				transfer("Thông tin liên hệ được gửi . Cảm ơn.", $http.$config_url."/lien-he");
			}else {
				transfer("Xin lỗi quý khách.<br>Hệ thống bị lỗi, xin quý khách thử lại.", $http.$config_url."/lien-he");
			}
		}else{
	        transfer("Xin lỗi quý khách.<br>Bạn đang cố spam dữ liệu.", $http.$config_url."/lien-he");
	    }
	}
?>