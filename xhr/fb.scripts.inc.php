<?php

// mavrick.id.au

// hacking check
if(!defined('_fb_promod')) die('Hacking Attempt by '.$_SERVER['REMOTE_ADDR']);

$presetID = $_POST['presetID'];

?>
<script language="javascript" type="text/javascript">
//<![CDATA[

var fb_create_new = null,date = new Date();
var fb_continue = true;

var fields = {};

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

$sql = "SELECT `field_name`,`field_default` FROM `field`";
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
else 
{
	$value = $row['field_default'];	
}

?>
fields.<?=$row['field_name']?> = '<?=$value?>';
<?php
	
}

?>

function clearOptionList(selectId)
{
	$(selectId).empty();
}

function pauseComp(millis)
{
	date = new Date();
	var curDate = null;
	do { var curDate = new Date(); }
	while(curDate-date < millis);
} 

function addOption(selectId, txt, val, defSel){
	var e = new Element('option',{'value':val,'title':txt}).injectInside($(selectId)).setHTML(txt);
	if(defSel) e.setProperty('selected','selected');
}

function deleteOption(id,i){

	var items = $(id).length;
	if(items>0)
	{
		$(id).options[i] = null;
	}
}


function fb_loading(s,title) 
{	
	if(s) 
	{		
		$('fb_overlay').setOpacity(0.7).setStyle('display','block');
		$('fb_overlayMsg').setStyle('display','block');
		$('overlayTitle').setHTML((title ? title : 'Loading')); fb_overlayMsg_adjust();
		$('overlayMiddle').setHTML('<div style="padding:6px;text-align:center;margin:0 auto;"><strong>Loading...</strong></div>');
	} 
	else 
	{		
		$('fb_overlay').fireEvent('click');		
	}
}

$('fb_load_ruleset').addEvent('click',function()
{
	// derp?
});

$('fb_create_new').addEvent('click',function()
{
	if(fb_create_new) fb_create_new.cancel();
	fb_create_new = new Ajax(fb_root + '?xhr', {method:'post',data:Object.toQueryString({'xhr':'create:new',ssid:fb_ssid}),evalScripts:true,update:$('overlayMiddle'),onRequest:function(){fb_loading(true);},onComplete:function(){fb_overlayMsg_adjust();}}).request();
});

new Asset.javascript('/js/fb_box.js?=' + date.getTime(), {id: 'fb_box_js'});
new Asset.javascript('/js/tooltip.js?=' + date.getTime(), {id: 'fb_tooltip_js'});
new Asset.css('/css/fb_box.css?=' + date.getTime(), {id: 'fb_box_css', title: 'fb_box_css'});
new Asset.css('/css/tooltip.css?=' + date.getTime(), {id: 'fb_tooltip_css', title: 'fb_tooltip_css'});

$$('.menuItem').addEvent('mouseover',function() 
{
	this.addClass('over');
}).addEvent('mouseout',function() 
{
	this.removeClass('over');
});

$$('.fb_field_item').addEvent('change',function() 
{
	fb_continue = false;
});

//]]>
</script>
<div class="fb_overlay" id="fb_overlay"></div>
<div class="fb_gen_overlay" id="fb_overlayMsg">
<div class="fb_container">
<div class="item">
<div class="header">
<div class="left"></div>
<div class="title" title="" id="overlayTitle"></div>
<div class="right"></div></div>
<div class="middle" rel="middle" id="overlayMiddle">
</div>
<div class="bottom">
<div class="left"></div>
<div class="right"></div>
</div></div></div></div>