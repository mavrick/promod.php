<?php

// mavrick.id.au

// hacking check
if(!defined('_fb_promod')) die('Hacking Attempt by '.$_SERVER['REMOTE_ADDR']);

$presetID = $_POST['presetID'];

?>
<script language="javascript" type="text/javascript">
//<![CDATA[

<?php

if($presetID) {
	
	$sql = "SELECT * FROM `config` WHERE `config_preset_id` = '".$presetID."'";
	$query 	= mysql_query($sql, $conn) or die(fb_mysql_error(mysql_error(),__LINE__,__FILE__));
	
	if(mysql_num_rows($query)) 
	{		
		$row = mysql_fetch_assoc($query);		
		$settingsID = $row['config_settings_id'];
		
		$sql = "SELECT * FROM `settings` WHERE `settings_id` = '".$settingsID."'";
		$query 	= mysql_query($sql, $conn) or die(fb_mysql_error(mysql_error(),__LINE__,__FILE__));
		$field_value = mysql_fetch_assoc($query);
	} 
	else 
	{	
		$presetID = false;		
	}
	
}

$sql = "SELECT `field_name` FROM `field`";
$query 	= mysql_query($sql, $conn) or die(fb_mysql_error(mysql_error(),__LINE__,__FILE__));
$rows = array();
while($row = mysql_fetch_assoc($query)) 
{ 
	$rows[] = $row;
}

foreach($rows as $k => $row) 
{
	$value = '';
	
	if($presetID) 
	{		
		$value = $field_value[$row['field_name']];		
	}

?>
fields.<?=$row['field_name']?> = '<?=$value?>';
<?php
	
}

?>

//]]>
</script>