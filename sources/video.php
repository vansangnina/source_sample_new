<?php  if(!defined('SOURCE')){ die("Error"); }

		$id =  addslashes($_GET['id']);
		
		if($id!=''){
			$d->reset();
			$d->query("select id,photo,link,ten_$lang,photo from #_video where hienthi=1 and tenkhongdau='".$id."'");
			$row_detail = $d->fetch_array();

			$title_detail = $title_main;
			$title_bar = $row_detail['title'];
			$keyword_bar = $row_detail['keywords'];
			$description_bar = $row_detail['description'];
			

			$title_other = VIDEOKHAC;

			$d->reset();
			$d->query("select ten_$lang,ngaytao,id,tenkhongdau,links,luotxem from #_video where hienthi=1 and tenkhongdau !='".$id."' and type='video' order by stt,ngaytao desc limit 0,10");
			$tintuc = $d->result_array();

		} else {

			// cac tin tuc
			$per_page = 10; // Set how many records do you want to display per page.
			$startpoint = ($page * $per_page) - $per_page;
			$limit = ' limit '.$startpoint.','.$per_page;
			
			$where = " #_video where hienthi=1 and type='video' order by id desc";

			$sql = "select ten_$lang,tenkhongdau,id,ngaytao,links,luotxem from $where $limit";
			$d->query($sql);
			$tintuc = $d->result_array();

			$url = getCurrentPageURL();
			$paging = pagination($where,$per_page,$page,$url);

			$title_detail = "Video";

		}
	
?>