<?php
	session_start();
	$lang = "vi";
	@define ( '_lib' , '../libraries/');
    
	include_once _lib."config.php";
	include_once _lib."functions_giohang.php";
	$d = new database($config['database']);
    
    if(!empty($_POST)){
    	$soluong = (int)$_POST['sl'];
    	$productid = (int)$_POST['pid'];

    	addtocart($productid,$soluong);
		
		$return['thongbao'] = get_product_name($productid). ' đã được thêm vào giỏ hàng';
		$return['img'] = "<img src='upload/product/".get_thumb($productid)."'>";
		$return['sl'] = count($_SESSION['cart']);
		echo json_encode($return);
	}

?>