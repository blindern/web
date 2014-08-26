<?php

header("Content-Type: text/html; charset=utf-8");

// innhold
$content = ob_get_contents();
@ob_clean();

// spesifiser åpent for søkemotorer hvis ikke allerede satt
$robots = '';
if (!preg_match("~<meta.*name=(|'|\")robots~", bs_side::$head)) $robots = '
<meta name="robots" content="index, follow" />';

// er vi på utviklersia?
$is_devserver = $_SERVER['SERVER_NAME'] != "blindern-studenterhjem.no";

$page_title = bs_side::get_title();
$page_keywords = implode(", ", bs_side::get_keywords());
$page_description = bs_side::get_description();
$page_head = bs_side::$head;
$page_lang = bs_side::$lang;

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


// banner på høyre side
// f.eks. til UKA, Bukkehaugfestival o.l.
$banner = array(
	false, // skal banner vises? sett til true for å vise
	'', // adresse banner skal lenke til
	'', // bildefil som skal brukes (må være 200px bred
	'', // alt-tekst på bildet
);


// infoboks i hjørnet i toppen
require_once ROOT."/base/tilpasning.php";
$t = new tilpasning();

$suffix = bs_side::$lang == "en" ? "_en" : "";
if (isset($_POST['tilpasset_hjorne']) && isset($_POST['preview_en'])) $suffix = "_en";

$show_application_box = isset($_POST['tilpasset_hjorne']) ? isset($_POST['active'.$suffix]) : $t->get("hjorne_active$suffix");
$application_box = false;
if ($show_application_box)
{
	if (isset($_POST['tilpasset_hjorne'])) {
		$title = postval("title$suffix");
		$c = postval("content$suffix");
	} else {
		$title = $t->get("hjorne_title$suffix");
		$c = $t->get("hjorne_content$suffix");
	}

	// vi ønsker ikke at kommentarer skal komme med
	$c = preg_replace("/<!--(?!<!)[^\\[>].*?-->/s", "", $c);
	$application_box = array(
		$title,
		$c
	);
}


// google analytics
$google_analytics = '';
if ($_SERVER['HTTP_HOST'] == "blindern-studenterhjem.no" || !empty($GLOBALS['gaq']))
{
	$google_analytics = '
	<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(["_setAccount", "UA-13059225-1"]);
	_gaq.push(["_trackPageview", '.json_encode($_SERVER['REQUEST_URI']).']);';
			
	foreach (ess::$b->page->gaq as $gaq)
	{
		$google_analytics .= '
	_gaq.push('.$gaq.');';
	}

	$google_analytics .= '
	(function() {
	var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
	ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
	var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
	})();
	</script>';
}



?>
<!DOCTYPE html>
<html lang="no"<?php if ($is_devserver): ?> class="devserver"<?php endif; ?>>
<head>
<title><?php echo $page_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Hjemmesideoppmann Blindern Studenterhjem" />
<meta name="keywords" content="<?php echo $page_keywords; ?>" />
<meta name="description" content="<php echo $page_description; ?>" />
<link rel="shortcut icon" href="/favicon.ico" />
<link href="/layout/layout.css?<?php echo @filemtime(dirname(dirname(dirname(__FILE__)))."/layout/layout.css"); ?>" rel="stylesheet" type="text/css" />
<!--[if lte IE 8]>
<script src="/html5ie.js" type="text/javascript"></script>
<![endif]-->
<?php echo $robots; ?>
<?php echo $page_head; ?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script type="text/javascript" src="/blindern.js"></script>

</head>
<body class="lang_<?php echo bs_side::$lang; ?> <?php echo $class_browser; ?><?php if ($is_devserver): ?> devinfobody<?php endif; ?>">

<?php if ($is_devserver): ?>
	<div class="devinfo">
		<p>Du ser nå på utviklersiden og ikke den offisielle nettsiden.</p>
	</div>
<?php endif; ?>

<div id="body_wrap">
	<!-- hvis vi viser banner, endre \'nobanner\' til \'banner\' og aktiver koden nedenfor -->
	<div id="container"<?php if ($banner[0]): ?> class="banner"<?php endif; ?>><div id="main">
		<div id="header">
			<h1><a href="/<?php if ($page_lang != "no"): echo $bs_lang; endif ?>"><span>Blindern Studenterhjem<br />
				<?php
				switch (bs_side::$lang)
				{
					case "en":
						echo 'A good home for students';
					break;
					
					default:
						echo 'Et godt hjem for studenter';
				}
				?>
			</span></a></h1>

			<?php
			if ($application_box):
				?>
				<div class="ledigeplasser">
					<h2><?php echo htmlspecialchars($application_box[0]); ?></h2>
					<?php echo $application_box[1]; ?>
				</div>
				<?php
			endif;
			?>
		</div>

		<?php echo bs_side::$menu_main; ?>
		<?php echo bs_side::$menu_sub; ?>

		<div id="content"<?php if (!bs_side::$menu_sub): ?> class="content_no_sub"<?php endif; ?>>
			<?php echo $content; ?>
			<div id="content_clear"></div>
		</div>
		<div id="footer">
			<p>Blindern Studenterhjem <?php echo date("Y"); ?>
				<?php
				switch (bs_side::$lang)
				{
					case "en":
						if (bs_side::$menu_active != "en/sitemap") echo ' | <a href="/en/sitemap">Sitemap</a>';
					break;
				
					default:
						if (bs_side::$menu_active != "sitemap") echo ' | <a href="/sitemap">Sidekart</a>';
				}
				?>
			</p>
		</div>
		</div>

		<?php if ($banner[0]): ?>
			<div id="banner"><a href="<?php echo htmlspecialchars($banner[1]); ?>"><img src="<?php echo htmlspecialchars($banner[2]); ?>" alt="<?php echo htmlspecialchars($banner[3]); ?>" /></a></div>
		<?php endif; ?>

	</div>
</div>

		<?php echo $google_analytics; ?>

</body>
</html>