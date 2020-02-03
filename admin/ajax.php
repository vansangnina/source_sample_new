<?php
	session_start();
	@define ( 'SOURCE' , './sources/');
	@define ( 'LIBRARIES' , '../libraries/');

	include_once LIBRARIES."config.php";
	include_once LIBRARIES."constant.php";
	include_once LIBRARIES."functions.php";
	include_once LIBRARIES."library.php";
	$d = new database($config['database']);
	
	$do = (isset($_REQUEST['do'])) ? addslashes($_REQUEST['do']) : "";
	$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
	
	
	if($do=='admin'){
		if($act=='login'){
			check_ip_login();
			$username = $_POST['email'];
			$password = $_POST['pass'];
			$sql = "select * from #_user where username='".$username."'";
			$d->query($sql);
			if($d->num_rows() == 1){
				$row = $d->fetch_array();
				if($row['password'] == encrypt_password($row['token'],$password,$config['salt'])){ 
					reset_limit_time_login();
					$login_name = $config['login_name'];
					$_SESSION[$login_name] = true;
					$_SESSION['login']['id'] = $row['id'];
					$_SESSION['login']['role'] = $row['role'];
					$_SESSION['login']['quyen'] = $row['quyen'];
					$_SESSION['isLoggedIn'] = true;
					$_SESSION['login']['username'] = $username;
					sessionhash();
					echo '{"page":"index.php"}';
				}else{ 
					count_times_login();
					echo '{"mess":"Mật khẩu không chính xác!"}';
				}
			}else{
				count_times_login();
				echo '{"mess":"Tên đăng nhập không tồn tại!"}';		
			}	
		}				
	}
		
	//Cap nhat so thu tu
	if($do=='number'){
		if($act=='update'){
			$table=addslashes($_POST['table']);
			$id=addslashes($_POST['id']);;
			$num=(int)$_POST['num'];
			$sql="update #_$table set stt='$num' where id='$id' ";
			$d->query($sql);
		}
	}
	
	//Cap nhat trang thai
	if($do=='status'){
		if($act=='update'){						
			$table=addslashes($_POST['table']);
			$id=addslashes($_POST['id']);
			$field=addslashes($_POST['field']);
			$d->reset();						
			$sql="update #_$table set $field =  where id='$id' ";
						
			$cart=array('thanhtien'=>$thanhtien,'tongtien'=>get_tong_tien($id_cart));
			echo json_encode($cart);
		}
	}
	
	//Cap nhat gio hang
	if($do=='cart'){
		if($act=='update'){						
			$id=(int)$_POST['id'];
			$sl=(int)$_POST['sl'];			
		 
			$d->reset();						
			$d->query("update #_order_detail set soluong='".$sl."' where id='".$id."'");
			
			$d->reset();
			$sql="select * from #_order_detail where id='".$id."'";
			$d->query($sql);
			$result=$d->fetch_array();


			
			$sql="select * from #_order_detail where id_order='".$result['id_order']."'";
			$d->query($sql);
			$result_order=$d->result_array();
			 
			$id_cart=$result['id_order'];
			$tongtien=get_tong_tien($id_cart);
			
			$d->reset();						
			$d->query("update #_order set tonggia='".$tongtien."' where id='".$id_cart."'"); 

			$thanhtien=$result['gia']*$result['soluong'];

			$cart=array('thanhtien'=>$thanhtien,'tongtien'=>$tongtien);
			echo json_encode($cart);
		}
	}
	
	//Xoa gio hang
	if($do=='cart'){
		if($act=='delete'){						
			$id=(int)$_POST['id'];			
			$d->reset();			
			$d->query("delete from #_order_detail where id='".$id."'");
			
			$d->reset();
			$sql="select * from #_order_detail where id='".$id."'";
			$d->query($sql);
			$result=$d->fetch_array();						
			$cart=array('tongtien'=>get_tong_tien($id_cart));
			echo json_encode($cart);
			
		}
	}
	
?>