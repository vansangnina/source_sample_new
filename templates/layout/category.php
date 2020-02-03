<style type="text/css">
.category{width:275px;float: left;height:auto;border:1px solid #e0e0e0;background:#fff;}
.category ul li{padding:9.5px 10px 9.5px 32px;position: relative;border-bottom:1px solid #e0e0e0;}
.category ul li:last-child{border-bottom: none;}
.category > ul > li img{margin-right:10px;}
.category ul li a{display:block;color:#666666;font-family: 'RobotoRegular';font-size:15px;}
.category ul li a:hover{color:#fe0002;}
.category ul li a .fa{float: right;}
.category ul li ul{width:235px; position:absolute;left:100%;top:0px;z-index:999;background:#fff;visibility:hidden;opacity:0;transition:0.3s all;}
.category ul li:hover > ul{visibility: visible;opacity: 1;}
.category ul li ul li{padding:9.5px 15px;border-right: 1px solid #e0e0e0;}
</style>
<div class="category">
	<ul>
	<?php foreach ($list as $key => $value_l) { 
		$d->reset();
		$d->query("select ten_vi as ten,tenkhongdau,id from #_product_cat where id_list='".$value_l['id']."' and type='product' and hienthi=1 order by stt,id desc");
		$cat = $d->result_array();
	?>
		<li>
			<a href="<?=$value_l['tenkhongdau']?>"><?=$value_l['ten']?> <i class="fa fa-angle-right" aria-hidden="true"></i>
			</a>
			<?php if($cat){ ?>
				<ul>
				<?php foreach ($cat as $key => $value_c) { 
					$d->reset();
					$d->query("select ten_vi as ten,tenkhongdau,id from #_product_item where id_cat='".$value_l['id']."' and type='product' and hienthi=1 order by stt,id desc");
					$item = $d->result_array();
				?>
					<li><a href="<?=$value_c['tenkhongdau']?>"><?=$value_c['ten']?></a>
						<?php if($cat){ ?>
							<ul>
							<?php foreach ($item as $key => $value_i) { ?>
								<li><a href="<?=$value_i['tenkhongdau']?>"><?=$value_i['ten']?></a></li>
							<?php } ?>
							</ul>
						<?php } ?>
					</li>
				<?php } ?>
				</ul>
			<?php } ?>
		</li>
	<?php } ?>
	</ul>
</div>