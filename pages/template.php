<?php

echo '
<!DOCTYPE html>
<html lang="no">
<head>
<title>'.bs_side::$title.'</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="'.bs_side::$pagedata->doc_path.'/layout/layout.css" />'.bs_side::$head.'
</head>
<body>
	<div id="container">
		<div id="header">
			<a href="'.bs_side::$pagedata->doc_path.'/"><img src="'.bs_side::$pagedata->doc_path.'/graphics/layout/new_header.jpg" width="800" height="100" border=0></a>
		</div>
		'.bs_side::$menu_main.'
		<div id="contentContainer">
			<div id="content">
				'.bs_side::$content.'
			</div>
			<div id="menu_sub_wrap">
				'.bs_side::$menu_sub.'
			</div>
			<div class="ledigeplasser">
				<h2>Ledige plasser i høst</h2>
				<p>Vi har fremdeles ledige plasser i høst.</p>
				<p>Send inn <a href="'.bs_side::$pagedata->doc_path.'/hvem_bor_soke/sok_om_plass">elektronisk søknad</a> som blir behandlet fortløpende!</p>
			</div>
			<div id="content_clear"></div>
		</div>
		<div id="footer">
			<p>Blindern Studenterhjem 2010</p>
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