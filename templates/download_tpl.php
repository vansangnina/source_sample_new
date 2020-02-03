<div class="sub_main clearfix">
	<div class="title_main"><span><?=$title_detail?></span></div>
	<div class="content_main col-md-10 col-sm-10 col-xs-12 col-md-offset-1 col-sm-offset-1 col-xs-offset-0">
	<?php foreach ($list_pro as $key => $value) { ?>
		<div class="box_file clearfix">
			<div class="col-md-4 col-sm-5 col-xs-12">
				<span class="name_list_file"><?=$list_pro[$key]['list']['ten']?></span>
			</div>
			<div class="col-md-8 col-sm-7 col-xs-12">
				<ul class="list_file">
				<?php foreach ($list_pro[$key]['file'] as $k => $v) { ?>
					<li><a target="_blank" href="<?=UPLOAD_FILE_L.$v['file']?>"><?=$v['ten_file']?>.<?=getFormatFile($v['file'])?> (<?=round(filesize(UPLOAD_FILE_L.$v['file'])/1000,0)?>KB)</a></li>
				<?php } ?>
				</ul>
			</div>
		</div>
	<?php } ?>
	</div>
</div>