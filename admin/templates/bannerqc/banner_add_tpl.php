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
});
</script>
 <?php
          if(_width_thumb < 800){
            $rong = _width_thumb;
            $cao = _height_thumb;
          } else {
            $rong = 800;
            $cao = '';
          }
      ?>
<div class="wrapper">

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
          <li><a href="index.php?com=bannerqc&act=capnhat<?php if($type!='') echo'&type='. $type;?>"><span>Quản lý <?=$title_main?></span></a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>

<form name="supplier" id="validate" class="form" action="index.php?com=bannerqc&act=save<?php if($type!='') echo'&type='. $type;?>" method="post" enctype="multipart/form-data">


<!--phan ngon ngu-->
<div class="widget">
<?php
 if($config_multi_lang=='true') {?>
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
  <div class="formRow" >
      <label>Tải banner :</label>
      <div class="formRight">
              <input type="file" id="file_<?=$key?>" name="file_<?=$key?>" />
        <img src="./images/question-button.png" alt="Upload hình" class="icon_question tipS" original-title="Tải hình ảnh (ảnh JPEG, GIF , JPG , PNG)">
        <div class="note"> width : <?php echo WIDTH_THUMB*$ratio_;?> px , Height : <?php echo HEIGHT_THUMB*$ratio_;?> px </div>
      </div>
      <div class="clear"></div>
    </div>
    <?php if($item['thumb_'.$key]!=''){ ?>
    <div class="formRow">
      <label><?=$title_main?> Hiện Tại :</label>
      <div class="formRight">
      
      <div class="mt10">
         <object width="<?=$rong?>" height="<?=$cao?>"  codebase="http://active.macromedia.com/flash4/cabs/swflash.cab#version=4,0,0,0" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
              <param NAME="_cx" VALUE="13414">
              <param NAME="_cy" VALUE="6641">
              <param NAME="FlashVars" VALUE>
              <param NAME="Movie" VALUE="<?=UPLOAD_IMAGE.$item['thumb_'.$key]?>">
              <param NAME="Src" VALUE="<?=UPLOAD_IMAGE.$item['thumb_'.$key]?>">
              <param NAME="Quality" VALUE="High">
              <param NAME="AllowScriptAccess" VALUE>
              <param NAME="DeviceFont" VALUE="0">
              <param NAME="EmbedMovie" VALUE="0">
              <param NAME="SWRemote" VALUE>
              <param NAME="MovieData" VALUE>
              <param NAME="SeamlessTabbing" VALUE="1">
              <param NAME="Profile" VALUE="0">
              <param NAME="ProfileAddress" VALUE>
              <param NAME="ProfilePort" VALUE="0">
              <param NAME="AllowNetworking" VALUE="all">
              <param NAME="AllowFullScreen" VALUE="false">
              <param name="scale" value="ExactFit">
             <embed src="<?=UPLOAD_IMAGE.$item['thumb_'.$key]?>" quality="High" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" width="<?=$rong?>" height="<?=$cao?>" scale="ExactFit"></embed>
            </object>
      </div>
      </div>
      <div class="clear"></div>
    </div>

    <?php } ?>

    
</div><!--lang-->
<?php } ?>


    <?php if($links_=='true'){?>
        <div class="formRow">
            <label>Link liên kết:</label>
            <div class="formRight">
                <input type="text" id="code_pro" name="link" value="<?=$item['link']?>"  title="Nhập link liên kết cho hình ảnh" class="tipS" />
            </div>
            <div class="clear"></div>
        </div>
        <?php }  ?>
      <?php if($config_hienthi=='true'){?>
        <div class="formRow">
          <label>Hiển thị : <img src="./images/question-button.png" alt="Chọn loại" class="icon_que tipS" original-title="Bỏ chọn để không hiển thị danh mục này ! "> </label>
          <div class="formRight">
         
            <input type="checkbox" name="hienthi" id="check1" value="1" <?=(!isset($item['hienthi']) || $item['hienthi']==1)?'checked="checked"':''?> />
          </div>
          <div class="clear"></div>
        </div>
        <?php } ?>


      <div class="formRow">
      <div class="formRight">
              <input type="submit" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
      </div>
      <div class="clear"></div>
    </div>


</div>
<!--end phan ngon ngu-->


  

  
</form></div>