<?php

bs_side::$page_class = "forside";

echo '
<div class="right_section">
	<p class="img">
		<a href="studentbolig/beliggenhet#kart"><img src="/graphics/layout/kart.jpg" alt="Kart over området rundt Blindern Studenterhjem" />
		<span>Blindern Studenterhjem ligger sentralt plassert mellom universitetsbygningene på Blindern. Trykk for stort kart</span></a>
	</p>
	'.get_img_p(201, null, "Vestfløyen ble rehabilitert våren 2012. Her vises et enkeltrom på vestfløyen.", "Foto: Petter Gripheim", "img").'
	'.get_img_p(198, null, "Slik ser et innflyttingsklart dobbeltrom ut.", "Foto: Petter Gripheim", "img").'
</div>';

echo '
<h1>Velkommen til Blindern Studenterhjem</h1>

<p>Blindern Studenterhjem er en privat stiftelse som åpnet i 1925 og tilbyr mer enn bare en studentbolig - det er et hjem.
Blindern Studenterhjem skal være et godt hjem for akademisk ungdom fra alle kanter av landet, uansett studieretning.</p>

<div class="dette_er_bs">
	<h2>Dette er BS</h2>
	<p>230 studenter</p>
	<p>Full kost og losji</p>
	<p>xx parhybler, xx enkeltrom, xx gjennomgangsrom, xx dobbeltrom, xx kott</p>
	<p>8 timer dugnad i semesteret</p>
	<p>Blindernånden</p>
	<p class="soknadsknapp">
		Klar for å flytte inn?
		<a href="/opptak/sok_om_plass">Send søknad &raquo;</a>
	</p>
</div>

<h2>Like ved Universitetet i Oslo</h2>
<p>I et praktfullt beliggende hageanlegg p&aring; Blindern, vegg-i-vegg med Universitetet i Oslo,
kan Blindern Studenterhjem tilby et rikt bofelleskap for 220 studenter.</p>
<p>Studenterhjemmet ligger sentralt i Oslo, og har god kollektivforbindelse med både T-bane og trikk. Det tar
i underkant av 10 minutter fra man går fra rommet til man sitter i forelesning på juridisk fakultet i sentrum.</p>

<h2>Et unikt sosialt milj&oslash;</h2>
<p>
	Blindern Studenterhjem er kjent for sitt sterke sosiale milj&oslash;. Hvert &aring;r arrangeres en rekke tradisjonsrike
	arrangementer og fester, hvorav noen kan spores tilbake til &aring;pningen av Studenthjemmet i 1925.</p>
<p>Som beboer har man mulighet til &aring; engasjere seg i flere foreninger, av sosial eller administrativ art.
	Studenter sitter i organer som tar aktivt del i avgj&oslash;relsene
	p&aring; studenthjemmet og har stor grad av medbestemmelsesrett.
</p>

<h2>Tre daglige m&aring;ltider inkludert i husleien</h2>
<p>
	Tre m&aring;ltider serveres hver dag. De daglige m&aring;ltidene
	s&oslash;rger for et sunt kosthold samtidig som de er sv&aelig;rt tidsbesparende for beboerne,
	og er noe av det som gj&oslash;r Blindern Studenterhjem til et godt og unikt sted &aring; bo.
</p>

<h2>Søk deg inn</h2>
<p>Hvert semester flytter mange nye inn, og du kan være så heldig å få muligheten. Du trenger ikke
å ha kjent noen som har bodd her før eller ha vært på besøk. Alt vi ønsker er engasjerte personer
som kunne tenke seg å bidra til et godt miljø.</p>
<p>På disse sidene kan du lese mer og bli kjent med studenterhjemmet. Sitter du fremdeles igjen med noen spørsmål, ta kontakt!</p>

<p class="img_line_header">Utdrag fra den digitale omvisningen <span>(trykk på bildene)</span>:</p>';

// hent fire tilfeldige bilder fra galleriet
// TODO: tar ikke høyde for at parent galleriet evt. er skjult
// TODO: kanskje litt lite optimalisert?
$result = ess::$b->db->query("
	SELECT gi_id, gi_description, gi_shot_person
	FROM gallery_images JOIN gallery_categories ON gi_gc_id = gc_id
	WHERE gc_visible != 0 AND gi_visible != 0 AND gc_id != 11"); // ikke hent bilder fra Småbruket (nr=11)
$data = array();
$max = 120;
while ($row = mysql_fetch_assoc($result)) {
	$d = $row['gi_description'];
	if (mb_strlen($d) > $max) $d = mb_substr($d, 0, $max-4)."...";

	$data[] = array($row['gi_id'], null, $d, null);
}

$s = array_rand($data, 4);
$c = array();
foreach ($s as $id) $c[] = $data[$id];

echo get_img_line($c);