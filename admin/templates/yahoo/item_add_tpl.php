<script type="text/javascript">
	function TreeFilterChanged2(){
		//alert('ok');
		$('#validate_yahoo').submit();
	}
</script>
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
            <li><a href="index.php?com=yahoo&act=man"><span>Hỗ trợ trực tuyến</span></a></li>
            <li class="current"><a href="#" onclick="return false;">Thêm</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<form name="supplier" id="validate_yahoo" class="form" action="index.php?com=yahoo&act=save" method="post" enctype="multipart/form-data">
	<div class="widget">
		<div class="title"><img src="./images/icons/dark/list.png" alt="" class="titleIcon" />
			<h6>Nhập dữ liệu</h6>
		</div>
		<?php
		 if(count($config['lang'])>1) {?>
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
	<div class="formRow">
		<label>Tên <?=$key!=$config['lang_active']?'('.$key.')':''?></label>
		<div class="formRight">
            <input type="text" name="data[ten_<?=$key?>]" title="Nhập tên nhân viên hỗ trợ" id="name" class="tipS validate[required]" value="<?=@$item['ten_'.$key]?>" />
		</div>
		<div class="clear"></div>
	</div>
</div><!--lang-->
<?php } ?>
		
        <div class="formRow">
			<label>Điện thoại</label>
			<div class="formRight">
                <input type="text" name="dienthoai" title="Nhập số điện thoại" id="dienthoai" class="tipS validate[required]" value="<?=@$item['dienthoai']?>" />
			</div>
			<div class="clear"></div>
		</div>
        <div class="formRow">
			<label>Email</label>
			<div class="formRight">
                <input type="text" name="email" title="Nhập địa chỉ email" id="email" class="tipS validate[required]" value="<?=@$item['email']?>" />
			</div>
			<div class="clear"></div>
		</div>
        <div class="formRow">
			<label>Yahoo</label>
			<div class="formRight">
                <input type="text" name="yahoo" title="Nhập nick chat yahoo" id="yahoo" class="tipS validate[required]" value="<?=@$item['yahoo']?>" />
			</div>
			<div class="clear"></div>
		</div>
        <div class="formRow">
			<label>Skype</label>
			<div class="formRight">
                <input type="text" name="skype" title="Nhập nick chat skype" id="skype" class="tipS validate[required]" value="<?=@$item['skype']?>" />
			</div>
			<div class="clear"></div>
		</div>
		     
        
		
        <div class="formRow">
          <label>Tùy chọn: <img src="./images/question-button.png" alt="Chọn loại" class="icon_que tipS" original-title="Check vào những tùy chọn "> </label>
          <div class="formRight">
           
            <input type="checkbox" name="active" id="check1" value="1" <?=(!isset($item['hienthi']) || $item['hienthi']==1)?'checked="checked"':''?> />
            <label for="check1">Hiển thị</label>            
          </div>
          <div class="clear"></div>
        </div>
        <div class="formRow">
            <label>Số thứ tự: </label>
            <div class="formRight">
                <input type="text" class="tipS" value="<?=isset($item['stt'])?$item['stt']:1?>" name="num" style="width:20px; text-align:center;" onkeypress="return OnlyNumber(event)" original-title="Số thứ tự của danh mục, chỉ nhập số">
            </div>
            <div class="clear"></div>
        </div>
		
		
		<div class="formRow">
			<div class="formRight">
                 <input type="hidden" name="id" id="id_this_yahoo" value="<?=@$item['id']?>" />
            	<input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
			</div>
			<div class="clear"></div>
		</div>
		
	</div>  
	
</form>        </div>