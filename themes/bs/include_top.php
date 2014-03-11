<?php

header("Content-Type: text/html; charset=utf-8");

// spesifiser åpent for søkemotorer hvis ikke allerede satt
$robots = '';
if (!preg_match("~<meta.*name=(|'|\")robots~", ess::$b->page->head)) $robots = '
<meta name="robots" content="index, follow" />';

// sett opp head
ess::$b->page->head = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Hjemmesideoppmann Blindern Studenterhjem" />
<meta name="keywords" content="'.ess::$b->page->generate_keywords().'" />
<meta name="description" content="'.ess::$b->page->description.'" />
<link rel="shortcut icon" href="'.ess::$s['rpath'].'/favicon.ico" />
<link href="'.ess::$s['rpath'].'/layout/layout.css?'.@filemtime(dirname(dirname(dirname(__FILE__)))."/layout/layout.css").'" rel="stylesheet" type="text/css" />
<!--[if lte IE 8]>
<script src="'.ess::$s['rpath'].'/html5ie.js" type="text/javascript"></script>
<![endif]-->
<script type="text/javascript">
var mobile_domain ="blindern-studenterhjem.1881gomo4u.com";
// Set to false to not redirect on iPad.
var ipad = false;
// Set to false to not redirect on other tablets (Android , BlackBerry, WebOS tablets).
var other_tablets = false;
document.write(unescape("%3Cscript src=\'"+location.protocol+"//s3.amazonaws.com/me.static/js/me.redirect.min.js\' type=\'text/javascript\'%3E%3C/script%3E"));
</script>'.$robots.'
'.ess::$b->page->head;

// sett opp nettleser "layout engine" til CSS
$list = array(
	"opera" => "presto",
	"applewebkit" => "webkit",
	"msie 8" => "trident6 trident",
	"msie 7" => "trident5 trident",
	"msie 6" => "trident4 trident",
	"gecko" => "gecko"
);
$class_browser = 'unknown_engine';
$browser = strtolower($_SERVER['HTTP_USER_AGENT']);
foreach ($list as $key => $item)
{
	if (strpos($browser, $key) !== false)
	{
		$class_browser = $item;
		break;
	}
}