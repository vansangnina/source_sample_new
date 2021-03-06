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
			var table = 'properties';
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
<?php
 function get_main_list()
  {
    global $d,$item,$type;
    $sql="select * from table_properties_list where type='".$type."' order by stt asc";
    $d->query($sql);
    $result = $d->result_array();
    $str='
      <select id="id_list" name="id_list" class="main_select">
      <option value="">Chọn danh mục </option>';
    foreach ($result as $key => $row) {
        if($row["id"]==(int)@$item["id_list"])
            $selected="selected";
        else 
            $selected="";
        $str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten_vi"].'</option>'; 
    }
    $str.='</select>';
    return $str;
  }  

?>
<div class="wrapper">

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="index.php?com=properties&act=add_list<?php if($type!='') echo'&type='. $type;?>"><span>Thêm <?=$title_main?></span></a></li>
            <li class="current"><a href="#" onclick="return false;">Thêm</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>

<form name="supplier" id="validate" class="form" action="index.php?com=properties&act=save<?php if($type!='') echo'&type='. $type;?>" method="post" enctype="multipart/form-data">
    <div class="widget">
        <div class="formRow">
            <label>Danh mục thuộc tính</label>
            <div class="formRight">
                <?=get_main_list()?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
	<div class="widget">
        <?php
         if(count($config['lang'])>1) {?>
            <div class="title chonngonngu">
                <ul>
                <?php foreach ($config['lang'] as $key => $value) { ?>
                    <li><a href="<?=$key?>" class="<?=$key==$config['lang_active']?'active':''?> tipS validate[required]" title="Chọn <?=$value?>"><?=$value?></a></li>
                <?php } ?>
                </ul>
            </div>
        <?php } ?>


        <?php foreach ($config['lang'] as $key => $value) { ?>
        <div class="contain_lang_<?=$key?> contain_lang <?=$key==$config['lang_active']?'active':''?>">
            
                <div class="title"><img src="./images/icons/dark/record.png" alt="" class="titleIcon" />
                    <h6>Nội dung <?=$value?></h6>
                </div>
                
                <div class="formRow">
                    <label>Tiêu đề <?=$key!=$config['lang_active']?'('.$key.')':''?></label>
                    <div class="formRight">
                        <input type="text" name="data[ten_<?=$key?>]" title="Nhập tên danh mục" id="ten_<?=$key?>" class="tipS validate[required]" value="<?=@$item['ten_'.$key]?>" />
                    </div>
                    <div class="clear"></div>
                </div>
                <?php if($config_mota=="true"){ ?>
                    <div class="formRow">
                        <label>Mô tả <?=$key!=$config['lang_active']?'('.$key.')':''?></label>
                        <div class="formRight">
                            <textarea rows="5" title="Nhập mô tả . " class="tipS" name="data[mota_<?=$key?>]"><?=@$item['mota_'.$key]?></textarea>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php } ?>
        </div><!--lang-->
        <?php } ?>
	
        

        <div class="formRow">
          <label>Hiển thị : <img src="./images/question-button.png" alt="Chọn loại" class="icon_que tipS" original-title="Bỏ chọn để không hiển thị danh mục này ! "> </label>
          <div class="formRight">
            <input type="checkbox" name="hienthi" id="check1" value="1" <?=(!isset($item['hienthi']) || $item['hienthi']==1)?'checked="checked"':''?> />
             <label>Số thứ tự: </label>
              <input type="text" class="tipS" value="<?=isset($item['stt'])?$item['stt']:1?>" name="stt" style="width:20px; text-align:center;" onkeypress="return OnlyNumber(event)" original-title="Số thứ tự của danh mục, chỉ nhập số">
          </div>
          <div class="clear"></div>
        </div>
        <div class="formRow">
            <div class="formRight">
                <input type="hidden" name="type" id="id_this_type" value="<?=$type?>" />
                <input type="hidden" name="id" id="id_this_post" value="<?=@$item['id']?>" />
                <input type="submit" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
                <a href="index.php?com=properties&act=man<?php if($type!='') echo'&type='. $type;?>" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
            </div>
            <div class="clear"></div>
        </div>
    </div> 
    </form>        
</div>
