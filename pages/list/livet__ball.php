<?php

bs_side::set_title("Ballkomitéer");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("ball");

echo '
<p class="img img_right">
	<img src="/graphics/images/hostball_h10.jpg" alt="" />
	<span>Høstball 2010. Foto: Anders Fagereng</span>
</p>

'.get_right_img_gal(180, null, "Under ballmiddager er det beboere som frivillig stiller opp som kelnere.", "Foto: Anders Fagereng").'


<h1>Blindernball</h1>

<p>Et av de flotteste arrangementene på BS er ballene. Dette arrangeres en gang hvert
semester. I galla-antrekk (for de som har) får man nyte et treretters måltid, med sang
og underholdning. Stemningen kan beskrives som magiask og må oppleves! Det er
beboerne selv som er kelnere og maten tilberedes av kjøkkenpersonalet.</p>

<p>
	Etter ballmiddagen spilles det opp til dans med et
	liveband. Mens noen danser, foretrekker andre &aring;
	ha midtspiel eller hygge seg i baren i musikksalongen.
	Festen fortsetter s&aring; med diskotek i peisestuen.
</p>

<p>
	Rundt klokken ti s&oslash;ndag morgen vekker Haarn
	oc Blaese Orchester brukets beboere. Turen b&aelig;rer
	opp mot Frognerseteren, og man har fremdeles p&aring;
	seg sitt ballantrekk.
</p>

<!--<p>Påfølgende søndag fortsetter festen med ekskursjon til en fin restaurant i Oslos åser,
med påfølgende avslapping på &quot;Valka&quot;. <a href="/livet/haarn_oc_blaese">Haarn oc Blaese</a>
er naturligvis med og leder an.</p>-->

<p>Dersom man etter en stund ikke
	skulle v&aelig;re &oslash;nsket i restauranten, begir
	man seg mot Majorstuen og et mer tolerant serveringssted.
	N&aring;r klokken n&aelig;rmer seg fem tar man turen
	tilbake til BS for &aring; spise s&oslash;ndagsmiddag.
	P&aring; kvelden arrangerer festforeningen caf&eacute;
	avec med levende musikk og fest ut i de sm&aring;
	timer.</p>

<h2>Ballkomitéen</h2>

<p>Ballkomitéen for høstballet utnevnes av festforeningen, mens ballkomitéene for vårballene utnevnes
av UKEstyret og Bukkekollegiet for henholdsvis UKEballet og Bukkefesten.</p>
';

$foreninger->gen_page();