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

<p>Stillinger under kollegiet:</p>
<p>Dette er nøkkelpersoner som bidrar til driften av studenterhjemmet. Disse mottar en reduksjon i husleia (angitt i parentes).</p>
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
<p>...</p>

<h2>Kontakt Kollegiet</h2>
<p>Kollegiet kan også kontaktes per e-post på <a href="mailto:kollegiet@blindern-studenterhjem.no">kollegiet@blindern-studenterhjem.no</a>.
	På kollegietavla er til en hver tid oppdatert informasjon tilgjengelig.</p>';

$foreninger->gen_page();