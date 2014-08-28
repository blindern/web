<?php

require ROOT."/base/omvisning.php";

class studentbolig__omvisning extends omvisning {
	const PATH = "/studentbolig/omvisning";
	private $page;

	public function __construct() {
		parent::__construct();

		bs_side::set_title("Digital omvisning");
		bs_side::$head .= '
		<script type="text/javascript" src="/omvisning.js"></script>
		<script type="text/javascript" src="http://balupton.github.com/history.js/scripts/bundled/html4+html5/jquery.history.js"></script>';
		
		// sjekk for korrekt adresse
		$this->check_subpage();
		
		// vise oversikt eller spesifikt bilde?
		switch ($this->page)
		{
		case "image":
			$this->show_image();
			break;
		case "oversikt":
			$this->show_main();
			break;
		default:
			$this->show_index();
		}
	}
	
	/**
	 * Sjekk for korrekt adresse
	 */
	private function check_subpage() {
		$part_base = 1; // 1 = omvisning (1 del i adressen)
		
		if (count(bs_side::$pagedata->path_parts) > $part_base) {
			// liste?
			if (bs_side::$pagedata->path_parts[$part_base] == "oversikt") {
				$this->page = "oversikt";
				return;
			}

			if (count(bs_side::$pagedata->path_parts) > $part_base+1 || !is_numeric(bs_side::$pagedata->path_parts[$part_base])) {
				bs_side::page_not_found();
			}
			
			$this->active_image_id = bs_side::$pagedata->path_parts[$part_base];
			$this->page = "image";
			
			// verifiser at vi har bildet
			if (!isset($this->images[$this->active_image_id])) {
				bs_side::page_not_found("<p>Bildet du refererte til ble ikke funnet.</p>");
			}

			return;
		}

		// send til første bilde
		$this->page = "index";
	}

	/**
	 * Lenke til første bilde
	 */
	public function getFirstLink()
	{
		foreach ($this->galleries as $gallery) {
			foreach ($gallery['images'] as $image) {
				return "/omvisning/{$image->data['id']}";
			}
		}
	}

	/**
	 * Vis video og en slags forside
	 */
	private function show_index()
	{
		echo '
<h1>Digital omvisning</h1>
<div style="text-align: center; margin: 30px 0">
	<iframe width="800" height="450" src="//www.youtube.com/embed/Aas0RHRi_20" frameborder="0" allowfullscreen></iframe>
</div>
<p style="text-align: center; max-width: none !important; margin: 30px 0"><a href="'.$this->getFirstLink().'">Vis bildegalleri fra Blindern Studenterhjem</a></p>';
	}
	
	/**
	 * Vise vanlig side
	 */
	private function show_main() {
		echo '
<h1>Digital omvisning</h1>
<div id="omvisning_bilde_inactive">
	<ul id="omvisning_liste">
		<li>Bilder
			<ul>';
		
		foreach ($this->galleries as $data)
		{
			echo '
				<li><a href="#'.urlencode($data['title']).'">'.htmlspecialchars($data['title']).'</a></li>';
		}
		
		echo '
			</ul>
		</li>
		<li><a href="#cmedia">Media om Blindern Studenterhjem</a></li>
	</ul>
	<p id="omvisning_bilder_h">Trykk på et bilde for å vise stort bilde og beskrivelse.</p>
	<div id="omvisning_bilder">';
		
		foreach ($this->galleries as $gallery_id => $gallery)
		{
			echo '
		<div class="omvisning_bilder_cat" id="'.urlencode($gallery['title']).'">
			<h2>'.htmlspecialchars($gallery['title']).'</h2>
			<div class="omvisning_bilder_g">';
			
			foreach ($gallery['images'] as $image)
			{
				$text = $image->get_image_text();
				
				echo '<!-- avoid inline-block spacing
			--><p id="img_'.$image->data['id'].'"><!--
				--><a href="'.self::PATH.'/'.$image->data['id'].'"><!--
					--><img src="/o.php?a=gi&amp;gi_id='.$image->data['id'].'&amp;gi_size=thumb_omvisning" alt="'.htmlspecialchars($text).'" title="'.htmlspecialchars($text).'" /><!--
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

		<div class="youtube-film">
			<object width="640" height="505"><param name="movie" value="http://www.youtube.com/v/0q4U6N6Qsd4?fs=1&amp;hl=nb_NO&amp;rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/0q4U6N6Qsd4?fs=1&amp;hl=nb_NO&amp;rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="505"></embed></object>
		</div>
	</div>
</div>';
	}
	
	/**
	 * Vis spesifikt bilde
	 */
	private function show_image() {
		list($prev, $next) = $this->get_prev_next();
		$image = $this->get_img($this->active_image_id);
		$gal_title = $image->data['category'];
		
		// lagre alle bilder for javascript
		list($img_i, $data) = $this->get_js_array();
		
		bs_side::$head .= '
<script type="text/javascript">
var omvisning_i = '.$img_i.';
var omvisning_data = '.json_encode($data).';
</script>';
		
		echo '
<div id="omvisning_bilde_w">
	<p id="omvisning_nav">
		<a href="'.self::PATH.'/oversikt#'.urlencode($image->data['category']).'" id="omvisning_back"><span>Til oversikt</span></a>
		<a href="'.self::PATH.'/'.$prev.'" id="omvisning_prev"><span>Forrige bilde</span></a>
		<a href="'.self::PATH.'/'.$next.'" id="omvisning_next"><span>Neste bilde</span></a>
	</p>
	<div id="omvisning_bilde">
		<h1>Omvisning - <span id="omvisning_cat">'.htmlspecialchars($gal_title).'</span></h1>
		<p><a href="'.self::PATH.'/'.$next.'"><img src="/o.php?a=gi&amp;gi_id='.$image->data['id'].'&amp;gi_size=inside" alt="'.htmlspecialchars($image->data['desc']).'" /></a></p>
		<p id="omvisning_bilde_tekst">'.$image->get_image_text().'</p>
	</div>
	<p id="omvisning_stort">
		<a href="/o.php?a=gi&amp;gi_id='.$image->data['id'].'&amp;gi_size=original">Vis bilde i full størrelse</a>
	</p>
</div>';
	}
}

new studentbolig__omvisning();
