<script language="javascript" type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js?render=<?=$site_key?>"></script>
<script>
    grecaptcha.ready(function () {
      <?php if($com=='lien-he' || $template=='index'){ ?>
        grecaptcha.execute('<?=$site_key?>', { action: 'contact' }).then(function (token) {
            var recaptchaResponseContact = document.getElementById('recaptchaResponseContact');
            recaptchaResponseContact.value = token;
        });
      <?php } ?>
      <?php if($com=='dang-ky'){ ?>
        grecaptcha.execute('<?=$site_key?>', { action: 'register' }).then(function (token) {
            var recaptchaResponseRegister = document.getElementById('recaptchaResponseRegister');
            recaptchaResponseRegister.value = token;
        });
      <?php } ?>
      <?php if($com=='thanh-toan'){ ?>
        grecaptcha.execute('<?=$site_key?>', { action: 'pay' }).then(function (token) {
            var recapchaPay = document.getElementById('recapchaPay');
            recapchaPay.value = token;
        });
      <?php } ?>
        grecaptcha.execute('<?=$site_key?>', { action: 'email' }).then(function (token) {
            var recaptchaResponseEmail = document.getElementById('recaptchaResponseEmail');
            recaptchaResponseEmail.value = token;
        });
    });
</script>
<script type="text/javascript" src="js/lazyload.min.js"></script>
<script>
  var myLazyLoad = new LazyLoad({
    elements_selector: ".lazy"
  });
</script>
<script type="text/javascript" src="js/owl.carousel.min.js"></script>
<script async src="js/my_js/script_menu_top.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery.mmenu.all.min.js"></script>
<?php include_once 'js/temp/js_backto_top.php'; ?>
<script  type="text/javascript">
  $("#menu_bootstrap").mmenu({
   "extensions": [
   "pagedim-black"
   ]
 });
  var api_mmenu=$("#menu_bootstrap").data('mmenu');
  api_mmenu.bind('opened', function () {
    $('#btn_menu_bootstrap').addClass('move_btn_bootstrap');
  });
  api_mmenu.bind('closed', function () {
    $('#btn_menu_bootstrap').removeClass('move_btn_bootstrap');
  });
  $(window).scroll(function(event) {
    if($(window).scrollTop() > $('#header').height()){
      $('#menu').addClass('fixed');
    }else{
      $('#menu').removeClass('fixed');
    }
  });
</script>
<!--end-->
<script type="text/javascript">
  $(document).ready(function() {
    $('#frm_timkiem').submit(function(){
        var str = "";
        $('.txt').each(function(index, el) {
          if($(this).val()!=''){
            str+='&'+$(this).attr('name')+'=';
            str+=$(this).val();
          }
        });
        window.location.href='tim-kiem'+str;
        return false;
    });
    
  });
</script>
<?php if($source=='product' || $template=='index' || $com=='tim-kiem'){ ?>
  <script type="text/javascript" src="js/jquery-ui.min.js"></script>
  <script type="text/javascript">
    function flyToElement(flyer, flyingTo) {
      var $func = $(this);
      var flyerClone = $(flyer).clone();
      $(flyerClone).css({
        position: 'absolute',
        top: $(flyer).offset().top + "px",
        left: $(flyer).offset().left + "px",
        opacity: 1,
        'z-index': 1000
      }).appendTo($('body'));
      var gotoX = $(flyingTo).offset().left;
      var gotoY = $(flyingTo).offset().top;
      $(flyerClone).animate({
        opacity: 0.4,
        left: gotoX,
        top: gotoY,
        width: $(flyingTo).width(),
        height: $(flyingTo).height()
      }, 700,
      function () {
        $(flyerClone).remove();
      });
    }
    function addtocart(pid,sl,action){
       $.ajax({
         url: 'ajax/add_giohang.php',
         type: 'POST',
         dataType: 'json',
         data: {pid:pid,sl:sl},
       })
       .done(function(result) {
            if(action==1){
             window.location.href='gio-hang';
           }else{
            flyToElement(result.img, $('#numcart'));
            $('#numcart').text(result.sl);
          }
        })
       .fail(function() {
         console.log("error");
       });
    }
  </script>
  
<?php } ?>
<!--end-->
<?php if($template=='product_detail'){ ?>
  <script type="text/javascript" src="js/magiczoomplus.js"></script> 
  <script type="text/javascript" src="js/temp/js_tab.js"></script>
  <script type="text/javascript">
    var owl = $("#owl_img_detail");
    owl.owlCarousel({
      rtl:false,
      loop:false,
      margin:1,
      dots:false,
      nav:false,
      responsive:{
        0:{
          items:4
        },
        600:{
          items:5
        },
        1000:{
          items:6
        }
      }
    });
    $(".next_sub_detail").click(function(){
      owl.trigger('next.owl');
    });
    $(".prev_sub_detail").click(function(){
      owl.trigger('prev.owl');
    });
  </script>
  <script type="text/javascript">
    $('#minus').click(function(event) {
     var number = $('.amount').val();
     if(number > 1) number = parseInt(number) - 1;
     else number = 1;
     $('.amount').val(number);
     return false;
   });
    $('#plus').click(function(event) {
     var number = $('.amount').val();
     number = parseInt(number) + 1;
     $('.amount').val(number);
     return false;
   });
 </script>
<?php } ?>
<?php if($com=='dang-ky' || $com=='thanh-toan'){ ?>
<script type="text/javascript">
  $('#tinhthanh').change(function(event) {
    $('#quanhuyen').load('ajax/load_quanhuyen.php',{id:$(this).val()});
  });
</script>
<?php } ?>
<?php if($com=='gio-hang'){ ?>
  <script type="text/javascript" src="js/temp/js_giohang.js"></script>
<?php } ?>
<?php if($com=='thanh-toan'){?>
  <script type="text/javascript">
    var id = $('.radio input[name=httt]:checked').val();
    $('.radio input[name=httt]').click(function() {
      id = $(this).val();
      $('div.content_httt').removeClass('active');
      $('#httt'+id).addClass('active');
    });
  </script>
<?php } ?>

<?php if($template=='index'){ ?>
<script>
$(document).ready(function() {
    $('#slider').owlCarousel({
        rtl:false,
        loop:false,
        margin:0,
        animateOut: 'fadeOut',
        nav:false,
        rewind:true,
        lazyLoad: true,
        autoplay:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true,
        items:1
    });
});
</script>
<script type="text/javascript">
  $('#news_owl').owlCarousel({
    rtl:false,
    loop:false,
    margin:45,
    nav:false,
    rewind:true,
    autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    responsive:{
      0:{
        items:1
      },
      600:{
        items:2
      },
      1000:{
        items:3
      }
    }
  });
  $('#product_owl').owlCarousel({
    rtl:false,
    loop:false,
    margin:30,
    nav:false,
    rewind:true,
    autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    responsive:{
      0:{
        margin:15,
        items:2
      },
      500:{
        margin:20,
        items:2
      },
      768:{
        margin:20,
        items: 3
      },
      1000:{
        margin:20,
        items:4
      },
      1028:{
        items:4
      }
    }
  });

</script>
<script type="text/javascript">
  $('#frmDK').submit(function(event) {
   $.ajax({
     url: 'ajax/ykienkhachhang.php',
     type: 'POST',
     data: $('#frmDK').serialize(),
   })
   .done(function(result) {
    if(result==1){
      alert("Gửi thông tin thành công!");
      $("#frmDK")[0].reset();
    }else if(result==0){
      alert("Hệ thống lỗi, thử lại sau!");
    }else if(result==2){
      alert("Hệ thống cho thấy bạn đang spam dữ liệu");
    }
  })
   .fail(function() {
     console.log("error");
   });
   return false;
 });
</script>
<?php } ?>
<script type="text/javascript">
  $(document).ready(function() {
    $('.frmEmail').submit(function(event) {
      $.ajax ({
        type: "POST",
        url: "ajax/dangky_email.php",
        data: $('.frmEmail').serialize(),
        success: function(result) { 
          if(result==0){
            $('.frmEmail')[0].reset();
            alert('Đăng ký thành công ! ');
          }else if(result==1){
            $('.frmEmail')[0].reset();
            alert('Email đã được đăng ký ! ');
          }else if(result==2){
            alert(' ! Đăng ký không thành công . Vui lòng thử lại ');
          }else{
            alert(' ! Mã xác nhận không đúng ');
          }
        }
      });
      return false;
    });
  });
</script>

<?php if($template=='index'){ ?>
<script>
  var fired = false;
  window.addEventListener("scroll", function(){
    if ((document.documentElement.scrollTop != 0 && fired === false) || (document.body.scrollTop != 0 && fired === false)) {
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.async=true;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));

      fired = true;
    }
  }, true);
</script>
<?php }else{ ?>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.async=true;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
</script>
<?php } ?>