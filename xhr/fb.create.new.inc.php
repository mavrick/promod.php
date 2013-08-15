<?php

// mavrick.id.au

?>
<div id="fb_new_preset_form">
<div class="info">
    Select a preset or create a new custom ruleset using the default values.
</div>
<div class="clear"></div>
<div class="item">
    <strong><label for="fb_new_preset_selection" class="label">Preset:</label></strong><br />
    <select name="fb_new_preset_selection" id="fb_new_preset_selection" lang="en" xml:lang="en" class="web20">
    <option value="">Please Select</option>
    <?php
    
    $sql = "SELECT * FROM `preset` ORDER BY `preset_title`";
    $query 	= mysql_query($sql, $conn) or die(fb_mysql_error(mysql_error(),__LINE__,__FILE__));
    while($row = mysql_fetch_assoc($query)) 
    {    
    ?>
    <option value="<?=$row['preset_id']?>"><?=$row['preset_title']?></option>
    <?php } ?>
    </select>
</div>
<div style="clear:both;"></div>
<div class="item">
	<img src="/images/btn/next.gif" title="Next" alt="Next" border="0" id="fb_new_preset_next" class="fb_btn" style="float:left;" />
    <img src="/images/btn/new.gif" title="New" alt="New" border="0" id="fb_new_preset_new" class="fb_btn" style="float:right;" />
</div>
</div>
<div style="clear:both;"></div>
<script language="javascript" type="text/javascript">
//<![CDATA[
$('overlayTitle').setHTML('Create a new ruleset');
$('fb_new_preset_next').addEvent('click',function() 
{
	
	var presetID = $('fb_new_preset_selection').getProperty('value');
	
	new Ajax(fb_root + '?xhr', {method:'post',data:Object.toQueryString({'xhr':'load:preset',ssid:fb_ssid,'presetID':presetID}),evalScripts:true,update:$('fb_contextMenu'),onRequest:function(){fb_loading(true);},onComplete:function() {
		
			new Ajax(fb_root + '?xhr', {method:'post',data:Object.toQueryString({'xhr':'create:new',ssid:fb_ssid,'context':'1','presetID':presetID}),evalScripts:true,update:$('fb_contextMenu'),onRequest:function(){fb_loading(true);}}).request();
		
		}}).request();
});
$('fb_new_preset_new').addEvent('click',function() 
{
	new Ajax(fb_root + '?xhr', {method:'post',data:Object.toQueryString({'xhr':'create:new',ssid:fb_ssid,'context':'1'}),evalScripts:true,update:$('fb_contextMenu'),onRequest:function(){fb_loading(true);}}).request();
});
//]]>
</script>