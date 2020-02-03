<?php	
	$act_type = explode('_',$act);
	$act_keyword = $act_type[0];
	if(count($act_type>1)){
		$act_type = $act_type[1];
	} else {
		$act_type = $act_type[0];
	}
	switch($type){
		//-------------product------------------
		case 'product':
			switch($act_type){
				case 'list':
					$title_main = "Danh mục cấp 1";
					$config_images = "true";
					$config_des= "false";
					$config_content= "false";
					$config_highlights= "true";
					$config_slider="false";
					@define ( WIDTH_THUMB , 200 );
					@define ( HEIGHT_THUMB ,200 );
					@define ( WIDTH_THUMB_QC , 200 );
					@define ( HEIGHT_THUMB_QC ,200 );
					@define ( STYLE_THUMB , 1 );
					$ratio_ = 1;
					break;
				case 'cat':
					$title_main = "Danh mục cấp 2";
					$config_images = "true";
					$config_des= "false";
					$config_content= "false";
					$config_highlights = "false";
					@define ( WIDTH_THUMB , 200 );
					@define ( HEIGHT_THUMB , 200 );
					@define ( STYLE_THUMB , 1 );
					$ratio_ = 1;
					break;
				case 'item':
					$title_main = "Danh mục cấp 3";
					$config_images = "false";
					$config_des= "false";
					$config_content= "false";
					@define ( WIDTH_THUMB , 555 );
					@define ( HEIGHT_THUMB , 232 );
					@define ( STYLE_THUMB , 1 );
					$ratio_ = 1;
					break;

				case 'sub':
					$title_main = "Danh mục cấp 4";
					$config_images = "false";
					$config_des= "false";
					$config_content= "false";
					@define ( WIDTH_THUMB , 555 );
					@define ( HEIGHT_THUMB , 232 );
					@define ( STYLE_THUMB , 1 );
					$ratio_ = 1;
					break;
				
				default:
					$title_main = "Sản Phẩm";
					$config_images = "true";
					$config_des= "true";
					$config_properties = "true";
					$config_selling = "false";
					$config_new = "false";
					$config_sale = "false";
					$config_tags = "true";
					$config_list = "true";
					$config_cat = "true";
					$config_item = "false";
					$config_sub = "false";
					@define ( WIDTH_THUMB , 280 );
					@define ( HEIGHT_THUMB , 260 );
					@define ( STYLE_THUMB , 1 );
					$ratio_ = 3;
					break;
				}
				@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			break;
		case 'properties':
			switch($act){
				case 'list':
					$title_main = "danh mục thuộc tính";
					$config_images = "false";
					$config_phiship = "true";
					$config_des= "false";
					$config_content= "false";
					$config_highlights= "false";
					@define ( WIDTH_THUMB , 40 );
					@define ( HEIGHT_THUMB , 37 );
					@define ( STYLE_THUMB , 1 );
					$ratio_ = 2;
					break;
				default:
					$title_main = "thuộc tính";
					$config_images = "true";
					$config_des= "false";
					$config_list = "true";
					@define ( WIDTH_THUMB , 290 );
					@define ( HEIGHT_THUMB , 290 );
					@define ( STYLE_THUMB , 1 );
					$ratio_ = 3;
					break;
				}
				@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			break;
		
		case 'tintuc':
			$title_main = "Tin tức";
			$config_images = "true";
			$config_des= "true";
			$config_highlights = "true";
			$config_list = "false";
			$config_cat = "false";
			$config_item = "false";
			$config_sub = "false";
			@define ( WIDTH_THUMB , 290 );
			@define ( HEIGHT_THUMB , 290 );
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			$ratio_ = 2;
		break;


		case 'tuvan':
			$title_main = "tư vấn mua hàng";
			$config_images = "true";
			$config_des= "true";
			$config_highlights = "true";
			$config_list = "false";
			$config_cat = "false";
			$config_item = "false";
			$config_sub = "false";
			@define ( WIDTH_THUMB , 300 );
			@define ( HEIGHT_THUMB , 300 );
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			$ratio_ = 2;
			break;
		case 'dichvu':
			$title_main = "Dịch vụ";
			$config_images = "true";
			$config_des= "true";
			$config_highlights = "true";
			$config_list = "false";
			$config_cat = "false";
			$config_item = "false";
			$config_sub = "false";
			@define ( WIDTH_THUMB , 300 );
			@define ( HEIGHT_THUMB , 300 );
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			$ratio_ = 2;
			break;
		case 'chinhsach':
			$title_main = "Chính sách";
			$config_images = "true";
			$config_des= "true";
			$config_highlights = "true";
			$config_list = "false";
			$config_cat = "false";
			$config_item = "false";
			$config_sub = "false";
			@define ( WIDTH_THUMB , 290 );
			@define ( HEIGHT_THUMB , 290 );
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			$ratio_ = 2;
			break;
		case 'album':
			switch($act_type){
				case 'list':
					$title_main = "Danh mục cấp 1";
					$config_images = "true";
					$config_des= "false";
					$config_content= "false";
					$config_highlights= "true";
					@define ( WIDTH_THUMB , 200 );
					@define ( HEIGHT_THUMB ,200 );
					@define ( WIDTH_THUMB_QC , 200 );
					@define ( HEIGHT_THUMB_QC ,200 );
					@define ( STYLE_THUMB , 1 );
					$ratio_ = 1;
					break;
				default:
					$title_main = "thư viện ảnh";
					$config_images = "true";
					$config_des= "true";
					$config_highlights = "true";
					$config_list = "true";
					@define ( WIDTH_THUMB , 800 );
					@define ( HEIGHT_THUMB , 500 );
					@define ( STYLE_THUMB , 1 );
					$ratio_ = 1;
				break;
			}
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
		break;
		case 'video':
			$title_main = "Video clip";
			$config_images = "true";
			$config_des= "true";
			$config_highlights = "true";
			$config_list = "false";
			$config_cat = "false";
			$config_item = "false";
			$config_sub = "false";
			@define ( WIDTH_THUMB , 800 );
			@define ( HEIGHT_THUMB , 500 );
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			$ratio_ = 1;
		break;
		//-------------info------------------
		case 'gioithieu':
			$title_main = 'giới thiệu';
			$config_ten = 'true';
			$config_des = 'false';
			$config_images = 'false';
			@define ( WIDTH_THUMB , 580 );
			@define ( HEIGHT_THUMB , 370 );
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			break;
		
		case 'lienhe':
			$title_main = 'Liên hệ';
			$config_ten = 'true';
			break;

		
		case 'bgemail':
			$title_main = 'Background đăng ký nhận tin';
			$config_multi_lang = "false";
			@define ( WIDTH_THUMB , 1366 );
			@define ( HEIGHT_THUMB , 260);
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF|swf' );
			$ratio_ = 1;
			break;
		case 'bgfooter':
			$title_main = 'Background footer';
			$config_multi_lang = "false";
			@define ( WIDTH_THUMB , 1366 );
			@define ( HEIGHT_THUMB , 648);
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF|swf' );
			$ratio_ = 1;
			break;
		case 'banner':
			$title_main = 'Banner';
			$config_multi_lang = "true";
			@define ( WIDTH_THUMB , 668 );
			@define ( HEIGHT_THUMB , 143 );
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF|swf' );
			$ratio_ = 1;
			break;
		case 'bgbanner':
			$title_main = 'Background banner';
			$config_multi_lang = "false";
			$links_ = "false";
			$config_hienthi = "true";
			@define ( WIDTH_THUMB , 1366);
			@define ( HEIGHT_THUMB , 110 );
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF|swf' );
			$ratio_ = 1;
			break;
		case 'bocongthuong':
			$title_main = 'Logo bộ công thương';
			$config_multi_lang = "false";
			$links_ = "true";
			$config_hienthi = "true";
			@define ( WIDTH_THUMB , 141 );
			@define ( HEIGHT_THUMB , 52 );
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			$ratio_ = 1;
			break;
		case 'logo':
			$title_main = 'Logo';
			$config_multi_lang = "true";
			@define ( WIDTH_THUMB , 279 );
			@define ( HEIGHT_THUMB ,137);
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			$ratio_ = 1;
			break;
		case 'popup':
			$title_main = 'Popup';
			$config_multi_lang = "false";
			$links_ = 'true';
			$config_hienthi = 'true';
			@define ( WIDTH_THUMB , 900 );
			@define ( HEIGHT_THUMB , 500 );
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			$ratio_ = 1;
			break;

		

		case 'favicon':
			$title_main = 'Favicon';
			$config_multi_lang = "false";
			@define ( WIDTH_THUMB , 40 );
			@define ( HEIGHT_THUMB , 40 );
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			$ratio_ = 1;
			break;

		case 'bgweb':
			$title_main = 'background web';
			@define ( WIDTH_THUMB , 500 );
			@define ( HEIGHT_THUMB , 120 );
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			$ratio_ = 1;
			break;
		//-------------photo------------------
		case 'slider':
			$title_main = "Hình ảnh slider";
			$config_multi_lang = "false";
			$config_list = "false";
			$config_des = "true";
			@define ( WIDTH_THUMB ,1366);
			@define ( HEIGHT_THUMB ,456);
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			$ratio_ = 1;
			$links_ = "true";
			break;

		case 'partner':
		    $title_main = "Đối tác";
		    $config_multi_lang = "false";
			@define ( WIDTH_THUMB , 460 );
			@define ( HEIGHT_THUMB , 330 );
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			$ratio_ = 2;
			$links_ = "true";
			break;

		case 'quangcao':
		    $title_main = "Quảng cáo";
		    $config_multi_lang = "true";
			@define ( WIDTH_THUMB , 587 );
			@define ( HEIGHT_THUMB ,225 );
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			$ratio_ = 1;
			$links_ = "true";
			break;
		
		#lkweb
		case 'mxh':
		    $title_main = "Mạng xã hội";
		    $config_link = "true";
		    $config_images= "true";
			$config_ngonngu= "false";
			@define ( WIDTH_THUMB , 27 );
			@define ( HEIGHT_THUMB , 27 );
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			$ratio_ = 1;
			break;
		case 'tailieu':
			$title_main = 'Quản lý tài liệu';
			$config_link = "false";
			$config_list = "true";
			$config_img = "true";
			@define ( WIDTH_THUMB , 27 );
			@define ( HEIGHT_THUMB , 27 );
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			$ratio_ = 1;
			break;
		case 'color':
			$title_main = 'màu';
			$config_link = "false";
		    $config_images= "false";
		    @define ( WIDTH_THUMB , 27 );
			@define ( HEIGHT_THUMB , 27 );
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			$ratio_ = 1;
			break;
		case 'size':
			$title_main = 'size';
			$config_link = "false";
		    $config_images= "false";
		    @define ( WIDTH_THUMB , 27 );
			@define ( HEIGHT_THUMB , 27 );
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			$ratio_ = 1;
			break;
		case 'tags':
			$title_main = 'Tags Seo';
			$config_link = "false";
		    $config_images= "false";
		    @define ( WIDTH_THUMB , 27 );
			@define ( HEIGHT_THUMB , 27 );
			@define ( STYLE_THUMB , 1 );
			@define ( IMG_TYPE , 'jpg|gif|png|jpeg|PNG|JPG|JPEG|GIF' );
			$ratio_ = 1;
			break;
		case 'lang':
			$title_main = 'Define ngôn ngữ';
			$config_multi_lang = "true";
			break;
		case 'title':
			$title_main = 'Quản lý title,keywords,description';
			$config_developer = "true";
			$config_delete = "true";
			break;
		//--------------defaut---------------
		default: 
			$source = "";
			$template = "index";
			break;
	}

?>