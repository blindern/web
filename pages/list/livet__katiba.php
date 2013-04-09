<?php

bs_side::set_title("Katiba Wa Mbilikimo");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("katiba");

echo '
<h1>Katiba Wa Mbilikimo</h1>

<p>Informasjon kommer!</p>';

$foreninger->gen_page();