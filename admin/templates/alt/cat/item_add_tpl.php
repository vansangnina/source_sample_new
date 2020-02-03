
<script type="text/javascript">		
	function TreeFilterChanged2(){		
				$('#validate').submit();		
	}
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
</script>
<?php
  function get_main_list()
  {
  	global $title_list,$id_list,$lang;
    $sql="select ten_$lang as ten,id from table_place_city order by stt asc";
    $stmt=mysql_query($sql);
    $str='
      <select id="id_list" name="id_list" onchange="select_list()" class="main_select">
      <option value="">Chọn tỉnh thành</option>';
    while ($row=@mysql_fetch_array($stmt)) 
    {
      if($row["id"]==(int)@$id_list)
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
        	<li><a href="index.php?com=alt&act=man_cat&type=<?=$type?>"><span>Quận huyện</span></a></li>
          <li class="current"><a href="#" onclick="return false;">Thêm</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>

<form name="supplier" id="validate" class="form" action="index.php?com=alt&act=save_cat" method="post" enctype="multipart/form-data">

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


<div >
	<div class="title"><img src="./images/icons/dark/record.png" alt="" class="titleIcon" />
		<h6>Nội dung</h6>
	</div>
	
    <div class="formRow">
			<label>Tiêu đề </label>
			<div class="formRight">
          <input type="text" name="ten" title="Nhập tên " id="ten" class="tipS validate[required]" value="<?=@$item['ten']?>" />
			</div>
			<div class="clear"></div>
		</div>
		


</div><!--lang-->


</div><!--end phan ngon ngu-->  

<div class="widget">
<div class="formRow">
			<div class="formRight">
               
                <input type="hidden" name="id" id="id_this_post" value="<?=@$item['id']?>" />
            	<input type="submit" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
            	<a href="index.php?com=alt&act=man_list&type=<?=$type?>" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>

			</div>
			<div class="clear"></div>
		</div>
</div><!--end widget-->

</form>        </div>
