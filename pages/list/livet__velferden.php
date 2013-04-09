<?php

bs_side::set_title("Velferden");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("velferden");

echo '
<h1>Velferden</h1>

<p>Velferden står for velferdstiltakene på bruket, og fører tilsyn med de forskjellige fellesrom,
unntatt biblioteket, biblionette og gymsalen.</p>

<p>Velferdssjefen velges av semestermøtet og sitter i ett år.</p>

<p>Velferdssjefen fastsetter velferdsaktivitetene, og utnevner oppmenn til
disse for ett semester av gangen.</p>

<p>Se listen over <a href="/studentbolig/velferdstilbud">velferdstilbud</a> for en
liste over mange av tilbudene som finnes på bruket, hvorav de fleste
ligger under velferdssjefen.</p>

<p>Oppmenn under velferden (per vår 2013):</p>
<ul>
	<li>Biljard- og fotballspilloppmann</li>
	<li>Boccia- og croquetoppmann</li>
	<li>Bordtennisoppmann</li>
	<li>Flaggoppmann</li>
	<li>Fotoromsoppmann</li>
	<li>Fuglekasseoppmann</li>
	<li>Hovmesteri Valhall</li>
	<li>Internmailoppmann</li>
	<li>Kopioppmann</li>
	<li>Kostymelageroppmann</li>
	<li>Kubboppmann</li>
	<li>Musikkromoppmann (2 stk)</li>
	<li>Peisoppmann</li>
	<li>Projektor- og videokameraoppmann</li>
	<li>Spilloppmann</li>
	<li>Symaskinoppmann</li>
	<li>TV-stueoppmann</li>
	<li>Vaskelisteoppmann</li>
	<li>Verktøyoppmann</li>
</ul>';

$foreninger->gen_page();