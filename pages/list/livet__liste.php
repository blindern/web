<?php

bs_side::set_title("Foreninger og grupper på BS");
bs_side::$page_class = "foreninger";

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();

echo '
<h1>Foreninger og grupper på BS</h1>

<div class="subsection noimg">
	<h2>Foreningsstyret</h2>
	<p>
		Det eksisterer mange klubber, foreninger og lag p&aring;
		Blindern Studenterhjem. De fleste av dem er organisert
		under foreningsstyret. Foreningsstyret st&aring;r
		for fordeling av midler til de ulike foreningene.
	</p>
	<p>
		Midlene kommer fra en del av husleien og overskudd
		fra fester. Du kan f&aring; en kort oversikt over
		noen av foreningene på denne siden.
	</p>
</div>';

$foreninger->gen_page();