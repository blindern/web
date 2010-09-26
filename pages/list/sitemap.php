<?php

bs_side::load_menu();
bs_side::$no_extra_col = true;

echo '
<h1>Sidekart</h1>

<ul>';

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

echo '
</ul>';