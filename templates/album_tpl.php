<div class="sub_main">
    <div class="title_main"><span><?=$title_detail?></span></div>
    <div class="content_main clearfix">
        <div class="row_product">
        <?php if(count($album)!=0){?>
            <?php foreach ($album as $key => $value) { ?>
                <div class="col_product">
                    <div class="box_album">
                        <a href="<?=$value['tenkhongdau']?>" title="<?=$value['ten_'.$lang]?>">
                            <img class="w100" src="thumb/400x300/1/<?=UPLOAD_ALBUM_L.$value['photo']?>" alt="<?=$value['tenkhongdau']?>">
                            <h2><?=$value['ten_'.$lang]?></h2>
                        </a>
                    </div>
                </div>
            <?php }?>
        <?php } else { ?><div style="text-align:center; color:#FF0000; font-weight:900; font-size:22px; text-transform:uppercase;" >Chưa Có Tin Cho Mục này .</div> <?php }?>
        </div>
    </div>
    <div class="wrap"><div class="auto"><?=$paging?></div></div>
</div>
