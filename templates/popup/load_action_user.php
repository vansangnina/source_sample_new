<?php  
	session_start();
	if(!$_SESSION['lang']){
		$_SESSION['lang'] = "vi";
	}
	$lang = $_SESSION['lang'];
	@define ( '_lib' , '../libraries/');
	include_once _lib."config.php";
	include_once _lib."constant.php";
	include_once _lib."class.database.php";
	$d = new database($config['database']);

	$style = $_GET['active'];
	$title_detail = $style=='register' ? "Tạo tài khoản" : "Đăng nhập";

	$d->reset();
    $d->query("select photo_$lang as photo from #_photo where type='logo_dkdn'");
    $bgdkdn = $d->fetch_array();
?>
<link rel="stylesheet" type="text/css" href="css/action_user.css">
<div id="register_login" class="clearfix">
	<div class="left">
		<div class="top_left">
			<div class="title_user"><?=$title_detail?></div>
			<span>Tạo tài khoản trên 3T để theo dõi kiểm tra thông tin điểm tích lũy của bạn có và chia sẽ thêm thông tin khác từ 3T</span>
		</div>
		<img class="w100" src="thumb/360x474/1/<?=_upload_hinhanh_l.$bgdkdn['photo']?>" alt="">
	</div>
	<div class="right">
		<div class="content_bg">
			<div class="item_tab_user">
				<a <?=$style=='login'?'class="active"':''?> href="#login">Đăng nhập</a>
				<a <?=$style=='register'?'class="active"':''?> href="#register">Tạo tài khoản</a>
				<a></a>
			</div>
			<div class="content_tab_user">
				<div id="register" class="content_tab_us" <?=$style=='login'?'style="display:none"':''?>>
				 	<div class="content_main clearfix">
				        <form id="frmRegister" method="post" name="register" enctype="multipart/form-data">
			            	<div class="form-group clearfix">
			                	<label>Họ và tên:</label>
			                	<div class="boxRight">
			                		<input type="text" class="form-control" name="name_user" placeholder="Họ và tên" required="required">
			                	</div>
			              	</div>
			              	<div class="form-group clearfix">
			                	<label class="control-label">Số điện thoại:</label>
			                	<div class="boxRight">
			                		<input type="text" class="form-control" name="phone" placeholder="Nhập số điện thoại.." required="required" pattern="^\+?\d{1,3}?[- .]?\(?(?:\d{2,3})\)?[- .]?\d\d\d[- .]?\d\d\d\d$">
			                	</div>
			              	</div>
			              	<div class="form-group clearfix">
			                	<label class="control-label">Email:</label>
			                	<div class="boxRight">
			                		<input type="email" class="form-control" name="email" placeholder="Nhập email.." required="required">
			                	</div>
			              	</div>
			              	<div class="form-group clearfix">
			                	<label class="control-label">Mật khẩu:</label>
			                	<div class="boxRight">
			                		<input type="password" id="pass" class="form-control" name="password" required="required" placeholder="Mật khẩu...">
			                	</div>
			              	</div>
			              	<div class="form-group clearfix">
			                	<label class="control-label">Giới tính:</label>
			                	<div class="boxRight">
			                		<div class="radio">
									  	<label><input type="radio" value="1" name="sex" checked>Nam</label>
									  	<label><input type="radio" value="2" name="sex">Nữ</label>
									</div>
			                	</div>
			              	</div>
			              	<div class="form-group clearfix">
			                	<label class="control-label">Ngày sinh:</label>
			                	<div class="boxRight">
			                		<select name="day" id="day">
			                			<option value="">Ngày</option>
			                			<?php for ($i=1; $i <= 31 ; $i++) { ?>
			                				<option value="<?=$i?>"><?=$i?></option>
			                			<?php } ?>
			                		</select>
			                		<select name="month" id="month">
			                			<option value="">Tháng</option>
			                			<?php for ($i=1; $i <= 12 ; $i++) { ?>
			                				<option value="<?=$i?>"><?=$i?></option>
			                			<?php } ?>
			                		</select>
			                		<select name="year" id="year">
			                			<option value="">Năm</option>
			                			<?php $yearnow = date('Y'); for ($i=1900; $i <= ($yearnow-18) ; $i++) { ?>
			                				<option value="<?=$i?>"><?=$i?></option>
			                			<?php } ?>
			                		</select>
			                	</div>
			              	</div>
							<div class="form-group clearfix">
								<div class="boxButton">
			                		<input type="hidden" id="recaptchaResponseRegister" name="recapcha_register">
			                		<input type="submit" class="btnSuccess" value="Tạo tài khoản">
			                		<p>Khi bạn nhấn Đăng ký, bạn đã đồng ý thực hiện mọi điều khoản giao dịch theo <a href="chinh-sach">điền kiện sử dụng và chính sách của 3T</a></p>
			                		<a id="LoginFB" class="loginSocial input-group">
									    <span class="icon iconFb"><i class="fab fa-facebook-f"></i></span>
									    <span class="textFB">Đăng nhập bằng Facebook</span>
									</a>
									<a id="LoginG" class="loginSocial input-group">
									    <span class="icon iconG"><i class="fab fa-google-plus-g"></i></span>
									    <span class="textFB">Đăng nhập bằng Google</span>
									</a>
			                	</div>
			              	</div>
				        </form>
				    </div>
				</div>
				<div id="login" class="content_tab_us" <?=$style!='login'?'style="display:none"':''?>>
			        <form id="frmLogin" name="form_dn" method="post">
						<div class="form-group clearfix">
							<label class="control-label">Email/SĐT : <span>*</span></label>
							<div class="boxRight">
			                	<input id="username" name="username" type="text" placeholder="Nhập email hoặc số điện thoại" autofocus required class="form-control">
			                </div>
			            </div>
						<div class="form-group clearfix">
							<label class="control-label">Mật khẩu : <span>*</span></label>
							<div class="boxRight">
			                	<input id="password" name="password" type="password" placeholder="Password" required class="form-control">
			                </div>
			            </div>
						<div class="form-group clearfix">
			                <div class="boxButton">
		                		<input type="submit" class="btnSuccess" value="Đăng nhập tài khoản">
		                		<p>Quên mật khẩu? Nhấn vào <a class="rePass" href="#repassword">Đây</a></p>
		                		<a id="LoginFB" class="loginSocial input-group">
								    <span class="icon iconFb"><i class="fab fa-facebook-f"></i></span>
								    <span class="textFB">Đăng nhập bằng Facebook</span>
								</a>
								<a id="LoginG" class="loginSocial input-group">
								    <span class="icon iconG"><i class="fab fa-google-plus-g"></i></span>
								    <span class="textFB">Đăng nhập bằng Google</span>
								</a>
		                	</div>
			            </div>
			        </form>
				</div>
				<div id="repassword" class="content_tab_us" style="display:none">
					<form id="frmRePass" method="post">
						<div class="form-group clearfix">
							<label class="control-label">Email : <span>*</span></label>
							<div class="boxRight">
			                	<input id="username" name="username" type="text" placeholder="Nhập email tài khoản" autofocus required class="form-control">
			                </div>
			            </div>
			            <div class="form-group clearfix">
			                <div class="boxButton">
			                	<input type="hidden" id="recaptchaResponseRePass" name="recapcha_password">
		                		<input type="submit" class="btnSuccess" value="Lấy lại mật khẩu">
		                	</div>
		                </div>
			        </form>
				</div>
			</div>
			<span id="error"></span>
		</div>
	</div>
</div>
<script type="text/javascript">
	grecaptcha.ready(function () {
		grecaptcha.execute('<?=$site_key?>', { action: 'register' }).then(function (token) {
	      	var recaptchaResponseRegister = document.getElementById('recaptchaResponseRegister');
	      	recaptchaResponseRegister.value = token;
	  	});
	  	grecaptcha.execute('<?=$site_key?>', { action: 'repassword' }).then(function (token) {
	      	var recaptchaResponseRePass = document.getElementById('recaptchaResponseRePass');
	      	recaptchaResponseRePass.value = token;
	  	});
	});
	$('html body').on('click', '.item_tab_user a', function(event) {
		event.preventDefault();
		var tabUser = $(this).attr("href");
		$('.title_user').text($(this).text());
		$('.item_tab_user a').removeClass('active');
		$(this).addClass('active');
		$('.content_tab_us').css({'display':'none'});
	    $(tabUser).fadeIn();
	});
	$('.rePass').click(function(event) {
		event.preventDefault();
		$('.item_tab_user a').removeClass('active');
		var tabUser_temp = $(this).attr("href");
		$('.content_tab_us').css({'display':'none'});
	    $(tabUser_temp).fadeIn();
	    $('.title_user').text("Quên mật khẩu");
	});
	$('#frmRegister').submit(function(event) {
		$.ajax({
			url: 'ajax/register.php',
			type: 'POST',
			dataType: 'json',
			data:$('#frmRegister').serialize(),
		})
		.done(function(result) {
			$('#error').text(result.mess);
			if(result.check==1){
				$('#frmRegister')[0].reset();
			}
		})
		.fail(function() {
			console.log("error");
		});
		return false;
	});
	$('#frmLogin').submit(function(event) {
		$.ajax({
			url: 'ajax/login.php',
			type: 'POST',
			dataType: 'json',
			data: $('#frmLogin').serialize(),
		})
		.done(function(result) {
			if(result.check==1){
				window.location.href="";
			}
			$('#error').text(result.mess);
		})
		.fail(function() {
			console.log("error");
		});
		return false;
	});
	$('#frmRePass').submit(function(event) {
		$.ajax({
			url: 'ajax/re_password.php',
			type: 'POST',
			dataType: 'json',
			data: $('#frmRePass').serialize(),
		})
		.done(function(result) {
			$('#error').text(result.mess);
			$('#frmRePass')[0].reset();
		})
		.fail(function() {
			console.log("error");
		});
		return false;
	});
</script>