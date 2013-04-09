<?php

bs_side::set_title("Biblioteksutvalget");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("biblioteksutvalget");

echo '
<h1>Biblioteksutvalget</h1>
<p>Informasjon kommer!</p>';

$foreninger->gen_page();