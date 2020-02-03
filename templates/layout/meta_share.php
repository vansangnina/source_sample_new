<?php 
	$share = '<meta property="og:url" content="'.getCurrentPageURL().'" />';
	$share .= '<meta property="og:type" content="'.$type_og.'" />';
	$share .= '<meta property="og:title" content="'.$title_bar.'" />';
	$share .= '<meta property="og:description" content="'.$description_bar.'" />';
	$share .= '<meta property="og:image" content="'.$http.$config_url.'/thumb/200x200/2/'.$upload_file.$row_detail['photo'].'" />';
	//$share .= '<meta property="og:image:width" content="200px"/>';
	//$share .= '<meta property="og:image:height" content="200px" />';
	$share .= '<meta property="og:image:alt" content="'.$title_bar.'" />';
	$share.= '<meta name="twitter:card" value="summary">';
    $share.= '<meta name="twitter:url" content="'.getCurrentPageURL().'">';
    $share.= '<meta name="twitter:title" content="'.$title_bar.'">';
    $share.= '<meta name="twitter:description" content="'.$description_bar.'">';
    $share.= '<meta name="twitter:image" content="'.$http.$config_url.'/thumb/200x200/2/'.$upload_file.$row_detail['photo'].'"/>';
    echo $share;
?>