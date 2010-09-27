<?php

switch (bs_side::$lang)
{
	case "en":
		$title = "Sitemap";
	break;
	
	default:
		$title = "Sidekart";
		bs_side::set_title("Sidekart");
		bs_side::$lang_crosslink['en'] = "en/sitemap";
}


bs_side::load_menu();

echo '
<h1>'.$title.'</h1>

<ul id="sitemap">';

foreach (bs_side::$menu_all as $section)
{
	echo '
	<li>'.htmlspecialchars($section[0]).'
		<ul>';
	
	foreach ($section[1] as $key => $item)
	{
		if ($key == "index") $key = "";
		
		echo '
			<li><a href="'.bs_side::$pagedata->doc_path.'/'.$key.'">'.htmlspecialchars($item).'</a></li>';
	}
	
	echo '
		</ul>
	</li>';
}

if (bs_side::$lang != "no") echo '
	<li><a href="'.bs_side::$pagedata->doc_path.'/sitemap" lang="no">På norsk</a></li>';

if (bs_side::$lang != "en") echo '
	<li><a href="'.bs_side::$pagedata->doc_path.'/en/sitemap" lang="en">In English</a></li>';

echo '
</ul>';