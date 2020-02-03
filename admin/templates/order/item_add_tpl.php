<?php
	function tinhtrang($i=0){
		global $d;
		$sql="select * from table_tinhtrang order by id";
		$d->query($sql);
		$result = $d->result_array();
		$str='<select id="id_tinhtrang" name="id_tinhtrang" class="main_font">';
		foreach ($result as $key => $row) {
			if($row["id"]==$i)
				$selected="selected";
			else 
				$selected="";
			$str.='<option value='.$row["id"].' '.$selected.'>'.$row["trangthai"].'</option>';	
		}
		$str.='</select>';
		return $str;
	}
	
?>
<script type="text/javascript">

function TreeFilterChanged2(){		
			$('#validate').submit();		
}
function update(id){
	if(id>0){
		var sl=$('#product'+id).val();
		if(sl>0){
			$('#ajaxloader'+id).css('display', 'block');	
			jQuery.ajax({
				type: 'POST',
				url: "ajax.php?do=cart&act=update",
				data: {'id':id, 'sl':sl},				
				success: function(data) {					
					$('#ajaxloader'+id).css('display', 'none');	
					var getData = $.parseJSON(data);
					$('#id_price'+id).html(addCommas(getData.thanhtien)+'&nbsp;VNĐ');
					$('#sum_price').html(addCommas(getData.tongtien)+'&nbsp;VNĐ');

					
				}
			});			
		}else alert('Số lượng phải lớn hơn 0');
	}
}

function del(id){
	if(id>0){				
		jQuery.ajax({
			type: 'POST',
			url: "ajax.php?do=cart&act=delete",
			data: {'id':id},			
			success: function(data) {										
					var getData = $.parseJSON(data);
					$('#productct'+id).css('display', 'none');	
					$('#sum_price').html(addCommas(getData.tongtien)+'&nbsp;VNĐ');
				}
		});
	}
}
</script>  
<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	            <li><a href="index.php?com=order&act=mam"><span>Đơn hàng</span></a></li>
                                    <li class="current"><a href="#" onclick="return false;">Xem và sửa đơn hàng</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>

<form name="supplier" id="validate" class="form" action="index.php?com=order&act=save" method="post" enctype="multipart/form-data">
	<div class="widget">
		<div class="title"><img src="./images/icons/dark/list.png" alt="" class="titleIcon" />
			<h6>Thông tin người mua</h6>
		</div>
		
		<div class="formRow">
			<label>Mã đơn hàng</label>
			<div class="formRight">
               <?=@$item['madonhang']?>
			</div>
			<div class="clear"></div>
		</div>	
        
        <div class="formRow">
			<label>Họ tên</label>
			<div class="formRight">            
              <input name="hoten" class="tipS " value="<?=@$item['hoten']?>" type="text" placeholder="" />
			</div>
            
            
			<div class="clear"></div>
		</div>	
        
         <div class="formRow">
			<label>Điện thoại</label>
			<div class="formRight">
              <input name="dienthoai" class="tipS " value="<?=@$item['dienthoai']?>" type="text" placeholder="" />
			</div>
			<div class="clear"></div>
		</div>		        
        
         <div class="formRow">
			<label>Email</label>
			<div class="formRight">
              <input name="email" class="tipS " value="<?=@$item['email']?>" type="text" placeholder="" />
			</div>
			<div class="clear"></div>
		</div>	
        
        <div class="formRow">
			<label>Địa chỉ</label>
			<div class="formRight">
           
             <input name="diachi" class="tipS " value="<?=@$item['diachi']?>" type="text" placeholder="" />
			</div>
			<div class="clear"></div>
		</div>	
        
         <div class="formRow">
			<label>Yêu cầu thêm</label>
			<div class="formRight">
              
             <input name="noidung" class="tipS " value="<?=@$item['noidung']?>" type="text" placeholder="" />
			</div>
			<div class="clear"></div>
		</div>		        
        
        </div>
		<div class="widget">
		<div class="title"><img src="./images/icons/dark/list.png" alt="" class="titleIcon" />
			<h6>Chi tiết đơn hàng</h6>
		</div>
      
    
        <table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck mTable" id="checkAll">
    <thead>
      <tr>
       
        <td class="tb_data_small"><a href="#" class="tipS" style="margin: 5px;">STT</a></td>      
        <td class="sortCol"><div>Tên sản phẩm<span></span></div></td>
        <td width="150">Hình ảnh</td>
        <td width="150">Đơn giá</td>
        <td width="150">Số lượng</td>
        <td width="150">Thành tiền</td>
        <td width="150">Thao tác</td>
      </tr>
    </thead> 
     <tfoot>
     <tr>
        <td colspan="6" style="text-align: right;font-weight:bold;">Tổng tiền: </td>
        <td><div class="pagination" id="sum_price" style="text-align:left;padding-left: 15px;"> <strong><?=number_format(@$item['tonggia'],0, ',', '.')?>&nbsp;VNĐ </strong></div></td>
        <td></td>
      </tr>
     <tr>
        <td colspan="6" style="text-align: right;font-weight:bold;">Phiship: </td>
        <td><div class="pagination" id="sum_price" style="text-align:left;padding-left: 15px;"> <strong><?=number_format(@$item['phivanchuyen'],0, ',', '.')?>&nbsp;VNĐ </strong></div></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="6" style="text-align: right;font-weight:bold;">Tổng đơn hàng: </td>
        <td><div class="pagination" id="sum_price" style="text-align:left;padding-left: 15px;"> <strong><?=number_format(@$item['phivanchuyen']+@$item['tonggia'],0, ',', '.')?>&nbsp;VNĐ </strong></div></td>
        <td></td>
      </tr>
    </tfoot>   
    <tbody>
     <?php      
				$tongtien=0;          
				for($i=0,$count_donhang=count($result_ctdonhang);$i<$count_donhang;$i++){	
				$pid=$result_ctdonhang[$i]['id_product'];
					
					
				$pname=get_product_name($pid);
				$pphoto=get_thumb($pid);
				$tongtien+=	$result_ctdonhang[$i]['giaban']*$result_ctdonhang[$i]['soluong'];				
			?>
        <tr id="productct<?=$result_ctdonhang[$i]['id']?>">
          <td><?=$i+1?></td>
          <td><?=$pname?></td>
           <td><img src="<?=UPLOAD_PRODUCT.$pphoto?>" height="100"  /></td>
          <td align="center"><?=number_format($result_ctdonhang[$i]['gia'],0, ',', '.')?>&nbsp;VNĐ</td>
          <td align="center"><input type="text" disabled class="tipS" style="width:50px; text-align:center" original-title="Nhập số lượng sản phẩm" maxlength="3" value="<?=$result_ctdonhang[$i]['soluong']?>" onchange="update(<?=$result_ctdonhang[$i]['id']?>)" id="product<?=$result_ctdonhang[$i]['id']?>">
          <div id="ajaxloader"><img class="numloader" id="ajaxloader<?=$result_ctdonhang[$i]['id']?>" src="images/loader.gif" alt="loader" /></div>
            &nbsp;</td>
          <td align="center" id="id_price<?=$result_ctdonhang[$i]['id']?>"><?=number_format($result_ctdonhang[$i]['gia']*$result_ctdonhang[$i]['soluong'],0, ',', '.')?>&nbsp;VNĐ</td>
          <td class="actBtns"><a class="smallButton tipS" original-title="Xóa sản phẩm" href="javascript:del(<?=$result_ctdonhang[$i]['id']?>)"><img src="./images/icons/dark/close.png" alt=""></a></td>
        </tr>
        <?php } ?>
     </tbody>
  </table>
      
        
        </div>
        
		<div class="widget">
		<div class="title"><img src="./images/icons/dark/list.png" alt="" class="titleIcon" />
			<h6>Thông tin thêm</h6>
		</div>
        
		<div class="formRow">
			<label>Mô tả ngắn:</label>
			<div class="formRight">
				<textarea rows="8" cols="" title="Viết ghi chú cho đơn hàng" class="tipS" name="ghichu" id="ghichu"><?=@$item['ghichu']?></textarea>
			</div>
			<div class="clear"></div>
		</div>	
        
        
        <div class="formRow">
			<label>Tình trạng</label>
			<div class="formRight">
            	<div class="selector">
					<?=tinhtrang($item['trangthai'])?>
                </div>
			</div>
			<div class="clear"></div>
		</div>
        
        	
        
        <div class="formRow">
			<div class="formRight">	     
                <input type="hidden" name="id" id="id_this_post" value="<?=@$item['id']?>" />
            	<input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Cập nhật" />
			</div>
			<div class="clear"></div>
		</div>
		
	</div>
   

</form>  