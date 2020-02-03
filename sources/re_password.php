<?php   if(!defined('SOURCE')){ die("Error"); }
	if(!empty($_POST) && isset($_POST['username'])){
		$username = addslashes($_POST['username']);

		$d->reset();
		$d->query("select id,ten,email from #_thanhvien where email='".$username."'");
		if($d->num_rows() == 1){
			$row = $d->fetch_array();

			include_once "phpMailer/class.phpmailer.php";
			$mail = new PHPMailer();

			include LIBRARIES.'config_mailserver.php';

			//Thiết lập thông tin người nhận
			$mail->AddAddress($row['email'], $row['ten']);

			//Thiết lập tiêu đề
			$mail->Subject    = "Cấp lại mật khẩu tài khoản";
			$mail->IsHTML(true);
			//Thiết lập định dạng font chữ
			$mail->CharSet = "utf-8";

			$body = '<table style="text-align:left;">';
			$body .= '
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">Hi!: '.$row['ten'].'! </td>
					</tr>
					<tr>
						<td colspan="2">Đã có người thực hiện chức năng cấp lại mất khẩu tài khoản của bạn trên website '.$http.$config_url.'/ . </td>
					</tr>
					<tr><td colspan="2">Nếu không phải là bạn vui lòng bỏ qua email này.</td></tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr>
						<td colspan="2"><i><b>NOTE:</b> Vui lòng Click vào <a href="'.$http.$config_url.'/reset/'.md5($row['id']).'">Tại đây</a> để lấy lại mật khẩu tài khoản!</td>
					</tr>

					';
				$body .= '</table>';

			$mail->Body = $body;
			if($mail->Send()) {
				transfer("Hệ thống đã gởi vào tài khoản email của bạn.</br>Vui lòng truy cập email để lấy lại mật khẩu",$http.$config_url,1);
			}
		}else{
			transfer("Email tài khoản không tồn tại",$http.$config_url,0);
		}	
	}
?>