<?php if(!defined('SOURCE')){ die("Error"); }
	$user = isset($_GET['user']) ? addslashes($_GET['user']) : 0;

	if($user!=0){
		$d->reset();
		$d->query("select id,email,ten from #_thanhvien where md5(id)='".$user."'");
		if($d->num_rows()==1){
			$row_user = $d->fetch_array();
			$password_new = ChuoiNgauNhien(8);
			$data_user['password'] = md5(sha1($password_new.$config['salt']));
			$d->reset();
			$d->setTable("thanhvien");
			$d->setWhere("id",$row_user['id']);
			if($d->update($data_user)){
				include_once "phpMailer/class.phpmailer.php";
				$mail = new PHPMailer();

				include LIBRARIES.'config_mailserver.php'; 

				//Thiết lập thông tin người nhận
				$mail->AddAddress($row_user['email'], $row_user['ten']);

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
							<td colspan="2">Hi!: '.$row_user['ten'].'! </td>
						</tr>
						<tr>
							<th width="100px">Username :</th><td> <a href="mailto:'.$row_user['email'].'">'.$row_user['email'].'</a></td>
						</tr>
						<tr>
							<th width="100px">Password mới: </th><td>'.$password_new.'</td>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<td colspan="2"><i><b>Lưu ý:</b> Đây là email được gửi tự động từ hệ thống. Vui lòng không trả lời!</td>
						</tr>

						';
					$body .= '</table>';

				$mail->Body = $body;
				if($mail->Send()) {
					transfer("Đổi mật khẩu thành công.</br>Mất khẩu mới đã được gởi về email của bạn!", $http.$config_url,1);
				}
			}
		}else{
			transfer("Dữ liệu không có thực!", $http.$config_url,0);
		}
	}
?>