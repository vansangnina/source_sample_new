<?php
	function get_color($id){
		global $d, $row,$lang;
		$sql = "select ten_$lang from #_product_image_color where id='".$id."'";
		$d->query($sql);
		$row = $d->fetch_array();
		return $row['ten_'.$lang];
	}
	function get_size($id){
		global $d, $row;
		$sql = "select ten_vi from #_tags where id='".$id."'";
		$d->query($sql);
		$row = $d->fetch_array();
		return $row['ten_vi'];
	}
	function get_product_name($pid){
		global $d, $row,$lang;
		$sql = "select ten_$lang from #_product where id='".$pid."'";
		$d->query($sql);
		$row = $d->fetch_array();
		return $row['ten_'.$lang];
	}
	function get_product_url($pid){
		global $d, $row,$lang;
		$sql = "select tenkhongdau from #_product where id='".$pid."'";
		$d->query($sql);
		$row = $d->fetch_array();
		return $row['tenkhongdau'];
	}
	function get_price($pid,$column){
		global $d, $row;
		$sql = "select $column from table_product where id='".$pid."'";
		$d->query($sql);
		$row = $d->fetch_array();
		return $row[$column];
	}
		
	function get_thumb($pid){
		global $d, $row;
		$sql = "select photo from table_product where id='".$pid."' ";
		$d->query($sql);
		$row = $d->fetch_array();
		return $row['photo'];
	}
	function remove_product($pid,$size=null,$color=null){
		$pid=intval($pid);
		$max=count($_SESSION['cart']);
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['cart'][$i]['productid'] && $size==$_SESSION['cart'][$i]['size'] && $color==$_SESSION['cart'][$i]['color']){
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
			$price=get_price($pid,"giaban");
			$sum+=$price*$q;
		}
		return $sum;
	}
	function addtocart($pid,$q,$size,$color){
		if($pid<1 or $q<1) return;
		
		if(is_array($_SESSION['cart'])){
			if(product_exists($pid,$q,$size,$color)) return 0;
			$max=count($_SESSION['cart']);
			$_SESSION['cart'][$max]['productid']=$pid;
			$_SESSION['cart'][$max]['qty']=$q;
			$_SESSION['cart'][$max]['size']=$size;
			$_SESSION['cart'][$max]['color']=$color;
			return count($_SESSION['cart']);
		}
		else{
			$_SESSION['cart']=array();
			$_SESSION['cart'][0]['productid']=$pid;
			$_SESSION['cart'][0]['qty']=$q;
			$_SESSION['cart'][0]['size']=$size;
			$_SESSION['cart'][0]['color']=$color;
			return count($_SESSION['cart']);	
		}
	}
	function product_exists($pid,$q,$size,$color){
		$pid=intval($pid);
		$max=count($_SESSION['cart']);
		$flag=0;
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['cart'][$i]['productid'] && $size==$_SESSION['cart'][$i]['size'] && $color==$_SESSION['cart'][$i]['color']){
				$_SESSION['cart'][$i]['qty'] = $_SESSION['cart'][$i]['qty'] + $q;
				$flag=1;
				break;
			}
		}
		return $flag;
	}

?>