<?php

bs_side::set_title("Festforeningen");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("festforeningen");

echo '
<p class="img img_right">
	<img src="/graphics/images/festforening_temafest.jpg" alt="" />
	<span>Festforeningen arrangerer to temafester hvert semester. Her fra temaet eventyr høsten 2010. Foto: Sindre Grading</span>
</p>

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

<h2>Bukkehaugsfestivalen</h2>
<p>...</p>

<h2>Øvrige arrangementer</h2>
<p>Festforeningen avholder en rekke arrangementer i løpet av semesteret. Som regel er det forskjellige
fester mellom høstsemesteret og vårsemesteret. Som regel vil du oppleve fester som:</p>
<ul>
	<li>Temafester hvert semester</li>
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