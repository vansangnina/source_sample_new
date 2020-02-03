
<form method="post" name="frm" id="frm" action="lien-he" enctype="multipart/form-data">
        <div class=" tablelienhe" style="width:100%">
        
            <div class="form-group">
                <input name="ten" type="text" class="form-control" id="ten" size="50" required="required" placeholder="<?=HOVATEN?>"/>
            </div><!--box input contact-->

            <div class="form-group">
               <input name="diachi" type="text"  class="form-control" size="50" id="diachi" required="required" placeholder="<?=DIACHI?>"/>
            </div><!--box input contact-->
         
            <div class="form-group">
               <input name="dienthoai" type="text" class="form-control" pattern="^0[0-9]{9}$" id="dienthoai" size="50" required="required" placeholder="<?=DIENTHOAI?>"/>
            </div><!--box input contact-->
              
            <div class="form-group">
                <input name="email" type="email" class="form-control" size="50" id="email" required="required" placeholder="Email"/>
            </div><!--box input contact-->
            
            <div class="form-group">
                <input name="tieude" type="text" class="form-control" id="tieude" size="50" placeholder="<?=TIEUDE?>"/>
           </div><!--box input contact-->
                
            <div class="form-group">
                <textarea name="noidung" cols="50" rows="7"  class="form-control" placeholder="<?=NOIDUNG?>"></textarea>
            </div>
            <div class="form-group">
                <input type="hidden" id="recaptchaResponseContact" name="recaptcha_response_contact">
                <input type="submit" value="<?=GUI?>" class="btn btn-success">
                <input type="reset" value="<?=LAMMOI?>" class="btn btn-default">
            </div><!--box input contact-->
    </div><!--end table lien he-->
</form>