<?php

header("Content-Type: text/html; charset=utf-8");

// sett opp head
ess::$b->page->head = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Hjemmesideoppmann Blindern Studenterhjem" />
<meta name="keywords" content="'.ess::$b->page->generate_keywords().'" />
<meta name="description" content="'.ess::$b->page->description.'" />
<base href="'.ess::$s['path'].'/" />
<link rel="shortcut icon" href="'.ess::$s['rpath'].'/favicon.ico" />
<link href="'.ess::$s['rpath'].'/layout/layout.css?'.@filemtime(dirname(dirname(dirname(__FILE__)))."/layout/layout.css").'" rel="stylesheet" type="text/css" />
<!--[if lte IE 8]>
<script src="'.ess::$s['rpath'].'/html5ie.js" type="text/javascript"></script>
<![endif]-->
<meta name="robots" content="index, follow" />
<link href="'.ess::$s['rpath'].'/rss" rel="alternate" type="application/rss+xml" title="RSS 2.0" />
<!--<script type="text/javascript" src="'.ess::$s['rpath'].'/mootools.1.3.js"></script>
<script type="text/javascript" src="'.ess::$s['rpath'].'/mootools-more.1.3.js"></script>-->
<!--<script type="text/javascript" src="'.ess::$s['rpath'].'/blindernuka.js?update='.@filemtime(dirname(dirname(dirname(__FILE__)))."/blindernuka.js").'"></script>-->'.ess::$b->page->head;

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