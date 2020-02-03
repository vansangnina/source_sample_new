<?php
	if($_SESSION['loginuser']){
		transfer("Vui lòng đăng xuất tài khoản trước khi đăng nhập tài khoản khác!", $http.$config_url ,1);
	}
	if(!empty($_POST)&& isset($_POST['username'])){
		$username = addslashes($_POST['username']);
		$password = addslashes($_POST['password']);
		$d->reset();
		$d->query("select * from #_thanhvien where email='".$username."'");
		if($d->num_rows() == 1){
			$row = $d->fetch_array();
			if($row['active']!=1){
				transfer("Bạn phải kích hoạt tài khoản của mình trước khi đăng nhập","dang-nhap",1);
			}else{
				if($row['password'] == md5(sha1($password.$config['salt']))){
					$_SESSION['loginuser'] = $row;
					$data1['lastlogin'] = time();
					$d->reset();
					$d->setTable("thanhvien");
					$d->setWhere("id",$row['id']);
					$d->update($data1);
					header("Location:".$http.$config_url);
				}else{
					transfer("Mật khẩu không đúng", "dang-nhap",0);
				}
			}
		}else{
			transfer("Tài khoản không tồn tại", "dang-nhap",0);
		}
	}

	$title_bar = "Đăng nhập";
?>
