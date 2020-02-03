<?php if(!defined('SOURCE')) { die("Error"); }
			
	if(!$_SESSION['loginuser']){
		transfer("Vui lòng đăng nhập tài khoản", $http.$config_url."/dang-nhap",0);
	}
	
	$id =  addslashes($_SESSION['loginuser']['id']);
	
	$d->reset();
	$d->setTable("thanhvien");
	$d->setWhere("id",$id);
	$d->select();
	
	if($d->num_rows()==0){
		transfer("Tài khoản không tồn tại", $http.$config_url,0);
	}else{
		$result_user = $d->fetch_array();

		$d->reset();
		$d->setTable("place_city");
		$d->select("ten_$lang as ten,id");
		$tinhthanh = $d->result_array();

		$d->reset();
		$d->setTable("place_dist");
		$d->setWhere("id_list",$result_user['id_city']);
		$d->select("ten_$lang as ten,id");
		$quanhuyen = $d->result_array();
	}

	if(!empty($_POST)){ 
		$data1['thanhvien'] = $_POST['hoten'];
		$data1['ten'] = $_POST['hoten'];
		$data1['dienthoai'] = $_POST['dienthoai'];
		$data1['diachi'] = $d->escape_str($_POST['diachi']);
		$data1['id_city'] = (int)$_POST['tinhthanh'];
		$data1['id_district'] = (int)$_POST['quanhuyen'];
		$data1['ngaytao'] = time();
		if($_POST['password_old']!=''){
			if($result_user['password']!=md5(sha1($_POST['password_old'].$config['salt']))){
				transfer("Mật khẩu không chính xác.", getCurrentPageURL_CANO(),0);
			}
			if($_POST['password'] != $_POST['renew_pass']){
				transfer("Nhập mật khẩu xác nhận không chính xác.", getCurrentPageURL_CANO(),0);
			}
			$data1['password'] = md5(sha1($_POST['password'].$config['salt']));
		}
		$d->reset();
		$d->setTable('thanhvien');
		$d->setWhere('id', $id);
		if($d->update($data1)){
			unset($_SESSION['loginuser']);
			transfer("Cấp nhật thông tin tài khoản thành công",'dang-nhap');
		}
		else
			transfer("Cập nhật thông tin thất bại",getCurrentPageURL_CANO(),0);
	}
?>