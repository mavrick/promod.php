window.addEvent('domready',function() 
{
	new Ajax(fb_root + '?xhr', 
		{
			method:'post',data:Object.toQueryString({'xhr':'scripts',ssid:fb_ssid}),evalScripts:true,update:$('fb_scripts')
		}
	).request();
	
	$$('.menuItem').addEvent('mouseover',function() 
	{
		this.addClass('over');
	}).addEvent('mouseout',function() 
	{
		this.removeClass('over');
	});
});