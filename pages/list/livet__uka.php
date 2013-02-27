<?php

bs_side::set_title("UKA på Blindern");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("uka");

echo get_right_img_gal(177, null, "Blindernrevyen 2013: FORDI JEG FORTJENER DET ...bedre enn deg!", "Foto: UKA");
echo get_right_img_gal(176, null, "Blindernrevyen har blitt sett av mange kjente fjes. Både (daværende) kronprins Harald og (daværende) kronprinsesse Sonja har sett revyen. Sist under UKA 2013 kom ordfører Fabian Stang.", "Foto: UKA");
echo get_right_img_gal(175, null, "Blæstgjengen er en av de viktigste gruppene under UKA. Det er de som sprer ordet om UKA og får mange tusen til å besøke oss.", "Foto: UKA");
echo get_right_img_gal(174, null, "Blindernrevyen står i sentrum når UKA arrangeres.", "Foto: UKA");

echo '
<h1>UKA på Blindern</h1>

<!--<p class="img img_right">
	<img src="/graphics/images/uka.jpg" alt="UKA på Blindern" />
	<span>Fra revysus høsten 2010. Revysus arrangeres i forkant av UKA og er et tilbakeblikk på revyene helt tilbake til 1932. Foto: Sindre Grading</span>
</p>-->

<p>Annenhvert &aring;r arrangeres UKA p&aring; Blindern
	p&aring; Blindern Studenterhjem. Da snus hele Studenterhjemmet
	p&aring; hodet, og alle beboerne er aktive i gjennomf&oslash;ringen
	av en halvannen ukes festival. Det spilles revy og
	arrangeres konserter, og fem-seks forskjellige barer &aring;pnes
	for beboere og eksterne bes&oslash;kende.
</p>

<p>
	Den aller f&oslash;rste revyen p&aring; Blindern Studenterhjem
	ble arrangert i 1932, og kunne alledere da tilby et
	omfattende sosialt program ved siden av selve forestillingen.
	Siden den gang har Blindernrevyen blitt arrangert
	med jevne mellomrom, og siden 1961 annenhvert &aring;r.</p>
<p>I 2003 skiftet arrangementet navn til UKA p&aring;
	Blindern, en tittel som bedre dekker alle de opplevelser
	og inntrykk UKA formidler.
</p>

<p>
	N&aring; som da er det frivillig arbeid fra de aller
	fleste av BS sine 220 beboere som skaper UKA p&aring;
	Blindern. Hver tekst som synges, hver drink som blandes
	og hver plakat som henges opp er et resultat av et
	enest&aring;ende kollektivt l&oslash;ft.</p>
<p>De mest ihuga
	ildsjelene begynner arbeidet allerede ett &aring;rs
	tid i forveien, og i de tolv dagene arrangementet
	varer er det de f&aelig;rreste som tilbringer timer
	p&aring; lesesal.
</p>

<h2>UKEstyret</h2>
<p>UKEstyet består av 8 beboere som sammen leder planleggingen og arbeidet frem til og under UKA. UKEsjefen velges
av avtroppende styre etter innkommende søknader, og den nye UKEsjefen sammen med det gamle styret velger
det nye styret, også etter søknader. På Bukkefesten offentliggjøres det nye styret.</p>

<p>Se egen hjemmeside på <a href="http://www.blindernuka.no" target="_blank">blindernuka.no</a>!</p>';

$foreninger->gen_page();