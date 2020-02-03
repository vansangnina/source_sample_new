<?php

	if(count($_SESSION['cart'])==0){
		transfer("Bạn không có sản phẩm nào trong giỏ hàng",'san-pham');
	}

	$title_bar = THANHTOAN;
	$keywords_bar = $row_setting['keywords'];
	$description_bar = $row_setting['description'];

	$d->reset();
	$d->query("select ten_vi,noidung_vi,id from #_httt order by stt,id desc");
	$httt = $d->result_array();

	$d->reset();
	$d->query("select ten_$lang as ten,id from #_place_city where hienthi=1 order by id asc");
	$tinhthanh = $d->result_array();

	if($_SESSION['loginuser']){
		$d->reset();
		$d->query("select ten_$lang as ten,id from  #_place_dist where id_list='".$_SESSION['loginuser']['id_city']."'");
		$result_dist = $d->result_array();
	}


	if(!empty($_POST) && isset($_POST['recapchaPay'])){
		$recaptcha_response = $_POST['recapchaPay'];
	    $ch = curl_init();

		curl_setopt_array($ch,array(
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
	    if($recaptcha->score >= 0.5 && $recaptcha->action=='pay') {

			$userID = $_SESSION['loginuser']['id'];
		    $name_order=$_POST['hotenpay'];
			$address_order=$_POST['diachipay'];
			$phone_order=$_POST['dienthoaipay'];
			$email_order=$_POST['emailpay'];
			$content_order=$_POST['noidungpay'];

			$httt = $_POST['httt'];

			$d->reset();
			$d->query("select ten_vi from #_httt where id='".$httt."' order by stt,id desc");
			$httt_string = $d->fetch_array();

			$d->reset();
			$d->query("select ten_$lang as ten,id from #_place_city where id='".$_POST['tinhthanh']."'");
			$city_pay = $d->fetch_array();

			$d->reset();
			$d->query("select ten_$lang as ten,id from #_place_dist where id='".$_POST['quanhuyen']."'");
			$dist_pay = $d->fetch_array();

			$code_order = "DH".time();
			$phiship = 0;
			
			$address_pay = $address_order.", ".$dist_pay['ten'].", ".$city_pay['ten'];

			
			$tonggia = get_order_total();
	  
	   	
			include_once "phpMailer/class.phpmailer.php";	
			$mail = new PHPMailer();
			include LIBRARIES.'config_mailserver.php'; 
			//Thiet lap thong tin nguoi gui va email nguoi gui
			
			
			$mail->AddAddress($row_setting['email'],$row_setting['ten_'.$lang]);
			$mail->AddAddress($email_order,$row_setting['ten_'.$lang]);
			
			/*=====================================
			 * THIET LAP NOI DUNG EMAIL
	 		*=====================================*/

			//Thiết lập tiêu đề
			$mail->Subject    = '[Đơn hàng '.$row_setting['ten_'.$lang].']';
			$mail->IsHTML(true);
			//Thiết lập định dạng font chữ
			$mail->CharSet = "utf-8";	
			$body = '';
			$body .= '<div style="margin:10px 0px;font-size:15px;font-weight:bold;">Thông tin đặt hàng từ website <a href="'.$http.$config_url.'">'.$http.$config_url.'</a></div>';
			$body.='<div style="margin-bottom:5px;">Mã đơn hàng:'.$code_order.'</div>';
			$body .= '<div style="margin-bottom:5px;">Họ và tên : '.$name_order.'</div>';
			$body .= '<div style="margin-bottom:5px;">Email  : '.$email_order.'</div>';
			$body .= '<div style="margin-bottom:5px;">Điện thoại  : '.$phone_order.'</div>';
			$body .= '<div style="margin-bottom:5px;">Địa chỉ  : '.$address_pay.'</div>';
			$body .= '<div style="margin-bottom:5px;">Hình thức thanh toán  : '.$httt_string['ten_vi'].'</div>';
			$body .= '<div style="margin-bottom:5px;">Ghi chú : '.$content_order.'</div><br /><br />';
	        $body.='<table style="width:100%;color:#333;border:1px solid #e9e9e9; border-collapse: collapse;">';
			
	        	$body.='<thead>';
				$body.='<tr style="background-color: #fff;">';
				$body.='<th style="text-align:center;padding:5px;white-space:nowrap;font-size: 13px;border:1px solid #e9e9e9;">STT</th>';
				$body.='<th style="text-align:center;padding:5px;white-space:nowrap;font-size: 13px;border:1px solid #e9e9e9;">Hình ảnh</th>';
				$body.='<th style="text-align:center;padding:5px;white-space:nowrap;font-size: 13px;border:1px solid #e9e9e9;">Tên sản phẩm</th>';
				$body.='<th style="text-align:center;padding:5px;white-space:nowrap;font-size: 13px;border:1px solid #e9e9e9;">Giá</th>';
				$body.='<th style="text-align:center;padding:5px;white-space:nowrap;font-size: 13px;border:1px solid #e9e9e9;">Số lượng</th>';
				$body.='<th style="text-align:center;padding:5px;white-space:nowrap;font-size: 13px;border:1px solid #e9e9e9;">Tổng</th>';
				$body.='</tr>';
				$body.='</thead>';

				$body.='<tfoot>';
				//$body.='<tr style="border:1px solid #e9e9e9;">';
				//$body.='<td colspan="6" style="text-align:right;padding:10px 5px;font-weight: bold;color:#E53C2F;font-size: 13px;"><b>Phiship : <span class="price_all_cart">'.number_format($phiship,0, ',', '.').' đ</span></b></td>';
				//$body.='</tr>';
				$body.='<tr style="border:1px solid #e9e9e9;">';
				$body.='<td colspan="6" style="text-align:right;padding:10px 5px;font-weight: bold;color:#E53C2F;font-size: 13px;"><b>Tổng giá : <span class="price_all_cart">'.number_format(get_order_total() + $phiship,0, ',', '.').' đ</span></b></td>';
				$body.='</tr>';
				$body.='</tfoot><!--footer-->';

				$body.='<tbody>';
				
						$max=count($_SESSION['cart']);
						for ($i=0;$i<$max;$i++) { 
						#======================================
						$pid=$_SESSION['cart'][$i]['productid'];
						$q=$_SESSION['cart'][$i]['qty'];
						//$size=$_SESSION['cart'][$i]['size'];
						//$color=$_SESSION['cart'][$i]['color'];

						
						
						
				$body.='<tr style="border-bottom:1px solid #ecedef;">';
				$body.='<td style="text-align:center;">';
				$body.='<span>'.($i+1).'</span>';
				$body.='</td>';
				$body.='<td style="text-align:center;padding:5px 5px;border:1px solid #e9e9e9;">';
				$body.='<img src="'.$http.$config_url.'/'.UPLOAD_PRODUCT_L.get_thumb($pid).'" width="60" />';
				$body.='</td>';
				$body.='<td style="text-align:left;padding:5px 5px;border:1px solid #e9e9e9;">';
				$body.='<h3 class="name_p_cart" style="font-size:14px;font-weight:bold;">'.get_product_name($pid).'</h3>';
				//$body.='<p style=="display:inline-block;background:#eee;">'.get_color($color).'-'.get_size($size).'</p>';
				$body.='</td>';
				$body.='<td style="text-align:center;">';
				$body.='<div class="price_p_cart_name" style="font-size:15px;color:#f00;">'.number_format(get_price($pid,"giaban"),0, ',', '.').' đ</div>';
				$body.='</td>';
				$body.='<td style="text-align:center;padding:5px 5px;border:1px solid #e9e9e9;">';
				$body.='<div class="box_number_cart">';
				$body.='<input type="text" class="number_cart" name="product'.$pid.'" readonly="readonly" value="'.$q.'" maxlength="3" size="2" style="background:#fff;text-align:center;border-radius:2px;border:none;outline:none; padding: 5px 0px;" />';
				$body.='</div><!--box number cart-->';
				$body.='</td>';
				$body.='<td  style="text-align:center;padding:5px 5px;border:1px solid #e9e9e9;"><div class="price_p_cart" style="text-align: center; font-size: 16px; color: #43484D;">'.number_format(get_price($pid,"giaban")*$q,0, ',', '.') .' đ</div></td>';
				$body.='</tr>';
						 } //end for cart
				$body.='</tbody>';
	        
	       	$body.=' </table>';
	    	
		  	$body.='<div style="margin:10px 0px;font-size:15px;font-weight:bold;">Support information</div>';
		  	$body.='<div style="margin-bottom:5px;"> Công ty : '.$row_setting['ten_'.$lang].'</div>';
		  	$body.='<div style="margin-bottom:5px;"> Địa chỉ : '.$row_setting['diachi_'.$lang].'</div>';
		  	$body.='<div style="margin-bottom:5px;"> Email : '.$row_setting['email'].'</div>';
		  	$body.='<div style="margin-bottom:5px;"> Website : '.$http.$config_url.'/</div>';

			
			

			$order['madonhang'] = $code_order;
			$order['tinhthanh'] = (int)$city_pay['id'];
			$order['quanhuyen'] = (int)$dist_pay['id'];
			$order['phivanchuyen'] = $phiship;
			$order['hoten'] = $name_order;
			$order['dienthoai'] = $phone_order;
			$order['diachi'] = $address_order;
			$order['email'] = $email_order;
			$order['httt'] = $httt;
			$order['tonggia'] = $tonggia;
			$order['noidung'] = $content_order;
			$order['ngaytao'] = time();
			$order['trangthai'] = 1;
			$order['userID'] = $userID;
			$d->reset();
			$d->setTable("order");
			$orderId = $d->insert($order);
			if($orderId > 0){
				$max=count($_SESSION['cart']);
				for($i=0;$i<$max;$i++){
					$pid = $_SESSION['cart'][$i]['productid'];
					$q = $_SESSION['cart'][$i]['qty'];
					//$size=$_SESSION['cart'][$i]['size'];
					//$color=$_SESSION['cart'][$i]['color'];
					
					if($q==0) continue;

					$data1['id_product'] = (int)$pid;
					$data1['id_order'] = (int)$orderId;
					$data1['ten'] = get_product_name($pid);
					$data1['gia'] = get_price($pid,"giaban");
					$data1['soluong'] = (int)$q;
					//$data1['size'] = (int)$size;
					//$data1['color'] = (int)$color;
					//$data1['name_color'] = get_color($color);
					//$data1['name_size'] = get_size($size);
					$d->reset();
					$d->setTable('order_detail');
					$d->insert($data1);
				}
				unset($_SESSION['cart']);
			}
			
			$mail->Body = $body;
			if($mail->Send()){
				
				transfer("Đặt hàng thành công ! ", 'san-pham',1);
			}else{
				transfer("Hệ thống đang quá tải, thử lại sau ít phút", "dang-nhap",false);
			}
		}
	}
?>