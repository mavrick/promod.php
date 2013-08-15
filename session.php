<?php

	// mavrick.id.au

	session_start();

	if($_GET['args']) 
	{
		$_GET['args'] = explode('/',$_GET['args']);
		$tmp = array();

		foreach($_GET['args'] as $k => $v) 
		{
			if(!$v) continue;
			$fbGet[$k] = $v;
			$_GET[$v] = true;
		}
	}

	if($_POST&&($_POST['ssid']!=session_id())) die('Hacking Attempt by '.$_SERVER['REMOTE_ADDR']);
	if(array_key_exists('xhr',$_GET)&&!$_POST) die('Hacking Attempt by '.$_SERVER['REMOTE_ADDR']);

	define('_seperator','/');
	define('_fb_promod',true);
	define('_fb_promod_root',dirname(realpath(__FILE__)));

	require( dirname(realpath(__FILE__)) . _seperator . "config.php");
	require( dirname(realpath(__FILE__)) . _seperator . "includes" . _seperator . "auth.inc.php");

	$settings['userip']			= $_SERVER['REMOTE_ADDR'];
	$settings['sessionid']		= session_id();

	/* flush cache incase someone tired to output something in the config. pfft noobs */
	ob_get_clean();
	ob_start();

?>