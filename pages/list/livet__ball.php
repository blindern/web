<?php

bs_side::set_title("Ballkomitéer");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("ball");

echo '
<h1>Ballkomitéer</h1>

<p>Hvert semester arrangeres det ball på Blindern Studenterhjem. Dette er en
hyggelig opplevelse hvor man kler seg opp i galla-antrekk (for de som har). Det er
beboerne selv som er kelnere og maten tilberedes av kjøkkenpersonalet.</p>
<p>Påfølgende søndag fortsetter festen med ekskursjon til en fin restaurant i Oslos åser,
med påfølgende avslapping på &quot;Valka&quot;. <a href="/livet/haarn_oc_blaese">Haarn oc Blaese</a>
er naturligvis med og leder an.</p>
<p>Ballkomitéen for høstballet velges av sittende festforening, mens ballkomitéene for vårballene velges
av UKEstyret og Bukkekollegiet for henholdsvis UKEballet og Bukkefesten.</p>

<p class="img subimg">
	<img src="/graphics/images/hostball_h10.jpg" alt="" />
	<span>Høstball 2010. Foto: Anders Fagereng</span>
</p>
<p class="img subimg">
	<img src="/graphics/images/hostball_h10_servering.jpg" alt="" />
	<span>Under store middager er det beboere som stiller opp som kelnere. Foto: Anders Fagereng</span>
</p>
<h2>H&oslash;stball</h2>
<p>
	Et av de flotteste arrangementene p&aring; BS er ballet.
	Dette arrangeres en gang hvert semester. I gallaantrekk
	f&aring;r man nyte et treretters m&aring;ltid, og
	dette passer s&aelig;rdeles godt i den erverdige bygningen.
	Stemningen kan beskrives som magisk og m&aring; oppleves!
</p>
<p>
	Etter Ballmiddagen spilles det opp til dans med et
	liveband. Mens noen danser, foretrekker andre &aring;
	ha midtspiel eller hygge seg i baren i musikksalongen.
	Festen fortsetter s&aring; med diskotek i peisestuen
	og servering i Billa.
</p>
<p>
	Rundt klokken ti s&oslash;ndag morgen vekker Haarn
	oc Blaese Orchester brukets beboere. Turen b&aelig;rer
	opp mot Frognerseteren, og man har fremdeles p&aring;
	seg sitt Ballantrekk.
</p>
<p>Dersom man etter en stund ikke
	skulle v&aelig;re &oslash;nsket i restauranten, begir
	man seg mot Majorstuen og et mer tolerant serveringssted.
	N&aring;r klokken n&aelig;rmer seg fem tar man turen
	tilbake til BS for &aring; spise s&oslash;ndagsmiddag.
	P&aring; kvelden arrangerer Festforeningen caf&eacute;
	avec med levende musikk og fest ut i de sm&aring;
	timer.
</p>';

$foreninger->gen_page();