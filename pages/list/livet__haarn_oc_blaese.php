<?php

bs_side::set_title("Blindern Haarn oc Blase Orchester");

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();
$foreninger->set_active("haarn_oc_blaese");

// bilde brukt: http://www.facebook.com/photo.php?pid=100193&id=118776114828317

echo get_right_img_gal(224, null, "Haarn oc Blaese", "Foto: Eivind Mørk");

echo '
<h1>Blindern Haarn oc Blaese Orchester</h1>

<p>
	Dette orkesteret er ikke som andre orkestere. Med
	schl&aelig;gers som Derrick, Final Countdown, Fairytale og annet snadder sprer de glede og galskap.
	P&aring; CV-en kan de skryte med gjentatte opptredener
	p&aring; P3, i utdrikningslag og bryllup og &aring; ha sneket seg inn foran slottet
	i barnetoget p&aring; 17.mai.
</p>
<ul>
	<li><a href="files/BS_musikk/HaarnocBlaese1.mp3" target="_blank">
		Haarn oc Blaese og P3morgen tar imot folk som ankommer p&aring; Gardermoen (mp3)
	</a></li>
	<li><a href="http://www.youtube.com/watch?v=X77unZfzhqQ&mode=related&search=" target="_blank">
		Haarn oc Blaese i 17.mai barnetoget (Youtube)
	</a></li>
</ul>

<p>Haarn oc Blaese har faste øvinger hver onsdag kl 20 i musikkrommet. Bare kom innom
om du vil være med, så finner vi et passende instrument til deg!';

$foreninger->gen_page();
