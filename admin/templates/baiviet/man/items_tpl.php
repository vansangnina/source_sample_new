<script type="text/javascript">
	$(document).ready(function() {
		$('.update_stt').keyup(function(event) {
			var id = $(this).attr('rel');
			var table = 'baiviet';
			var value = $(this).val();
			$.ajax ({
				type: "POST",
				url: "ajax/update_stt.php",
				data: {id:id,table:table,value:value},
				success: function(result) {
				}
			});
		});
		$('.timkiem button').click(function(event) {
			var keyword = $(this).parent().find('input').val();
			window.location.href="index.php?com=baiviet&act=man&type=<?=$type?>&keyword="+keyword;
		});
    $("#xoahet").click(function(){
      var listid="";
      $("input[name='chon']").each(function(){
        if (this.checked) listid = listid+","+this.value;
        })
      listid=listid.substr(1);   //alert(listid);
      if (listid=="") { alert("Bạn chưa chọn mục nào"); return false;}
      hoi= confirm("Bạn có chắc chắn muốn xóa?");
      if (hoi==true) document.location = "index.php?com=baiviet&act=delete&type=<?=$type?>&curPage=<?=$curPage?>&listid=" + listid;
    });
	});

  function select_list()
  {
    var a=document.getElementById("id_list");
    window.location ="index.php?com=baiviet&act=man&type=<?=$type?>&id_list="+a.value; 
    return true;
  }

  function select_cat()
  {
    var a=document.getElementById("id_list");
    var b=document.getElementById("id_cat");
    window.location ="index.php?com=baiviet&act=man&type=<?=$type?>&id_list="+a.value+"&id_cat="+b.value; 
    return true;
  }
   function select_item()
  {
    var a=document.getElementById("id_list");
    var b=document.getElementById("id_cat");
    var c=document.getElementById("id_item");
    window.location ="index.php?com=baiviet&act=man&type=<?=$type?>&id_list="+a.value+"&id_cat="+b.value+"&id_item="+c.value; 
    return true;
  }
  function select_sub()
  {
    var a=document.getElementById("id_list");
    var b=document.getElementById("id_cat");
    var c=document.getElementById("id_item");
    var d=document.getElementById("id_sub");
    window.location ="index.php?com=baiviet&act=man&type=<?=$type?>&id_list="+a.value+"&id_cat="+b.value+"&id_item="+c.value+"&id_sub="+d.value; 
    return true;
  }

</script>
<?php
  function get_main_list()
  {
    global $d,$id_list,$type,$lang;
    $sql="select ten_$lang as ten,id from table_baiviet_list where type='".$type."' order by stt asc";
    $d->query($sql);
    $result = $d->result_array();
    $str='
      <select id="id_list" name="id_list" onchange="select_list()" class="main_select">
      <option value="">Chọn danh mục 1</option>';
    foreach ($result as $key => $row) {
      if($row["id"]==(int)@$id_list)
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
    global $d,$type,$id_cat,$id_list,$lang;
    $sql="select ten_$lang as ten,id from table_baiviet_cat where id_list='".$id_list."' and type='".$type."' order by stt asc";
    $d->query($sql);
    $result = $d->result_array();
    $str='
      <select id="id_cat" name="id_cat" onchange="select_cat()" class="main_select">
      <option value="">Chọn danh mục 2</option>';
    foreach ($result as $key => $row) {
      if($row["id"]==(int)@$id_cat)
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
    global $d,$type,$id_cat,$id_item,$lang;
    $sql="select ten_$lang as ten,id from table_baiviet_item where id_cat='".$id_cat."' and type='".$type."' order by stt asc";
    $d->query($sql);
    $result = $d->result_array();
    $str='
      <select id="id_item" name="id_item" onchange="select_item()" class="main_select">
      <option value="">Chọn danh mục 3</option>';
    foreach ($result as $key => $row) {
      if($row["id"]==(int)@$id_item)
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
    global $d,$type,$id_item,$id_sub,$lang;
    $sql="select ten_$lang as ten,id from table_baiviet_sub where id_item='".$id_item."' and type='".$type."' order by stt asc";
    $d->query($sql);
    $result = $d->result_array();
    $str='
      <select id="id_sub" name="id_sub" onchange="select_sub()" class="main_select">
      <option value="">Chọn danh mục 4</option>';
    foreach ($result as $key => $value) {
      if($row["id"]==(int)@$id_sub)
        $selected="selected";
      else 
        $selected="";
      $str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten"].'</option>'; 
    }
    $str.='</select>';
    return $str;
  }
?>

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="index.php?com=baiviet&act=man<?php if($type!='') echo'&type='. $type;?>"><span>Quản lý <?=$title_main ?></span></a></li>
        	<?php if($keyword!=''){ ?>
				<li class="current"><a href="#" onclick="return false;">Kết quả tìm kiếm " <?=$keyword?> " </a></li>
			<?php }  else { ?>
            	<li class="current"><a href="#" onclick="return false;">Tất cả</a></li>
            <?php } ?>
        </ul>
        <div class="clear"></div>
    </div>
</div>


<form name="f" id="f" method="post">
<div class="control_frm" style="margin-top:0;">
  	<div style="float:left;">
    	<input type="button" class="blueB" value="Thêm" onclick="location.href='index.php?com=baiviet&act=add<?php if($type!='') echo'&type='. $type;?>'" />
        <input type="button" class="blueB" value="Xoá Chọn" id="xoahet" />

    </div>  
</div>

<div class="widget">
  <div class="title"><span class="titleIcon">
    <input type="checkbox" id="titleCheck" name="titleCheck" />
    </span>
    <h6>Chọn tất cả</h6>
    <div class="timkiem search_product clearfix">
	    <input type="text" value="" placeholder="Nhập từ khóa tìm kiếm ">
	    <button type="button" class="blueB"  value="">Tìm kiếm</button>
    </div>
  </div>
  <table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck mTable" id="checkAll">
    <thead>
      <tr>
        <td></td>
        <td class="tb_data_small"><a href="#" class="tipS" style="margin: 5px;">Thứ tự</a></td>     
        <?php if($config_list=='true'){ ?>
        <td class="tb_data_small"><?=get_main_list()?></td>
        <?php } ?>
        <?php if($config_cat=='true'){ ?> 
        <td class="tb_data_small"><?=get_main_cat()?></td>
        <?php } ?>
         <?php if($config_item=='true'){ ?> 
        <td class="tb_data_small"><?=get_main_item()?></td>
        <?php } ?>
         <?php if($config_sub=='true'){ ?> 
        <td class="tb_data_small"><?=get_main_sub()?></td>
        <?php } ?>
        <td class="sortCol"><div>Tên bài viết<span></span></div></td>
        <?php if($config_highlights=='true'){ ?> 
         <td class="tb_data_small">Nổi bật</td>
         <?php } ?>
         
        <td class="tb_data_small">Ẩn/Hiện</td>
        <td width="200">Thao tác</td>
      </tr>
    </thead>

    <tbody>
         <?php for($i=0, $count=count($items); $i<$count; $i++){?>
          <tr>
       <td>
            <input type="checkbox" name="chon" value="<?=$items[$i]['id']?>" id="check<?=$i?>" />
        </td>

       
        <td align="center">
            <input type="text" value="<?=$items[$i]['stt']?>" name="ordering[]" onkeypress="return OnlyNumber(event)" class="tipS smallText update_stt" original-title="Nhập số thứ tự bài viết" rel="<?=$items[$i]['id']?>" />

            <div id="ajaxloader"><img class="numloader" id="ajaxloader<?=$items[$i]['id']?>" src="images/loader.gif" alt="loader" /></div>
        </td> 
        <?php if($config_list=='true'){ ?>
         <td align="center">
          <?php
            $d->reset();
            $sql = "select ten_$lang as ten from table_baiviet_list where id='".$items[$i]['id_list']."'";
            $d->query($sql);
            $name_danhmuc = $d->fetch_array();
            echo @$name_danhmuc['ten'];
          ?>  
         </td>
         <?php } ?> 
         <?php if($config_cat=='true'){ ?>
         <td align="center">
          <?php
            $d->reset();
            $sql = "select ten_$lang as ten from table_baiviet_cat where id='".$items[$i]['id_cat']."'";
            $d->query($sql);
            $name_danhmuc = $d->fetch_array();
            echo @$name_danhmuc['ten'];
          ?>  
         </td>
        <?php } ?> 
         <?php if($config_item=='true'){ ?>
         <td align="center">
          <?php
            $d->reset();
            $sql = "select ten_$lang as ten from table_baiviet_item where id='".$items[$i]['id_item']."'";
            $d->query($sql);
            $name_danhmuc = $d->fetch_array();
            echo @$name_danhmuc['ten'];
          ?>  
         </td>
        <?php } ?> 
        <?php if($config_sub=='true'){ ?>
         <td align="center">
          <?php
            $d->reset();
            $sql = "select ten_$lang as ten from table_baiviet_sub where id='".$items[$i]['id_sub']."'";
            $d->query($sql);
            $name_danhmuc = $d->fetch_array();
            echo @$name_danhmuc['ten'];
          ?>  
         </td>
        <?php } ?> 
        <td class="title_name_data">
            <a href="index.php?com=baiviet&act=edit&id_list=<?=$items[$i]['id_list']?>&id_cat=<?=$items[$i]['id_cat']?>&id_item=<?=$items[$i]['id_item']?>&id_sub=<?=$items[$i]['id_sub']?>&id=<?=$items[$i]['id']?><?php if($type!='') echo'&type='. $type;?>" class="tipS SC_bold"><?=$items[$i]['ten_vi']?></a>
        </td>
        <?php if($config_highlights=='true'){ ?> 
        <td align="center">
          <a data-val2="table_<?=$com?>" rel="<?=$items[$i]['noibat']?>" data-val3="noibat" title class="status smallButton tipS" original-title="<?php if($items[$i]['noibat']==0) echo 'Click để hiện'; else echo "Click để ẩn"; ?>" data-val0="<?=$items[$i]['id']?>" >
            <?php if($items[$i]['noibat']==1) { ?>
            <img src="./images/icons/color/tick.png" alt="">
            <?php }else{ ?>
            <img src="./images/icons/color/hide.png" alt="">
            <?php } ?>
          </a>
         
        </td>
        <?php } ?>              
        <td align="center">
          <a data-val2="table_<?=$com?>" rel="<?=$items[$i]['hienthi']?>" data-val3="hienthi" title class="status smallButton tipS" original-title="<?php if($items[$i]['hienthi']==0) echo 'Click để hiện'; else echo "Click để ẩn"; ?>" data-val0="<?=$items[$i]['id']?>" >
            <?php if($items[$i]['hienthi']==1) { ?>
            <img src="./images/icons/color/tick.png" alt="">
            <?php }else{ ?>
            <img src="./images/icons/color/hide.png" alt="">
            <?php } ?>
          </a>
         
        </td>
       
        <td class="actBtns">
            <a href="index.php?com=baiviet&act=edit&id_list=<?=$items[$i]['id_list']?>&id_cat=<?=$items[$i]['id_cat']?>&id_item=<?=$items[$i]['id_item']?>&id_sub=<?=$items[$i]['id_sub']?>&id=<?=$items[$i]['id']?><?php if($type!='') echo'&type='. $type;?>" title="" class="smallButton tipS" original-title="Sửa bài viết"><img src="./images/icons/dark/pencil.png" alt=""></a>

            <a href="index.php?com=baiviet&act=delete&id=<?=$items[$i]['id']?><?php if($type!='') echo'&type='. $type;?>" onClick="if(!confirm('Xác nhận xóa')) return false;" title="" class="smallButton tipS" original-title="Xóa bài viết"><img src="./images/icons/dark/close.png" alt=""></a>
        </td>
      </tr>
         <?php } ?>
                </tbody>
  </table>
</div>
</form>  

<div class="paging"><?=$paging?></div>