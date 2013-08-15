<?php

// mavrick.id.au

$lvl = ($_POST['lvl'] ? $_POST['lvl'] : '1');
$nlvl = $lvl + 1;
$plvl = $lvl - 1;
$groupID = ($_POST['id'] ? $_POST['id'] : false);
$presetID = ($_POST['presetID'] ? $_POST['presetID'] : false);

if($_POST['fb_process']) 
{

	ob_get_clean();
	ob_start();
	
	sleep(1);
	
	$sql = "SELECT * FROM `field` WHERE `field_group_id` = '".$groupID."'";
	echo $sql;
	$query 	= mysql_query($sql, $conn) or die(fb_mysql_error(mysql_error(),__LINE__,__FILE__));
	if(mysql_num_rows($query)) 
	{
		
	?><script language="javascript" type="text/javascript">
//<![CDATA[
    <?php
		
	$rows = array();
	while($row = mysql_fetch_assoc($query)) 
	{ 
		$rows[] = $row;
	}
	
	foreach($rows as $row) 
	{
	
	?>
fields.<?=$row['field_name']?> = '<?=$_POST[$row['field_name']]?>'; 
    <?php
	
	}
	
	?>
fb_continue = true;
//]]>
</script><?php
	
	}
	
	die(ob_get_clean());
	
}

$sql = "SELECT * FROM `field` WHERE `field_group_id` = '".$groupID."' ORDER BY `field_order`";
$query 	= mysql_query($sql, $conn) or die(fb_mysql_error(mysql_error(),__LINE__,__FILE__));
$rows = array();
while($row = mysql_fetch_assoc($query)) 
{ 
	$rows[] = $row;
}

// breadcrumb
$breadcrumb = '';
$continue = true;
$gID = $groupID;
$title = false;
$desc = false;
while($continue == true) 
{
	
	$sql = "SELECT * FROM `group` WHERE `group_id` = '".$gID."'";
	$query 	= mysql_query($sql, $conn) or die(fb_mysql_error(mysql_error(),__LINE__,__FILE__));
	if(!mysql_num_rows($query)) $continue = false;
	$group = mysql_fetch_assoc($query);
	
	if(!$title) $title = $group['group_title'];
	if(!$desc) $desc = $group['group_description'];
	
	$breadcrumb = '<strong>'.$group['group_title'] . '</strong> : ' . $breadcrumb;
	$gID = $group['group_group_id'];

}

$breadcrumb = '<strong>Home</strong> ' . $breadcrumb;
	
?>
<div class="fb_loader" id="fb_loader_<?=$groupID?>"></div>
<div class="info">
<?=$breadcrumb?>
</div>
<div class="clear"></div>
<div class="item">
<strong><?=$title?></strong> <?php if($desc) { ?><span class="info">(<?=$desc?>)</span><?php } ?>
</div>
<div class="clear"></div>
<?php

if(!empty($rows)) {
	
?>
<div id="fb_form_<?=$groupID?>">
<table class="fb_tbl">
<thead>
<tr>
    <th width="150">Field</th><th width="150">Value</th><th width="1"></th><th width="50">Rule</th><th>Description</th>
</tr>
</thead>
<tbody>
<?php

if($presetID) 
{	
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

foreach($rows as $k => $row) 
{	
	if($presetID) 
	{	
		$value = $field_value[$row['field_name']];		
	} 
	else 
	{		
		$value = $row['field_default'];		
	}

?>
<tr class="<?=(($k&1) ? 'odd' : 'even')?>">
    <td><label for="fb_field_<?=$row['field_name']?>"><strong><?=$row['field_title']?></strong></label></td>
    <?php if($row['field_type']=='text') { ?>
    <td><input type="text" name="<?=$row['field_name']?>" id="fb_field_<?=$row['field_name']?>" rel="<?=$row['field_id']?>" class="fb_field_item<?=($row['field_readonly'] ? ' readonly' : false)?>" value="<?=$value?>"<?=($row['field_readonly'] ? ' disabled="disabled" title="Unable to Edit"' : false)?> /></td>
    <?php } elseif($row['field_type']=='yesno') { ?>
    <td>
    <select name="<?=$row['field_name']?>" id="fb_field_<?=$row['field_name']?>" rel="<?=$row['field_id']?>" class="fb_field_item<?=($row['field_readonly'] ? ' readonly' : false)?>" lang="en" xml:lang="en" style="width:98%;"<?=($row['field_readonly'] ? ' disabled="disabled" title="Unable to Edit"' : false)?>>
    	<option value="1"<?=($value=='1' ? ' selected="selected"' : false)?>>Yes</option>
        <option value="0"<?=($value!='1' ? ' selected="selected"' : false)?>>No</option>
    </select>
    </td>
    <?php } elseif($row['field_type']=='select') { ?>
    <td>
    <select name="<?=$row['field_name']?>" id="fb_field_<?=$row['field_name']?>" rel="<?=$row['field_id']?>" class="fb_field_item<?=($row['field_readonly'] ? ' readonly' : false)?>" lang="en" xml:lang="en" style="width:98%;"<?=($row['field_readonly'] ? ' disabled="disabled" title="Unable to Edit"' : false)?>>
    	<?php
		
		$data = ($row['field_select_data'] ? unserialize($row['field_select_data']) : false);
		
		// static
		if($data['static']) 
		{
		
			foreach($data['static'] as $dk => $dv) 
			{
				
				?>
                <option value="<?=$dk?>"<?=($value==$dk ? ' selected="selected"' : false)?>><?=$dv?></option>
                <?php
				
			}
		
		// dynamic
		} 
		else 
		{
		
			$sql = "SELECT * FROM `select` WHERE `select_field_id` = '".$row['field_id']."' ORDER BY `select_order`";
			$query 	= mysql_query($sql, $conn) or die(fb_mysql_error(mysql_error(),__LINE__,__FILE__));
			while($select = mysql_fetch_assoc($query)) 
			{
			
				?>
                <option value="<?=$select['select_value']?>" rel="<?=$select['select_field_name']?>"<?=($value==$select['select_value'] ? ' selected="selected"' : false)?>><?=$select['select_title']?></option>
                <?php
				
			}
			
		}
		
		?>
    </select>
    </td>
    <?php } ?>
    <td>
    <?php
	
	$tooltip = false;
	
	if($row['field_type']=='yesno') 
	{
		
		$tooltip = ($row['field_default'] ? 'Yes' : 'No');
		
	} 
	else 
	{
	
		$tooltip = $row['field_default'];
		
	}
	
	?>
    <img src="help.png" class="fb_help fb_btn" tooltip="Default Value:<br /><strong><?=addslashes($tooltip)?></strong><?php if($row['field_type']!='select'&&!$row['field_select_data']&&!$row['field_readonly']) { ?><br /><br />Click to load default!" rel="fb_field_<?=$row['field_name']?>" default="<?=$row['field_default']?><?php } ?>" />
    </td>
    <td><?=$row['field_rule']?></td>
    <td><?=$row['field_description']?></td>
</tr>
<?php
	
}

?>
</tbody>
</table>
<input type="hidden" name="xhr" value="field:array" />
<input type="hidden" name="ssid" value="<?=session_id()?>" />
<input type="hidden" name="fb_process" value="1" />
<input type="hidden" name="presetID" value="<?=$presetID?>" />
<input type="hidden" name="id" value="<?=$groupID?>" />
</div>
<div class="clear"></div>
<div class="item">
<img src="/images/btn/save.gif" title="Save" alt="Save" id="fb_save_<?=$groupID?>" class="fb_btn" style="float:right;" />
<div style="clear:both;"></div>
</div>
<div class="clear"></div>
<?php } else { ?>
<div class="info">
<strong>Select from additional menu items above!</strong>
</div>
<?php } ?>
<script language="javascript" type="text/javascript">
//<![CDATA[

$$('.fb_help').each(function(el) 
{
	el.addEvent('mouseover',function(event) 
	{
		tooltip(this, this.getProperty('tooltip'), 200, event, this.getProperty('rel'));
	}).addEvent('click',function() 
	{
		if(this.getProperty('rel')&&this.getProperty('default')) 
		{
			if($(this.getProperty('rel')).getProperty('value')!=this.getProperty('default')) 
			{
				if(confirm('Are you sure you want to reset to the default value?')) { $(this.getProperty('rel')).setProperty('value',this.getProperty('default')); fb_continue = false; };
			}
		}
	});
});

<?php

foreach($rows as $k => $row) 
{

?>
if((fields.<?=$row['field_name']?>!=$('fb_field_<?=$row['field_name']?>').getProperty('value'))&&(fields.<?=$row['field_name']?>)) {
	$('fb_field_<?=$row['field_name']?>').setProperty('value',fields.<?=$row['field_name']?>);
}
<?php

if($row['field_type']=='select'&&!$row['field_select_data']) 
{
	
	$sql = "SELECT * FROM `select` WHERE `select_field_id` = '".$row['field_id']."' ORDER BY `select_order`";
	$query 	= mysql_query($sql, $conn) or die(fb_mysql_error(mysql_error(),__LINE__,__FILE__));
	while($select = mysql_fetch_assoc($query)) 
	{

?>
if(fields.<?=$select['select_field_name']?>=='0') 
{
	$('fb_field_<?=$row['field_name']?>').getChildren().each(function(el) 
	{
		if(el.getProperty('rel')=='<?=$select['select_field_name']?>') 
		{ 
			el.remove();
			$('fb_field_<?=$row['field_name']?>').fireEvent('change');
			if((fields.<?=$row['field_name']?>!=$('fb_field_<?=$row['field_name']?>').getProperty('value'))&&(fields.<?=$row['field_name']?>)) 
			{
				fb_continue = false;	
			}
		}
	});
}
<?php

	}
	
}
	
}

?>

$$('.fb_field_item').addEvent('change',function() 
{
	fb_continue = false;
});

if($('fb_save_<?=$groupID?>')) 
{	
	$('fb_save_<?=$groupID?>').addEvent('click',function() 
	{		
		new Ajax(fb_root + '?xhr', {method:'post',data:$('fb_form_<?=$groupID?>').toQueryString(),onRequest:function(){$('fb_loader_<?=$groupID?>').setStyle('display','block');},onComplete:function(){$('fb_loader_<?=$groupID?>').setStyle('display','none');},evalScripts:true}).request();
	});
}

//]]>
</script>