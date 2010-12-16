<?php

bs_side::set_title("Digital omvisning");
require BASE."/omvisning.php";



// redigere meta?
if (isset($_GET['edit']))
{
	echo '
<h1>Digital omvisning - endre metadata</h1>
<form action="" method="post">
	<div id="omvisning_meta">';
	
	foreach (omvisning::$groups as $group => $images)
	{
		foreach ($images as $image)
		{
			echo '
		<p>
			<img src="'.omvisning::$link.'/thumb.php?file='.htmlspecialchars($image['o_file']).'" alt="Bildet" />
			<b>Kategori</b> '.htmlspecialchars($group).'<br />
			<b>Fotograf</b> <input type="text" name="foto['.$image['o_id'].']" value="'.htmlspecialchars($image['o_foto']).'" /><br />
			<b>Dato</b> <input type="text" name="date['.$image['o_id'].']" value="'.htmlspecialchars($image['o_date']).'" /><br />
			<b>Beskrivelse</b> <textarea name="beskrivelse['.$image['o_id'].']">'.htmlspecialchars($image['o_text']).'</textarea>
		</p>';
		}
	}
	
	echo '
	</div>
	<p><input type="submit" value="Lagre endringer" /></p>
</form>';
	
	return;
}





// ordne ID for kategorier
$categories = array();
foreach (array_keys(omvisning::$groups) as $category)
{
	$id = preg_replace("/[^\\w]/", "", strtolower($category));
	$categories[$id] = $category;
}

bs_side::$head .= '
<script src="/lib/mootools/mootools-1.2.x-core-nc.js" type="text/javascript"></script>
<!--<script src="http://ajax.googleapis.com/ajax/libs/mootools/1.2.4/mootools-yui-compressed.js"></script>-->
<script src="/lib/mootools/mootools-1.2.x-more-nc.js" type="text/javascript"></script>
<script src="'.bs_side::$pagedata->doc_path.'/default.js"></script>
<script>
window.addEvent("domready", function()
{
	var img_groups = '.json_encode($categories).';
	var mySortables = new Sortables($$(".omvisning_bilder_sort"), {
		constrain: false,
		clone: true,
		opacity: 0.1,
		onComplete: function(element)
		{
			order = element.getAllPrevious("p").length + 1;
			
			// lagre
			var xhr = new Request({
				url: "'.htmlspecialchars(bs_side::$pagedata->doc_path).'/ajax/omvisning.php?move",
				data: {
					"id": element.get("id").substring(4),
					"cat": img_groups[element.getParent(".omvisning_bilder_cat").getFirst("h2").get("id").substring(1)],
					"order": order
				}
			});
			xhr.send();
		}
	});
	new Sortables(document.id("omvisning_bilder"), {
		constraint: true,
		clone: true,
		handle: "h2",
		opacity: 0.1
	});
});
</script>';



echo '
<h1>Digital omvisning - omorganisere bilder</h1>
<div id="omvisning_bilde_w" class="omvisning_bilde_skjult">
	<p id="omvisning_nav">
		<span id="omvisning_back"><span>Tilbake til oversikt</span></span>
		<span id="omvisning_prev"><span>Forrige bilde</span></span>
		<span id="omvisning_next"><span>Neste bilde</span></span><br />(Piltaster kan også benyttes.)
	</p>
	<p id="omvisning_bilde"></p>
</div>
<div id="omvisning_bilde_inactive">
	<div id="omvisning_bilder">';

foreach (omvisning::$groups as $category => $images)
{
	$c = preg_replace("/[^\\w]/", "", strtolower($category));
	
	echo '
		<div class="omvisning_bilder_cat">
			<h2 id="c'.$c.'">'.$category.'</h2>
			<div class="omvisning_bilder_sort">';
	
	foreach ($images as $image)
	{
		$text = $image['o_text'];
		if ($text && $image['o_foto']) $text .= " ";
		if ($image['o_foto']) $text .= "Foto: " . $image['o_foto'];
		
		echo '<!-- avoid inline-block spacing
--><p id="img_'.$image['o_id'].'"><img src="'.omvisning::$link.'/thumb.php?file='.htmlspecialchars($image['o_file']).'" alt="'.htmlspecialchars($text).'" title="'.htmlspecialchars($text).'" /></p>';
	}
	
	echo '
			</div>
		</div>';
}

echo '
	</div>
</div>';