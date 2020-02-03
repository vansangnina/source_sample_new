<div id="dangky" class="clearfix">
  <div class="title_main"><span>Đăng ký tài khoản</span></div>
  <div class="content_main clearfix">
      <form method="post" name="register" action="dang-ky" enctype="multipart/form-data">
          <div class="left_register col-md-6 col-sm-6 col-xs-12">
              <div class="title_register">Thông tin tài khoản</div>
               <div class="form-group">
                <label class="control-label">Họ và tên:</label>
                <input type="text" class="form-control" name="hoten" placeholder="Họ và tên" required="required">
              </div>
              <div class="form-group">
                <label class="control-label">Email:</label>
                <input type="email" class="form-control" name="email" placeholder="Email" required="required">
              </div>
              <div class="form-group">
                <label class="control-label">Password:</label>
                <input type="password" id="pass" class="form-control" name="password" required="required" placeholder="Password">
              </div>
              <div class="form-group">
                <label class="control-label">Password Confirm:</label>
                <input type="password" id="renew_pass" class="form-control" name="renew_pass" required="required" placeholder="Password Confirm">
              </div>

          </div>
          <div class="right_register col-md-6 col-sm-6 col-xs-12">
              <div class="title_register">Thông tin cá nhân</div>

              <div class="form-group">
                <label class="control-label">Điện thoại:</label>
                <input type="text" class="form-control" name="dienthoai" placeholder="Điện thoại" required="required" pattern="^\+?\d{1,3}?[- .]?\(?(?:\d{2,3})\)?[- .]?\d\d\d[- .]?\d\d\d\d$">
              </div>
              <div class="form-group">
                <label class="control-label">Tỉnh/thành phố:</label>
                <select class="form-control" name="tinhthanh" id="tinhthanh">
                    <option value="">Tỉnh/thành phố</option>
                <?php foreach ($city as $key => $value) { ?>
                    <option value="<?=$value['id']?>"><?=$value['ten']?></option>
                <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label">Quận huyện:</label>
                <select class="form-control" name="quanhuyen" id="quanhuyen">
                    <option value="">Quận huyện</option>
                </select>
              </div>
              <div class="form-group">
                  <label class="control-label">Địa chỉ: </label>
                  <input type="text" id="address" class="form-control" name="diachi" placeholder="Địa chỉ" required="required">
              </div>
              <div class="form-group">
                <input type="hidden" id="recaptchaResponseRegister" name="recapcha_register">
                <input type="reset" class="btn btn-danger" value="Làm mới">
                <input type="submit" id="btnRegister" class="btn btn-info" value="Đăng ký">
              </div>
          </div>
      </form>
  </div><!--content main-->
</div><!--sub main-->
