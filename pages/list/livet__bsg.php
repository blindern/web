<?php

bs_side::set_title("Blindern Spill og Gåte");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("bsg");

echo '
<p class="img img_right">
	<img src="/graphics/images/sjakk_bsg_h10.jpg" alt="Sjakkmesterskap med BSG høsten 2010" /></a>
	<span>Sjakkmesterskap arrangert av BSG høsten 2010. Foto: Henrik Steen</span>
</p>

<h1>Blindern Spill og Gåte (BSG)</h1>
<p>Blindern Spill og Gåte er det nyeste tilskuddet blant foreningene på Blindern Studenterhjem. Hvis du liker å stimulere intellektet i upretensiøse omgivelser er dette foreningen for deg.</p>
<p>Bocketurnerningen – den prestisjetunge sjakkturneringen – arrangeres av BSG hvert semester. Andre arrangementer inkluderer blant annet Data-LAN, film-maraton og brettspillturnerninger. BSG har også som regel åpen kaffebar under alle arrangementer.</p>';

$foreninger->gen_page();