<div class="wrapper">

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
          <li><a href="index.php?com=bannerqc&act=capnhat<?php if($type!='') echo'&type='. $type;?>"><span>Quản lý banner</span></a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>

<form name="supplier" id="validate" class="form" action="index.php?com=bannerqc&act=save_banner_giua<?php if($type!='') echo'&type='. $type;?>" method="post" enctype="multipart/form-data">
  <div class="widget">

    <div class="title chonngonngu">
    <ul>
      <li><a href="vi" class="active tipS validate[required]" title="Chọn tiếng việt "><img src="./images/vi.png" alt="" class="tiengviet" />Tiếng Việt</a></li>
      <li><a href="en" class="tipS validate[required]" title="Chọn tiếng anh "><img src="./images/en.png" alt="" class="tienganh" />Tiếng Anh</a></li>
    </ul>
    </div>  

    <div class="formRow lang_hidden lang_vi active" >
      <label>Tải logo :</label>
      <div class="formRight">
              <input type="file" id="file_vi" name="file_vi" />
        <img src="./images/question-button.png" alt="Upload hình" class="icon_question tipS" original-title="Tải hình ảnh (ảnh JPEG, GIF , JPG , PNG)">
      </div>
      <div class="clear"></div>
    </div>

    <div class="formRow lang_hidden lang_vi active">
      <label>Logo Hiện Tại :</label>
      <div class="formRight">
      
      <div class="mt10">
         <object width="208" height="108"  codebase="http://active.macromedia.com/flash4/cabs/swflash.cab#version=4,0,0,0" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
              <param NAME="_cx" VALUE="13414">
              <param NAME="_cy" VALUE="6641">
              <param NAME="FlashVars" VALUE>
              <param NAME="Movie" VALUE="<?=UPLOAD_IMAGE.$item['photo_vi']?>">
              <param NAME="Src" VALUE="<?=UPLOAD_IMAGE.$item['photo_vi']?>">
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
             <embed src="<?=UPLOAD_IMAGE.$item['photo_vi']?>" quality="High" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" width="208" height="108" scale="ExactFit"></embed>
            </object>
      </div>
      </div>
      <div class="clear"></div>
    </div>

    <div class="formRow lang_hidden lang_en" >
      <label>Tải logo (Tiếng anh) :</label>
      <div class="formRight">
              <input type="file" id="file_en" name="file_en" />
        <img src="./images/question-button.png" alt="Upload hình" class="icon_question tipS" original-title="Tải hình ảnh (ảnh JPEG, GIF , JPG , PNG)">
      </div>
      <div class="clear"></div>
    </div>

    <div class="formRow lang_hidden lang_en">
      <label>Logo Hiện Tại :</label>
      <div class="formRight">
      
      <div class="mt10">
         <object width="208" height="108"  codebase="http://active.macromedia.com/flash4/cabs/swflash.cab#version=4,0,0,0" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
              <param NAME="_cx" VALUE="13414">
              <param NAME="_cy" VALUE="6641">
              <param NAME="FlashVars" VALUE>
              <param NAME="Movie" VALUE="<?=UPLOAD_IMAGE.$item['photo_en']?>">
              <param NAME="Src" VALUE="<?=UPLOAD_IMAGE.$item['photo_en']?>">
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
             <embed src="<?=UPLOAD_IMAGE.$item['photo_en']?>" quality="High" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" width="208" height="108" scale="ExactFit"></embed>
            </object>
      </div>
      </div>
      <div class="clear"></div>
    </div>

      <div class="formRow">
        <label>Kích thước : </label>
        <div class="formRight">
          <b>Rộng : 130px , Cao : 130px;</b>
        </div>
        <div class="clear"></div>
      </div>

      <div class="formRow">
      <div class="formRight">
              <input type="submit" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
      </div>
      <div class="clear"></div>
    </div>
    
  </div> 

  

  
</form></div>