<?php	if(!defined('SOURCE')){ die("Error"); }

switch($act){
	case "login":
		if($_SESSION['login'] && $_SESSION[$config['login_name']]) redirect('index.php');
		if(!empty($_POST)) login();
		
		$template = "user/login";
		break;
	case "admin_edit":
		edit();
		$template = "user/admin_add";
		break;
	case "logout":
		logout();
		break;	
	case "man":
		get_items();
		$template = "user/items";
		break;
	case "add":
		$template = "user/item_add";
		break;
	case "edit":
		get_item();
		$template = "user/item_add";
		break;
	case "save":
		save_item();
		break;
	case "delete":
		delete_item();
		break;
	default:
		$template = "index";
}

//////////////////
function get_items(){
	global $d, $items, $paging ,$page;
	
	if($_SESSION['login']['role']!='3'){
		transfer("Chỉ có admin mới được vào mục này . ", "index.php");
	}
	
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_user where role=1 order by username ";

	$sql = "select * from $where $limit";
	$d->query($sql);
	$items = $d->result_array();

	$url = "index.php?com=user&act=man";
	$paging = pagination($where,$per_page,$page,$url);
}

function get_item(){
	global $d, $item;
	
	if($_SESSION['login']['role']!='3'){
			transfer("Chỉ có admin mới được vào mục này . ", "index.php");
	}
	$id = isset($_GET['id']) ? (int)$_GET['id'] : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=user&act=man");
	
	$sql = "select * from #_user where id='".$id."' and role=1";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=user&act=man");
	$item = $d->fetch_array();
}

function save_item(){
	global $d,$config;
	$username1 = addslashes($_POST['username']);
	
	if($_SESSION['login']['role']!='3'){
			transfer("Chỉ có admin mới được vào mục này . ", "index.php");
	}
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=user&act=man");
	$id = isset($_POST['id']) ? (int)$_POST['id'] : "";

	if($id){ // cap nhat
		$id =  (int)$_POST['id'];
		
		$d->reset();
		$d->setTable("user");
		$d->setWhere("id",$id);
		$d->select("token");
		$row = $d->fetch_array();

		$data['username'] = $_POST['username'];
		if($_POST['oldpassword']!=""){
			$data['password'] = encrypt_password($row['token'],$_POST['oldpassword'],$config['salt']);
		}
		$data['email'] = $_POST['email'];
		$data['ten'] = $_POST['ten'];
		$data['sex'] = $_POST['sex'];
		$data['dienthoai'] = $_POST['dienthoai'];
		$data['nick_yahoo'] = $_POST['nick_yahoo'];
		$data['nick_skype'] = $_POST['nick_skype'];
		$data['diachi'] = $_POST['diachi'];
		$data['country'] = $_POST['country'];
		$data['city'] = $_POST['city'];
		$data['quyen'] = $_POST['quyen'];
		
		
		
		$d->reset();
		$d->setTable('user');
		$d->setWhere('id', $id);
		$d->setWhere('role', 1);
		if($d->update($data))
			transfer("Dữ liệu đã được cập nhật", "index.php?com=user&act=man");
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=user&act=man");
	
	}else{ // them moi
		$token = getToken(32);
		// kiem tra ten trung
		$d->reset();
		$d->setTable('user');
		$d->setWhere('username', $username1);
		$d->select();
		if($d->num_rows()>0) transfer("Tên dăng nhập nay đã có.<br>Xin chọn tên khác.", "index.php?com=user&act=edit&id=".$id);
		
		if($_POST['oldpassword']=="") transfer("Chưa nhập mật khẩu", "index.php?com=user&act=add");
		
		$data['username'] = $_POST['username'];
		$data['password'] = encrypt_password($token,$_POST['oldpassword'],$config['salt']);
		$data['token'] = $token;
		$data['email'] = $_POST['email'];
		$data['ten'] = $_POST['ten'];
		$data['sex'] = $_POST['sex'];
		$data['dienthoai'] = $_POST['dienthoai'];
		$data['nick_yahoo'] = $_POST['nick_yahoo'];
		$data['nick_skype'] = $_POST['nick_skype'];
		$data['diachi'] = $_POST['diachi'];
		$data['country'] = $_POST['country'];
		$data['city'] = $_POST['city'];
		$data['quyen'] = $_POST['quyen'];
		$data['role'] = 1;
		$data['com'] = "user";
		
		$d->setTable('user');
		if($d->insert($data)){

			transfer("Dữ liệu đã được lưu", "index.php?com=user&act=man");
		}
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=user&act=man");
	}
}

function delete_item(){
	global $d;
	if($_SESSION['login']['role']!='3'){
			transfer("Chỉ có admin mới được vào mục này . ", "index.php");
	}
	if(isset($_GET['id'])){
		$id =  (int)$_GET['id'];
		
		// kiem tra
		$d->reset();
		$d->setTable('user');
		$d->setWhere('id', $id);
		$d->select();
		if($d->num_rows()>0){
			$row = $d->fetch_array();
			if($row['role'] != 1) transfer("Bạn không có quyền trên tài khoản này.<br>Mọi thắc mắc xin liên hệ quản trị website.", "index.php?com=user&act=man");
		}
		
		// xoa item
		$sql = "delete from #_user where id='".$id."'";
		if($d->query($sql))
			transfer("Dữ liệu đã được xóa", "index.php?com=user&act=man");
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=user&act=man");
	}else transfer("Không nhận được dữ liệu", "index.php?com=user&act=man");
}

///////////////////////

function edit(){
	global $d, $item, $login_name,$config;
	
	if(!empty($_POST)){
		$username = addslashes($_SESSION['login']['username']);
		$username1 = addslashes($_POST['username']);
		
		$sql = "select * from #_user where username!='".$username."' and username='".$username1."' and role=3";
		$d->query($sql);
		if($d->num_rows() > 0) transfer("Tên đăng nhập này đã có","index.php?com=user&act=edit");
		
		$sql = "select * from #_user where username='".$username."'";
		$d->query($sql);
		if($d->num_rows() == 1){
			$row = $d->fetch_array();
			if($row['password'] != encrypt_password($row['token'],$_POST['oldpassword'],$config['salt'])) transfer("Mật khẩu không chính xác","index.php?com=user&act=admin_edit");
		}else{
			die('Hệ thống bị lỗi. Xin liên hệ với admin. <br>Cám ơn.');
		}
		$data['username'] = $_POST['username'];
		if($_POST['new_pass']!=""){
			if($_POST['new_pass']!=$_POST['renew_pass'])
				transfer("Nhập lại mật khẩu mới không đúng!","index.php?com=user&act=admin_edit");
			$data['lastlogin'] = time();
			$data['user_token'] = md5(time());
			$data['token'] = getToken(32);
			$data['password'] = encrypt_password($data['token'],$_POST['new_pass'],$config['salt']);
			$data['login_session'] = md5(sha1($data['code'].$data['username']));
		}
		$data['ten'] = $_POST['ten'];
		$data['email'] = $_POST['email'];
		$data['nick_yahoo'] = $_POST['nick_yahoo'];
		$data['nick_skype'] = $_POST['nick_skype'];
		$data['dienthoai'] = $_POST['dienthoai'];
		
		$d->reset();
		$d->setTable('user');
		$d->setWhere('username', $username1);
		if($d->update($data)){
			session_unset();
			transfer("Dữ liệu đã được lưu.","index.php");
		}
	}
	
	$sql = "select * from #_user where username='".$username."'";
	$d->query($sql);
	if($d->num_rows() == 1){
		$item = $d->fetch_array();
	}
}
function logout(){
	global $config;
	$login_name = $config['login_name'];
	unset($_SESSION['login']);
	unset($_SESSION[$login_name]);
	unset($_SESSION['isLoggedIn']);
	unset($_SESSION['login_session']);
	unset($_SESSION['login_token']);
	transfer("Đăng xuất thành công", "index.php?com=user&act=login");
}
?>