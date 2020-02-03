<?php   
	session_start();
	@define ( '_lib' , '../libraries/');
	@define ( '_source' , '../sources/');
	$lang="vi";
	include_once _lib."config.php";
	include_once _lib."functions.php";
	include_once _lib."class.database.php";
	$d = new database($config['database']);
	include_once _source."lang_$lang.php";
	$http = get_http();
	if(isset($_POST) && isset($_POST['recapcha_register'])){
		
		$recaptcha_response = $_POST['recapcha_register'];
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
	    

	    if($recaptcha->score >= 0.5 && $recaptcha->action=='register') {

	    	$time =  time();
			$mathanhvien="TV".$time;

			$d->reset();
			$d->query("select ten_$lang from #_setting limit 0,1");
			$row_setting = $d->fetch_array();

			$randomkey = ramdomCodeText("text",4);
			$randomkey.= ramdomCodeText("number",6);
			$d->reset();
			$d->setTable("thanhvien");
			$d->setWhere('email',$_POST['email']);
			$d->select('email');
			if($d->num_rows()>0){
				$result['check'] = 0;
				$result['mess'] = "Email đã được đăng ký. Vui lòng nhập một email khác.";
				echo json_encode($result,true);
				die();
			}

			$d->reset();
			$d->setTable("thanhvien");
			$d->setWhere('dienthoai',$_POST['phone']);
			$d->select('dienthoai');
			if($d->num_rows()>0){
				$result['check'] = 0;
				$result['mess'] = "Số điện thoại đã được đăng ký. Vui lòng chọn số điện thoại khác.";
				echo json_encode($result,true);
				die();
			}

			$day = (int)$_POST['day'];
			$month = (int)$_POST['month'];
			$year = (int)$_POST['year'];

			$date_user = $year."-".$month."-".$day;

			$data_user['email'] = $d->escape_str($_POST['email']);
			$data_user['ten'] = $d->escape_str($_POST['name_user']);
			$data_user['dienthoai'] = $d->escape_str($_POST['phone']);
			
			$data_user['randomkey'] = $randomkey;
			$data_user['sex'] = (int)$_POST['sex'];
			$data_user['ngaysinh'] = strtotime($date_user);
			$data_user['password'] = md5(sha1($_POST['password'].$config['salt']));
			$data_user['mathanhvien'] = $mathanhvien;
			$data_user['ngaytao'] = time();
			$data_user['active'] = 0;

			$d->reset();
			$d->setTable('thanhvien');
			$idUser = $d->insert($data_user);
			if($idUser>0){
				include_once "../phpMailer/class.phpmailer.php";
				$mail = new PHPMailer();

				include _lib.'config_sendemail.php';

				//Thiết lập thông tin người nhận
				$mail->AddAddress($_POST['email'], $_POST['name_user']);

				//Thiết lập tiêu đề
				$mail->Subject    = "Xác nhận tài khoản";
				$mail->IsHTML(true);
				//Thiết lập định dạng font chữ
				$mail->CharSet = "utf-8";

				$body = '<table style="text-align:left;">';
				$body .= '
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2">Hi!: '.$_POST['name_user'].'! </td>
						</tr>
						<tr>
							<td colspan="2">Cảm ơn bạn đã đăng ký tài khoản trên '.$http.$config_url.'/ .</td>
						</tr>


						<tr>
							<th width="100px">Username :</th><td> <a href="mailto:'.$_POST['email'].'">'.$_POST['email'].'</a></td>
						</tr>
						<tr>
							<th width="100px">Password : </th><td>'.$_POST['password'].'</td>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<td colspan="2"><i><b>NOTE:</b> Vui lòng Click vào <a href="'.$http.$config_url.'/activated/'.md5($idUser).'">Tại đây</a> để kích hoạt tài khoản!</td>
						</tr>

						';
					$body .= '</table>';

				$mail->Body = $body;


				if($mail->Send()) {
					$result['check'] = 1;
					$result['mess'] = "Bạn đã đăng ký thành công. Vui lòng nhập email kích hoạt tài khoản của bạn!";
				}else{
					$result['check'] = 1;
					$result['mess'] = "Hệ thống gởi email tự động bị lỗi!";
				}
			}
			else{
				$result['check'] = 1;
				$result['mess'] = "Đăng ký không thành công. Vui lòng đăng ký lại.";
			}
		}else{
			$result['check'] = 1;
			$result['mess'] = "Hệ thống cho rằng bạn đang cố spam dữ liệu!";
		}
	}
	echo json_encode($result,true);
?>