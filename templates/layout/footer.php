<div id="footer" class="clearfix lazy" data-bg="url(thumb/1366x648/1/<?=UPLOAD_IMAGE_L.$bgfooter['photo_vi']?>)">
	<div class="register_mail">
		<p class="title_email">Đăng ký nhận tin</p>
		<span class="slogan_mail">Hãy đăng ký để nhận được những thông tin khuyến mãi và tin tức mới nhất</span>
		<form action="" method="post" name="frmEmail" class="frmEmail">
			<input name="email" type="email" class="input" placeholder="Nhập email của bạn . " required="required">
			<input type="hidden" id="recaptchaResponseEmail" name="recaptcha_response_email">
			<button type="submit" value="">Gửi</button>
		</form>
	</div>
	<div class="content_footer_full">
		<div class="inner">
			<div class="row">
				<div class="item_footer col-md-5 col-sm-12 col-xs-12">
					<div class="name_company"><?=$row_setting['ten_'.$lang]?></div>
					<div class="content_footer"><?=$footer['noidung']?></div>
					<div class="social">
						<span>Follow us: </span>
						<?php foreach ($mxh as $key => $value) { ?>
							<a href="<?=$value['url']?>" title="<?=$value['ten']?>"><img src="thumb/27x27/1/<?=UPLOAD_IMAGE_L.$value['photo']?>" alt="<?=$value['ten']?>"></a>
						<?php } ?>
					</div>
				</div>
				<div class="item_footer col-md-3 col-sm-6 col-xs-12">
					<div class="title_footer">Chính sách công ty</div>
					<ul>
						<?php foreach ($chinhsach as $key => $value) { ?>
							<li><h3><a href="<?=$value['tenkhongdau']?>"><?=$value['ten']?></a></h3></li>
						<?php } ?>
					</ul>
					<?php if($bct){ ?>
						<a href="<?=$bct['link']?>"><img src="thumb/141x53/1/<?=UPLOAD_IMAGE_L.$bct['photo_vi']?>" alt="Đã đăng ký bộ công thương"></a>
					<?php } ?>
				</div>
				<div class="item_footer col-md-4 col-sm-6 col-xs-12">
					<div class="title_footer">Fanpage</div>
					<div class="fb-page" data-href="<?=$row_setting['facebook']?>" data-tabs="timeline" data-width="500" data-height="210" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?=$row_setting['facebook']?>" class="fb-xfbml-parse-ignore"><a href="<?=$row_setting['facebook']?>">Facebook</a></blockquote></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="bottom" class="clearfix">
	<div class="inner">
		<div class="copyright">Copyright &copy 2019 <?=$row_setting['ten_'.$lang]?>. Web design by Nina.vn</div>
		<div class="counter">
			<span>Online: <?php $count=count_online();echo $tong_xem=$count['dangxem'];?></span>
			<span>Ngày: <?=$today_visitors?></span>
			<span>Tuần: <?=$week_visitors?></span>
			<span>Tháng <?=$month_visitors?></span>
			<span>Tổng truy cập: <?=$all_visitors?></span>
		</div>
	</div>
</div>
<?php 
	include_once TEMPLATE.'layout/menu_mobile.php'; 
?>