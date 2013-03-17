<?php

bs_side::set_title("Studentbolig i Oslo");
bs_side::$lang_crosslink['en'] = "en/housing";

echo get_rand_images_right(
	array(
		115, // biblioteket
		137, // skilt ved pærealeen
		//155, // oversiktsbilde fra universitetet
		160, // mat 17. mai
		190, // østfløy fra sørsiden
		195, // alette i peisestua
		197, // dobbeltrom hovedbygget
		198, // dobbeltrom med standardinventar på vestfløy
		199, // bad på vestfløy
		//154, // personlig innredet rom østfløy
		200, // enkeltrom vestfløy
		206, // kjøkkenpersonal
		208, // matsal med personer
		210, // peisestua
		216, // porten fra uio
		218, // skilt fra oslo byes vel
		219, // skulptur dør hovedbygg
	),
	4);

echo '
<h1>Studentbolig i Oslo</h1>
<h2>Hva slags bolig tilbyr BS?</h2>
<p>
	Det er plass til over 220 studenter p&aring;
	studenterhjemmet. For &aring; hjelpe beboerne inn i
	studenterhjemmets unike sosiale milj&oslash; flytter
	de aller fleste f&oslash;rst inn p&aring; dobbeltrom
	eller kombinasjonsrom. Et kombinasjonsrom er to rom
	hvor man m&aring; g&aring; gjennom det ene rommet for
	&aring; komme til det andre.</p>
<p>Etter et kort opphold p&aring;
	dobbeltrom eller kombinasjonsrom vil man kunne søke om plass
	på ledige enkeltrom. Romfordelingen er basert p&aring;
	ansiennitet, og desto lengre tid du bor p&aring; studenterhjemmet,
	jo st&oslash;rre og nyere rom vil du kunne f&aring;.
</p>


<h2>Hva er inkludert i husleien?</h2>

<ul class="spaced">
	<li><span class="u">Full kost og losji</span>. Tre måltider servert hver dag med varierende retter med
		fokus på et sunt tilbud.</li>
	<li><span class="u">Rommet er fullt m&oslash;blert</span>
		n&aring;r du flytter inn, men du har ogs&aring;
		mulighet til &aring; bytte ut noen av studenterhjemmets
		m&oslash;bler med dine egne.</li>
	
	<li><span class="u">Tilgang til Internett</span>. Dette er
		den samme nettforbindelsen som Studentsamskipnaden i Oslo
		tilbyr i sine studentbyer.</li>

	<li><span class="u">Fasttelefon</span> finnes p&aring; enkelte rom.
		Det er gratis &aring; ringe andre beboere. Dersom du bruker telefonen til &aring;
		ringe eksternt, belastes dette automatisk p&aring; den m&aring;nedlige husleiefakturaen.</li>

	<li><span class="u">Str&oslash;mforbruk er inkludert i den faste leieprisen.</span> Dette bidrar til
		&aring; gi beboerne en forutsigbar &oslash;konomi.</li>

	<li><span class="u">Studentvaskeriet</span> gir mulighet for vask av kl&aelig;r, senget&oslash;y og lignende. Dette
		betaler man allerede gjennom husleia, og man kan vaske så lenge det er ledige maskiner.</li>

	<li>Et bredt og unikt <a href="studentbolig/velferdstilbud">velferdstilbud</a></span> samt det gode <a href="/livet">miljøet</a> studenterhjemmet byr på.</li>
</ul>

<div class="mattider">
	<h2>Mat-tider</h2>
	<p><u>Mandag-fredag:</u><br />Frokost 07.15-09.00. Middag 14.30-17.30. Kveldsmat 19.30-20.30.</p>
	<p><u>Lørdag:</u><br />Frokost 08.00-10.00. Middag 14.00-15.30. Kveldsmat 18.00-19.30.</p>
	<p><u>Søndag:</u><br />Frokost 10.00-11.30. Middag 17.00-18.30. Ingen kveldsmat.</p>
</div>

<h2>Tre daglige m&aring;ltider pluss matpakke</h2>
<p>
	Hver dag serveres tre m&aring;ltider p&aring; Blindern
	Studenterhjem. Disse foreg&aring;r til fleksible tider
	og er inkludert i husleien. I tillegg kan beboerne
	sm&oslash;re matpakke ved frokost og kvelds og p&aring;
	dagen hente kaffe og te fra matsalen.
</p>
<ul class="spaced">
	<li><span class="u">Frokostbuffeten</span> inkluderer et bredt
	utvalg av br&oslash;d, knekkebr&oslash;d, p&aring;legg
	og frokostblandinger, samt ulike typer melk og juice.</li>
	<li><span class="u">Middagen</span> som serveres hver dag er variert
	og n&aelig;ringsrik. Som beboer vil du i l&oslash;pet
	av en uke f&aring; servert b&aring;de kj&oslash;tt
	og fisk, samt et sortiment av gr&oslash;nnsaker og
	annet tilbeh&oslash;r. Hver fredag serveres den s&aring;kalte
	&#8221;ungdomsmiddagen&#8221; som gjerne best&aring;r
	av hamburgere, tacos, eller bugnende buffeter med
	meksikansk eller orientalsk tema, og s&oslash;ndag
	middag er spesielt forseggjort og inkluderer dessert.</li>
	<li><span class="u">Kveldsmaten</span> er ogs&aring; en buffet
	som stort sett tilsvarer frokostbuffeten. og er stort
	sett lik utvalget man har til frokostbuffeten.</li>
</ul>

<h2>Parkering</h2>
<p>
	Studenthjemmet har et begrenset antall parkeringsplasser
	til utleie. Prisen er kr 500,- per semester. Det er også mulighet
	for gratis korttidsparkering, man må da ta kontakt med kontoret eller
	Kollegiet (utenom kontortid).
</p>';