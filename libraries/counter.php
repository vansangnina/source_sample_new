<?php 
    $today            =    'Hôm nay : '; 
    $yesterday        =    'Hôm qua : '; 
    $x_month        =    'Tháng này : '; 
    $x_week            =    'Tuần này : '; 
    $all            =    'Tất cả : '; 
     
    $locktime        =  15; 
    $initialvalue    =    1; 
    $records        =    500000; 
     
    $s_today        =    1; 
    $s_yesterday    =    1; 
    $s_all            =    1; 
    $s_week            =    1; 
    $s_month        =    1; 
     
    $s_digit        =    1; 
    $disp_type        =     'Mechanical'; 
     
    $widthtable        =    '60'; 
    $pretext        =     ''; 
    $posttext        =     ''; 
    $locktime        =    $locktime * 60; 
    // Now we are checking if the ip was logged in the database. Depending of the value in minutes in the locktime variable. 
    $day             =    date('d'); 
    $month             =    date('n'); 
    $year             =    date('Y'); 
    $daystart         =    mktime(0,0,0,$month,$day,$year); 
    $monthstart         =  mktime(0,0,0,$month,1,$year); 
    // weekstart 
    $weekday         =    date('w'); 
    $weekday--; 
    if ($weekday < 0)    $weekday = 7; 
    $weekday         =    $weekday * 24*60*60; 
    $weekstart         =    $daystart - $weekday; 

    $yesterdaystart     =    $daystart - (24*60*60); 
    $now             =    time(); 
    $ip                 =    $_SERVER['REMOTE_ADDR']; 
     
    $d->query("SELECT MAX(id) AS total FROM counter");
    $t = $d->fetch_array(); 
    $all_visitors     =    $t['total']; 
     
    if ($all_visitors !== NULL) { 
        $all_visitors += $initialvalue; 
    } else { 
        $all_visitors = $initialvalue; 
    } 
     
    // Delete old records 
    $temp = $all_visitors - $records; 
     
    if ($temp>0){ 
        $d->query("DELETE FROM counter WHERE id<'$temp'"); 
    } 
     
    $d->query("SELECT COUNT(*) AS visitip FROM counter WHERE ip='$ip' AND (tm+'$locktime')>'$now'");
    $vip  = $d->fetch_array(); 
    $items             =    $vip['visitip']; 
     
    if (empty($items)){ 
        $d->query("INSERT INTO counter (tm, ip) VALUES ('$now', '$ip')"); 
    } 
     
    $n                 =     $all_visitors; 
    $div = 100000; 
    while ($n > $div) { 
        $div *= 10; 
    } 

    $d->query("SELECT COUNT(*) AS todayrecord FROM counter WHERE tm>'$daystart'");
    $todayrc  = $d->fetch_array(); 
    $today_visitors     =    $todayrc['todayrecord']; 
     
    $d->query("SELECT COUNT(*) AS yesterdayrec FROM counter WHERE tm>'$yesterdaystart' and tm<'$daystart'");
    $yesrec  = $d->fetch_array(); 
    $yesterday_visitors     =    $yesrec['yesterdayrec']; 
         
    $d->query("SELECT COUNT(*) AS weekrec FROM counter WHERE tm>='$weekstart'");
    $weekrec = $d->fetch_array(); 
    $week_visitors     =    $weekrec['weekrec']; 

    $d->query("SELECT COUNT(*) AS monthrec FROM counter WHERE tm>='$monthstart'");
    $monthrec  = $d->fetch_array(); 
    $month_visitors     =    $monthrec['monthrec']; 
?>