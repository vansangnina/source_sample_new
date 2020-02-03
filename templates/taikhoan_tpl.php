<div class="sub_main">
  <div class="title_main"><span>Thông tin tài khoản</span></div>
  <div class="content_main content_register">
    <form action="tai-khoan" method="POST">
        <div class="left_register col-md-6 col-sm-6 col-xs-12">
              <div class="title_register">Thông tin tài khoản</div>
               <div class="form-group">
                <label class="control-label">Họ và tên:</label>
                <input type="text" value="<?=$result_user['ten']?>" class="form-control" name="hoten" placeholder="Họ và tên" required="required">
              </div>
              <div class="form-group">
                <label class="control-label">Email:</label>
                <input type="email" value="<?=$result_user['email']?>" class="form-control" name="email" placeholder="Email" required="required"  disabled>
              </div>
              <div class="form-group">
                <label class="control-label">Password:</label>
                <input type="password" class="form-control" name="password_old" placeholder="Mật khẩu hiện tại">
              </div>
              <div class="form-group">
                <label class="control-label">New password:</label>
                <input type="password" id="pass" class="form-control" name="password" placeholder="Mật khẩu mới">
              </div>
              <div class="form-group">
                <label class="control-label">Password Confirm:</label>
                <input type="password" id="renew_pass" class="form-control" name="renew_pass" placeholder="Nhập lại mật khẩu">
              </div>
          </div>
          <div class="right_register  col-md-6 col-sm-6 col-xs-12">
              <div class="title_register">Thông tin cá nhân</div>
             
              <div class="form-group">
                <label class="control-label">Điện thoại:</label>
                <input type="text" value="<?=$result_user['dienthoai']?>" class="form-control" name="dienthoai" placeholder="Telephone" required="required" pattern="^\+?\d{1,3}?[- .]?\(?(?:\d{2,3})\)?[- .]?\d\d\d[- .]?\d\d\d\d$">
              </div>
              <div class="form-group">
                <label class="control-label">Tỉnh/thành phố:</label>
                <select class="form-control" name="tinhthanh" id="tinhthanh">
                    <option value="">Tỉnh/thành phố</option>
                <?php foreach ($tinhthanh as $key => $value) { ?>
                    <option <?=($value['id']==$result_user['id_city'])?'selected':''?> value="<?=$value['id']?>"><?=$value['ten']?></option>
                <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label">Quận/huyện:</label>
                <select class="form-control" name="quanhuyen" id="quanhuyen">
                    <option value="">Quận/huyện</option>
                    <?php foreach ($quanhuyen as $key => $value) { ?>
                      <option <?=($value['id']==$result_user['id_district'])?'selected':''?> value="<?=$value['id']?>"><?=$value['ten']?></option>
                    <?php } ?>
                </select>
              </div>
              <div class="form-group">
                  <label class="control-label">Địa chỉ: </label>
                  <input type="text" value="<?=$result_user['diachi']?>" class="form-control" name="diachi" placeholder="Địa chỉ" required="required">
              </div>
              <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Cập nhật">
              </div>
          </div>
    </form>
  </div>
</div>