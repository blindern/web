<?php

bs_side::set_title("Katiba Wa Mbilikimo");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("katiba");

echo '
<h1>Katiba Wa Mbilikimo</h1>

<p>Katiba Wa Mbilikimo er Swahili og betyr &quot;Orden av pygméer&quot;.</p>
<p>I 1998 ble &laquo;Ordenen Katiba Wa Mbilikimo&raquo; stiftet. Dens formål er
å fremme de nyinnflyttede pygméenes trivsel og samhold, samt å være et
springbrett til videre foreningsvirksomhet på BS.</p>

<h2>&laquo;Jakten&raquo;</h2>

<p>Katiba arrangerer fester og kurs for sine medlemmer, det største
arrangementet hvert semester for ordenen er &laquo;Jakten&raquo; (på folkemunne PPP) som
går parallellt med Pigeforsamlingens semestermøte. Det deles ut fellingstillatelser
på pigefaar og de dresskledde medlemmene samles i peisestuen for å spille poker og blackjack, nyte live
musikk og eksotisk underholdning følger med.</p>

<p>De vakre bunnyene som er til stede er der for å fremme trivsel og øke motivasjonen til hva som
venter festdeltakerene nede i Billa Bar, de forventer å bli tatt godt vare på,
og hvis du gjør det, behandler de deg som en ekte James Bond ved pokerbordet.</p>

<p><i>Katiba - Av pygméer for pygméer</i></p>';

$foreninger->gen_page();