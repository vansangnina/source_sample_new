<?php
	function get_product_name($pid){
		global $d, $row,$lang;
		$sql = "select ten_$lang from #_product where id='".$pid."'";
		$d->query($sql);
		$row = $d->fetch_array();
		return $row['ten_'.$lang];
	}
	
	function get_price($pid){
		global $d, $row;
		$sql = "select giaban from table_product where id='".$pid."'";
		$d->query($sql);
		$row = $d->fetch_array();
		return $row['giaban'];
	}
		
	function get_thumb($pid){
		global $d, $row;
		$sql = "select photo from table_product where id='".$pid."' ";
		$d->query($sql);
		$row = $d->fetch_array();
		return $row['photo'];
	}
	function remove_product($pid){
		$pid=intval($pid);
		$max=count($_SESSION['cart']);
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['cart'][$i]['productid']){
				unset($_SESSION['cart'][$i]);
				break;
			}
		}
		$_SESSION['cart']=array_values($_SESSION['cart']);
	}
	function remove_pro_thanh($pid){
		$pid=intval($pid);
		$max=count($_SESSION['cart']);
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['cart'][$i]['productid']){
				unset($_SESSION['cart'][$i]);
				break;
			}
		}
		$_SESSION['cart']=array_values($_SESSION['cart']);
		redirect('thanh-toan');
	}
	function get_order_total(){
		$max=count($_SESSION['cart']);
		$sum=0;
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['cart'][$i]['productid'];
			$q=$_SESSION['cart'][$i]['qty'];
			$price=get_price($pid);
			$sum+=$price*$q;
		}
		return $sum;
	}
	function addtocart($pid,$q){
		if($pid<1 or $q<1) return;
		
		if(is_array($_SESSION['cart'])){
			if(product_exists($pid,$q)) return 0;
			$max=count($_SESSION['cart']);
			$_SESSION['cart'][$max]['productid']=$pid;
			$_SESSION['cart'][$max]['qty']=$q;
			return count($_SESSION['cart']);
		}
		else{
			$_SESSION['cart']=array();
			$_SESSION['cart'][0]['productid']=$pid;
			$_SESSION['cart'][0]['qty']=$q;
			return count($_SESSION['cart']);	
		}
	}
	function product_exists($pid,$q){
		$pid=intval($pid);
		$max=count($_SESSION['cart']);
		$flag=0;
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['cart'][$i]['productid']){
				$_SESSION['cart'][$i]['qty'] = $_SESSION['cart'][$i]['qty'] + $q;
				$flag=1;
				break;
			}
		}
		return $flag;
	}

?>