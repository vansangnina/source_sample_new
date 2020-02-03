<HTML>
<HEAD>
<TITLE>:: Thông Báo ::</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="REFRESH" content="4.5; url=<?=$page_transfer?>">
<meta name="robots" content="noodp,noindex,nofollow" />
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/icon.css">
</HEAD>
<BODY>



<div id="alert">
	<i class="fas <?=($stt) ? 'fa-check-circle color_success' : 'fa-exclamation-triangle color_danger'?> fa-5x"></i>
	<div class="title">Thông báo</div>
	<div class="message alert <?=($stt) ? 'alert-success' : 'alert-danger'?>"><?=$showtext?></div>
	<div class="rlink">(<a href="<?=$page_transfer?>" >Click vào đây nếu không muốn đợi lâu</a>)</div>
	<div class="progress">
	  <div id="my_process_bar" class="progress-bar progress-bar-striped progress-bar-<?=($stt) ? 'success' : 'danger'?> active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
	  </div>
	</div>
</div>

</BODY>
</HTML>
<style>
	body{background:#eee}
	#alert{background:#fff;padding:20px;margin:30px auto;border-radius:3px;-webkit-box-shadow: 0px 0px 3px 0px rgba(50, 50, 50, 0.3);
-moz-box-shadow:    0px 0px 3px 0px rgba(50, 50, 50, 0.3);
box-shadow:         0px 0px 3px 0px rgba(50, 50, 50, 0.3);	

 margin-top: 100px;

text-align:center;
width:100%;
max-width:400px;

}
	#alert .fas{font-size:60px;}
	#alert .rlink{margin: 10px 0px;}
	
	
	#alert .title{    text-transform: uppercase;
    font-weight: bold;
    margin: 10px;}
    .color_success{color:#5cb85c;}
    .color_danger{color:#D9534F}

    #my_process_bar{width: 0%;-webkit-transition:all 0.3s !important;

transition:all 0.3s  !important;}
   
</style>
<script type="text/javascript">
var elem = document.getElementById("my_process_bar"); 
var pos = 0;
	setInterval(function(){
		pos+=1; 
		elem.style.width = pos + '%'; 
	},40);
</script>