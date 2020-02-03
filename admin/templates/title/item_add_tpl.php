<div class="wrapper">
	<div class="control_frm" style="margin-top:25px;">
	    <div class="bc">
	        <ul id="breadcrumbs" class="breadcrumbs">
	            <li class="current"><a href="#" onclick="return false;"><?=$title_main?></a></li>
	        </ul>
	        <div class="clear"></div>
	    </div>
	</div>
	<form name="supplier" id="validate" class="form" action="index.php?com=title&act=save&type=<?=$type?>" method="post" enctype="multipart/form-data">
		<div class="widget">
			<div class="title"><img src="./images/icons/dark/record.png" alt="" class="titleIcon" />
				<h6>Nội dung seo</h6>
			</div>
			<?php if($config_images=='true'){ ?>
				<div class="formRow">
					<label>Tải hình ảnh:</label>
					<div class="formRight">
			        	<input type="file" id="file" name="file" />
						<img src="./images/question-button.png" alt="Upload hình" class="icon_question tipS" original-title="Tải hình ảnh (ảnh JPEG, GIF , JPG , PNG)">
						<div class="note"> width : <?php echo 300;?> px , Height : <?php echo 300;?> px </div>
					</div>
					<div class="clear"></div>
				</div>

					<div class="formRow">
						<label>Hình Hiện Tại :</label>
						<div class="formRight">
						
						<div class="mt10"><img src="<?=UPLOAD_SEO.$item['thumb']?>"  alt="NO PHOTO" width="200"/></div>
						</div>
						<div class="clear"></div>
					</div>
			<?php } ?>
			<div class="formRow">
				<label>Title</label>
				<div class="formRight">
	                <input type="text" name="title" title="Nhập title" id="title" class="tipS validate[required]" value="<?=@$item['title']?>" />
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<label>Keywords</label>
				<div class="formRight">
					<input type="text" value="<?=@$item['keywords']?>" name="keywords" title="Từ khóa chính cho danh mục" class="tipS validate[required]" />
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="formRow">
				<label>Description:</label>
				<div class="formRight">
					<textarea rows="5" cols="" title="Nội dung thẻ meta Description dùng để SEO" class="tipS validate[required]" name="description"><?=@$item['description']?></textarea>
	                <b>(Tốt nhất là 68 - 170 ký tự)</b>
				</div>
				<div class="clear"></div>
			</div>
		    <div class="formRow">
				<div class="formRight">
	                <input type="hidden" name="id" id="id_this_post" value="<?=@$item['id']?>" />
	            	<input type="submit" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
	            	<a href="index.php?com=title&act=man" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</form>
</div>