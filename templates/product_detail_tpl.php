<div class="sub_main clearfix">
  <div class="title_main"><span><?=CHITIETSANPHAM?></span></div>
  <div class="content_main">
    <div class="row">
      <div class="img_detail col-md-5 col-sm-6 col-xs-12">
        <div class="main_img_detail">
          <a id="Zoomer" href="<?=UPLOAD_PRODUCT_L.$row_detail['photo']?>" class="MagicZoomPlus" rel="zoom-width:300px; zoom-height:300px;selectors-effect-speed: 600; selectors-class: Active;">
            <img src="thumb/625x500/1/<?=UPLOAD_PRODUCT_L.$row_detail['photo']?>" alt="<?=$row_detail['ten_'.$lang]?>"/>
          </a>
        </div>
        <?php include_once "layout/module/sub_img_detail_h.php"; ?>
      </div>

      <div class="info_detail col-md-7 col-sm-6 col-xs-12">
        <div class="item_info_detail name_detail"><h1><?=$row_detail['ten_'.$lang]?></h1></div>
        <div class="item_info_detail"><b><?=MASANPHAM?> : </b><span><?=$row_detail['masp']?></span></div>
        <div class="item_info_detail clearfix">
          <span class="price_now"><?=($row_detail['giaban']==0)?'Liên hệ':number_format($row_detail['giaban'],0,',','.')."đ"?></span>
          <?php if($row_detail['giacu']>0){?><span class="price_old">(<?=number_format($row_detail['giacu'],0,',','.')."đ"?>)</span><?php } ?>
        </div>
        <div class="item_info_detail"><b><?=MOTA?> : </b><?=$row_detail['mota_'.$lang]?></div>
        
        <div class="item_info_detail"><?php include_once TEMPLATE.'layout/module/share.php'; ?></div>
        <div class="item_info_detail amount_cart clearfix">
          <button id="minus"><i class="fas fa-minus"></i></button>
          <input type="text" min="1" max="99" value="1" class="amount">
          <button id="plus"><i class="fas fa-plus"></i></button>
        </div>
        <div class="item_info_detail">
          <a class="btn_Cart_Detail buy-now" onclick="addtocart(<?=$row_detail['id']?>,$('.amount).val(),1)">Mua ngay</a>
          <a class="btn_Cart_Detail buy-to-cart" onclick="addtocart(<?=$row_detail['id']?>,$('.amount').val(),0)">Thêm vào giỏ hàng</a>
        </div>
      </div>
      <div class="clear"></div>
    </div>
    <div class="bottom_detail">
        <div class="contain_tab">
            <a href="#noidung_chitiet" class="item_tab active" ><?=NOIDUNGCHITIET?></a>
            <a href="#binhluan" class="item_tab" ><?=BINHLUAN?></a>
        </div><!--end contain tab-->
        <div class="clear"></div>
        <div class="contain_content_tab">
            <div id="noidung_chitiet" class="content_tab active ">
                <div class="text">
                    <?=check_ssl_content($row_detail['noidung_'.$lang])?>
                </div>
            </div>
            <div id="binhluan" class="content_tab">
              <div class="fb-comments" data-href="<?=getCurrentPageURL_CANO()?>" data-width="100%" data-numposts="5"></div>
            </div>
        </div>
    </div>
  </div>
</div>
<div class="sub_main clearfix">
    <div class="title_main"><span><?=$title_other?></span></div>
    <div class="content_main clearfix">
        <div class="row">
          <?php
              if(count($product)>0){
              foreach ($product as $key => $value) { ?>
                <div class="col_product col-md-3 col-sm-4 col-xs-6">
                  <div class="box_product">
                      <div class="img_product">
                          <a href="<?=$value['tenkhongdau']?>" title="<?=$value['ten_vi']?>"><img src="thumb/280x260/1/<?=UPLOAD_PRODUCT_L.$value['photo']?>" alt="<?=$value['ten_'.$lang]?>" class="w100"></a>
                      </div>
                      <h2 class="name_product"><a href="<?=$value['tenkhongdau']?>" title="<?=$value['ten_vi']?>"><?=$value['ten_'.$lang]?></a></h2>
                      <div class="price_product">
                          <?php if($value['giacu']>0){?><p class="price_old"><?=number_format($value['giacu'],0,',','.').' VNĐ'?></p><?php }?>
                          <p class="price_now"><?=$value['giaban']==0?LIENHE:number_format($value['giaban'],0,',','.').' VNĐ'?></p> 
                          <span onclick="addtocart(<?=$value['id']?>,1,1)">Mua ngay</span>
                      </div>
                  </div>
                </div>
            <?php } } ?>
        </div>
    </div>
</div>
