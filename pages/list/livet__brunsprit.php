<?php

bs_side::set_title("Brun Sprit");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("brunsprit");

echo '
<h1>Brun Sprit</h1>

<p>Informasjon kommer!</p>';

$foreninger->gen_page();