<?php

bs_side::set_title("Digital omvisning");
require BASE."/omvisning.php";

omvisning::init();

// sjekk for korrekt adresse
$image_id = null;
if (count(bs_side::$pagedata->path_parts) > 2) {
	if (count(bs_side::$pagedata->path_parts) > 3 || !is_numeric(bs_side::$pagedata->path_parts[2])) {
		bs_side::page_not_found();
	}
	
	$image_id = bs_side::$pagedata->path_parts[2];
	
	// verifiser at vi har bildet
	if (!isset(omvisning::$images_category[$image_id])) {
		bs_side::page_not_found("<pP>Bildet du refererte til ble ikke funnet.</p>");
	}
}


$link_img = bs_side::$pagedata->doc_path."/studentbolig/omvisning/%d";

bs_side::$head .= '
<!--<script src="/lib/mootools/mootools-1.2.x-core-nc.js" type="text/javascript"></script>-->
<!--<script src="http://ajax.googleapis.com/ajax/libs/mootools/1.2.4/mootools-yui-compressed.js"></script>-->
<!--<script src="/lib/mootools/mootools-1.2.x-more-nc.js" type="text/javascript"></script>-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js" type="text/javascript"></script>
<!--<script src="'.bs_side::$pagedata->doc_path.'/default.js"></script>-->
<script src="'.bs_side::$pagedata->doc_path.'/omvisning.js"></script>';

echo '
<h1>Digital omvisning</h1>
<div id="omvisning_bilde_w" class="omvisning_bilde_skjult2">
	<p id="omvisning_nav">
		<span id="omvisning_back"><span>Tilbake til oversikt</span></span>
		<span id="omvisning_prev"><span>Forrige bilde</span></span>
		<span id="omvisning_next"><span>Neste bilde</span></span><br />(Piltaster kan også benyttes.)
	</p>
	<p id="omvisning_bilde">
		<img src="http://blindern-pp.hsw.no/graphics/omvisning/trapp_paere.jpg" alt="" />
		<span>Bunnen av pærealleen. T-banen ligger ca 70 meter til venstre for denne trappen. Foto: Cecilie Sæle Merkesvik</span>
	</p>
</div>
<div id="omvisning_bilde_inactive">
	<ul id="omvisning_liste">
		<li>Bilder
			<ul>';

foreach (omvisning::$categories as $category) {
	echo '
				<li><a href="#c'.$category->id.'">'.htmlspecialchars($category->data['oc_title']).'</a></li>';
}

echo '
			</ul>
		</li>
		<li><a href="#cmedia">Media om Blindern Studenterhjem</a></li>
	</ul>
	<p id="omvisning_bilder_h">Trykk på et bilde for å vise stort bilde og beskrivelse.</p>
	<div id="omvisning_bilder">';

foreach (omvisning::$categories as $category) {
	echo '
		<div class="omvisning_bilder_cat">
			<h2 id="c'.$category->id.'">'.htmlspecialchars($category->data['oc_title']).'</h2>
			<div class="omvisning_bilder_g">';
	
	foreach ($category->images as $image)
	{
		$key = substr(md5($image->data['oi_file']), 0, 7);
		
		$text = $image->data['oi_text'];
		if ($text && $image->data['oi_foto']) $text .= " ";
		if ($image->data['oi_foto']) $text .= "Foto: " . $image->data['oi_foto'];
		
		if ($text && $image->data['oi_date']) $text .= " ";
		if ($image->data['oi_date']) $text .= "(".$image->data['oi_date'].")";
		
		echo '<!-- avoid inline-block spacing
			--><p id="img_'.$key.'"><!--
				--><a href="'.sprintf($link_img, $image->id).'"><!--
					--><img src="'.omvisning::$link.'/thumb.php?file='.htmlspecialchars($image->data['oi_file']).'" alt="'.htmlspecialchars($text).'" title="'.htmlspecialchars($text).'" /><!--
				--></a></p>';
	}
	
	echo '
			</div>
		</div>';
}

echo '
	</div>
	
	<div id="omvisning_media">
		<h2 id="cmedia">Media om Blindern Studenterhjem</h2>
		<p>Blindern Studenterhjem ble k&aring;ret av TV-Norge til beste studentbolig i Oslo.</p>
		<!--<object width="425" height="350">
			<param name="movie" value="http://www.youtube.com/v/0q4U6N6Qsd4"></param>
			<embed src="http://www.youtube.com/v/0q4U6N6Qsd4" type="application/x-shockwave-flash" width="425" height="350"></embed>
		</object>-->
		
		<object width="640" height="505"><param name="movie" value="http://www.youtube.com/v/0q4U6N6Qsd4?fs=1&amp;hl=nb_NO&amp;rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/0q4U6N6Qsd4?fs=1&amp;hl=nb_NO&amp;rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="505"></embed></object>
	</div>
</div>';