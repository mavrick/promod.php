<?php

	// mavrick.id.au

	// hacking check
	if(!defined('_fb_promod')) die('Hacking Attempt by '.$_SERVER['REMOTE_ADDR']);

	/* email checker */
	if(!function_exists('checkEmail')) {
	function checkEmail($email) {
	if(eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]", $email)) {return false;}
	list($Username, $Domain) = split("@",$email);
	if(getmxrr($Domain, $MXHost)) {
	return true;
	} else {
	if(@fsockopen($Domain, 25, $errno, $errstr, 30)) {
	return true; 
	} else {
	return false; 
	}}}};

	/* fb error output */
	function fb_mysql_error($msg,$line=__LINE__,$file=__FILE__) 
	{
		global $settings, $conn, $sql;
		//$sql = "INSERT INTO `sqlErrors` (`file`,`line`,`sql`,`error`,`date`) VALUES ('".basename($file)."','".$line."','".addslashes($sql)."','".addslashes($msg)."',NOW());";
		//echo '<strong>Error:</strong> '.$sql.'<br />';
		//mysql_query($sql, $conn);
		return '<div style="width: 450px;padding: 8px;background-color: #FFCCCC;margin-top: 8px;margin-bottom: 4px;border: 1px solid #FF0000;font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px;text-decoration: none;"><strong>MySQL Error:</strong><br /><br />'.$msg.'<br /><br /><strong>Line Number:</strong> '.$line.'</div>';
	}

	function fb_permission_error($msg) 
	{
		return '<div style="width: 450px;padding: 8px;background-color: #FFCCCC;margin-top: 8px;margin-bottom: 4px;border: 1px solid #FF0000;font-family: Geneva, Arial, Helvetica, sans-serif;font-size: 12px;text-decoration: none;"><strong>System Error:</strong><br /><br />'.$msg.'</div>';
	}

?>