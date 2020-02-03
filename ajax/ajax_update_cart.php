<?php
	session_start();

	if(!isset($_SESSION['lang'])||$_SESSION['lang']==''){
		$_SESSION['lang']='vi';
	}
	$lang=$_SESSION['lang'];
	
	@define ( '_lib' , '../libraries/');
    
	include_once _lib."config.php";
	include_once _lib."constant.php";;
	include_once _lib."functions.php";
	include_once _lib."functions_giohang.php";    
	$d = new database($config['database']);

	@$quantity = (int)$_POST['quantity'];
	@$id_product = (int)$_POST['id_product'];
	

	$max=count($_SESSION['cart']);
	for($i=0;$i<$max;$i++){
		$pid=$_SESSION['cart'][$i]['productid'];
		if($pid==$id_product){
			$_SESSION['cart'][$i]['qty']=$quantity;
			$arr['total_this']=number_format($quantity*get_price($pid,'giaban'),0,0,'.').' đ';
		}
	}
	$arr['total_all']=number_format(get_order_total(),0,0,'.').' đ';
	echo json_encode($arr);
?>