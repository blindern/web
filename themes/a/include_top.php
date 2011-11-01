<?php

header("Content-Type: text/html; charset=utf-8");

// sett opp head
ess::$b->page->head = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Henrik Steen [henrist.net]" />
<meta name="generator" content="hsw.no websystem" />
<!--<meta name="keywords" content="" />-->
<meta name="description" content="Kontrollpanel" />
<link rel="shortcut icon" href="'.ess::$s['rpath'].'/favicon.ico" />
<link href="'.ess::$s['rpath'].'/themes/a/default.css?'.@filemtime(dirname(__FILE__)."/default.css").'" rel="stylesheet" type="text/css" />
<!--[if lte IE 8]>
<script src="'.ess::$s['rpath'].'/html5ie.js" type="text/javascript"></script>
<![endif]-->
<meta name="robots" content="noindex, nofollow" />'.ess::$b->page->head;

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