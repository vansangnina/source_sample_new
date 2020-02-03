<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.timkiem button').click(function(event) {
            var keyword = $(this).parent().find('input').val();
            window.location.href="index.php?com=lang&act=man&type=<?=$type?>&keyword="+keyword;
        });
    });
</script>
<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="index.php?com=lang&act=man<?php if($type!='') echo'&type='. $type;?>"><span>Quản lý ngôn ngữ</span></a></li>
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
            <input type="button" class="blueB" value="Thêm" onclick="location.href='index.php?com=lang&act=add&type=<?=$type?>'" />
            <?php /* ?><input type="button" class="blueB" value="Xoá Chọn" id="xoahet" /><?php */ ?>
        </div>  
    </div>
    <div class="widget">
        <div class="title"><span class="titleIcon">
            <input type="checkbox" id="titleCheck" name="titleCheck" />
            </span>
            <h6>Chọn tất cả</h6>
            <div class="timkiem">
                <input type="text" value="" placeholder="Nhập từ tên define">
                <button type="button" class="blueB"  value="">Tìm kiếm</button>
            </div>
        </div>
    
        <table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck mTable" id="checkAll">
            <thead>
              <tr>
                <td></td>     
                <td width="200">Define</td>
                <td width="200">Tiếng việt</td>
                <td width="200">Tiếng anh</td>
                <td width="10%">Ẩn/Hiện</td>
                <td width="10%">Thao tác</td>
              </tr>
            </thead>
            <tbody>
            <?php for ($i=0; $i < count($items); $i++) { ?>
                <tr>
                    <td><input type="checkbox" name="chon" value="<?=$items[$i]['id']?>" id="check<?=$i?>" /></td>
                    <td align="center"><?=@$items[$i]['define']?></td>
                    <td align="center"><?=@$items[$i]['lang_vi']?></td>
                    <td align="center"><?=@$items[$i]['lang_en']?></td>
                    <td align="center">
                        <a data-val2="table_<?=$com?>" rel="<?=$items[$i]['hienthi']?>" data-val3="hienthi" title class="status smallButton tipS" original-title="<?php if($items[$i]['hienthi']==0) echo 'Click để hiện'; else echo "Click để ẩn"; ?>" data-val0="<?=$items[$i]['id']?>" >
                            <?php if($items[$i]['hienthi']==1) { ?>
                            <img src="./images/icons/color/tick.png" alt="">
                            <?php }else{ ?>
                            <img src="./images/icons/color/hide.png" alt="">
                            <?php } ?>
                        </a>
                    </td>
                    <td align="center">
                        <a href="index.php?com=lang&act=edit&type=<?=$type?>&id=<?=$items[$i]['id']?>" title="" class="smallButton tipS" original-title="Sửa lang"><img src="./images/icons/dark/pencil.png" alt=""></a>

                        <a href="index.php?com=lang&act=delete&type=<?=$type?>&id=<?=$items[$i]['id']?>" onClick="if(!confirm('Xác nhận xóa')) return false;" title="" class="smallButton tipS" original-title="Xóa bài viết"><img src="./images/icons/dark/close.png" alt=""></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</form>
<div class="paging"><?=$paging?></div>