<?php

bs_side::set_title("Foreningsstyret");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("foreningsstyret");

echo '
<h1>Foreningsstyret</h1>
<p>
	Det eksisterer mange klubber, foreninger og lag p&aring;
	Blindern Studenterhjem. De større av dem er organisert
	under Foreningen Blindern Studenterhjem. Foreningsstyret står for Foreningens løpende virksomhet.
</p>
<p>Hvert semester avholder foreningsstyret fordeling, hvor både undergruppene så vel som øvrige foreninger og grupper, og til og med enkeltpersoner
kan søke om midler til tiltak som vil komme beboerne til gode.</p>
<p>Midlene kommer fra en del av husleien og overskudd fra fester og arrangementer.</p>

<h2>Foreningsrådet</h2>
<p>Foreningsrådet består av seks medlemmer og bidrar til at foreningen har stabil kontinuitet.
De forvalter Foreningsfondet, gjennomgår regnskapet til foreningen og gir samtykke til avgjørelser
som har særlig stor betydning for foreningen.</p>

<h2>Foreningens semestermøte</h2>
<p>På foreningens semestermøte velges foreningsstyret og medlemmer til undergruppene. Her har beboerne mulighet til å
ta opp saker som angår foreningen og mye av det sosiale som foregår på bruket.</p>';

$foreninger->gen_page();