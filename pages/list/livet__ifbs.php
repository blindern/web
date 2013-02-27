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


<p>
	Dette er BS sin idrettsforening. Deres oppgaver
	er &aring; organisere turer, idrettsarrangementer
	og &aring; holde orden i gymsalen.</p>
<p>I tillegg til større arrangementer, arrangerer IFBS felles joggetur, ballspill på Blindern Athletica, spinning/sykling hver uke gjennom hele semesteret. IFBS bidrar til å holde den sportslige kulturen oppe.</p>
<p>Blant annet blir
	det &aring;rlig arrangert tur til Hemsedal i midten
	av v&aring;rsemesteret.
</p>';

$foreninger->gen_page();