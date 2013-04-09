<?php

bs_side::set_title("Blindern Spill og Gåte");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("bsg");

echo get_right_img_gal(186, null, "Sjakkmesterskap arrangert av BSG høsten 2010.", "Foto: Henrik Steen");

echo '
<h1>Blindern Spill og Gåte (BSG)</h1>
<p>Blindern Spill og Gåte er det nyeste tilskuddet blant foreningene på Blindern Studenterhjem.
Hvis du liker å stimulere intellektet i upretensiøse omgivelser er dette foreningen for deg.</p>
<p>Bocketurnerningen – den prestisjetunge sjakkturneringen – arrangeres av BSG.
Andre arrangementer inkluderer blant annet Data-LAN, film-maraton
og brettspillturnerninger. BSG har også som regel åpen kaffebar
under alle arrangementer.</p>';

$foreninger->gen_page();