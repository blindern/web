<?php

bs_side::set_title("Blindern Bad og Badstu forening (BBB)");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("bbb");

echo '
<h1>Blindern Bad og Badstu forening (BBB)</h1>
<p>
	Denne ordenen ble startet i 1986 for &aring; fremme
	psykisk og fysisk velv&aelig;re blant Blindern Studenterhjems
	gutter. Det er opptak til foreningen en gang i semesteret,
	og de som blir valgt ut blir satt p&aring; pr&oslash;ve
	en hel kveld.</p>
<p>N&aring;r man f&oslash;rst er blitt
	medlem best&aring;r stort sett aktivitetene i &aring;
	sitte i badstuen, drikke &oslash;l og nyte et &aring;ndelig
	broderskap som varer livet ut.
</p>';

$foreninger->gen_page();