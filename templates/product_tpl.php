<div class="sub_main">
  <div class="title_main"><span><?=$title_detail?></span></div>
  <div class="content_main clearfix">
      <div class="row_product">
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
  </div><!--content main-->
  <div class="wrap"><div class="auto"><?=$paging?></div></div>
</div><!--end sub main-->

