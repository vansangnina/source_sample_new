<?php  
  function get_main_list()
  {
    global $d,$type,$id_list,$lang;
    $sql="select id,ten_$lang as ten from table_tags where type='".$type."' and hienthi=1 order by stt asc";
    $d->query($sql);
    $result = $d->result_array();
    $str='
      <select id="id_list" name="id_list" onchange="select_list()" class="main_select">
      <option value="">Chọn danh mục 1</option>';
    foreach ($result as $key => $value) {
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
<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
            <li><a href="index.php?com=download&act=man"><span><?=$title_main?></span></a></li>
            <li class="current"><a href="#" onclick="return false;">Tất cả</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<script language="javascript">
	function CheckDelete(l){
		if(confirm('Bạn có chắc muốn xoá mục này?'))
		{
			location.href = l;	
		}
	}	
	function ChangeAction(str){
		if(confirm("Bạn có chắc chắn?"))
		{
			document.f.action = str;
			document.f.submit();
		}
	}		
</script>
<form name="f" id="f" method="post">
<div class="control_frm" style="margin-top:0;">
  	<div style="float:left;">
    	<input type="button" class="blueB" value="Thêm" onclick="location.href='index.php?com=download&act=add&type=<?=$type?>'" />
        <input type="button" class="blueB" value="Xoá" onclick="ChangeAction('index.php?com=download&act=man&multi=del&type=<?=$type?>');return false;" />
    </div>    
</div>



<div class="widget">
  <div class="title"><span class="titleIcon">
    <input type="checkbox" id="titleCheck" name="titleCheck" />
    </span>
    <h6>Danh sách liên kết web</h6>
  </div>
  <table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck mTable" id="checkAll">
    <thead>
      <tr>
        <td></td>
        <td class="tb_data_small"><a href="#" class="tipS" style="margin: 5px;">Thứ tự</a></td>
        <?php if($config_list=='true') {?>
          <td class="tb_data_small"><?=get_main_list()?></td>
        <?php } ?>
        <td width="200"><div>Tên<span></span></div></td>
        <td class="tb_data_small">Ẩn/Hiện</td>
        <td width="200">Thao tác</td>
      </tr>
    </thead>
    <tbody>
          <?php for($i=0, $count=count($items); $i<$count; $i++){?>
          <tr>
        <td>
            <input type="checkbox" name="iddel[]" value="<?=$items[$i]['id']?>" id="check<?=$i?>" />
        </td>
        <td align="center">
            <input type="text" value="<?=$items[$i]['stt']?>" name="ordering[]" onkeypress="return OnlyNumber(event)" class="tipS smallText" original-title="Nhập số thứ tự danh mục" id="number<?=$items[$i]['id']?>" onchange="return updateNumber('download', '<?=$items[$i]['id']?>')" />
            <div id="ajaxloader"><img class="numloader" id="ajaxloader<?=$items[$i]['id']?>" src="images/loader.gif" alt="loader" /></div>
        </td>   
        <?php if($config_list=='true') {?>
          <td align="center">
            <?php
              $d->reset();
              $sql = "select ten_$lang as ten from table_tags where id='".$items[$i]['id_list']."'";
              $d->query($sql);
              $name_danhmuc = $d->fetch_array();
              echo @$name_danhmuc['ten'];
            ?>  
          </td>    
        <?php } ?>
        <td>
            <a href="index.php?com=download&act=edit&id=<?=$items[$i]['id']?>&type=<?=$type?>" class="tipS SC_bold"><?=$items[$i]['ten_vi']?></a>
        </td>
   
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
            <a href="index.php?com=download&act=edit&id=<?=$items[$i]['id']?>&type=<?=$type?>" title="" class="smallButton tipS" original-title="Sửa danh mục"><img src="./images/icons/dark/pencil.png" alt=""></a>
            <a href="" onclick="CheckDelete('index.php?com=download&act=delete&id=<?=$items[$i]['id']?>&type=<?=$type?>'); return false;" title="" class="smallButton tipS" original-title="Xóa danh mục"><img src="./images/icons/dark/close.png" alt=""></a>
        </td>
      </tr>
           <?php } ?> 
                </tbody>
  </table>
</div>
</form>               
<div class="paging"><?=$paging?></div>