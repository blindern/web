<?php

bs_side::set_title("Tilpasning av tekst");

if (!bs::is_adm()) {
	echo '
	<h1>Tilpasning av tekst</h1>
	<p>Denne siden kan kun nås fra administrasjonen sitt nettverk.</p>';

	return;
}

require_once ROOT."/base/tilpasning.php";

$t = new tilpasning();

$title = isset($_POST['title']) ? $_POST['title'] : $t->get("hjorne_title");
$content = isset($_POST['content']) ? $_POST['content'] : $t->get("hjorne_content");

$title_en = isset($_POST['title_en']) ? $_POST['title_en'] : $t->get("hjorne_title_en");
$content_en = isset($_POST['content_en']) ? $_POST['content_en'] : $t->get("hjorne_content_en");

if (isset($_POST['tilpasset_hjorne']) && isset($_POST['save'])) {
	$t->set("hjorne_active", isset($_POST['active']));
	$t->set("hjorne_title", postval("title"));
	$t->set("hjorne_content", postval("content"));

	$t->set("hjorne_active_en", isset($_POST['active_en']));
	$t->set("hjorne_title_en", postval("title_en"));
	$t->set("hjorne_content_en", postval("content_en"));
	
	//add_message("Hjørneboks ble oppdatert.");
	$https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? "s" : "";
	header("Location: http{$https}://{$_SERVER['HTTP_HOST']}/tilpasset");
	die;
}

echo '
<h1>Tilpasning av tekst</h1>

<h2>Hjørneboks</h2>
<form action="tilpasset" method="post">
	<input type="hidden" name="tilpasset_hjorne" value="1" />
	<p>Norsk: Vise hjørneboks? <input type="checkbox" name="active"'.(isset($_POST['active']) || ($t->get("hjorne_active") && !isset($_POST['tilpasset_hjorne'])) ? ' checked="checked"' : '').' /></p>
	<p>Norsk: Overskrift: <input type="text" name="title" value="'.htmlspecialchars($title).'" /></p>
	<p>Norsk: Innhold (HTML):<br /><textarea name="content" rows="10" cols="100" style="width: 100%">'.htmlspecialchars($content).'</textarea></p>
	<p>Engelsk: Vise hjørneboks? <input type="checkbox" name="active_en"'.(isset($_POST['active_en']) || ($t->get("hjorne_active_en") && !isset($_POST['tilpasset_hjorne'])) ? ' checked="checked"' : '').' /></p>
	<p>Engelsk: Overskrift: <input type="text" name="title_en" value="'.htmlspecialchars($title_en).'" /></p>
	<p>Engelsk: Innhold (HTML):<br /><textarea name="content_en" rows="10" cols="100" style="width: 100%">'.htmlspecialchars($content_en).'</textarea></p>'.(isset($_POST['tilpasset_hjorne']) ? '
	<p><b>Du viser nå en forhåndsvisning!</b></p>' : '').'
	<p><input type="submit" value="Oppdater innhold" name="save" /> <input type="submit" value="Forhåndsvis norsk" name="preview" /> <input type="submit" value="Forhåndsvis engelsk" name="preview_en" /></p>
</form>';

