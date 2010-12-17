<?php

bs_side::set_title("Digital omvisning");
require BASE."/omvisning.php";

$msg = "";


// redigere meta?
if (isset($_GET['edit']))
{
	// skal vi lagre?
	if (isset($_POST['foto']) && is_array($_POST['foto']))
	{
		// sett opp liste over alle bildene vi har
		$all = array();
		foreach (omvisning::$groups as $group => $images)
		{
			foreach ($images as &$image)
			{
				$all[$image['o_id']] = &$image;
			}
			unset($image);
		}
		
		// finn ut hva som har blitt endret
		$check = array("active" => "o_active", "foto" => "o_foto", "date" => "o_date", "beskrivelse" => "o_text");
		$changed = array();
		foreach ($_POST['foto'] as $key => $foto)
		{
			if (!isset($all[$key])) return;
			
			// sjekk hver parameter
			$new = array();
			foreach ($check as $p => $col)
			{
				if ($p == "active")
				{
					$d = isset($_POST[$p][$key]);
				}
				elseif (!isset($_POST[$p][$key]))
				{
					continue;
				}
				else $d = $_POST[$p][$key];
				
				// er dataen i POST forskjellig fra nåværende?
				if ($d != $all[$key][$col])
				{
					$new[$col] = $d;
					
					// oppdater nåværende så det vises i skjemaet
					$all[$key][$col] = $d;
				}
			}
			
			// noe endret?
			if ($new) $changed[$key] = $new;
		}
		
		// oppdater de som ble endret
		if ($changed)
		{
			omvisning::handle_edit($changed);
			
			$msg = '
	<p>Endringene ble lagret.</p>';
		}
		
		else
		{
			$msg = '
	<p>Ingen endringer ble utført.</p>';
		}
	}
	
	echo '
<h1>Digital omvisning - endre metadata</h1>
<form action="" method="post">'.$msg.'
	<p><a href="/'.bs_side::$pagedata->path.'">Tilbake</a></p>
	<p><input type="submit" value="Lagre endringer" /></p>
	<div id="omvisning_meta">';
	
	foreach (omvisning::$groups as $group => $images)
	{
		foreach ($images as $image)
		{
			echo '
		<p'.(!$image['o_active'] ? ' style="background-color: #FFEEEE"' : '').'>
			<img src="'.omvisning::$link.'/thumb.php?file='.htmlspecialchars($image['o_file']).'" alt="Bildet" />
			<b>Kategori</b> '.htmlspecialchars($group).'<br />
			<b>Aktiv?</b> <input type="checkbox" name="active['.$image['o_id'].']"'.($image['o_active'] ? ' checked="checked"' : '').' /><br />
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

// laste opp fil?
if (isset($_FILES['file']) && isset($_POST['cat']))
{
	$ret = omvisning::handle_upload($_FILES['file'], $_POST['cat']);
	if (is_array($ret))
	{
		$msg = '
	<p>Bildet ble lastet opp! ('.htmlspecialchars($ret[0]).')</p>';
		
		// last inn bilder på nytt
		omvisning::get_images();
	}
	
	else
	{
		switch ($ret)
		{
			case "error_ext":
				$msg = '
	<p>Bildet som ble lastet opp hadde ugyldig filendelse.</p>';
			break;
			
			case "error_move":
				$msg = '
	<p>Klarte ikke å flytte opplastet bilde til bildemappen.</p>';
			break;
			
			default:
				$msg = '
	<p>Opplasting feilet.</p>';
		}
	}
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
<p><a href="/'.bs_side::$pagedata->path.'?edit">Endre metadata</a></p>'.$msg.'
<div id="omvisning_bilde_inactive">
	<div id="omvisning_bilder">';

foreach (omvisning::$groups as $category => $images)
{
	$c = preg_replace("/[^\\w]/", "", strtolower($category));
	
	echo '
		<div class="omvisning_bilder_cat">
			<h2 id="c'.$c.'">'.$category.'</h2>
			<div class="omvisning_bilder_sort omvisning_bilder_g">';
	
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
			<form action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="cat" value="'.htmlspecialchars($category).'" />
				<p style="margin: 10px 0 0 0"><input type="file" name="file" /> <input type="submit" value="Last opp" /></p>
			</form>
		</div>';
}

echo '
	</div>
</div>';