<?php

bs_side::set_title("Biblioteksutvalget");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("biblioteksutvalget");

echo '
<h1>Biblioteksutvalget</h1>
<p>Biblioteksutvalget forvalter boksamlingen til Blindern Studenterhjem. Helt fra 1925 har studenthjemmet mottatt en kontinuerlig strøm av nye bøker. Biblioteksutvalget i ledelse av bibliotekaren sørger for at relevant og oppdatert litteratur er utstilt ryddig i biblioteket.</p>
<p>Utvalget kommer også med bokanbefalinger, og de arrangerer jevnlig kulturelle arrangementer, for eksempel foredrag, teaterutflukter og museumsbesøk.</p>';

$foreninger->gen_page();
