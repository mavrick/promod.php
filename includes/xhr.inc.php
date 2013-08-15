<?php

	// mavrick.id.au

	// hacking check
	if(!defined('_fb_promod')) die('Hacking Attempt by '.$_SERVER['REMOTE_ADDR']);

	$_t = $_POST['xhr'];

	ob_get_clean();
	ob_start();

	if(strstr($_t,':')) {
		$_t = explode(':',$_t);
	}

	if(file_exists(_fb_promod_root . _seperator . 'xhr' . ($_POST['context'] ? _seperator . 'context' : false) . _seperator . 'fb.'.(is_array($_t) ? $_t[0] . '.' . $_t[1].'.inc.php' : $_t.'.inc.php'))) 
	{
		define('_fb_promod_xhr',true);
		
		// inject detection
		foreach($_POST as $k => $v) 
		{
			if(!$v||is_array($v)) continue;
			$_POST[$k] = addslashes($v);
		}

		require(_fb_promod_root . _seperator . 'xhr' . ($_POST['context'] ? _seperator . 'context' : false) . _seperator . 'fb.'.(is_array($_t) ? $_t[0] . '.' . $_t[1].'.inc.php' : $_t.'.inc.php'));
	} 
	else 
	{
		die('Bad XHR Call');
	}

	unset($_t);

?>
