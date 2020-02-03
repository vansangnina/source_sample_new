
<script type="text/javascript">		

	$(document).ready(function() {
		$('.update_stt').keyup(function(event) {
			var id = $(this).attr('rel');
			var table = 'chinhanh_photo';
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
			var table = 'chinhanh_photo';
			var links = "<?=UPLOAD_BRANCH;?>";
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

 function get_main_list(){
  	global $d,$item,$type;
    $sql="select * from table_place_city order by id asc";
    $d->query($sql);
    $result = $d->result_array();
    $str='
      <select id="id_city" name="id_list" data-level="0" data-type="'.$type.'" data-table="table_place_dist" data-child="id_dist" class="main_select select_danhmuc_alt">
      <option value="">Chọn tỉnh thành</option>';
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
  	global $d,$item,$type;
    $sql="select * from table_place_dist where id_list='".$item['id_list']."' order by stt asc";
    $d->query($sql);
    $result = $d->result_array();
    $str='
      <select id="id_dist" name="id_cat" data-level="1" data-type="'.$type.'" data-table="table_place_ward" data-child="id_cat" class="main_select select_danhmuc_alt">
      <option value="">Chọn quận huyện</option>';
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

  /*function get_main_item()
  {
  	global $item,$title_item;
    $sql="select * from table_place_ward where id_cat='".$item['id_cat']."' order by stt asc";
    $stmt=mysql_query($sql);
    $str='
      <select id="id_item" name="id_item" data-level="2" data-type="'.$type.'" data-table="table_chinhanh_sub" data-child="id_sub" class="main_select select_danhmuc">
      <option value="">Chọn '.$title_item.'</option>';
    while ($row=@mysql_fetch_array($stmt)) 
    {
      if($row["id"]==(int)@$item["id_item"])
        $selected="selected";
      else 
        $selected="";
      $str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten_vi"].'</option>';      
    }
    $str.='</select>';
    return $str;
  }
function get_main_sub()
  {
  	global $item,$title_sub;
    $sql="select * from table_chinhanh_sub where id_item='".$item['id_item']."' and type='".$type."' order by stt asc";
    $stmt=mysql_query($sql);
    $str='
      <select id="id_sub" name="id_sub" class="main_select">
      <option value="">Chọn '.$title_sub.'</option>';
    while ($row=@mysql_fetch_array($stmt)) 
    {
      if($row["id"]==(int)@$item["id_sub"])
        $selected="selected";
      else 
        $selected="";
      $str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten_vi"].'</option>';      
    }
    $str.='</select>';
    return $str;
  }*/


?>

<div class="wrapper">

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="index.php?com=chinhanh&act=add_list<?php if($type!='') echo'&type='. $type;?>"><span>Thêm <?=$title_main?></span></a></li>
            <li class="current"><a href="#" onclick="return false;">Thêm</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>

<form name="supplier" id="validate" class="form" action="index.php?com=chinhanh&act=save<?php if($type!='') echo'&type='. $type;?>" method="post" enctype="multipart/form-data">

<!--thong tin chung-->
<div class="widget">

	
	<div class="formRow">
		<label>Chọn tỉnh thành</label>
		<div class="formRight">
		<?=get_main_list()?>
		</div>
		<div class="clear"></div>
	</div><!--cap 1-->
	
	<div class="formRow">
		<label>Chọn quận huyện</label>
		<div class="formRight">
		<?=get_main_cat()?>
		</div>
		<div class="clear"></div>
	</div><!--cap 2-->
	
	
	
	
	
	 <div class="formRow">
			<label>Tên</label>
			<div class="formRight">
                <input type="text" name="ten" title="Nhập số điện thoại" id="ten" class="tipS validate[required]" value="<?=@$item['ten']?>" />
			</div>
			<div class="clear"></div>
		</div>
		
	


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
	<div class="formRow">
			<div class="formRight">
                
                <input type="hidden" name="id" id="id_this_post" value="<?=@$item['id']?>" />
            	<input type="submit" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
            	<a href="index.php?com=alt&act=man" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
			</div>
			<div class="clear"></div>
		</div>
</div>
</form>        
</div>
<!--end seo-->


