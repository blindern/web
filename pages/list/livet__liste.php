<?php

bs_side::set_title("Foreninger og grupper på BS");
bs_side::$page_class = "foreninger";

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();

echo '
<h1>Foreninger og grupper på BS</h1>

<p>I listen til venstre finnes en oversikt over de ulike foreningene og gruppene ved studenterhjemmet.</p>
<p>Det finnes også andre mer uformelle og uoffisielle grupper på studenterhjemmet, men disse er ikke omtalt her.</p>';

$foreninger->gen_page();