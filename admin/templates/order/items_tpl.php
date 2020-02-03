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

<div class="control_frm" style="margin-top:25px;">
  <div class="bc">
    <ul id="breadcrumbs" class="breadcrumbs">
      <li><a href="index.php?com=order&act=man"><span>Đơn hàng</span></a></li>
      <li class="current"><a href="#" onclick="return false;">Tất cả</a></li>
    </ul>
    <div class="clear"></div>
  </div>
</div>

<script language="javascript">
	function CheckDelete(l){
		if(confirm('Bạn có chắc muốn xoá đơn hàng này?'))
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

 <link rel="stylesheet" type="text/css" href="js/jquery.datetimepicker.css"/ >
<script src="js/jquery.datetimepicker.full.min.js"></script>
<script>
$().ready(function(e) {
    
	jQuery.datetimepicker.setLocale('vi');

jQuery('.datetimepicker').datetimepicker({
 i18n:{
  de:{
   months:[
    'Januar','Februar','März','April',
    'Mai','Juni','Juli','August',
    'September','Oktober','November','Dezember',
   ],
   dayOfWeek:[
    "CN", "T2", "T3", "T4", 
    "T5", "T6", "T7",
   ]
  }
 },
 timepicker:false,
 format:'d-m-Y'
});
});
</script>


<div class="widget">
  <div class="titlee" style="padding-bottom:5px;">

    <div class="timkiem" >
    <form name="search" action="index.php" method="GET" class="form giohang_ser">
      <input name="com" value="order" type="hidden"  />
      <input name="act" value="man" type="hidden" />
      <input name="p" value="<?=($_GET['p']=='')?'1':$_GET['p']?>" type="hidden" />

      <input class="form_or" name="keyword" placeholder="Nhập từ khóa.." value="<?=$_GET['keyword']?>" type="text" />
      <input class="form_or" name="ngaybd" id="datefm" type="text" value="<?=$_GET['ngaybd']?>" placeholder="Từ ngày.."/>
      <input class="form_or" name="ngaykt" id="dateto" type="text" value="<?=$_GET['ngaykt']?>" placeholder="Đến ngày.." />

      
      <select name="httt">
      <option value="0">Hình thức thanh toán</option>
        <?php 
          $sql="select id,ten_vi from #_httt order by id";
          $d->query($sql);
          $httt_sr = $d->result_array();
          for ($i=0,$count=count($httt_sr); $i < $count; $i++) { 
        ?>
          <option value="<?=$httt_sr[$i]["id"]?>" <?php if($httt_sr[$i]["id"]==$httt) echo "selected='selected'";?>>
            <?=$httt_sr[$i]["ten_vi"]?>
          </option>
        <?php }?>
      </select>
      <select name="tinhtrang">
      <option value="0">Tình trạng</option>
        <?php  
          $sql="select id,trangthai from #_tinhtrang order by id";
          $d->query($sql);
          $tinhtrang_sr = $d->result_array();
          for ($i=0,$count=count($tinhtrang_sr); $i < $count; $i++) { 
        ?>
          <option value="<?=$tinhtrang_sr[$i]["id"]?>" <?php if($tinhtrang_sr[$i]["id"]==$tinhtrang) echo "selected='selected'";?> >
            <?=$tinhtrang_sr[$i]["trangthai"]?>
          </option>
        <?php }?>
      </select>
      <input type="submit" class="blueB" value="Tìm kiếm" style="width:100px; margin:0px 0px 0px 10px;"  />
    </form>
    </div><!--end tim kiem-->
  </div>
  
</div>
<div style="display:block;clear:both;margin-top: 5px;"></div>

<script>
$().ready(function(e) {
   $('.export_excel').click(function(){
	  	$data=$('.frm_data').serialize();
		var listid="";
		$("input.chon").each(function(){
		if (this.checked) listid = listid+","+this.value;
    	})
	listid=listid.substr(1);	 //alert(listid);
	if (listid=="") { alert("Bạn chưa chọn mục nào"); return false;}

		
		 
		$.ajax({
						url:"ajax/export_data.php",
						type:"POST",
						data:$data,						 
						success:function(data1){
						 setTimeout(function(){
							 window.location.href='ajax/export_data.php';
							 },1000)
						}
		 			});

	   })
});
</script>




<form name="f" id="f" method="post" class="frm_data">
  <div class="control_frm" style="margin-top:0;">
    <div style="float:left;">
      <input type="button" class="blueB" value="Xoá" onclick="ChangeAction('index.php?com=order&act=man&multi=del');return false;" />
      
    <?php /*?>  <button type="button" class="export_excel">Xuất Excel chọn</button><?php */?>
      
    </div>
    <div style="float:right;"> </div>
    <img src="./images/question-button.png" alt="Chọn loại" class="icon_que tipS" style="float:right; margin:5px 5px 0 0;" original-title="Dùng cây thư mục để di chuyển nhanh đến sản phẩm"> </div>
  <div class="widget">
    <div class="title"><span class="titleIcon">
      <input type="checkbox" id="titleCheck" name="titleCheck" />
      </span>
      <h6>Danh sách đơn hàng</h6>
    </div>
    <table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck mTable" id="checkAll">
      <thead>
        <tr>
          <td></td>
          <td class="sortCol" width="20"><div>Mã đơn hàng<span></span></div></td>
          <td class="sortCol"  width="120"><div>Họ tên<span></span></div></td>
          <td class="sortCol"><div>Điện thoại<span></span></div></td>
          <td class="sortCol" width="30"><div>Email<span></span></div></td>
          <td class="sortCol" width="150"><div>Ngày đặt<span></span></div></td>
          <td width="150">Số tiền</td>
          <td width="150">Tình trạng</td>
          <td width="150">Thao tác</td>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="10"></td>
        </tr>
      </tfoot>
      <tbody>
      
      
      
        <?php 
		 
		 
	
		 for($i=0, $count=count($items); $i<$count; $i++){?>
        <tr>
          <td><input type="checkbox" name="iddel[]" value="<?=$items[$i]['id']?>" class="chon" id="check<?=$i?>" /></td>
          <td align="center" <?php if($items[$i]['view']==0){ echo "style='font-weight:bold;'";}?>><?=$items[$i]['madonhang']?></td>
          <td <?php if($items[$i]['view']==0){ echo "style='font-weight:bold;'";}?>><?=$items[$i]['hoten']?></td>
          <td <?php if($items[$i]['view']==0){ echo "style='font-weight:bold;'";}?>><?=$items[$i]['dienthoai']?></td>
          <td <?php if($items[$i]['view']==0){ echo "style='font-weight:bold;'";}?>><?=$items[$i]['email']?></td>
          <td align="center" <?php if($items[$i]['view']==0){ echo "style='font-weight:bold;'";}?>><?=date('d/m/Y - g:i A',$items[$i]['ngaytao']);?></td>
          <td align="center" <?php if($items[$i]['view']==0){ echo "style='font-weight:bold;'";}?>><?=number_format($items[$i]['tonggia'],0, ',', '.')?>
            &nbsp;VNĐ </td>
          <td align="center" <?php if($items[$i]['view']==0){ echo "style='font-weight:bold;'";}?>><?php 
		   		 $sql="select trangthai from #_tinhtrang where id= '".$items[$i]['trangthai']."' ";
				    $d->query($sql);
				    $result=$d->fetch_array();
				    echo $result['trangthai'];
		      ?>
          
          </td>
          <td class="actBtns"><!-- <a href="export.php?id=<?=$items[$i]['id']?>" title="" class="smallButton tipS" original-title="Xuất đơn hàng"><img src="./images/icons/dark/excel.png" alt=""></a> <a href="export_word.php?id=<?=$items[$i]['id']?>" title="" class="smallButton tipS" original-title="Xuất đơn hàng"><img src="./images/icons/dark/word.png" alt=""></a> --> <a href="index.php?com=order&act=edit&id=<?=$items[$i]['id']?>" title="" class="smallButton tipS" original-title="Xem và sửa đơn hàng"><img src="./images/icons/dark/preview.png" alt=""></a> <a href="" onclick="CheckDelete('index.php?com=order&act=delete&id=<?=$items[$i]['id']?>'); return false;" title="" class="smallButton tipS" original-title="Xóa đơn hàng"><img src="./images/icons/dark/close.png" alt=""></a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</form>
 
<div class="paging"><?=$paging['paging']?></div>

<script type="text/javascript">
function onSearch(evt) {	
		var datefm = document.getElementById("datefm").value;	
		var dateto = document.getElementById("dateto").value;
		var status = document.getElementById("id_tinhtrang").value;		
		//var encoded = Base64.encode(keyword);
		location.href = "index.php?com=order&act=man&datefm="+datefm+"&dateto="+dateto+"&status="+status;
		loadPage(document.location);
			
}
$(document).ready(function(){						
	var dates = $( "#datefm, #dateto" ).datepicker({
			defaultDate: "+1w",
			dateFormat: 'dd/mm/yy',
			changeMonth: true,			
			numberOfMonths: 3,
			onSelect: function( selectedDate ) {
				var option = this.id == "datefm" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
        
		});
		
</script>