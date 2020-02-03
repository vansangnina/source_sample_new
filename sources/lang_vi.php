<?php  if(!defined('SOURCE')){ die("Error"); }
	$d->reset();
	$d->setTable("lang");
	$d->setWhere("type","lang");
	$d->select("define,lang_vi");
	$result_lang = $d->result_array();
	foreach ($result_lang as $key => $value) {
		@define($value['define'],$value['lang_vi']);
	}
?>