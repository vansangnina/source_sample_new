<div id="header" class="clearfix lazy" data-bg="url(thumb/1366x110/1/<?=UPLOAD_IMAGE_L.$banner_qc['photo_'.$lang]?>)">
  <div id="banner">
    <div class="inner">
      <?php if(!$_GET['id']){ ?><h1><?=$title_bar?></h1><?php } ?>
      <div class="logo">
        <a href=""><img src="thumb/279x137/1/<?=UPLOAD_IMAGE_L.$logo['photo_'.$lang]?>" alt="<?=$row_setting['ten_'.$lang]?>" class="mw100"/></a>
      </div>
      <div class="company"><img src="thumb/668x143/1/<?=UPLOAD_IMAGE_L.$banner['photo_'.$lang]?>" alt="<?=$row_setting['ten_'.$lang]?>" class="mw100"/></div>
      <div class="cart"><span id="numcart"><?=count($_SESSION['cart'])?></span><a href="gio-hang">Sản phẩm</a></div>
      <div class="user">
        <?php if(!$_SESSION['loginuser']){?>
          <a href="dang-ky">Đăng ký</a>
          <a href="dang-nhap">Đăng nhập</a>
        <?php }else{ ?>
          <a><i class="fas fa-user"></i> <?=$info_user['ten']?></a>
          <a href="logout">Đăng xuất <i class="fas fa-sign-out-alt"></i></a>
          <a class="block" href="tai-khoan">Thông tin tài khoản</a>
        <?php } ?>
      </div>
      <div id="languages">
        <a href="ngon-ngu/vi.htm"><img src="thumb/32x22/1/images/vi.png" alt="vi"></a>
        <a href="ngon-ngu/en.htm"><img src="thumb/32x22/1/images/en.png" alt="en"></a>
      </div>
    </div>
  </div>
</div>