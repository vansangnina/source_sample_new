<?php  if(!defined('SOURCE')) { die("Error"); }

	$upload_file = UPLOAD_IMAGE_L;

	$d->reset();
	$d->query("select noidung_$lang,title,keywords,description,photo from #_info where type='".$type_bar."'");
	$row_detail = $d->fetch_array();

	$title_bar = $row_detail['title'];
	$keywords_bar = $row_detail['keywords'];
	$description_bar = $row_detail['description'];

?>