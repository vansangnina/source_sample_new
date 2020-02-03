<?php
if($_REQUEST['command']=='delete' && $_REQUEST['pid']>0){
		remove_product($_REQUEST['pid']);
	}
		else if($_REQUEST['command']=='clear'){
		unset($_SESSION['cart']);
	}
		else if($_REQUEST['command']=='update'){
		$max=count($_SESSION['cart']);
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['cart'][$i]['productid'];
			$q=$_REQUEST['product'.$pid];
			if($q>0 && $q<=999){
				$soluong = str_replace(",", '.', $q);
				$_SESSION['cart'][$i]['qty']=$soluong;
			}
			else{
				$msg='Some proudcts not updated!, quantity must be a number between 1 and 999';
			}
		}
	}
?>
<div class="sub_main">
	<div class="title_main"><span><?=$title?></span></h3></div>
	<div class="content_main">
		<?php if($_SESSION['cart']){ ?>
		<div id="giohang_ct">
			<form name="form1" method="post">
				<input type="hidden" name="pid" />
				<input type="hidden" name="command" />
				<div class="contain_table_giohang">
					<?php include_once TEMPLATE.'layout/table_cart.php'; ?>
				</div>
			</form>
		</div>
		<?php }else{ ?>
		<div class="alert alert-danger"><strong>Không có sản phẩm nào trong giỏ hàng</strong></div>
		<?php } ?>
	</div><!--content main-->
</div><!--sub main-->

