<?php  if(!defined('SOURCE')){ die("Error"); }
		@$idc =  addslashes($_GET['idc']);
		@$idl =  addslashes($_GET['idl']);
		@$idi =  addslashes($_GET['idi']);
		@$ids =  addslashes($_GET['ids']);
		@$id=  addslashes($_GET['id']);
		$per_page = 8; 
		$upload_file = UPLOAD_POST_L;
		if($id!=''){
			$d->reset();
			$d->query("select id,id_list,id_cat,ten_$lang,mota_$lang,noidung_$lang,title,keywords,description,photo from #_baiviet where id='".$id."' and hienthi=1");
			$row_detail = $d->fetch_array();

			switch ($type_bar) {
				case 'tintuc':
					$title_other = TINTUCKHAC;
					break;
				case 'dichvu':
					$title_other = DICHVUKHAC;
					break;
				default:
					$title_other = BAIVIETKHAC;
					break;
			}

			if($row_detail['title']!=''){
				$title_bar = $row_detail['title'];
			}else{
				$title_bar = $row_detail['ten_'.$lang];
			}
			$keywords_bar = $row_detail['keywords'];
			$description_bar = $row_detail['description'];

			$sql_other = "select ten_$lang,ngaytao,id,tenkhongdau,photo,mota_$lang from #_baiviet where id!='".$row_detail['id']."' and type='".$type_bar."'";
			if($row_detail['id_list']!=0){
				$sql_other.=" and id_list='".$row_detail['id_list']."'";
			}
			if($row_detail['id_cat']!=0){
				$sql_other.=" and id_cat='".$row_detail['id_cat']."'";
			}
			
			$sql_other.=" and hienthi=1 order by stt,ngaytao desc limit 0,6";
			$d->query($sql_other);
			$tintuc = $d->result_array();

		}elseif($idl!=''){ 
			$d->reset();
			$sql_cat="select id,ten_$lang,title,keywords,description,photo from #_baiviet_list where id='".$idl."' and type='".$type_bar."'";
			$d->query($sql_cat);
			$row_detail=$d->fetch_array();
			$where = " #_baiviet where type='".$type_bar."' and id_list='".$row_detail['id']."' and hienthi=1";
			$sql="select id,ten_$lang,mota_$lang,noidung_$lang,photo,title,keywords,description from";
			$startpoint = ($page * $per_page) - $per_page;
			$limit = ' limit '.$startpoint.','.$per_page;
			$sql.=$where." order by stt,ngaytao desc $limit";
			$d->query($sql);
			$tintuc = $d->result_array();
			$url = getCurrentPageURL();
			$paging = pagination($where,$per_page,$page,$url);
			$title_detail = $row_detail['ten_'.$lang];
			if($row_detail['title']!=''){
				$title_bar = $row_detail['title'];
			}else{
				$title_bar = $row_detail['ten_'.$lang];
			}
			$keywords_bar = $row_detail['keywords'];
			$description_bar = $row_detail['description'];
		}elseif($idc!=''){
			$d->reset();
			$sql_cat="select id,ten_$lang,title,keywords,description,photo from #_baiviet_cat where id='".$idc."' and type='".$type_bar."'";
			$d->query($sql_cat);
			$row_detail=$d->fetch_array();
			$where = " #_baiviet where type='".$type_bar."' and id_cat='".$row_detail['id']."' and hienthi=1";
			$sql="select id,ten_$lang,mota_$lang,noidung_$lang,photo,title,keywords,description from";
			$startpoint = ($page * $per_page) - $per_page;
			$limit = ' limit '.$startpoint.','.$per_page;
			$sql.=$where." order by stt,ngaytao desc $limit";
			$d->query($sql);
			$tintuc = $d->result_array();
			$url = getCurrentPageURL();
			$paging = pagination($where,$per_page,$page,$url);
			$title_detail = $row_detail['ten_'.$lang];
			if($row_detail['title']!=''){
				$title_bar = $row_detail['title'];
			}else{
				$title_bar = $row_detail['ten_'.$lang];
			}
			$keywords_bar = $row_detail['keywords'];
			$description_bar = $row_detail['description'];
		}elseif($idi){
			$d->reset();
			$sql_cat="select id,ten_$lang,title,keywords,description,photo from #_baiviet_item where id='".$idi."' and type='".$type_bar."'";
			$d->query($sql_cat);
			$row_detail=$d->fetch_array();
			$where = " #_baiviet where type='".$type_bar."' and id_item='".$row_detail['id']."' and hienthi=1";
			$sql="select id,ten_$lang,mota_$lang,noidung_$lang,photo,title,keywords,description from";
			$startpoint = ($page * $per_page) - $per_page;
			$limit = ' limit '.$startpoint.','.$per_page;
			$sql.=$where." order by stt,ngaytao desc $limit";
			$d->query($sql);
			$tintuc = $d->result_array();
			$url = getCurrentPageURL();
			$paging = pagination($where,$per_page,$page,$url);
			$title_detail = $row_detail['ten_'.$lang];
			if($row_detail['title']!=''){
				$title_bar = $row_detail['title'];
			}else{
				$title_bar = $row_detail['ten_'.$lang];
			}
			$keywords_bar = $row_detail['keywords'];
			$description_bar = $row_detail['description'];
		}elseif($ids){
			$d->reset();
			$sql_cat="select id,ten_$lang,title,keywords,description,photo from #_baiviet_sub where id='".$ids."' and type='".$type_bar."'";
			$d->query($sql_cat);
			$row_detail=$d->fetch_array();
			$where = " #_baiviet where type='".$type_bar."' and id_sub='".$row_detail['id']."' and hienthi=1";
			$sql="select id,ten_$lang,mota_$lang,noidung_$lang,photo,title,keywords,description from";
			$startpoint = ($page * $per_page) - $per_page;
			$limit = ' limit '.$startpoint.','.$per_page;
			$sql.=$where." order by stt,ngaytao desc $limit";
			$d->query($sql);
			$tintuc = $d->result_array();
			$url = getCurrentPageURL();
			$paging = pagination($where,$per_page,$page,$url);
			$title_detail = $row_detail['ten_'.$lang];
			if($row_detail['title']!=''){
				$title_bar = $row_detail['title'];
			}else{
				$title_bar = $row_detail['ten_'.$lang];
			}
			$keywords_bar = $row_detail['keywords'];
			$description_bar = $row_detail['description'];
		}else{
			$upload_file = UPLOAD_SE0_L;
			$d->reset();
			$d->query("select title,keywords,description,photo from #_title where type='".$type_bar."' limit 0,1");
			$row_detail = $d->fetch_array();
			$title_bar = $row_detail['title'];
			$keywords_bar = $row_detail['keywords'];
			$description_bar = $row_detail['description'];
			$sql="select id,ten_$lang,mota_$lang,tenkhongdau,photo from";
			$startpoint = ($page * $per_page) - $per_page;
			$limit = ' limit '.$startpoint.','.$per_page;
			$where = " #_baiviet where type='".$type_bar."' and hienthi=1";
			$sql.=$where." order by stt,ngaytao desc $limit";
			$d->query($sql);
			$tintuc = $d->result_array();
			$url = getCurrentPageURL();
			$paging = pagination($where,$per_page,$page,$url);
		}
?>