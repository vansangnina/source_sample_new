<div id="slider" class="owl-carousel">
 <?php  foreach ($slider as $key => $value) { ?>
 	<a class="slider-img" href="<?=$value['link']?>" title="<?=$value['ten']?>">
		<img class="owl-lazy" data-src="<?=UPLOAD_IMAGE_L.$value['thumb']?>" alt="<?=$value['ten']?>" 
		data-srcset="thumb/440x155/1/<?=UPLOAD_IMAGE_L.$value['thumb']?> 440w, thumb/768x270/1/<?=UPLOAD_IMAGE_L.$value['thumb']?> 768w, <?=UPLOAD_IMAGE_L.$value['thumb']?>" 
		data-sizes="(max-width: 440px) 420px, (max-width: 768px) 748px, (min-width: 769px) 749px"/>
	</a>
 <?php } ?>
</div>