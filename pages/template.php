<?php

echo '
<!DOCTYPE html>
<html lang="'.bs_side::$lang.'">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>'.bs_side::get_title().'</title>
<meta name="keywords" content="'.bs_side::get_keywords().'" />
<link rel="stylesheet" type="text/css" href="'.bs_side::$pagedata->doc_path.'/layout/layout.css" />'.bs_side::$head.'
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><a href="'.bs_side::$pagedata->doc_path.'/'.(bs_side::$lang != "no" ? bs_side::$lang : '').'"><span>Blindern Studenterhjem<br />Et godt hjem for studenter</span></a></h1>
			<div class="ledigeplasser">';

switch (bs_side::$lang)
{
	case "en":
		echo '
				<h2>Available places</h2>
				<p>We still have places in the fall.</p>
				<p>Apply an <a href="'.bs_side::$pagedata->doc_path.'/en/who_can_apply/application">electronic application</a> which will be processed continuously!</p>';
	break;
	
	default:
		echo '
				<h2>Ledige plasser i høst</h2>
				<p>Vi har fremdeles ledige plasser i høst.</p>
				<p>Send inn <a href="'.bs_side::$pagedata->doc_path.'/hvem_bor_soke/sok_om_plass">elektronisk søknad</a> som blir behandlet fortløpende!</p>';
}

echo '
			</div>
		</div>
		'.bs_side::$menu_main.'
		'.bs_side::$menu_sub.'
		<div id="content"'.(!bs_side::$menu_sub ? ' class="content_no_sub"' : '').'>
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
	<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
		try {
		var pageTracker = _gat._getTracker("UA-13059225-1");
		pageTracker._trackPageview();
		} catch(err) {}
	</script>
</body>
</html>';