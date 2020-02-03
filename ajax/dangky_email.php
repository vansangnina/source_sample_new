<?php
	session_start();
	@define ( '_lib' , '../libraries/');	
	include_once _lib."config.php";
	include_once _lib."functions.php";
	$d = new database($config['database']);
	
	if(!empty($_POST) && isset($_POST['recaptcha_response_email'])){
	    $recaptcha_response = $_POST['recaptcha_response_email'];
	    $ch = curl_init();
		curl_setopt_array($ch, array(
		    CURLOPT_URL => $api_url,
		    CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		    CURLOPT_CUSTOMREQUEST => "POST",
		    CURLOPT_POSTFIELDS => array(
		       'secret' => $secret_key,
		       'response' => $recaptcha_response,
		    ) 
		));
		$recaptcha = curl_exec($ch);
		curl_close($recaptcha);
	    $recaptcha = json_decode($recaptcha);
	    if($recaptcha->score >= 0.5 && $recaptcha->action=='email') {
			$d->reset();
			$d->query("select id from #_newsletter where email='".$_POST['email']."'");
			if($d->num_rows() > 0){
				echo 1;
			}else{
				$data_email['email'] = $d->escape_str($_POST['email']);
				$data_email['ngaytao'] = time();

				$d->reset();
				$d->setTable('newsletter');
				$idInsert = $d->insert($data_email);
				if($idInsert>0)
					echo 0;
				else
					echo 2;
			}
		}else{
			echo 3;
		}
	}
?>