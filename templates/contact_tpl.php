
<div class="sub_main">
	<div class="title_main"><span><?=$title_detail?></span></div>
    <div class="content_main">
    	<div class="col-md-6 col-sm-6 col-xs-12">
    		<div class="text"><?=stripcslashes($row_detail['noidung_'.$lang])?></div>
    	</div>
    	<div class="col-md-6 col-sm-6 col-xs-12">
    		<?php include TEMPLATE.'form/form_contact.php'; ?>
    	</div>
    	<div class="clear"></div>

    	<div class="contain_map_lienhe">
	    	<?=$row_setting['googlemap']?>
    	</div>
     </div><!--content main-->
</div><!--end sub main-->

