<?php $ma = ChuoiNgauNhien(9); ?>
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

		$('.update_stt').keyup(function(event) {
			var id = $(this).attr('rel');
			var table = 'coupon';
			var value = $(this).val();
			$.ajax ({
				type: "POST",
				url: "ajax/update_stt.php",
				data: {id:id,table:table,value:value},
				success: function(result) {
				}
			});
		});

	});
	
</script>
<link rel="stylesheet" type="text/css" href="js/jquery.datetimepicker.css"/ >
<script src="js/jquery.datetimepicker.full.min.js"></script>
<script>
$(document).ready(function(){                    
    var dates = $( "#ngaybatdau, #ngayketthuc" ).datepicker({
        defaultDate: "+1w",
        minDate: new Date(),
        dateFormat: 'dd-mm-yy',
        changeMonth: true, 
        changeYear: true,          
        numberOfMonths: 1,
        onSelect: function( selectedDate ) {
            var option = this.id == "ngaybatdau" ? "minDate" : "maxDate",
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
<div class="wrapper">

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="index.php?com=coupon&act=add"><span>Thêm <?=$title_main?></span></a></li>
            <li class="current"><a href="#" onclick="return false;">Thêm</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>

<form name="supplier" id="validate" class="form" action="index.php?com=coupon&act=save" method="post" enctype="multipart/form-data">
    <div class="widget">
        <div class="formRow">
            <label>Mã giảm giá</label>
            <div class="formRight">
                <input type="text" readonly="true"  name="ma" title="Mã giảm giá" id="phantram" class="tipS validate[required]" value="<?=@$item['ma']!='' ? @$item['ma'] : $ma?>" />
            </div>
            <div class="clear"></div>
        </div>
        <div class="formRow">
            <label>Phần trăm</label>
            <div class="formRight">
                <input type="text" name="phantram" title="Phần trăm giảm giá" id="phantram" class="tipS validate[required]" value="<?=@$item['phantram']?>" />
            </div>
            <div class="clear"></div>
        </div>
        <div class="formRow">
            <label>Số lần</label>
            <div class="formRight">
                <input type="text" name="solan" title="Số lần" id="solan" class="tipS validate[required]" value="<?=@$item['solan']?>" />
            </div>
            <div class="clear"></div>
        </div>
        <div class="formRow">
            <label>Ngày bắt đầu</label>
            <div class="formRight">
                <input type="text" name="ngaybatdau" title="Số lần" id="ngaybatdau" class="tipS validate[required]" value="<?=@$item['ngaybatdau']!='' ? date('d-m-Y',@$item['ngaybatdau']) : date('d-m-Y',time())?>" />
            </div>
            <div class="clear"></div>
        </div>
        <div class="formRow">
            <label>Ngày kết thúc</label>
            <div class="formRight">
                <input type="text" name="ngayketthuc" title="Số lần" id="ngayketthuc" class="tipS validate[required]" value="<?=@$item['ngayketthuc']!='' ? date('d-m-Y',@$item['ngayketthuc']) : date('d-m-Y',time())?>" />
            </div>
            <div class="clear"></div>
        </div>
        <?php if($_GET['act']=='edit') { ?>
        <div class="formRow">
          <label>Tình trạng :</label>
          <div class="formRight">
                <select class="main_select" name="tinhtrang">
                    <option <?php if($item['tinhtrang']==0) { echo "selected"; } ?> value="0">Chưa sử dụng</option>
                    <option <?php if($item['tinhtrang']==1) { echo "selected"; } ?> value="1">Đã sử dụng</option>
                    <option <?php if($item['tinhtrang']==2) { echo "selected"; } ?> value="2">Hết hạn</option>
                    <option <?php if($item['tinhtrang']==3) { echo "selected"; } ?> value="3">Đã gửi</option>
                </select>
          </div>
          <div class="clear"></div>
        </div>
        <?php } ?>
    </div>

	<div class="widget">
		<div class="formRow">
			<div class="formRight">
                <input type="hidden" name="id" id="id_this_post" value="<?=@$item['id']?>" />
            	<input type="submit" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
            	<a href="index.php?com=coupon&act=man" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
			</div>
			<div class="clear"></div>
		</div>

	</div>
</form>       
</div>

