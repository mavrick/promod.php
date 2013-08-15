<?php

	// mavrick.id.au

	// hacking check
	if(!defined('_fb_promod')) die('Hacking Attempt by '.$_SERVER['REMOTE_ADDR']);

	// reset settings just incase
	$settings = array();

	// requirements
	require( dirname(realpath(__FILE__)) . _seperator . "functions.inc.php");
	require( dirname(realpath(__FILE__)) . _seperator . "dbconn.inc.php");

	// xhr requests
	if(array_key_exists('xhr',$_GET)) 
	{
		require( dirname(realpath(__FILE__)) . _seperator . "xhr.inc.php");
		die;
	}

?>