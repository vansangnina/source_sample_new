<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	            <li><a href="index.php?com=thanhvien&act=man"><span>Thành viên</span></a></li>
                                    <li class="current"><a href="#" onclick="return false;">Tất cả</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<script language="javascript">
	function CheckDelete(l){
		if(confirm('Bạn có chắc muốn xoá thành viên này?'))
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
function select_onchange()
	{
		var a=document.getElementById("id_role");
		window.location ="index.php?com=thanhvien&act=man&id_role="+a.value;	
		return true;
	}					
</script>
<form name="f" id="f" method="post">
<div class="control_frm" style="margin-top:0;">
  	<div style="float:left;">
    	<input type="button" class="blueB" value="Thêm" onclick="location.href='index.php?com=thanhvien&act=add'" />
        
        <input type="button" class="blueB" value="Xoá" onclick="ChangeAction('index.php?com=thanhvien&act=man&multi=del');return false;" />
    </div>  
     
    	
</div>



<div class="widget">
  <div class="title"><span class="titleIcon">
    <input type="checkbox" id="titleCheck" name="titleCheck" />
    </span>
    <h6>Danh sách các thành viên hiện có</h6>
  </div>
  <table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck mTable" id="checkAll">
    <thead>
      <tr>
        <td></td>
        <td width="50">ID</td>
        <td width="200"><div>Email<span></span></div></td>
        <td width="100">Họ tên</td>
        <td width="100">Lần đăng nhập cuối</td>
        <td width="100">Đăng nhập bằng</td>
        <td class="tb_data_small">Kích hoạt</td>      
        <td width="100">Thao tác</td>
      </tr>
    </thead>
    
    <tbody>
         <?php for($i=0, $count=count($items); $i<$count; $i++){?>
          <tr>
       <td>
            <input type="checkbox" name="iddel[]" value="<?=$items[$i]['id']?>" id="check<?=$i?>" />
        </td>
        <td align="center">
          <?=$items[$i]['id']?>
        </td>
        <td align="center">
        <a href="index.php?com=thanhvien&act=edit&id=<?=$items[$i]['id']?>" class="tipS SC_bold"><?=$items[$i]['email']?></a>
        </td>
      
        <td align="center">
          <?=$items[$i]['ten']?>
        </td>
        <td align="center">
          <?=$items[$i]['lastlogin']!=0? date("h:i:s - d/m/Y",$items[$i]['lastlogin']):"Chưa đăng nhập lần nào!"?>
        </td>
        <td align="center">
          <?php if($items[$i]['com']=='facebook'){?>
          <a href="http://facebook.com/<?=$items[$i]['facebook_auth_id']?>" class="lg_facebook" target="_blank"><i class="fa fa-facebook-square"></i> Facebook</a>
          <?php }elseif($items[$i]['com']=='google'){?>
          <a href="http://plus.google.com/<?=$items[$i]['google_auth_id']?>" class="lg_google" target="_blank"><i class="fa fa-google-plus"></i> Google</a>
          <?php }else{?>
          <span class="lg_regular">User thường</span>
          <?php }?>
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
            <a href="index.php?com=thanhvien&act=edit&id=<?=$items[$i]['id']?>" title="" class="smallButton tipS" original-title="Sửa thành viên"><img src="./images/icons/dark/pencil.png" alt=""></a>
            <a href="" onclick="CheckDelete('index.php?com=thanhvien&act=delete&id=<?=$items[$i]['id']?>'); return false;" title="" class="smallButton tipS" original-title="Xóa thành viên"><img src="./images/icons/dark/close.png" alt=""></a>        </td>
      </tr>
         <?php } ?>
                </tbody>
  </table>
</div>
</form>               
<div class="paging"><?=$paging?></div>