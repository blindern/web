<?php

bs_side::set_title("Festforeningen");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("festforeningen");

echo get_right_img_gal(109, null, "Festforeningen Hatlem, høsten 2011.", "Foto: Henrik Steen");
echo get_right_img_gal(164, null, "Festforeningen arrangerer to temafester hvert semester. Her fra temaet &quot;all but clothes&quot; høsten 2012.", "Foto: Henrik Steen");

echo '
<h1>Festforeningen</h1>
<p>
	Festforeningen velges ut for et semester av gangen.
	Oppgavene deres er &aring; organisere de fleste festene
	og s&oslash;rge for at BS sin egen pub er &aring;pen
	hver onsdag.</p>
<p>&Aring; v&aelig;re med her betyr mye
	arbeid, men det er et minne for livet og s&aring;
	absolutt verdt det.
</p>


<h2>Rebusl&oslash;p</h2>
<p>
	Etter hytteturen er det rebusl&oslash;p. De nyinnflyttede
	blir delt inn i lag og f&aring;r i oppgave &aring;
	bes&oslash;ke de ulike foreningene som presenterer
	seg.</p>
<p>Dette rebusl&oslash;pet er ikke som andre rebusl&oslash;p,
	og det vil v&aelig;re plenty av overraskelser p&aring;
	veien.
</p>

<p class="img img_right">
	<img src="/graphics/images/pygmemiddag_v10.jpg" alt="" />
	<span>Pygmémiddag våren 2010. Foto: Anders Fagereng</span>
</p>

<h2>Pygm&eacute;middag</h2>
<p>
	Den siste s&oslash;ndagen i januar og august er til &aelig;re
	for de som har flyttet inn. Det serveres et finere
	m&aring;ltid og etterp&aring; er det fest med liveband.</p>
<p>Dersom du ikke har h&oslash;rt om begrepet midtspiel
	f&oslash;r, s&aring; vil du oppleve ditt f&oslash;rste
	p&aring; dette arrangementet.
</p>

<h2>17. mai</h2>
<p>Feiring av nasjonaldagen på bruket er en morsom og innholdsrik opplevelse.</p>
<p>Dagen begynner tidlig med at Haarn og Blaese går vekkerunde. Dette skjer rundt halv
syv. Fra klokken syv avholdes et champagnevorspiel på Balustraden for
de som skal dyppes. Varselet om at man skal dyppes gis i form av en
invitasjon til champagnevorspiel som legges i posthyllen ut på kvelden
16. mai. Antrekk til vorspielet er badetøy og slåbrok med badesko eller
tøfler. Det er vanlig at dommerne som skal forestå dyppingen deltar på
vorspielet inkognito, det vil si kledd som om de også skal dyppes.
Haarn og Blaese er selvskrevne gjester på champagnevorspielet.</p>
<p>Litt før klokken åtte trekker forsamlingen ned fra Balustraden og ut
til flaggstangen. Der heises flagget, det holdes tale og nasjonalsangen
synges. Talen til flagget er en tradisjonell syttendemaitale.
Når seansen ved flaggstangen er over spaserer man ned til syvhundregangen
hvor talen til lønnen avholdes. Lønnetalen reflekter over livet på
Blindern og livet som student generelt. Den avsluttes med en offergave
til lønnen i form av en flaske gin, i det håp at man neste år vil få
“høyere lønn”.</p>
<p>Rundt halv ni begynner selve dyppeseremonien ved fonten. Domstolen
som skal avgjøre de innkaltes dyppverdighet består av en hoveddommer,
en aktor og en forsvarer. Prosedyrene er skrevet på forhånd og går på
rim. Dommerpanelet kaller frem de inviterte etter tur og avgjør tiltalen
og om vedkommende bør dyppes.</p>
<p>Dersom de bestemmer seg for å ilegge dypping, vasser tiltalte ned
i fonten og stiller seg med ansiktet vendt mot dommerne. Bødlene
eksekverer dommen ved å senke tiltalte med ryggen først ned i og under
vannet det antall ganger dommen tilsier. Når dyppingen er overstått
går man inn i matsalen og nyter en frokost av det beste kjøkkenet har
å tilby.</p>
<p>I løpet av formiddagen tar man turen ned til sentrum sammen med
Haarn og Blaese og forsøker så godt det lar seg gjøre å ta del i barnetoget.</p>
<p>Rundt klokken to har det vært tradisjon for at Festforeningen
avholdt leker i hagen. Blant annet blir det arrangert “grøtkasting” på
præces. Etter middag arrangeres en café avec med levende musikk og dans ut
i de sene nattetimer.</p>


<h2>Bukkehaugsfestivalen</h2>
<p>...</p>

<h2>Øvrige arrangementer</h2>
<p>Festforeningen avholder en rekke arrangementer i løpet av semesteret. Som regel er det forskjellige
fester mellom høstsemesteret og vårsemesteret. Som regel vil du oppleve fester som:</p>
<ul>
	<li>Temafester hvert semester</li>
	<li>Sølecup</li>
	<li>Togafest</li>
	<li>Schussrenn</li>
	<li>Café Avec</li>
	<li>Russefest</li>
	<li>Foredrag i regi av festforeningen</li>
	<li>Billa Kino</li>
	<li>Julemøte</li>
</ul>

';

$foreninger->gen_page();