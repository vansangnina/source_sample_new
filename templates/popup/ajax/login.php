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
	if($_SESSION['loginuser']){
		$result['mess'] = "Vui lòng đăng xuất tài khoản trước khi đăng nhập tài khoản khác!";
		$result['check'] = 0;
		die(json_encode($result,true));
	}
	if(!empty($_POST) && isset($_POST['username'])){
		$username = $_POST['username'];
		$password = $_POST['password'];

		$d->reset();
		$d->query("select * from #_thanhvien where email='".$username."' or dienthoai='".$username."'");
		if($d->num_rows() == 1){
			$row = $d->fetch_array();
			if($row['active']!=1){
				$result['check'] = 0;
				$result['mess'] = "Bạn phải kích hoạt tài khoản của mình trước khi đăng nhập";
			}else{
				if($row['password'] == encrypt_password($password,$config['salt'])){
					$_SESSION['loginuser'] = $row;
					$data_user['lastlogin'] = time();
					$d->reset();
					$d->setTable("thanhvien");
					$d->setWhere("id",$row['id']);
					$d->update($data_user);
					$result['check'] = 1;
					$result['mess'] = "";
				}else{
					$result['check'] = 0;
					$result['mess'] = "Mật khẩu không đúng";
				}
			}
		}else{
			$result['check'] = 0;
			$result['mess'] = "Tài khoản không tồn tại";
		}	
	}
	echo json_encode($result,true);
?>