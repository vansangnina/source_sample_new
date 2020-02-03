<div class="sub_main">
    <div class="title_main"><span><?=$title_detail?></span></div>
      <div class="content_main">
            <div class="text"><?=stripcslashes($row_detail['noidung_'.$lang])?></div>
            <?php include_once TEMPLATE.'layout/module/share.php'; ?>
            <div class="fb-comments" data-href="<?=getCurrentPageURL_CANO()?>" data-width="100%" data-numposts="5"></div>
       </div><!--content main-->
</div><!--end sub main-->
