
<script type="text/javascript">		
	$(document).ready(function() {
		$('.chonngonngu li a').click(function(event) {
			var lang = $(this).attr('href');
			$('.chonngonngu li a').removeClass('active');
			$(this).addClass('active');
			$('.lang_hidden').removeClass('active');
			$('.lang_'+lang).addClass('active');
			return false;
		});
	});

</script>
<div class="wrapper">

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="index.php?com=httt&act=add<?php if($type!='') echo'&type='. $type;?>"><span>Thêm <?=$title_main?></span></a></li>
            <li class="current"><a href="#" onclick="return false;">Thêm</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>

<form name="supplier" id="validate" class="form" action="index.php?com=httt&act=save<?php if($type!='') echo'&type='. $type;?>" method="post" enctype="multipart/form-data">
	<div class="widget">
		<?php if(count($config['lang']) > 1){ ?>
			<div class="title chonngonngu">
			<ul>
			<?php foreach ($config['lang'] as $key => $value) { ?>
	            <li><a href="<?=$key?>" class="<?=$key==$config['lang_active']?'active':''?> tipS validate[required]" title="Chọn <?=$value?>"><?=$value?></a></li>
	        <?php } ?>
			</ul>
			</div>	
		<?php } ?>
		<?php foreach ($config['lang'] as $key => $value) { ?>
	       <div class="contain_lang_<?=$key?> contain_lang <?=$key==$config['lang_active']?'active':''?>">
			    <div class="title"><img src="./images/icons/dark/record.png" alt="" class="titleIcon" />
			        <h6>Nội dung <?=$value?></h6>
			    </div>
		        <div class="formRow">
					<label>Tiêu đề <?=$key!=$config['lang_active']?'('.$key.')':''?></label>
					<div class="formRight">
		                <input type="text" name="data[ten_<?=$key?>]" title="Nhập tên hình thức thanh toán" id="ten" class="tipS validate[required]" value="<?=@$item['ten_'.$key]?>" />
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label>Mô tả <?=$key!=$config['lang_active']?'('.$key.')':''?></label>
					<div class="ck_editor">
			            <textarea id="noidung_<?=$key?>" cols="50" rows="10" name="data[noidung_<?=$key?>]"><?=@$item['noidung_'.$key]?></textarea>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		<?php } ?>
	</div>  
	<div class="widget">
	
		<div class="formRow">
			<div class="formRight">
                <input type="hidden" name="type" id="id_this_type" value="<?=$type?>" />
                <input type="hidden" name="id" id="id_this_post" value="<?=@$item['id']?>" />
            	<input type="submit" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
            	<a href="index.php?com=httt&act=man<?php if($type!='') echo'&type='. $type;?>" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
			</div>
			<div class="clear"></div>
		</div>

	</div>
</form>        </div>
