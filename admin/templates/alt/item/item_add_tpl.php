
<script type="text/javascript">		

	$(document).ready(function() {
		$('.chonngonngu li a').click(function(event) {
			var lang = $(this).attr('href');
			$('.chonngonngu li a').removeClass('active');
			$(this).addClass('active');
			$('.lang_hidden').removeClass('active');
			$('.lang_'+lang).addClass('active');
			return false;
		});
	});

	function select_list()
	{
		var a=document.getElementById("id_list");
		window.location ="index.php?com=alt&act=<?php if($act=='edit_item') echo 'edit_item'; else echo 'add_item';?><?php if($id!='') echo"&id=".$id; ?>&id_list="+a.value;	
		return true;
	}	

	function select_cat()
	{
		var a=document.getElementById("id_list");
		var b=document.getElementById("id_cat");
		window.location ="index.php?com=alt&act=<?php if($act=='edit_item') echo 'edit_item'; else echo 'add_item';?><?php if($id!='') echo"&id=".$id; ?>&id_list="+a.value+"&id_cat="+b.value;	
		return true;
	}

</script>
<?php

  function get_main_list()
  {
   $title_list="tỉnh thành";
  	global $item,$type,$lang;
    $sql="select ten_$lang as ten,id from table_place_city order by id asc";
    $stmt=mysql_query($sql);
    $str='
      <select id="id_city" name="id_list" data-level="0" data-type="'.$type.'" data-table="table_place_dist" data-child="id_dist" class="main_select select_alt">
      <option value="">Chọn '.$title_list.'</option>';
    while ($row=@mysql_fetch_array($stmt)) 
    {
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
  	global $item,$lang,$type;
    $sql="select ten_$lang as ten,id from table_place_dist where id_list='".$item['id_list']."' order by stt asc";
    $stmt=mysql_query($sql);
    $str='
      <select id="id_dist" name="id_cat" data-level="1" data-type="'.$type.'" data-table="table_place_ward" data-child="id_cat" class="main_select select_alt">
      <option value="">Chọn quận huyện</option>';
    while ($row=@mysql_fetch_array($stmt)) 
    {
      if($row["id"]==(int)@$item["id_cat"])
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
        	<li><a href="index.php?com=alt&act=add_item<?php if($type!='') echo'&type='. $type;?>"><span>Thêm <?=$title_main?></span></a></li>
            <li class="current"><a href="#" onclick="return false;">Thêm</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>

<form name="supplier" id="validate" class="form" action="index.php?com=alt&act=save_item<?php if($type!='') echo'&type='. $type;?>" method="post" enctype="multipart/form-data">


<!--thong tin chung-->
<div class="widget">
	<div class="formRow">
		<label>Chọn tỉnh thành </label>
		<div class="formRight">
		<?=get_main_list()?>
		</div>
		<div class="clear"></div>
	</div>	
	<div class="formRow">
		<label>Chọn quận huyện</label>
		<div class="formRight">
		<?=get_main_cat()?>
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
	<div class="title chonngonngu">
		<ul>
			<li><a class="active tipS validate[required]" title="Chọn tiếng việt">Tiếng việt</a></li>
		</ul>
	</div>
<div>
	<div class="title"><img src="./images/icons/dark/record.png" alt="" class="titleIcon" />
		<h6>Nội dung</h6>
	</div>
	
        <div class="formRow">
			<label>Tiêu đề </label>
			<div class="formRight">
                <input type="text" name="ten" title="Nhập tên" id="ten" class="tipS validate[required]" value="<?=@$item['ten']?>" />
			</div>
			<div class="clear"></div>
		</div>
		

</div><!--lang-->


</div><!--end phan ngon ngu-->  

	<div class="widget">
<div class="formRow">
			<div class="formRight">
                <input type="hidden" name="type" id="id_this_type" value="<?=$type?>" />
                <input type="hidden" name="id" id="id_this_post" value="<?=@$item['id']?>" />
            	<input type="submit" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
            	<a href="index.php?com=alt&act=man_item<?php if($type!='') echo'&type='. $type;?>" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
			</div>
			<div class="clear"></div>
		</div>
</div><!--end widget-->
</form>        </div>
