<div class="sub_main clearfix">
    <div class="title_main"><span><?=$title_detail?></span></div>
    <div class="content_main">
        
        <h1 class="tieude"> <?=$row_detail['ten_'.$lang]?></h1>
        <div class="text">
            <?=check_ssl_content($row_detail['noidung_'.$lang])?>
            <?php include_once TEMPLATE.'layout/module/share.php'; ?>
            <div class="fb-comments" data-href="<?=getCurrentPageURL_CANO()?>" data-width="100%" data-numposts="5"></div>
        </div>
    </div>
</div>
<div class="sub_main clearfix">
    <div class="title_news_other"><?=$title_other?></div>
    <div class="row_product">
        <?php
        if($tintuc){
            foreach ($tintuc as $key => $value) { ?>
            <div class="col_news col-md-3 col-sm-6 col-xs-6">
                <div class="box_news clearfix">
                    <a class="box_news_img" href="<?=$value['tenkhongdau']?>" title="<?=$value['ten_'.$lang]?>" class="my_glass"><img alt="<?=$value['ten_'.$lang]?>" src="thumb/300x250/1/<?=UPLOAD_POST_L.$value['photo']?>" onError="this.src='thumb/300x250/1/images/noimage.png'" class="w100 trans03"/></a>
                    <div class="right_news">
                        <h3 class="box_news_name">
                            <a href="<?=$value['tenkhongdau']?>" title="<?=$value['ten_'.$lang]?>">
                                <?=stripcslashes($value['ten_'.$lang])?>
                            </a>
                        </h3>
                        <div class="box_news_mota"><?=sub_str(stripcslashes($value['mota_'.$lang]),150)?></div>
                    </div>
                </div>
            </div>
        <?php } } ?>
    </div>
</div>