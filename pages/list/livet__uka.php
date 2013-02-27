<?php

bs_side::set_title("UKA på Blindern");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("uka");

echo '
<h1>UKA på Blindern</h1>

<p class="img img_right">
	<img src="/graphics/images/uka.jpg" alt="UKA på Blindern" />
	<span>Fra revysus høsten 2010. Revysus arrangeres i forkant av UKA og er et tilbakeblikk på revyene helt tilbake til 1932. Foto: Sindre Grading</span>
</p>

<h1>UKEstyret</h1>
<p>
	Den aller f&oslash;rste revyen p&aring; Blindern Studenterhjem
	ble arrangert i 1932, og kunne alledere da tilby et
	omfattende sosialt program ved siden av selve forestillingen.
	Siden den gang har Blindernrevyen blitt arrangert
	med jevne mellomrom, og siden 1961 annenhvert &aring;r.</p>
<p>I 2003 skiftet arrangementet navn til Uka p&aring;
	Blindern, en tittel som bedre dekker alle de opplevelser
	og inntrykk UKA formidler.
</p>

<p>
	N&aring; som da er det frivillig arbeid fra de aller
	fleste av BS sine 220 beboere som skaper Uka p&aring;
	Blindern. Hver tekst som synges, hver drink som blandes
	og hver plakat som henges opp er et resultat av et
	enest&aring;ende kollektivt l&oslash;ft.</p>
<p>De mest ihuga
	ildsjelene begynner arbeidet allerede ett &aring;rs
	tid i forveien, og i de tolv dagene arrangementet
	varer er det de f&aelig;rreste som tilbringer timer
	p&aring; lesesal.
</p>
<p>Se egen hjemmeside på <a href="http://www.blindernuka.no" target="_blank">blindernuka.no</a>!</p>';

$foreninger->gen_page();