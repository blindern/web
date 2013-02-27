<?php

bs_side::set_title("Pigenes Musikalske Selskab (PMS)");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("pms");

echo '
<h1>Pigenes Musikalske Selskab (PMS)</h1>
<p>...</p>';

$foreninger->gen_page();