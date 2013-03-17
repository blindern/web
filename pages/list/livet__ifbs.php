<?php

bs_side::set_title("Idrettsforeningen Blindern Studenterhjem (IFBS)");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("ifbs");

echo '
<h1>Idrettsforeningen Blindern Studenterhjem (IFBS)</h1>

<p class="img img_right">
	<img src="/graphics/images/volleyball.jpg" alt="" />
	<span>Volleyballturnering på egen volleyballbane under idrettsdagen til IFBS våren 2010. Foto: Anders Fagereng</span>
</p>
<p class="img img_right">
	<img src="/graphics/images/tennisbane.jpg" alt="" />
	<span>Tennisbanen er ofte i bruk på våren og tidlig på høsten. Her fra idrettsdagen til IFBS våren 2010. Foto: Anders Fagereng</span>
</p>

'.get_right_img_gal(58, null, "Ballspill i gymsalen på studenterhjemmet. Spilles normalt i gymsalen på Blindern Athletica.", "Foto: Henrik Roald").'

<p>Dette er BS sin idrettsforening. Deres oppgaver
	er &aring; organisere turer, idrettsarrangementer
	holde orden i gymsalen og vedlikeholde tennisbanene og sandvolleyballbanen.</p>
<p>IFBS er medlem av Norges Idrettsforbund og Norges Studentidrettsforbund.</p>
<p>Ved semestermøtet velges leder av IFBS. Lederen utpeker selv sine medlemmer.</p>

<h2>&quot;Faste&quot; IFBS-arrangementer</h2>
<p>IFBS arrangerer mange faste arrangementer. Hva som arrangeres varierer litt fra IFBS-styre til IFBS-styre, men fast i det siste har vært:</p>
<ul>
	<li>Joggetur hver mandag</li>
	<li>Styrkesirkel (&quot;styrkel&quot;) hver onsdag</li>
	<li>Ballspill hver torsdag (på Blindern Athletica)</li>
</ul>
<p>Tidligere har det også vært avholdt ukentlige hiphop-treninger, sprint-treninger, svømmedager og annet.</p>

<h2>Arrangementer og utflukter</h2>
<p>IFBS pleier å arrangere turer hvert semester i tillegg til en rekke forskjellige arrangementer. Et knippe utvalg de siste årene:</p>
<ul>
	<li>Hemsedalstur (våren 2012 ble det i stedet tur til Studentlekene i Trondheim)</li>
	<li>Holmenkollstafetten er fast innslag hver vår. IFBS har en rekke pokaler fra deltakelse.</p>
	<li>IFBS sine sommerleker: konkurranser i tennis, sandvolleyball, sprint, kasting m.v.</li>
</ul>
<p>Som mye annet er det litt til og fra hva som blir arrangert de ulike semestrene/årene.</p>

';

$foreninger->gen_page();