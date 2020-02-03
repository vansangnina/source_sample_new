<div class="col_left_cart col-md-9 col-sm-8 col-xs-12">
	<div id="shopping-cart">
	<?php
		$max=count($_SESSION['cart']); 
		for ($i=0; $i < $max; $i++) { 
			$pid=$_SESSION['cart'][$i]['productid'];
			$q=$_SESSION['cart'][$i]['qty'];
	?>
		<div class="shopping-cart-item clearfix">
			<div class="img-thumnail-custom">
				<p class="image">
					<img class="img-responsive" src="http://<?=$config_url.'/'.UPLOAD_PRODUCT_L.get_thumb($pid)?>">
				</p>
			</div>
			<div class="col-right">
				<div class="box-info-product">
					<input type="hidden" class="hidden-quantity" name="quantity[179531609319035]" value="2">
					<p class="name">
						<a href="" target="_blank"><?=get_product_name($pid)?></a>
					</p>
				</div>
				<div class="box-price">
					<p class="price"><?=number_format(get_price($pid,'giaban'),0,',','.')?>&nbsp;₫</p>
					<p class="price2"><?=number_format(get_price($pid,'giacu'),0,',','.')?>&nbsp;₫</p>

				</div>
				<div class="quantity-block">
					<div class="input-group bootstrap-touchspin">
						<span class="input-group-btn">
							<button class="btn btn-default bootstrap-touchspin-down minius_cart" type="button" data-id="<?=$pid?>">-</button>
						</span>
						<span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span>
						<input type="tel" class="form-control quantity-r2 quantity-<?=$pid?> js-quantity-product" min="0"  value="<?=$q?>" style="display: block;">
						<span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span>
						<span class="input-group-btn">
							<button class="btn btn-default bootstrap-touchspin-up plus_cart" type="button" data-id="<?=$pid?>">+</button>
						</span>
					</div>
					<p class="action">
						<a href="javascript:del(<?=$pid?>)" class="item-delete" data-title="<?=get_product_name($pid)?>">Xóa</a>
					</p>
				</div>
			</div>
		</div>
	<?php } ?>
	</div>
</div>
<div class="col_right_cart col-md-3 col-sm-4 col-xs-12">
	<div class="info_pay">
		<ul>
			<li>Tạm tính:  <span class="price-temp"><?=number_format(get_order_total(),0, ',', '.')?>&nbsp;₫</span></li>
			<li>Thành tiền: <span class="price-all"><?=number_format(get_order_total(),0, ',', '.')?>&nbsp;₫</span></li>
		</ul>
	</div>
	<a class="btn btn-danger btn-block btn-pay" href="thanh-toan">Tiến hành thanh toán</a>
</div>