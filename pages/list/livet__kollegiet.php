<?php

bs_side::set_title("Blindern Studenterkollegium");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("kollegiet");

echo '
<h1>Blindern Studenterkollegium (Kollegiet)</h1>

<p><i>Blindern Studenterkollegium består av seks tillitsmenn valgt av og blant studentene på Blindern Studenterhjem.
	Kollegiet avgjør spørsmål vedrørende studentenes personlige forhold på og til Hjemmet, og tjener
	som mellomledd mellom studentene og Hjemmets administrasjon, Styre og Råd.</i></p>
<p><i>
	Kollegiet står som øverste fortolker i de videre Statutter, Instrukser, Reglement og Retningslinjer.
	Kollegiet står fritt til å vedta og endre de overnevnte bestemmelser, med unntak av de som er
	vedtatt av Styret, Allmannamøtet, Semestermøtet og Husrådet.</i>
</p>

<p>Kollegiet har møter hver mandag, og ellers når det er nødvendig. På kollegietavla er til en hver tid oppdatert informasjon tilgjengelig.
Kollegiet kan også kontaktes per e-post på <a href="mailto:kollegiet@blindern-studenterhjem.no">kollegiet@blindern-studenterhjem.no</a>.</p>

<h2>Bråk/støy - disiplinærorgan</h2>
<p>Bråk skal i utgangspunktet påtales til den det gjelder. Et gangtilsyn kan også kontaktes for hjelp. Gangtilsynet kan igjen om nødvendig kontakte kollegiet.</p>
<p>Kollegiet er disiplinærorgan på Hjemmet. Kollegiet kan gi ulike sanksjoner, og i verste fall kan kollegiet innstille på utkastelse av en enkelt beboer. Mer normalt er
at beboeren blir kalt inn til kollegiemøte og at kollegiet gir en muntlig irettesettelse.</p>

<h2>Stillinger og oppmenn under kollegiet</h2>

<p>Stillinger som ansettes av kollegiet er nøkkelpersoner som bidrar til driften av studenterhjemmet. Disse mottar en reduksjon i husleia (angitt i parentes).</p>
<ul>
	<li>Arkivar/skapoppmann (12,5 %)</li>
	<li>Bibliotekar (12,5 %)</li>
	<li>Dugnadsleder (2 stk) (25 %)</li>
	<li>Hjemmesideoppmann (12,5 %)</li>
	<li>Vaktsjef (12,5 %)</li>
</ul>

<p>Oppmenn under kollegiet:</p>
<ul>
	<li>Badstueoppmann</li>
	<li>Lesesalinspektør</li>
	<li>Madrassoppmann (2 stk)</li>
	<li>Medisinalkollegiet (2 stk)</li>
	<li>Redaktør for Blindernåret</li>
	<li>Studentkjøkkenoppmann</li>
</ul>
<p>I tillegg utnevner Kollegiet en beboer som styremedlem (&quot;eksternt styremedlem&quot;), i tillegg til kollegiets eget styremedlem.</p>

<h2>Gangtilsyn</h2>
<p>På hver gang finnes det to til tre gangtilsyn. Gangtilsynets oppgave er å påtale bråk, påtale rot i gangene, orientere mangler og uregelmessigheter på gangen til vedlikehold/kontoret og andre oppgaver.
	Ved brannalarm har gangtilsynet spesielle oppgaver.</p>
<p>Gangtilsynet utnevnes fritt av kollegiet og får delta på velferdsfesten.</p>

<h2>Allmannamøtet</h2>
<p>...</p>';

$foreninger->gen_page();