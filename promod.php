<?php

// mavrick.id.au

ob_start();

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

require("session.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="en-au" />
<meta name="copyright" content="2008, mavrick.id.au" />
<meta name="author" content="mavrick.id.au" />
<meta name="owner" content="mavrick.id.au" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<title>Call of Duty 4: ProMod Custom Ruleset Generator v1.0</title>
<link href="/css/promod.css" rel="stylesheet" type="text/css" media="screen" />
<link href="/css/tooltip.css" rel="stylesheet" type="text/css" media="screen" />
<script language="javascript" type="text/javascript">
//<![CDATA[
var fb_ssid = '<?=session_id()?>';
var fb_root = '<?=$_SERVER['PHP_SELF']?>';
//]]>
</script>
</head>
<body>
<div align="left" id="fb_postForm">
<h1>Call of Duty 4: ProMod Custom Ruleset Generator v1.0</h1>
<div class="info">Compatible for versions 2.06 and above</div><br />
<div class="fb_gen" id="fb_top">
<div class="fb_container">
<div class="item">
<div class="header">
<div class="left"></div>
<div class="title" title="Current Version: ProMod Live 2.07">Current Version: ProMod Live 2.07</div>
<div class="right"></div>
</div>
<div class="contextMenu" id="fb_contextMenu">
<div class="left"></div>
<div class="right"></div>
<div class="menuItem" style="float:right;" title="Load Saved Ruleset">
<div class="right"></div>
<div class="left"></div>
<div class="btn" id="fb_load_ruleset">Load Saved Ruleset</div>
</div> 
<div class="divider" style="float:right;"></div>
<div class="menuItem" style="float:right;" title="Create New Ruleset">
<div class="right"></div>
<div class="left"></div>
<div class="btn" id="fb_create_new">Create New Ruleset</div>
</div> 
</div>
<div class="middle" rel="middle" id="fb_content">
<div>
<div class="info">To begin select from <strong>Create New Ruleset</strong> or <strong>Load Saved Ruleset</strong>.</div>
</div>
</div>
<div class="bottom">
<div class="left"></div>
<div class="right"></div>
</div>
</div>
</div>
</div>
</div>
<script language="javascript" type="text/javascript" src="/js/mootools.js"></script>
<script language="javascript" type="text/javascript" src="/js/promod.js"></script>
<div id="fb_scripts"></div>
</body>
</html>
<?php ob_end_flush(); ?>