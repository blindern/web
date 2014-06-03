<?php

bs_side::$page_class = "forside";

echo '
<div class="right_section">
	<p class="img">
		<a href="studentbolig/beliggenhet#kart"><img src="/graphics/layout/kart.jpg" alt="Kart over området rundt Blindern Studenterhjem" />
		<span>Blindern Studenterhjem ligger sentralt plassert mellom universitetsbygningene på Blindern. Trykk for stort kart</span></a>
	</p>
	<!--'.get_img_p(201, null, "Vestfløyen ble rehabilitert våren 2012. Her vises et enkeltrom på vestfløyen.", "Foto: Petter Gripheim", "img").'-->
	
	<section class="dette_er_bs">
		<h2>Dette er BS</h2>
		<p>215 studenter</p>
		<p>Full kost og losji</p>
		<p>147 enkeltrom,<br /> 16 gjennomgangsrom,<br /> 18 dobbeltrom</p>
		<!-- INFO: parrom, f.eks. 712, telles som to enkeltrom
		           brakkene er ikke talt med, heller ikke kottene -->
		<p>8 timer dugnad per semester</p>
		<p>Blindernånden<br />Godt og trygt sosialt miljø</p>
		<p class="soknadsknapp">
			Klar for å flytte inn?
			<a href="/opptak/sok_om_plass">Send søknad &raquo;</a>
		</p>
	</section>

	'.(rand(1,2) == 1 ? get_img_p(198, null, "Slik ser et innflyttingsklart dobbeltrom ut.", "Foto: Petter Gripheim", "img")
	                  : get_img_p(201, null, "Innredet rom på nyoppusset fløy.", "Foto: Petter Gripheim", "img")).'
</div>';

echo '
<h1>Velkommen til Blindern Studenterhjem</h1>

<div class="index_group">
<p>Blindern Studenterhjem er en privat stiftelse som åpnet i 1925 og tilbyr mer enn bare en studentbolig.
Blindern Studenterhjem skal være et godt hjem for akademisk ungdom fra alle kanter av landet, uansett studieretning.</p>

<p>På Blindern Studenterhjem er det 147 enkeltrom, 16 kombinasjonsrom og 18 dobbeltrom.</p>
<p><a href="studentbolig">Les mer om boligtilbudet vårt &raquo;</a></p>
</div>


<div class="romgrupper">

<div class="romgruppe">
	<a href="studentbolig">
		<div class="h2">Enkeltrom</div>
		<div class="pris">kr 6 904 / mnd</div>
		<div>Inkl. mat, strøm<br />og internett</div>
		<div class="more">Flere detaljer &raquo;</div>
	</a>
</div>

<div class="romgruppe">
	<a href="studentbolig">
		<div class="h2">Kombinasjonsrom</div>
		<div class="pris">kr 6 756 / mnd</div>
		<div>Inkl. mat, strøm<br />og internett</div>
		<div class="more">Flere detaljer &raquo;</div>
	</a>
</div>

<div class="romgruppe">
	<a href="studentbolig">
		<div class="h2">Dobbeltrom</div>
		<div class="pris">kr 6 506 / mnd</div>
		<div>Inkl. mat, strøm<br />og internett</div>
		<div class="more">Flere detaljer &raquo;</div>
	</a>
</div>

</div>
<p style="text-align: center"><i>Priser gjelder høst 2014 / vår 2015.</i></p>


<div class="index_group">
	<h2 style="margin-top: 25px">Like ved Universitetet i Oslo</h2>
	<p class="index_kart_img">
		<a href="/studentbolig/beliggenhet"><img src="/graphics/layout/kart_ikon.png" alt="Kart" /></a>
	</p>
	<p>Studenterhjemmet ligger sentralt i Oslo, midt mellom universitetsbygningene på Blindern. Det er god kollektivforbindelse med både T-bane og trikk. Kort vei til universitetsbygningene i sentrum.</p>
</div>

<div class="index_group">
	<h2 style="margin-top: 25px">Et unikt sosialt milj&oslash;</h2>
	<p>
		Blindern Studenterhjem er kjent for sitt sterke sosiale milj&oslash;. Hvert &aring;r arrangeres en rekke tradisjonsrike
		arrangementer og fester, hvorav noen kan spores tilbake til &aring;pningen av studenthjemmet i 1925.</p>
	<p>Som beboer har du mulighet til &aring; engasjere deg i flere foreninger, av sosial eller administrativ art.
		Studenter sitter i organer som tar aktivt del i avgj&oslash;relsene
		p&aring; studenthjemmet og har stor grad av medbestemmelsesrett.
	</p>
	<p>Hvert semester flytter mange nye inn, og alle studenter kan søke om plass. Du trenger ikke
	å ha kjent noen som har bodd her før eller ha vært på besøk. Alt vi ønsker er engasjerte personer
	som ønsker å bidra til et godt miljø.</p>
	<p><a href="livet">Les mer om livet på BS &raquo;</a></p>
</div>';

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

$s = array_rand($data, 10);
$c = array();
foreach ($s as $id) $c[] = $data[$id];

echo get_img_line($c);
