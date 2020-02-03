<?php  if(!defined('SOURCE')){ die("Error"); }

	$id_list = $d->escape_str($_GET['list']);
	$key = $d->escape_str($_GET['keywords']);
	$key_khong_dau=changeTitle($key);

	$per_page = 12; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " #_product where type='product'";
	if($key!=''){
		$where.=" and (ten_$lang like'%$key%' or tenkhongdau like'%$key_khong_dau%' or ( id_list IN (SELECT id FROM #_product_list where ten_$lang like'%$key%') ) or ( id_cat IN (SELECT id FROM #_product_cat where ten_$lang like'%$key%') ) or ( id_item IN (SELECT id FROM #_product_item where ten_$lang like'%$key%') ) )";

	}
	if($id_list!=''){
		$where.=" and id_list=(select id from #_product_list where tenkhongdau='".$id_list."')";
	}
	$where .= " and hienthi=1 order by stt,ngaytao desc";

	$sql = "select ten_$lang,id,photo,tenkhongdau,giaban,giacu from $where $limit";
	$d->query($sql);
	$product = $d->result_array();
	$title_detail = TIMTHAY." ".count($product)." ".KETQUA;

	$url = getCurrentPageURL();
	$paging = pagination($where,$per_page,$page,$url);

?>