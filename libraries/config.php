<?php 
	/**
	 * NINA Framework
	 * Vertion 1.0
	 * Author NINA Co.,Ltd. (nina@nina.vn)
	 * Copyright (C) 2015 NINA Co.,Ltd. All rights reserved
	*/
	
	if(!defined('LIBRARIES')) { die("Error"); }
	include_once LIBRARIES.'AntiSQLInjection.php';
	
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	

	$api_url     = 'https://www.google.com/recaptcha/api/siteverify';
	$site_key    = '6Lcsd5kUAAAAAGQc7N1jOh3y4usRmMaXqHySYvF3';
	$secret_key  = '6Lcsd5kUAAAAABtUZ7y-yP9_L_dlka47_bOnurZ3';
	
	$config_url = $_SERVER["SERVER_NAME"].'/source_sample';
	$config_file = "http://".$config_url."/admin";
	$config['arrayDomainSSL'] = array("yourdomainssl.com.vn");
	$config['debug'] = 1;    #Bật chế độ debug dành cho developer
	$config['lang']="vi";
	$config['email']="";
	$config['pass']="";
	$config['ip']="";
	$config['lang']= array('vi'=>'Tiếng việt');
	$config['lang_active'] = 'vi';
	$config['salt']='@#$fd_!34^';
	$config['login_name'] = $config_url;
	$config['login']['attempt'] = 5;
	$config['login']['delay'] = 15;

	define('NN_MSHĐ', 'xxxxxxW');
	define('NN_AUTHOR', 'devnina@gmail.com');

	$config['author']['MSHĐ'] = NN_MSHĐ;
	$config['author']['Email'] = NN_AUTHOR;

	$config['database']['debug'] = $config['debug'];	
	$config['database']['servername'] = 'localhost';
	$config['database']['username'] = 'root';
	$config['database']['password'] = '';
	$config['database']['database'] = 'database_source';
	$config['database']['refix'] = 'table_';

	error_reporting($config['debug']);
	
	include_once LIBRARIES."class.database.v7.php";
?>