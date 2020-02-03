<?php if(!defined('SOURCE')){ die("Error"); }
		
	$idUser = isset($_GET['user']) ? (string)$_GET['user'] : 0;
	if($idUser!=0){
		$d->reset();
		$sql = "select id from #_thanhvien where md5(id)='".$idUser."'";
		$d->query($sql);
		if($d->num_rows()==1){
			$row_user = $d->fetch_array();
			$data_user['active'] = 1;
			$d->setTable("thanhvien");
			$d->setWhere('id',$row_user['id']);
			if($d->update($data_user)){
				transfer("Kích hoạt tài khoản thành công", "dang-nhap",1);
			}
		}else{
			transfer("Dữ liệu không có thực!", "dang-nhap",0);
		}
	}
?>