<?php	if(!defined('SOURCE')){ die("Error"); }

switch($act){

	case "man":
		get_items(); 

		$template = "order/items";
		break;
	case "add":		
		$template = "order/item_add";
		break;
	case "edit":		
		get_item();
		$template = "order/item_add";
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

#====================================

function get_items(){		
	global $d, $items,$paging,$page,$type;
	
	
	if(!empty($_POST)){
		$multi=$_REQUEST['multi'];
		$id_array=$_POST['iddel'];
		$count=count($id_array);				
		if($multi=='del'){
			
			for($i=0;$i<$count;$i++){
								
				
				$sql = "delete from #_order_detail where id_order 	='".$id_array[$i]."'";
				$d->query($sql);
		
				$sql = "delete from table_order where id = '".$id_array[$i]."'";
				$d->query($sql) or die("Not query sqlUPDATE_ORDER");			
							
			}
			redirect("index.php?com=order&act=man&type=".$type);			
		}
		
		
	}
	
	
	
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_order ";
	$where .= " where id <> 0";	

	
	if($_GET["ngaybd"]!=''){
	$ngaybatdau = addslashes($_GET["ngaybd"]);		
	$Ngay_arr = explode("/",$ngaybatdau); // array(17,11,2010)
	if (count($Ngay_arr)==3) {
		$ngay = $Ngay_arr[0]; //17
		$thang = $Ngay_arr[1]; //11
		$nam = $Ngay_arr[2]; //2010
		if (checkdate($thang,$ngay,$nam)==false){ $coloi=true; $error_ngaysinh = "Bạn nhập chưa đúng ngày <br>";} else $ngaybatdau=$nam."-".$thang."-".$ngay;
	}	
		$where.=" and ngaytao>=".strtotime($ngaybatdau)." ";
	}

	if($_GET["ngaykt"]!=''){
	 $ngayketthuc = addslashes($_GET["ngaykt"]);		
	$Ngay_arr = explode("/",$ngayketthuc); // array(17,11,2010)
	if (count($Ngay_arr)==3) {
		$ngay = $Ngay_arr[0]; //17
		$thang = $Ngay_arr[1]; //11
		$nam = $Ngay_arr[2]; //2010
		if (checkdate($thang,$ngay,$nam)==false){ $coloi=true; $error_ngaysinh = "Bạn nhập chưa đúng ngày <br>";} else  $ngayketthuc=$nam."-".$thang."-".$ngay;
	}	
		$where.=" and ngaytao<=".strtotime($ngayketthuc)." ";
		
	}

	
	if($keyword!=''){
		$where.=" and (madonhang like '%".$keyword."%' or hoten like '%".$keyword."%' )  ";
	}
	//sotien
	$sotien = (int) $_GET["sotien"];

	if($sotien!='' && $sotien>0){
		$sql="select giatu,giaden from #_giasearch where id='".$sotien."'";
		$d->query($sql);
		$giatim=$d->fetch_array();
		if($giatim!=null){
			$where.=" and tonggia>=".$giatim['giatu']." and tonggia<=".$giatim['giaden']." ";			
		}
	}
	
	//tinhtrang
	$tinhtrang = (int)$_GET["tinhtrang"];
	if($tinhtrang!='' && $tinhtrang>0){
		$where.=" and trangthai=".$tinhtrang." ";
	}
	$httt = (int) $_GET["httt"];
	if($httt!='' && $httt>0){
		$where.=" and httt=".$httt." ";
	}				
	
	$where.=" order by id desc ";				
	
	$sql = "select * from $where $limit";	

	$d->query($sql);
	$items = $d->result_array();
	$url = getCurrentPageURL();
	$paging = pagination($where,$per_page,$page,$url);	
		
}
function get_item(){
	global $d, $item,$result_ctdonhang;
	$id = isset($_GET['id']) ? (int)$_GET['id'] : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=order&act=man");
	
	$sql = "select * from #_order where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=order&act=man");
	$item = $d->fetch_array();



	$sqlUPDATE_ORDER = "UPDATE table_order SET view =1 WHERE  id = ".$id."";
	$d->query($sqlUPDATE_ORDER);
	
	
	$d->reset();
	$sql="select * from #_order_detail where id_order = '".$item['id']."'";
	$d->query($sql);
	$result_ctdonhang=$d->result_array();
}

function save_item(){
	global $d,$curPage,$type;
	$file_name=fns_Rand_digit(0,9,12);
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=order&act=man");
	$id = isset($_POST['id']) ? (int)$_POST['id'] : "";
	
	
	if($id){
				
		
		$data['ghichu'] = $d->escape_str($_POST['ghichu']);
		$data['trangthai'] = $_POST['id_tinhtrang'];				
		$d->setTable('order');
		$d->setWhere('id', $id);
		if($d->update($data))
			redirect("index.php?com=order&act=man&curPage=".$curPage."");
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=order&act=man");
	}
}

function delete_item(){
	global $d;
	if($id_cat!='')
	{ $id_catt="&id_cat=".$id_cat;
	}
	if($curPage!='')
	{ $id_catt.="&curPage=".$curPage;
	}
	
	
	if(isset($_GET['id'])){
		$id =  (int)$_GET['id'];
		$d->reset();
		$sql = "delete from #_order where id='".$id."'";
		$d->query($sql);
		
		$d->reset();
		$sql = "delete from #_order_detail where id_order 	='".$id."'";
		$d->query($sql);
		
		if($d->query($sql))
			redirect("index.php?com=order&act=man".$id_catt."");
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=order&act=man");
	}else transfer("Không nhận được dữ liệu", "index.php?com=order&act=man");
}
?>