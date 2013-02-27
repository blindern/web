<?php

bs_side::set_title("Velferden");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("velferden");

echo '
<h1>Velferden</h1>

<p>Oppmenn under velferden:</p>
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