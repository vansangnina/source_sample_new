<div class="wrapper">
	<div class="control_frm" style="margin-top:25px;">
	    <div class="bc">
	        <ul id="breadcrumbs" class="breadcrumbs">
	            <li class="current"><a href="#" onclick="return false;">Thêm nội dung dịch</a></li>
	        </ul>
	        <div class="clear"></div>
	    </div>
	</div>
	<form name="supplier" id="validate" class="form" action="index.php?com=lang&act=save&type=<?=$type?>" method="post" enctype="multipart/form-data">
		<div class="widget">
			<div class="formRow">
				<label>Define</label>
				<div class="formRight">
	                <input type="text" name="define" title="Nhập define" id="define" class="tipS validate[required]" <?=$_GET['act']=='edit' ? 'readonly="readonly"':''?> value="<?=@$item['define']?>"  />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Tiếng việt</label>
				<div class="formRight">
	                <input type="text" name="lang_vi" title="Nhập tiếng việt" id="lang_vi" class="tipS validate[required]" value="<?=@$item['lang_vi']?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Tiếng anh</label>
				<div class="formRight">
	                <input type="text" name="lang_en" title="Nhập tiếng anh" id="lang_en" class="tipS validate[required]" value="<?=@$item['lang_en']?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
		          <label>Hiển thị : <img src="./images/question-button.png" alt="Chọn loại" class="icon_que tipS" original-title="Bỏ chọn để không hiển thị danh mục này ! "> </label>
		          <div class="formRight">
		         
		            <input type="checkbox" name="hienthi" id="check1" value="1" <?=(!isset($item['hienthi']) || $item['hienthi']==1)?'checked="checked"':''?> />
		             
		          </div>
		          <div class="clear"></div>
		    </div>
		    <div class="formRow">
				<div class="formRight">
	                <input type="hidden" name="id" id="id_this_post" value="<?=@$item['id']?>" />
	            	<input type="submit" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
	            	<a href="index.php?com=lang&act=man" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</form>
</div>