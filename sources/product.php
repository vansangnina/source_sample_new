<?php  if(!defined('SOURCE')){ die("Error"); }
		
		@$idc =  addslashes($_GET['idc']);
		@$idl =  addslashes($_GET['idl']);
		@$idi =  addslashes($_GET['idi']);
		@$ids =  addslashes($_GET['ids']);
		@$id=  addslashes($_GET['id']);
			

		$per_page = 20; 
		$upload_file = UPLOAD_PRODUCT_L;

		if($id!=''){ 
			$d->reset();
			$d->query("select * from #_product where hienthi=1 and type='".$type_bar."' and id='".$id."'");
			$row_detail = $d->fetch_array();

			$title_other = SANPHAMKHAC;

			if($row_detail['title']!=''){
				$title_bar = $row_detail['title'];
			}else{
				$title_bar = $row_detail['ten_'.$lang];
			}
			$keywords_bar = $row_detail['keywords'];
			$description_bar = $row_detail['description'];
			

			$d->reset();
			$sql_other = "select id,ten_$lang,giaban,giacu,tenkhongdau,photo from #_product where type='".$type_bar."' and id!='".$row_detail['id']."'";
			if($row_detail['id_list']!=0){
				$sql_other.=" and id_list='".$row_detail['id_list']."'";
			}
			if($row_detail['id_cat']!=0){
				$sql_other.=" and id_cat='".$row_detail['id_cat']."'";
			}
			$sql_other.=" and hienthi=1 order by stt,ngaytao desc limit 0,8";
			$d->query($sql_other);
			$product = $d->result_array();
			


			$d->reset();
		    $sql = "select thumb,id,photo from #_product_photo where hienthi=1 and type='$type_bar' and id_product='".$row_detail['id']."' order by stt,id desc ";
		    $d->query($sql);
		    $product_photo = $d->result_array();
		}elseif($idl!=''){
			$d->reset();
			$sql_list="select id,ten_$lang,keywords,description,title,photo from #_product_list where id='".$idl."' and type='$type_bar'";
			$d->query($sql_list);
			$row_detail = $d->fetch_array();
			$where = " #_product where type='".$type_bar."' and id_list='".$row_detail['id']."' and hienthi=1";
			$sql="select id,ten_$lang,giaban,giacu,tenkhongdau,photo from";
			$startpoint = ($page * $per_page) - $per_page;
			$limit = ' limit '.$startpoint.','.$per_page;
			$sql.=$where." order by stt,ngaytao desc $limit";
			$d->query($sql);
			$product = $d->result_array();
			
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
			$sql_cat="select id,ten_$lang,keywords,description,title,photo from #_product_cat where id='".$idc."' and type='$type_bar'";
			$d->query($sql_cat);
			$row_detail = $d->fetch_array();
			$where = " #_product where type='".$type_bar."' and id_cat='".$row_detail['id']."' and hienthi=1";
			$sql="select id,ten_$lang,giaban,giacu,tenkhongdau,photo from";
			$startpoint = ($page * $per_page) - $per_page;
			$limit = ' limit '.$startpoint.','.$per_page;
			$sql.=$where." order by stt,ngaytao desc $limit";
			$d->query($sql);
			$product = $d->result_array();
			
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
		}elseif($idi!=''){
			$d->reset();
			$sql_item="select id,ten_$lang,keywords,description,title,photo from #_product_item where id='".$idi."' and type='$type_bar'";
			$d->query($sql_item);
			$row_detail = $d->fetch_array();
			$where = " #_product where type='".$type_bar."' and id_item='".$row_detail['id']."' and hienthi=1";
			$sql="select id,ten_$lang,giaban,giacu,tenkhongdau,photo from";
			$startpoint = ($page * $per_page) - $per_page;
			$limit = ' limit '.$startpoint.','.$per_page;
			$sql.=$where." order by stt,ngaytao desc $limit";
			$d->query($sql);
			$product = $d->result_array();
			
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
		}elseif($ids!=''){
			$d->reset();
			$sql_sub="select id,ten_$lang,keywords,description,title,photo from #_product_sub where id='".$ids."' and type='$type_bar'";
			$d->query($sql_sub);
			
			$row_detail = $d->fetch_array();
			
			$where = " #_product where type='".$type_bar."' and id_sub='".$row_detail['id']."' and hienthi=1";
			$sql="select id,ten_$lang,giaban,giacu,tenkhongdau,photo from";
			$startpoint = ($page * $per_page) - $per_page;
			$limit = ' limit '.$startpoint.','.$per_page;
			$sql.=$where." order by stt,ngaytao desc $limit";
			$d->query($sql);
			$product = $d->result_array();
			
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
		}else{ // if rong

			$upload_file = UPLOAD_SE0_L;
			$d->reset();
			$d->query("select title,keywords,description,photo from #_title where type='".$type_bar."' limit 0,1");
			$row_detail = $d->fetch_array();

			$title_bar = $row_detail['title'];
			$keywords_bar = $row_detail['keywords'];
			$description_bar = $row_detail['description'];

			$sql="select id,ten_$lang,giaban,giacu,tenkhongdau,photo from";
			$startpoint = ($page * $per_page) - $per_page;
			$limit = ' limit '.$startpoint.','.$per_page;
			$where = " #_product where type='".$type_bar."' and hienthi=1";
			$sql.=$where." order by stt,ngaytao desc $limit";
			$d->query($sql);
			$product = $d->result_array();
			$url = getCurrentPageURL();
			$paging = pagination($where,$per_page,$page,$url);
		}
?>