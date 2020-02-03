<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	  <li><a href="index.php?com=photo&act=man_photo<?php if($type!='') echo'&type='. $type;?>"><span><?=$title_main?></span></a></li>
            <li class="current"><a href="#" onclick="return false;">Tất cả</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<script language="javascript">
	function CheckDelete(l){
		if(confirm('Bạn có chắc muốn xóa hình ảnh này?'))
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
    	<input type="button" class="blueB" value="Thêm" onclick="location.href='index.php?com=photo&act=add_photo<?php if($type!='') echo'&type='. $type;?>'" />
        
        <input type="button" class="blueB" value="Xoá" onclick="ChangeAction('index.php?com=photo&act=man_photo&multi=del<?php if($type!='') echo'&type='. $type;?>');return false;" />
    </div>  
    <div style="float:right;">
        <div class="selector">
			
        </div>  
    </div>      	  
</div>



<div class="widget">
  <div class="title"><span class="titleIcon">
    <input type="checkbox" id="titleCheck" name="titleCheck" />
    </span>
    <h6>Danh sách các hình ảnh hiện có</h6>
  </div>
  <table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck mTable" id="checkAll">
    <thead>
      <tr>
        <td></td>
        <td class="tb_data_small"><a href="#" class="tipS" style="margin: 5px;">Thứ tự</a></td>  
        <?php if($config_list=='true'){ ?>
        <td width="250">Danh mục cấp 1</td>   
        <?php } ?>  
        <td width="150">Hình ảnh</td>        
        <td class="sortCol"><div>Tên hình<span></span></div></td>        
        <td class="tb_data_small">Ẩn/Hiện</td>
        <td width="200">Thao tác</td>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="10"><div class="pagination">  <?=pagesListLimitadmin($url_link , $totalRows , $pageSize, $offset)?>     </div></td>
      </tr>
    </tfoot>
    <tbody>
         <?php for($i=0, $count=count($items); $i<$count; $i++){?>
          <tr>
       <td>
            <input type="checkbox" name="iddel[]" value="<?=$items[$i]['id']?>" id="check<?=$i?>" />
        </td>        
        <td align="center">
            <input type="text" value="<?=$items[$i]['stt']?>" name="ordering[]" onkeypress="return OnlyNumber(event)" class="tipS smallText" original-title="Nhập số thứ tự hình ảnh" id="number<?=$items[$i]['id']?>" onchange="return updateNumber('photo', '<?=$items[$i]['id']?>')" />
            <div id="ajaxloader"><img class="numloader" id="ajaxloader<?=$items[$i]['id']?>" src="images/loader.gif" alt="loader" /></div>
        </td> 
        <?php if($config_list=='true'){ ?>
        <td align="center">
          <?php
              $d->reset();
              $sql="select id,ten_vi from table_product_list where hienthi =1 and id=".$items[$i]['id_list']." order by stt,id desc";
              $d->query($sql);
              $result_list=$d->fetch_array();
              echo $result_list['ten_vi'];
          ?>
        </td>
        <?php } ?>  
        <td align="center">
                <img src="<?=UPLOAD_IMAGE.$items[$i]['thumb_vi']?>" width="100" border="0" />
                </td>
      
        <td class="title_name_data">
            <a href="index.php?com=photo&act=edit_photo&id=<?=$items[$i]['id']?><?php if($type!='') echo'&type='. $type;?>" class="tipS SC_bold"><?=$items[$i]['ten_vi']?></a>
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
            <a href="index.php?com=photo&act=edit_photo&id=<?=$items[$i]['id']?><?php if($type!='') echo'&type='. $type;?>" title="" class="smallButton tipS" original-title="Sửa hình ảnh"><img src="./images/icons/dark/pencil.png" alt=""></a>
            <a href="" onclick="CheckDelete('index.php?com=photo&act=delete_photo&id=<?=$items[$i]['id']?><?php if($type!='') echo'&type='. $type;?>'); return false;" title="" class="smallButton tipS" original-title="Xóa hình ảnh"><img src="./images/icons/dark/close.png" alt=""></a>        </td>
      </tr>
         <?php } ?>
                </tbody>
  </table>
</div>
</form>      