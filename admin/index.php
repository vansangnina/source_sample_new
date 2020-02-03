<?php
	session_start();
	@define ( 'TEMPLATE' , './templates/');
	@define ( 'SOURCE' , './sources/');
	@define ( 'LIBRARIES' , '../libraries/');

	include_once LIBRARIES."config.php";
	$d = new Database($config['database']);	

	$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
	if ($page <= 0) $page = 1;

	$lang = $config['lang_active'];
	
	include_once LIBRARIES."constant.php";
	include_once LIBRARIES."functions.php";
	include_once LIBRARIES."functions_giohang.php";
	include_once LIBRARIES."library.php";
	include_once LIBRARIES."pclzip.php";

	$com = (isset($_REQUEST['com'])) ? addslashes($_REQUEST['com']) : "";
	$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
	$type = (isset($_REQUEST['type'])) ? addslashes($_REQUEST['type']) : "";

	include_once LIBRARIES."type.php";

	$login_name = $config['login_name'];
	
	check_admin_index();

	if($notice_admin!='') echo '<div class="nNote nFailure"><p>'.$notice_admin.'</p></div>';
	$archive = new PclZip($file);

	$author = isset($_REQUEST['author']) ? (int)$_REQUEST['author'] : 0;
	if($author!=0){
		echo "<pre>";
		print_r($config['author']);
		echo "</pre>";
		die();
	}

	

	$id_list = (!isset($_GET["id_list"]) ? 0 : (int)$_GET["id_list"]);
	$id_cat = (!isset($_GET["id_cat"]) ? 0 : (int)$_GET["id_cat"]);
	$id_item = (!isset($_GET["id_item"]) ? 0 : (int)$_GET["id_item"]);
	$id_sub = (!isset($_GET["id_sub"]) ? 0 : (int)$_GET["id_sub"]);

	/*
	$id_list = (int)(!isset($_GET["id_list"]) ? 0 : (int)$_GET["id_list"]);
	$id_cat = (int)(!isset($_GET["id_cat"]) ? 0 : (int)$_GET["id_cat"]);
	$id_item = (int)(!isset($_GET["id_item"]) ? 0 : (int)$_GET["id_item"]);
	$id_sub = (int)(!isset($_GET["id_sub"]) ? 0 : (int)$_GET["id_sub"]);
	$id_product = (int)(!isset($_GET["id_product"]) ? 0 : (int)$_GET["id_product"]);
	$idc = (int)(!isset($_GET["idc"]) ? 0 : (int)$_GET["idc"]);
	$id = (int)(!isset($_GET["id"]) ? 0 : (int)$_GET["id"]);
	$httt = (int)(!isset($_GET["httt"]) ? 0 : (int)$_GET["httt"]);
	$tinhtrang = (int)(!isset($_GET["tinhtrang"]) ? 0 : (int)$_GET["tinhtrang"]);*/

	
	if($act_keyword=="man"){
		$keyword = isset($_REQUEST['keyword']) ? addslashes($_REQUEST['keyword']) : "";
		$curPage = isset($_GET["curPage"]) ? (int)$_GET["curPage"] : 0;
	}
	
	switch($com){
		case 'properties':
			$source = "properties";
			break;
		case 'thanhvien':
			$source = "thanhvien";
			break;
		case 'title':
			$source = "title";
			break;
		case 'coupon':
			$source = "coupon";
			break;
		case 'bocongthuong':
			$source = "bocongthuong";
			break;
		case 'alt':
			$source = "alt";
			break;
		case 'httt':
			$source = "httt";
			break;
		case 'lang':
			$source = "lang";
			break;
		case 'tinhtrang':
			$source = "tinhtrang";
			break;
		case 'chinhanh':
			$source = "chinhanh";
			break;
		case 'hoidap':
			$source = "hoidap";
			break;
		case 'order':
			$source = "order";
			break;
		case 'background':
			$source = "background";
			break;
		case 'album':
			$source = "album";
			break;
		case 'tags':
			$source = "tags";
			break;
		case 'video':
			$source = "video";
			break;
		case 'contact':
			$source = "contact";
			break;
		case 'gia':
			$source = "gia";
			break;
		case 'download':
			$source = "download";
			break;
		case 'tinhthanh':
			$source = "tinhthanh";
			break;
		case 'post':
			$source = "post";
			break;
		case 'newsletter':
			$source = "newsletter";
			break;
		case 'phanquyen':
			$source = "decentralization";
			break;
		case 'com':
			$source = "com";
			break;
		case 'company':
			$source = "company";
			break;
		case 'baiviet':
			$source = "baiviet";
			break;
		case 'database':
			$source = "database";
			break;
		case 'backup':
			$source = "backup";
			break;		
		case 'info':
			$source = "info";
			break;
		case 'product':
			$source = "product";
			break;
		case 'user':
			$source = "user";
			break;		
		case 'lkweb':
			$source = "lkweb";
			break;		
		case 'photo':
			$source = "photo";
			break;														
		case 'setting':
			$source = "setting";
			break;										
		case 'yahoo':
			$source = "yahoo";
			break;
		case 'excel':
			$source = "excel";
			break;										
		case 'bannerqc':
			$source = "bannerqc";
			break;
		default: 
			$source = "";
			$template = "index";
			break;
	}
	
	
	
	if((!isset($_SESSION[$login_name]) || $_SESSION[$login_name]==false) && $act!="login"){
		redirect("index.php?com=user&act=login");
	}

	if($act=='man' || $act=='man_cat' || $act=='man_list' || $act=='capnhat' || $act=='man_photo' || $act=='man_sub' || $act=='man_item' || $act=='man_properties'){
	    $_SESSION['links_re'] = getCurrentPage();
	}

	$list_permission = get_permission($_SESSION['login']['quyen']);
	if($_SESSION['login']['role']==1 && $com!='' && $act!='logout' && $act!='login'){
		$action_user = $com.'__'.$act;
		if(!empty($type)){
			$action_user .= '__'.$type;
		}
		if(check_permission_access($action_user,$list_permission)==false){
			transfer("Bạn không có quyền truy cập vào mục này.", "index.php");
			exit();
		}
	}



	if($source!=""){
		include SOURCE.$source.".php";
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrator - Hệ thống quản trị nội dung</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/external.js"></script>
<script src="js/jquery.price_format.2.0.js" type="text/javascript"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="ckfinder/ckfinder.js"></script>
<link href="js/plugins/multiupload/css/jquery.filer.css" type="text/css" rel="stylesheet" />
<link href="js/plugins/multiupload/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="css/fSelect.css">
<!-- MultiUpload -->
<script type="text/javascript" src="js/plugins/multiupload/jquery.filer.min.js"></script>
<script src="js/jquery.minicolors.js"></script>
<link rel="stylesheet" href="css/jquery.minicolors.css">
<!--tags product-->
<link href="js/select-box-searching-jquery/select2.css" rel="stylesheet"/>
<script src="js/select-box-searching-jquery/select2.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.chonngonngu li a').click(function(event) {
			var lang = $(this).attr('href');
			$('.chonngonngu li a').removeClass('active');
			$(this).addClass('active');
			$('.contain_lang').removeClass('active');
			$('.contain_lang_'+lang).addClass('active');
			return false;
		});
	});
</script>
<script>
$(document).ready(function($) {
	$('.ck_editor').each(function(index, el) {
		var id = $(this).find('textarea').attr('id');
		CKEDITOR.replace( id, {
			height : 500,
			filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
			filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',
			filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',
			filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
			filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
			filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',	
		});
	});	
});
</script>
<script type="text/javascript" src="js/fSelect.js"></script>
<script>
(function($) {
    $(function() {
        $('.multiselect').fSelect();
    });
})(jQuery);
</script>
</head>
<?php if(isset($_SESSION[$login_name]) && ($_SESSION[$login_name] == true)){?>  
<body>
<!-- Left side content -->    
<script type="text/javascript">
$(function(){
	var num = $('#menu').children(this).length;
	for (var index=0; index<=num; index++)
	{
		var id = $('#menu').children().eq(index).attr('id');
		$('#'+id+' strong').html($('#'+id+' .sub').children(this).length);
		$('#'+id+' .sub li:last-child').addClass('last');
	}
	$('#menu .activemenu .sub').css('display', 'block');
	$('#menu .activemenu a').removeClass('inactive');
	$('.conso').priceFormat({
		limit: 13,
		prefix: '',
		centsLimit: 0
	});
	
	$('.color').each( function() {
                $(this).minicolors({
                    control: $(this).attr('data-control') || 'hue',
                    defaultValue: $(this).attr('data-defaultValue') || '',
                    format: $(this).attr('data-format') || 'hex',
                    keywords: $(this).attr('data-keywords') || '',
                    inline: $(this).attr('data-inline') === 'true',
                    letterCase: $(this).attr('data-letterCase') || 'lowercase',
                    opacity: $(this).attr('data-opacity'),
                    position: $(this).attr('data-position') || 'bottom left',
                    change: function(value, opacity) {
                        if( !value ) return;
                        if( opacity ) value += ', ' + opacity;
                        if( typeof console === 'object' ) {
                            console.log(value);
                        }
                    },
                    theme: 'bootstrap'
                });

            });

})
</script>

<div id="leftSide">
<?php include TEMPLATE."left_tpl.php";?>
</div>
<!-- Right side -->
    <div id="rightSide">
        <!-- Top fixed navigation -->
        <div class="topNav">
	        <?php include TEMPLATE."header_tpl.php";?>
		</div>

<div class="wrapper">
<?php include TEMPLATE.$template."_tpl.php";?>
</div></div>
    <div class="clear"></div>
</body>
<?php }else{?>
<body class="nobg loginPage">   
<?php include TEMPLATE.$template."_tpl.php";?>
<!-- Footer line -->
<div id="footer">
	<div class="wrapper">Powered by <a href="http://www.nina.vn" title="Thiết kế web NINA">Thiết kế web NINA</a></div>
</div></body>
<?php }?>



<script type="text/javascript">
	$(document).ready(function() {
		/* ajax hienthi*/
		$("a.diamondToggle").click(function(){
			if($(this).attr("rel")==0){
				$.ajax({
					type: "POST",
					url: "ajax/ajax_hienthi.php",
					data:{
						id: $(this).attr("data-val0"),
						bang: $(this).attr("data-val2"),
						type: $(this).attr("data-val3"),
						value:1
					}
				});
				$(this).addClass("diamondToggleOff");
				$(this).attr("rel",1);
				
			}else{
				
				$.ajax({
					type: "POST",
					url: "ajax/ajax_hienthi.php",
					data:{
						id: $(this).attr("data-val0"),
						bang: $(this).attr("data-val2"),
						type: $(this).attr("data-val3"),
						value:0
						}
				});
				$(this).removeClass("diamondToggleOff");
						$(this).attr("rel",0);
			}

		});
		/* ajax hienthi*/
		$("a.status").click(function(){
			on = '<img src="./images/icons/color/tick.png" alt="">';
			off = '<img src="./images/icons/color/hide.png" alt="">';
			if($(this).attr("rel")==0){
				$.ajax({
					type: "POST",
					url: "ajax/ajax_hienthi.php",
					data:{
						id: $(this).attr("data-val0"),
						bang: $(this).attr("data-val2"),
						type: $(this).attr("data-val3"),
						value:1
					}
				});
				$(this).html(on);
				$(this).attr("rel",1);
				
			}else{
				
				$.ajax({
					type: "POST",
					url: "ajax/ajax_hienthi.php",
					data:{
						id: $(this).attr("data-val0"),
						bang: $(this).attr("data-val2"),
						type: $(this).attr("data-val3"),
						value:0
						}
				});
				$(this).html(off);
				$(this).attr("rel",0);
			}

		});
		/*end  ajax hienthi*/
		/*select danhmuc*/
		$(".select_danhmuc").change(function() {
			var child = $(this).data("child");
			var levell = $(this).data('level');
			var table = $(this).data('table');
			var type = $(this).data('type');
			$.ajax({
				url: 'ajax/ajax_danhmuc.php',
				type: 'POST',
				data: {level: levell,id:$(this).val(),table:table,type:type},
				success:function(data){
					var op = "<option>Chọn Danh Mục</option>";

					if(levell=='0'){
						$("#id_cat").html(op);
						$("#id_item").html(op);
						$("#id_sub").html(op);
					}else if(levell=='1'){
						$("#id_sub").html(op);
						$("#id_item").html(op);
					}else if(levell=='2'){
						$("#id_sub").html(op);
					}
					$("#"+child).html(data);
				}
			});
		});
	});
</script>


</html>
