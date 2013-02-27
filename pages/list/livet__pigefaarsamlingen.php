<?php

bs_side::set_title("Pigefaarsamlingen");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("pigefaarsamlingen");

echo '
<h1>Pigefaarsamlingen</h1>
<p>
	Pigefaarsamlingen ble startet opp i 1992, og hensikten
	var &aring; samle jentene p&aring; studenterhjemmet,
	ved &aring; arrangere diverse sammenkomster og utflukter.
</p>
<p>Pigefaarsamlingen disponerer sitt eget rom - pigerommet - der de inviterer til TV-kvelder og annet.

<h2>Semestermøte</h2>
<p>Pigefaarsamlingens styre sitter et halvt år om gangen, og i forbindelse med valget hvert semester arrangeres en stor og meget populær fest for alle jentene på studenthjemmet.</p>
<p>Her er det ulike former for innslag, og kvelden blir som regel ung for de fleste.</p>

<p class="img img_right">
	<a href="/studentbolig/omvisning#?img=afb76a1"><img src="/graphics/images/pige_juleverksted_h09.jpg" alt="" /></a>
	<span>Pigefaarsamlingen arrangerer her juleverksted julen 2009. Foto: Milla Melgaard</span>
</p>

<h2>Juleverksted</h2>
<p>Før hver jul er det tradisjon at Pigefaarsamlingen arrangerer juleverksted.
Her samles beboere for en hyggelig aften i peisestua hvor det lages julepynt og juletreet på studenterhjemmet blir pyntet.</p>';

$foreninger->gen_page();