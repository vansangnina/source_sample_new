<div class="wrapper">
	<div class="control_frm" style="margin-top:25px;">
	    <div class="bc">
	        <ul id="breadcrumbs" class="breadcrumbs">
	        	<li><a href="index.php?com=coupon&act=add"><span>Thêm <?=$title_main?></span></a></li>
	            <li class="current"><a href="#" onclick="return false;">Thêm</a></li>
	        </ul>
	        <div class="clear"></div>
	    </div>
	</div>
	<form name="supplier" id="validate" class="form" action="index.php?com=coupon&act=send" method="post" enctype="multipart/form-data">
	    <div class="widget">
	        <div class="formRow">
	            <label>Mã giảm giá</label>
	            <div class="formRight">
	                <input type="text" readonly="readonly"  name="macode" title="Mã giảm giá" id="code" class="tipS validate[required]" value="<?=@$item['ma']?>" />
	            </div>
	            <div class="clear"></div>
	        </div>
	        <div class="formRow">
	            <label>Thành viên</label>
	            <div class="formRight">
	                <select name="thanhvien[]" id="thanhvien" multiple="multiple" class="sel_muti">
	                	<option value="">Chọn danh sách thành viên</option>
	                	<?php foreach ($thanhvien as $key => $value) { ?>
	                		<option value="<?=$value['id']?>"><?=$value['ten']?></option>
	                	<?php } ?>
	                </select>
	            </div>
	            <div class="clear"></div>
	        </div>
			<div class="formRow">
				<div class="formRight">
	                <input type="hidden" name="id" id="id_this_post" value="<?=@$_GET['id']?>" />
	            	<input type="submit" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Gửi mã" />
	            	<a href="index.php?com=coupon&act=man" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</form>
</div>