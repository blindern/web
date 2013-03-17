<?php

bs_side::set_title("Bukkekollegiet");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("bukkekollegiet");

echo '
'.get_right_img_gal(121, null, "Bukkefesten er en gammel tradisjon på bruket. Her mottar gamle beboere heder og ære etter god innsats i løpet av sin botid på hjemmet.", "Foto: Anders Fagereng").'
'.get_right_img_gal(217, null, "Jan IV - brukets beskytter.", "Foto: Petter Gripheim").'

<h1>Bukkekollegiet</h1>

<p>Bukkekollegiet består av tre beboere som forvalter en av studenterhjemmets eldste og mest
eiendommelige tradisjoner, Bukkeordenen, som ble innstiftet i 1926 av Georg Klem.
Blindern Studenterhjems høye beskytter er Hans Majestet Den Blinde Bukk, og tidligere beboere eller
andre som har gjort en særskilt innsats for studenterhjemmet kan bli tildelt Hans Majestets
orden under den såkalte bukkefesten, som arrangeres annenhver vår.</p>
<p>Ordenen har tre grader, Halv Bukk ( = Ridder), Hel Bukk (= Kommandør) og Høy Bukk (= Storkors).</p>
<p>I spisesalen henger det skjold som er laget i anledning utnevnelse av bukken og som deles ut på bukkefesten.</p>';

$foreninger->gen_page();