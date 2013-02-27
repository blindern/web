<?php

bs_side::set_title("Blindern Studenterkollegium");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("kollegiet");

echo '
<h1>Blindern Studenterkollegium (Kollegiet)</h1>

<p>Oppmenn under kollegiet:</p>
<ul>
	<li>Arkivar/skapoppmann</li>
	<li>Badstueoppmann</li>
	<li>Bibliotekar</li>
	<li>Dugnadsleder (2 stk)</li>
	<li>Ekstern styremedlem</li>
	<li>Hjemmesideoppmann</li>
	<li>Lesesalinspektør</li>
	<li>Madrassoppmann (2 stk)</li>
	<li>Medisinalkollegiet (2 stk)</li>
	<li>Redaktør for Blindernåret</li>
	<li>Studentkjøkkenoppmann</li>
	<li>Vaktsjef</li>
</ul>
<p>Kollegiet kan også kontaktes per e-post på <a href="mailto:kollegiet@blindern-studenterhjem.no">kollegiet@blindern-studenterhjem.no</a>.</p>';

$foreninger->gen_page();