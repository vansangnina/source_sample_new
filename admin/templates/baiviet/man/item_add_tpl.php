
<script type="text/javascript">		

	$(document).ready(function() {
		$('.update_stt').keyup(function(event) {
			var id = $(this).attr('rel');
			var table = 'baiviet_photo';
			var value = $(this).val();
			$.ajax ({
				type: "POST",
				url: "ajax/update_stt.php",
				data: {id:id,table:table,value:value},
				success: function(result) {
				}
			});
		});

		$('.delete_images').click(function(){
	      if (confirm('Bạn có muốn xóa hình này ko ? ')) {
	        var id = $(this).attr('title');
			var table = 'baiviet_photo';
			var links = "<?=UPLOAD_POST;?>";
	        $.ajax ({
	          type: "POST",
	          url: "ajax/delete_images.php",
	          data: {id:id,table:table,links:links},
	          success: function(result) { 
	          }
	        });
	        $(this).parent().slideUp();
	      }
	      return false;
	    });

	    $('.themmoi').click(function(e) {
			$.ajax ({
				type: "POST",
				url: "ajax/khuyenmai.php",
				success: function(result) { 
					$('.load_sp').append(result);
				}
			});
        });

		$('.delete').click(function(e) {
			$(this).parent().remove();
		});
		

	});
	
</script>
<?php

 function get_main_list()
  {
  	global $d,$item,$type,$lang;
    $sql="select ten_$lang as ten,id from table_baiviet_list where type='".$type."' order by stt asc";
    $d->query($sql);
    $result = $d->result_array();
    $str='
      <select id="id_list" name="id_list" data-level="0" data-type="'.$type.'" data-table="table_baiviet_cat" data-child="id_cat" class="main_select select_danhmuc">
      <option value="">Chọn danh mục 1</option>';
    foreach ($result as $key => $row) {
      if($row["id"]==(int)@$item["id_list"])
        $selected="selected";
      else 
        $selected="";
      $str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten"].'</option>'; 
    }
    $str.='</select>';
    return $str;
  }

  function get_main_cat()
  {
  	global $d,$item,$type,$lang;
    $sql="select ten_$lang as ten,id from table_baiviet_cat where id_list='".$item['id_list']."' and type='".$type."' order by stt asc";
    $d->query($sql);
    $result = $d->result_array();
    $str='
      <select id="id_cat" name="id_cat" data-level="1" data-type="'.$type.'" data-table="table_baiviet_item" data-child="id_item" class="main_select select_danhmuc">
      <option value="">Chọn danh mục 2</option>';
    foreach ($result as $key => $row) { 
      if($row["id"]==(int)@$item["id_cat"])
        $selected="selected";
      else 
        $selected="";
      $str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten"].'</option>';
    }
    $str.='</select>';
    return $str;
  }

  function get_main_item()
  {
  	global $d,$item,$type,$lang;
    $sql="select ten_$lang as ten,id from table_baiviet_item where id_cat='".$item['id_cat']."' and type='".$type."' order by stt asc";
    $d->query($sql);
    $result = $d->result_array();
    $str='
      <select id="id_item" name="id_item" data-level="2" data-type="'.$type.'" data-table="table_baiviet_sub" data-child="id_sub" class="main_select select_danhmuc">
      <option value="">Chọn danh mục 3</option>';
    foreach ($result as $key => $row) {
      if($row["id"]==(int)@$item["id_item"])
        $selected="selected";
      else 
        $selected="";
      $str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten"].'</option>';
    }
    $str.='</select>';
    return $str;
  }
function get_main_sub()
  {
  	global $d,$item,$type,$lang;
    $sql="select ten_$lang as ten,id from table_baiviet_sub where id_item='".$item['id_item']."' and type='".$type."' order by stt asc";
    $d->query($sql);
    $result = $d->result_array();
    $str='
      <select id="id_sub" name="id_sub" class="main_select">
      <option value="">Chọn danh mục 3</option>';
    foreach ($result as $key => $row) {
      if($row["id"]==(int)@$item["id_sub"])
        $selected="selected";
      else 
        $selected="";
      $str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten"].'</option>';
    }
    $str.='</select>';
    return $str;
  }


?>

<div class="wrapper">

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="index.php?com=baiviet&act=add_list<?php if($type!='') echo'&type='. $type;?>"><span>Thêm <?=$title_main?></span></a></li>
            <li class="current"><a href="#" onclick="return false;">Thêm</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>

<form name="supplier" id="validate" class="form" action="index.php?com=baiviet&act=save<?php if($type!='') echo'&type='. $type;?>" method="post" enctype="multipart/form-data">

<!--thong tin chung-->
<div class="widget">

	<?php if($config_list=='true'){ ?>
	<div class="formRow">
		<label>Chọn danh mục 1</label>
		<div class="formRight">
		<?=get_main_list()?>
		</div>
		<div class="clear"></div>
	</div><!--cap 1-->
	<?php } ?>
	<?php if($config_cat=='true'){ ?>
	<div class="formRow">
		<label>Chọn danh mục 2</label>
		<div class="formRight">
		<?=get_main_cat()?>
		</div>
		<div class="clear"></div>
	</div><!--cap 2-->
	<?php } ?>
	<?php if($config_item=='true'){ ?>
    <div class="formRow">
		<label>Chọn danh mục 3</label>
		<div class="formRight">
		<?=get_main_item()?>
		</div>
		<div class="clear"></div>
	</div><!--cap 3-->
	<?php } ?>
	<?php if($config_sub=='true'){ ?>
	<div class="formRow">
		<label>Chọn danh mục 4</label>
		<div class="formRight">
		<?=get_main_sub()?>
		</div>
		<div class="clear"></div>
	</div><!--cap 4-->
	<?php } ?>
	
	<?php if($config_images=='true'){?>
	<div class="formRow">
		<label>Tải hình ảnh:</label>
		<div class="formRight">
        	<input type="file" id="file" name="file" />
			<img src="./images/question-button.png" alt="Upload hình" class="icon_question tipS" original-title="Tải hình ảnh (ảnh JPEG, GIF , JPG , PNG)">
			<div class="note"> width : <?php echo WIDTH_THUMB*$ratio_;?> px , Height : <?php echo HEIGHT_THUMB*$ratio_;?> px </div>
		</div>
		<div class="clear"></div>
	</div>
    <?php if($act=='edit'){?>
	<div class="formRow">
		<label>Hình Hiện Tại :</label>
		<div class="formRight">
		
		<div class="mt10"><img src="<?=UPLOAD_POST.$item['thumb']?>"  alt="NO PHOTO" width="100" /></div>
		</div>
		<div class="clear"></div>
	</div>
	<?php } } ?>
    <?php if($config_img=='true'){ ?>
    <div class="formRow">
  <label>Hình ảnh kèm theo: </label>
  <div class="formRight">
      <a class="file_input" data-jfiler-name="files" data-jfiler-extensions="jpg, jpeg, png, gif"><img src="images/image_add.png" alt="" width="100"></a>                
     
 
<?php if($act=='edit'){?>
  <?php if(count($ds_photo)!=0){?>       
        <?php for($i=0;$i<count($ds_photo);$i++){?>
          <div class="item_trich">
              <img class="img_trich" width="140px" height="110px" src="<?=UPLOAD_POST.$ds_photo[$i]['photo']?>" />
              <input type="text" rel="<?=$ds_photo[$i]['id']?>" value="<?=$ds_photo[$i]['stt']?>" class="update_stt tipS" />
              <a class="delete_images" title="<?=$ds_photo[$i]['id']?>"><img src="images/delete.png"></a>
          </div>
        <?php } ?>
    
  <?php }?>

<?php }?>
  </div>
      <div class="clear"></div>
    </div> 
    <?php } ?>


    <div class="formRow">
      <label>Hiển thị : <img src="./images/question-button.png" alt="Chọn loại" class="icon_que tipS" original-title="Bỏ chọn để không hiển thị danh mục này ! "> </label>
      <div class="formRight">
     
        <input type="checkbox" name="hienthi" id="check1" value="1" <?=(!isset($item['hienthi']) || $item['hienthi']==1)?'checked="checked"':''?> />
         <label>Số thứ tự: </label>
          <input type="text" class="tipS" value="<?=isset($item['stt'])?$item['stt']:1?>" name="stt" style="width:20px; text-align:center;" onkeypress="return OnlyNumber(event)" original-title="Số thứ tự của danh mục, chỉ nhập số">
      </div>
      <div class="clear"></div>
    </div>
	   
</div>  
<!--end thong tin chung-->

<!--phan ngon ngu-->
<div class="widget">
<?php
 if(count($config['lang'])>1) {?>
	<div class="title chonngonngu">
		<ul>
		<?php foreach ($config['lang'] as $key => $value) { ?>
			<li><a href="<?=$key?>" class="<?=$key==$config['lang_active']?'active':''?> tipS validate[required]" title="Chọn <?=$value?>"><?=$value?></a></li>
		<?php } ?>
		</ul>
	</div>
<?php } ?>

<?php foreach ($config['lang'] as $key => $value) { ?>
<div class="contain_lang_<?=$key?> contain_lang <?=$key==$config['lang_active']?'active':''?>">
	<div class="title"><img src="./images/icons/dark/record.png" alt="" class="titleIcon" />
		<h6>Nội dung <?=$value?></h6>
	</div>
	
        <div class="formRow">
			<label>Tiêu đề <?=$key!=$config['lang_active']?'('.$key.')':''?></label>
			<div class="formRight">
                <input type="text" name="data[ten_<?=$key?>]" title="Nhập tên danh mục" id="ten_<?=$key?>" class="tipS validate[required]" value="<?=@$item['ten_'.$key]?>" />
			</div>
			<div class="clear"></div>
		</div>
		
<?php if($config_mota=='true'){ ?>
		<div class="formRow">
			<label>Mô tả <?=$key!=$config['lang_active']?'('.$key.')':''?></label>
			<div class="formRight">
                <textarea rows="4" cols="" title="Nhập mô tả . " class="tipS" name="data[mota_<?=$key?>]"><?=@$item['mota_'.$key]?></textarea>
			</div>
			<div class="clear"></div>
		</div>

		
<?php } ?>

		<div class="formRow">
			<label>Nội Dung <?=$key!=$config['lang_active']?'('.$key.')':''?></label>
			<div class="ck_editor">
                <textarea id="noidung_<?=$key?>" name="data[noidung_<?=$key?>]"><?=@$item['noidung_'.$key]?></textarea>
			</div>
			<div class="clear"></div>
		</div>
</div><!--lang-->
<?php } ?>
</div>
<!--end phan ngon ngu-->

<!--seo-->
	<div class="widget">
		<div class="title"><img src="./images/icons/dark/record.png" alt="" class="titleIcon" />
			<h6>Nội dung seo</h6>
		</div>
		
		<div class="formRow">
			<label>Title</label>
			<div class="formRight">
				<input type="text" value="<?=@$item['title']?>" name="title" title="Nội dung thẻ meta Title dùng để SEO" class="tipS" />
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="formRow">
			<label>Từ khóa</label>
			<div class="formRight">
				<input type="text" value="<?=@$item['keywords']?>" name="keywords" title="Từ khóa chính cho danh mục" class="tipS" />
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="formRow">
			<label>Description:</label>
			<div class="formRight">
				<textarea rows="4" cols="" title="Nội dung thẻ meta Description dùng để SEO" class="tipS" name="description"><?=@$item['description']?></textarea>
                <input readonly="readonly" type="text" style="width:25px; margin-top:10px; text-align:center;" name="des_char" value="<?=@$item['des_char']?>" /> ký tự <b>(Tốt nhất là 68 - 170 ký tự)</b>
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="formRow">
			<div class="formRight">
                <input type="hidden" name="type" id="id_this_type" value="<?=$type?>" />
                <input type="hidden" name="id" id="id_this_post" value="<?=@$item['id']?>" />
            	<input type="submit" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
            	<a href="index.php?com=baiviet&act=man<?php if($type!='') echo'&type='. $type;?>" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
			</div>
			<div class="clear"></div>
		</div>

	</div>
</form>        
</div>
<!--end seo-->


<script>
  $(document).ready(function() {
    $('.file_input').filer({
            showThumbs: true,
            templates: {
                box: '<ul class="jFiler-item-list"></ul>',
                item: '<li class="jFiler-item">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-info">\
                                            <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                        </div>\
                                        {{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left">\
                                            <li><span class="jFiler-item-others">{{fi-icon}} {{fi-size2}}</span></li>\
                                        </ul>\
                                        <ul class="list-inline pull-right">\
                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                    </div>\<input type="text" name="stthinh[]" class="stthinh" placeholder="Nhập STT" />\
                                </div>\
                            </div>\
                        </li>',
                itemAppend: '<li class="jFiler-item">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-info">\
                                            <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                        </div>\
                                        {{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left">\
                                            <span class="jFiler-item-others">{{fi-icon}} {{fi-size2}}</span>\
                                        </ul>\
                                        <ul class="list-inline pull-right">\
                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                    </div>\<input type="text" name="stthinh[]" class="stthinh" placeholder="Nhập STT" />\
                                </div>\
                            </div>\
                        </li>',
                progressBar: '<div class="bar"></div>',
                itemAppendToEnd: true,
                removeConfirmation: true,
                _selectors: {
                    list: '.jFiler-item-list',
                    item: '.jFiler-item',
                    progressBar: '.bar',
                    remove: '.jFiler-item-trash-action',
                }
            },
            addMore: true
        });
  });
</script>
