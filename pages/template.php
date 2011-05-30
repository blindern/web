<?php

$page_class = bs_side::$page_class;

echo '
<!DOCTYPE html>
<html lang="'.bs_side::$lang.'">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>'.bs_side::get_title().'</title>
<meta name="keywords" content="'.bs_side::get_keywords().'" />
<meta name="description" content="'.bs_side::get_description().'" />
<link rel="stylesheet" type="text/css" href="'.bs_side::$pagedata->doc_path.'/layout/layout.css" />'.bs_side::$head.'
<link rel="shortcut icon" href="'.bs_side::$pagedata->doc_path.'/favicon.ico" />
</head>
<body class="lang_'.bs_side::$lang.'">
<div id="body_wrap">
	<div id="container"><div id="main">
		<div id="header">
			<h1><a href="'.bs_side::$pagedata->doc_path.'/'.(bs_side::$lang != "no" ? bs_side::$lang : '').'"><span>Blindern Studenterhjem<br />';

switch (bs_side::$lang)
{
	case "en":
		echo 'A good home for students';
	break;
	
	default:
		echo 'Et godt hjem for studenter';
}

echo '</span></a></h1>
			<div class="ledigeplasser">';

switch (bs_side::$lang)
{
	case "en":
		echo '
				<h2>Applications</h2>
				<p>Applications for fall 2011 are evaluated throughout the summer.</p>
				<p>Apply an <a href="'.bs_side::$pagedata->doc_path.'/en/application">electronic application &raquo;</a></p>';
	break;
	
	default:
		echo '
				<h2>Inntak</h2>
				<p>Søknad for plass til høsten 2011 evalueres fortløpende utover sommeren.</p>
				<p>Send inn <a href="'.bs_side::$pagedata->doc_path.'/opptak/sok_om_plass">elektronisk søknad &raquo;</a></p>';
}

echo '
			</div>
		</div>
		'.bs_side::$menu_main.'
		'.bs_side::$menu_sub.'
		<div id="content"'.(!bs_side::$menu_sub ? ' class="content_no_sub'.(bs_side::$page_class ? ' '.bs_side::$page_class : '').'"' : (bs_side::$page_class ? ' class="'.bs_side::$page_class.'"' : '')).'>
			'.bs_side::$content.'
			<div id="content_clear"></div>
		</div>
		<div id="footer">
			<p>Blindern Studenterhjem 2010';

switch (bs_side::$lang)
{
	case "en":
		if (bs_side::$menu_active != "en/sitemap") echo ' | <a href="'.bs_side::$pagedata->doc_path.'/en/sitemap">Sitemap</a>';
	break;

	default:
		if (bs_side::$menu_active != "sitemap") echo ' | <a href="'.bs_side::$pagedata->doc_path.'/sitemap">Sidekart</a>';
}

echo '</p>
		</div>
		</div>
		<div id="banner"><a href="'.bs_side::$pagedata->doc_path.'/foreninger/arrangementsplan"><img src="'.bs_side::$pagedata->doc_path.'/graphics/images/bukkehaug2011.jpg" alt="Bukkehaugsfestivalen 2011" /></a></div>
	</div>
	<div id="footer_spacer"></div>
</div>';

if (strpos($_SERVER['SERVER_NAME'], "blindern-studenterhjem.no") !== false) echo '

<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(["_setAccount", "UA-13059225-1"]);
_gaq.push(["_trackPageview"]);

(function() {
var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
})();
</script>';

echo bs_side::$footer.'
</body>
</html>';