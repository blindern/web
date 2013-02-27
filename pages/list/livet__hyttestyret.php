<?php

bs_side::set_title("Hyttestyret");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("hyttestyret");

echo '
'.get_right_img_gal(104, null, "Småbruket tar seg vakkert ut i Bærumsmarka.", "Foto: Henrik Steen").'
'.get_right_img_gal(158, null, "Pygmétur i starten av semesteret er en flott mulighet for å bli godt kjent.", "Foto: Henrik Steen").'

<h1>Hyttestyret for Småbruket</h1>
<p>
	Sm&aring;bruket ligger ved Brunkollen i B&aelig;rumsmarka og er studenterhjemmet sin flotte hytte.
	Hytta ligger i fint turterreng og er en flott laftet
	t&oslash;mmerbygning med stor peisestue og badstue.
</p>
<p>Hytta leies ut til beboere, andre studenter, bedrifter og turinteresserte og er et flott tilbud for å få en avslappende helg.</p>
<p>Hyttesjefen velges på semestermøtet hvert år. Medlemmer i hyttestyret sitter som regel over flere perioder og skifter ikke nødvendigvis ved semestermøtet. Hyttestyret lyser med gjevne mellomrom ut nye stillinger etter hvert som folk forlater styret.</p>

<h2>Pygmétur</h2>
<p>Hyttestyret arrangerer pygmétur i starten av hvert semester. Dette er en bli-kjent tur og drar med opp mot 50 personer opp til hytta!</p>

<p class="img img_right">
	<img src="/graphics/images/hyttetur_h10.jpg" alt="Pygmétur høsten 2010" />
	<span>Pygmétur høsten 2010. Foto: Henrik Steen</span>
</p>
<p>
	Dersom du flytter inn p&aring; h&oslash;sten s&aring;
	vil det f&oslash;rste arrangementet du blir invitert til v&aelig;re
	en hyttetur sammen med de andre nyinnflyttede.
</p>
<p>Turen g&aring;r til Blindern Studenterhjems hytte i B&aelig;rumsmarka. Det vanker mange oppgaver som er ment &aring; veve dere sammen til en gjeng.</p>
<p>P&aring; kvelden er det fyr i peisen og flere ulike konkurranser.
	Dersom stemingen var litt spent til &aring; begynne
	s&aring; sitter ordene garantert litt l&oslash;sere
	i munnen n&aring;.</p>

<h2>Hyttedugnad</h2>
<p>Senere i semesteret arrangeres hyttedugnad. Det er hyttestyret og beboerne selv som står for vedlikehold av hytta, og hyttedugnad teller som to ordinære dugnader på studenterhjemmet.</p>

<p>Se mer informasjon om Småbruket på egen side:<br />
<a href="/smaabruket">blindern-studenterhjem.no/smaabruket</a></p>';

$foreninger->gen_page();