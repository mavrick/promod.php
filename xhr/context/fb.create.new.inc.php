<?php

// mavrick.id.au

$lvl = ($_POST['lvl'] ? $_POST['lvl'] : '1');
$nlvl = $lvl + 1;
$plvl = $lvl - 1;
$groupID = ($_POST['id'] ? $_POST['id'] : false);
$presetID = ($_POST['presetID'] ? $_POST['presetID'] : false);

?>
<div class="left"></div>
<div class="right"></div>
<?php

$sql = "SELECT * FROM `group` WHERE ".($groupID ? "`group_group_id` = '".$groupID."'" : "`group_group_id` = '0'")." AND `group_enable` = '1'";
$query 	= mysql_query($sql, $conn) or die(fb_mysql_error(mysql_error(),__LINE__,__FILE__));
$rows = array();
while($row = mysql_fetch_assoc($query)) { 
$rows[] = $row;
}

foreach($rows as $k => $row) {

?>
<div class="menuItem" style="float:right;" title="<?=$row['group_title']?>">
<div class="right"></div>
<div class="left"></div>
<div class="btn fb_new_group_<?=$lvl?>" id="fb_new_group_<?=$row['group_id']?>" rel="<?=$row['group_id']?>"><?=$row['group_title']?></div>
</div> 
<?php 

if(($k+1)!=count($rows)) {

?>
<div class="divider" style="float:right;"></div>
<?php } } ?>
<script language="javascript" type="text/javascript">
//<![CDATA[
<?php 

$sql = "SELECT * FROM `group` WHERE `group_group_id` = '".$groupID."' AND `group_enable` = '1'";
$query 	= mysql_query($sql, $conn) or die(fb_mysql_error(mysql_error(),__LINE__,__FILE__));
if(mysql_num_rows($query)||!$groupID) {
	
?>
if($('fb_contextMenu_<?=$plvl?>')) {
	$('fb_contextMenu_<?=$plvl?>').removeClass('hide');
}
		
$$('.fb_new_group_<?=$lvl?>').each(function(el) {
	el.addEvent('click',function() {
		if(!fb_continue) { if(!confirm('Values have been changed and you have not saved these settings.\n\nAre you sure you want to continue?')) { return false; } else { fb_continue = true; }; };
		if(!$('fb_contextMenu_<?=$lvl?>')) {
			var fb_contextMenu = new Element('div',{'id':'fb_contextMenu_<?=$lvl?>','class':'contextMenu hide'}).injectAfter($$('.contextMenu').getLast());
		} else {
			var fb_contextMenu = $('fb_contextMenu_<?=$lvl?>');
			fb_contextMenu.empty().addClass('hide');
		}
		if($('fb_contextMenu_<?=$nlvl?>')) {
			$('fb_contextMenu_<?=$nlvl?>').remove();
		}
		new Ajax(fb_root + '?xhr', {method:'post',data:Object.toQueryString({'xhr':'field:array',ssid:fb_ssid,'lvl':'<?=($nlvl)?>','presetID':'<?=($presetID)?>','id':el.getProperty('rel')}),evalScripts:true,update:$('fb_content'),onRequest:function(){fb_loading(true,'Loading Fields');},onComplete:function() {
			
				new Ajax(fb_root + '?xhr', {method:'post',data:Object.toQueryString({'xhr':'create:new',ssid:fb_ssid,'context':'1','lvl':'<?=($nlvl)?>','presetID':'<?=($presetID)?>','id':el.getProperty('rel')}),evalScripts:true,update:$('fb_contextMenu_<?=$lvl?>'),onRequest:function(){fb_loading(true,'Loading Menu Items');}}).request();
			
			}}).request();
	});
});
<?php } else { ?>
if($('fb_contextMenu_<?=$plvl?>')) $('fb_contextMenu_<?=$plvl?>').remove();
<?php } ?>
fb_overlayClose();
<?php

if($lvl==='1') {

if($presetID) {
	
	$sql = "SELECT * FROM `config` WHERE `config_preset_id` = '".$presetID."'";
	$query 	= mysql_query($sql, $conn) or die(fb_mysql_error(mysql_error(),__LINE__,__FILE__));
	
	if(mysql_num_rows($query)) {
		
		$row = mysql_fetch_assoc($query);		
		$settingsID = $row['config_settings_id'];
		
		$sql = "SELECT * FROM `settings` WHERE `settings_id` = '".$settingsID."'";
		$query 	= mysql_query($sql, $conn) or die(fb_mysql_error(mysql_error(),__LINE__,__FILE__));
		$field_value = mysql_fetch_assoc($query);
	
	} else {
	
		$presetID = false;
		
	}
	
}

if($presetID) {

$sql = "SELECT `field_name`,`field_default` FROM `field`";
$query 	= mysql_query($sql, $conn) or die(fb_mysql_error(mysql_error(),__LINE__,__FILE__));
$rows = array();
while($row = mysql_fetch_assoc($query)) { 
$rows[] = $row;
}

foreach($rows as $k => $row) {

$value = '';

if($presetID) {
	
	$value = $field_value[$row['field_name']];
	
} else {

	$value = $row['field_default'];
	
}

?>
fields.<?=$row['field_name']?> = '<?=$value?>';
<?php
	
}

}

}

?>
//]]>
</script>