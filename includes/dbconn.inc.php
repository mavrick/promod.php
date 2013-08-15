<?php

	// mavrick.id.au

	// hacking check
	if(!defined('_fb_promod')) die('Hacking Attempt by '.$_SERVER['REMOTE_ADDR']);

	// database connection details
	$settings['hostname'] = _DBHOST;
	$settings['username'] = _DBUSER;
	$settings['password'] = _DBPASSWORD;
	$settings['database'] = _DBNAME;

	/* make connection to database */
	$conn 	= mysql_connect($settings['hostname'], $settings['username'], $settings['password']) or die(fb_mysql_error(mysql_error(),__LINE__,__FILE__));
	$db 	= mysql_select_db($settings['database'], $conn) or die(fb_mysql_error(mysql_error(),__LINE__,__FILE__));

	/* set database to utf8 */
	$sql 	= "SET NAMES utf8";
	$query 	= mysql_query($sql, $conn) or die(fb_mysql_error(mysql_error(),__LINE__,__FILE__));

?>