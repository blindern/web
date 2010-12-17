<?php

bs_side::set_title("Digital omvisning");
require BASE."/omvisning.php";

bs_side::$head .= '
<script src="/lib/mootools/mootools-1.2.x-core-nc.js" type="text/javascript"></script>
<!--<script src="http://ajax.googleapis.com/ajax/libs/mootools/1.2.4/mootools-yui-compressed.js"></script>-->
<script src="/lib/mootools/mootools-1.2.x-more-nc.js" type="text/javascript"></script>
<script src="'.bs_side::$pagedata->doc_path.'/default.js"></script>
<script>
window.addEvent("domready", function()
{
	active_img = null;
	load_hm();
	var images = {};
	
	window.HM.addEvent("img-changed", function(data) {
		set_img(data);
	});
	window.HM.addEvent("img-removed", function() {
		set_img(null);
	});
	
	$$("#omvisning_bilder p").addEvent("click", function(e)
	{
		window.HM.set("img", this.get("id").substring(4));
		prepare(get_upcoming(this));
		
		(function(){$("omvisning_bilde").getParent().goto(-10);}).delay(1);
		
		e.stop();
	});
	$("omvisning_back").addEvent("click", function(){ window.HM.remove("img"); }).addEvent("mousedown", function(e){e.stop()});
	$("omvisning_prev").addEvent("click", function(){ rotate_img(true); }).addEvent("mousedown", function(e){e.stop()});
	$("omvisning_next").addEvent("click", function(){ rotate_img(); }).addEvent("mousedown", function(e){e.stop()});
	$("omvisning_bilde").addEvent("click", function(){ rotate_img(); });
	
	window.HM.recheck();
	
	function set_img(id)
	{
		var pa = active_img;
		var p = active_img = $("img_"+id);
		if (!p)
		{
			$("omvisning_bilde_inactive").setStyle("display", "");
			$("omvisning_bilde_w").addClass("omvisning_bilde_skjult");
			if (id) window.HM.remove("img");
			
			if (pa) pa.goto(-30);
			
			return;
		}
		
		$$("#omvisning_bilder p").removeClass("omvisning_aktiv");
		$("omvisning_bilde_inactive").setStyle("display", "none");
		
		var c = $("omvisning_bilde");
		c.empty().getParent().removeClass("omvisning_bilde_skjult");
		
		prepare(p).inject(c);
		new Element("p", {text: p.getElement("img").get("alt")}).inject(c);
		
		// sett thumbnail som aktivt
		p.addClass("omvisning_aktiv");
	}
	
	document.addEvent("keydown", function(event)
	{
		if (event.alt || event.control || event.meta || event.shift) return;
		
		// 27: esc
		if (event.code == 27)
		{
			window.HM.remove("img");
		}
		
		// 37: left, 39: right
		else if (event.code == 37 || event.code == 39)
		{
			var t = $(event.target).get("tag");
			if (t == "input" || t == "textarea") return;
			rotate_img(event.code == 37, event);
			
			event.stop();
		}
	});
	
	function rotate_img(prev, event)
	{
		// har vi bilde som referanse?
		if (!active_img) return;
		
		// hent bildet vi skal gå til
		var to = get_upcoming(active_img, prev);
		
		// last inn neste bilde vi forventer at blir vist
		prepare(get_upcoming(to, prev));
		
		window.HM.set("img", to.get("id").substring(4));
	}
	
	function get_upcoming(elm, prev)
	{
		var to = prev ? elm.getPrevious("p") : elm.getNext("p");
		
		// prøv neste gruppe
		if (!to)
		{
			to = elm.getParent(".omvisning_bilder_cat")[prev ? "getPrevious" : "getNext"](".omvisning_bilder_cat");
			if (to) to = to[prev ? "getLast" : "getFirst"]("p");
		}
		
		// roter til første/siste bilde
		if (!to)
		{
			f = prev ? "getLast" : "getFirst";
			to = $("omvisning_bilder")[f]("div")[f]("p");
		}
		
		return to;
	}
	
	function prepare(p)
	{
		var id = p.get("id").substring(4);
		if (!images[id])
		{
			images[id] = new Element("img");
			images[id].set("src", p.getElement("a").get("href"));
		}
		
		return images[id];
	}
});
</script>';



echo '
<h1>Digital omvisning</h1>
<div id="omvisning_bilde_w" class="omvisning_bilde_skjult">
	<p id="omvisning_nav">
		<span id="omvisning_back"><span>Tilbake til oversikt</span></span>
		<span id="omvisning_prev"><span>Forrige bilde</span></span>
		<span id="omvisning_next"><span>Neste bilde</span></span><br />(Piltaster kan også benyttes.)
	</p>
	<p id="omvisning_bilde"></p>
</div>
<div id="omvisning_bilde_inactive">
	<ul id="omvisning_liste">
		<li>Bilder
			<ul>';

foreach (array_keys(omvisning::$groups) as $category)
{
	$c = preg_replace("/[^\\w]/", "", strtolower($category));
	echo '
				<li><a href="#c'.$c.'">'.$category.'</a></li>';
}

echo '
			</ul>
		</li>
		<li><a href="#cmedia">Media om Blindern Studenterhjem</a></li>
	</ul>
	<p id="omvisning_bilder_h">Trykk på et bilde for å vise stort bilde og beskrivelse.</p>
	<div id="omvisning_bilder">';

foreach (omvisning::$groups as $category => $imgs)
{
	$c = preg_replace("/[^\\w]/", "", strtolower($category));
	
	echo '
		<div class="omvisning_bilder_cat">
			<h2 id="c'.$c.'">'.$category.'</h2>
			<div class="omvisning_bilder_g">';
	
	foreach ($imgs as $image)
	{
		$key = substr(md5($image['o_file']), 0, 7);
		
		$text = $image['o_text'];
		if ($text && $image['o_foto']) $text .= " ";
		if ($image['o_foto']) $text .= "Foto: " . $image['o_foto'];
		
		echo '<!-- avoid inline-block spacing
			--><p id="img_'.$key.'"><!--
				--><a href="'.omvisning::$link.'/'.htmlspecialchars($image['o_file']).'"><!--
					--><img src="'.omvisning::$link.'/thumb.php?file='.htmlspecialchars($image['o_file']).'" alt="'.htmlspecialchars($text).'" title="'.htmlspecialchars($text).'" /><!--
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