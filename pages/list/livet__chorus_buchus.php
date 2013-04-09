<?php

bs_side::set_title("cHorus Buchus");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("chorus_buchus");

echo get_right_img_gal(122, null, "cHorus Buchus synger på Holmenkollen Restaurant i anledning bukkefesten våren 2010.", "Foto: Anders Fagereng");

echo '
<h1>cHorus Buchus</h1>
<p>
	Dette mannskoret har ingen andre opptakskrav enn at
	man t&oslash;r &aring; tr&oslash;kke til med stemmen
	man har. cHorus Bukkus sin opptreden p&aring; Pigefaarsamlingens
	semesterm&oslash;te er en sikker vinner dersom man
	&oslash;nsker &aring; smelte lengselsfulle pigehjerter.</p>
<p>Du kan laste ned noen innspillinger av koret her.
	Sangene er arrangert og dirigert av Stefan Theofilakes
	og innspilt av Torbj&oslash;rn H. Sandvik v&aring;ren
	2006:
</p>
<ul>
	<li><a href="files/BS_musikk/cHorus%20Bukkus%20-%20Hit%20Me%20Baby.mp3" target="_blank">
		cHorus Buchus - Hit Me Baby(mp3)
	</a></li>
	<li><a href="files/BS_musikk/cHorus%20Bukkus%20-%20Your%20Song.mp3" target="_blank">
		cHorus Buchus - Your Song (mp3)
	</a></li>
	<li><a href="files/BS_musikk/cHorus%20Bukkus%20-%20Vintern%20Rasat.mp3" target="_blank">
		cHorus Buchus - Vintern rasat (mp3)
	</a></li>
	<li><a href="files/BS_musikk/cHorus%20Bukkus%20-%20Opp%E5%20Kauk%E5sen.mp3" target="_blank">
		cHorus Buchus - Opp&aring; kauk&aring;sen (mp3)
	</a></li>
</ul>
<p>cHorus Buchus pleier å ha faste øvelser på tirsdager i musikksalongen og opptrer på
mange av brukets arrangementer. Alle beboere som ønsker å være med inviteres til å møte
opp på øvelse. Ingen erfaring fra tidligere er nødvendig.</p>';

$foreninger->gen_page();