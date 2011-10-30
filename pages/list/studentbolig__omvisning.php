<?php

class studentbolig__omvisning {
	private $galleries; // alle galleriene
	private $images_gallery = array(); // bilde->galleri relasjon
	
	private $image_id;
	
	const PATH = "/studentbolig/omvisning";
	
	public function __construct() {
		bs_side::set_title("Digital omvisning");
		jquery();
		ess::$b->page->add_js_file(ess::$s['rpath'].'/omvisning.js');
		ess::$b->page->add_js_file("http://balupton.github.com/history.js/scripts/bundled/html4+html5/jquery.history.js");
		
		// hent inn alle bildene
		$this->get_images();
		
		// sjekk for korrekt adresse
		$this->check_subpage();
		
		// vise oversikt eller spesifikt bilde?
		if (!$this->image_id) {
			$this->show_main();
		} else {
			$this->show_image();
		}
	}
	
	/**
	 * Sjekk for korrekt adresse
	 */
	private function check_subpage() {
		$part_base = 2; // 2 = studentbolig/omvisning (2 deler i adressen)
		
		if (count(bs_side::$pagedata->path_parts) > $part_base) {
			if (count(bs_side::$pagedata->path_parts) > $part_base+1 || !is_numeric(bs_side::$pagedata->path_parts[$part_base])) {
				bs_side::page_not_found();
			}
			
			$this->image_id = bs_side::$pagedata->path_parts[$part_base];
			
			// verifiser at vi har bildet
			if (!isset($this->images_gallery[$this->image_id])) {
				bs_side::page_not_found("<pP>Bildet du refererte til ble ikke funnet.</p>");
			}
		}
	}
	
	/**
	 * Last inn bildegalleriene og bildene i dem
	 */
	private function get_images() {
		// hent alle galleriene
		$result = ess::$b->db->q("
			SELECT gc_id, gc_title
			FROM gallery_categories
			WHERE gc_visible != 0 AND gc_parent_gc_id = 0
			ORDER BY gc_priority");
		
		$this->galleries = array();
		while ($row = $result->fetch()) {
			$this->galleries[$row['gc_id']] = array(
				"title" => $row['gc_title'],
				"images" => array()
			);
		}
		
		// hent alle bildene
		if (count($this->galleries) > 0) {
			$gc_ids = implode(", ", array_keys($this->galleries));
			$result = ess::$b->db->q("
				SELECT gi_id, gi_gc_id, gi_description, gi_shot_person, gi_shot_date
				FROM gallery_images
				WHERE gi_gc_id IN ($gc_ids) AND gi_visible != 0
				ORDER BY gi_priority");
			
			while ($row = $result->fetch()) {
				$this->galleries[$row['gi_gc_id']]['images'][$row['gi_id']] = $row;
				$this->images_gallery[$row['gi_id']] = $row['gi_gc_id'];
			}
		}
		
		// fjern gallerier uten bilder
		// må gjøre dette for at get_prev_next() skal fungere på en enkel måte
		foreach ($this->galleries as $gc_id => $data) {
			if (count($data['images']) == 0) unset($this->galleries[$gc_id]);
		}
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
		
		foreach ($this->galleries as $id => $data)
		{
			echo '
				<li><a href="#c'.$id.'">'.htmlspecialchars($data['title']).'</a></li>';
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
		<div class="omvisning_bilder_cat">
			<h2 id="c'.$gallery_id.'">'.htmlspecialchars($gallery['title']).'</h2>
			<div class="omvisning_bilder_g">';
			
			foreach ($gallery['images'] as $image)
			{
				$text = $this->get_image_text($image);
				
				echo '<!-- avoid inline-block spacing
			--><p id="img_'.$image['gi_id'].'"><!--
				--><a href="'.self::PATH.'/'.$image['gi_id'].'"><!--
					--><img src="'.ess::$s['relative_path'].'/o.php?a=gi&amp;gi_id='.$image['gi_id'].'&amp;gi_size=thumb_omvisning" alt="'.htmlspecialchars($text).'" title="'.htmlspecialchars($text).'" /><!--
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
	}
	
	/**
	 * Vis spesifikt bilde
	 */
	private function show_image() {
		list($prev, $next) = $this->get_prev_next();
		$image = $this->get_img($this->image_id);
		$gal_title = $this->galleries[$this->images_gallery[$this->image_id]]['title'];
		
		// lagre alle bilder for javascript
		list($img_i, $data) = $this->get_js_array();
		
		ess::$b->page->add_js('
var omvisning_i = '.$img_i.';
var omvisning_data = '.json_encode($data).';');
		
		echo '
<div id="omvisning_bilde_w">
	<p id="omvisning_nav">
		<a href="'.self::PATH.'" id="omvisning_back"><span>Tilbake til oversikt</span></a>
		<a href="'.self::PATH.'/'.$prev.'" id="omvisning_prev"><span>Forrige bilde</span></a>
		<a href="'.self::PATH.'/'.$next.'" id="omvisning_next"><span>Neste bilde</span></a>
	</p>
	<div id="omvisning_bilde">
		<h1>Omvisning - <span id="omvisning_cat">'.htmlspecialchars($gal_title).'</span></h1>
		<p><a href="'.ess::$s['relative_path'].'/o.php?a=gi&amp;gi_id='.$image['gi_id'].'&amp;gi_size=original"><img src="'.ess::$s['relative_path'].'/o.php?a=gi&amp;gi_id='.$image['gi_id'].'&amp;gi_size=inside" alt="'.htmlspecialchars($image['gi_description']).'" /></a></p>
		<p id="omvisning_bilde_tekst">'.$image['gi_description'].'</p>
	</div>
</div>';
	}
	
	/**
	 * Lag array for javascript over bildene
	 */
	private function get_js_array() {
		$data = array();
		
		$img_i = 0;
		$i = 0;
		foreach ($this->galleries as $gallery) {
			foreach ($gallery['images'] as $row) {
				if ($row['gi_id'] == $this->image_id) $img_i = $i;
				$data[] = array(
					$gallery['title'],
					$row['gi_id'],
					$this->get_image_text($row)
				);
				$i++;
			}
		}
		
		return array($img_i, $data);
	}
	
	/**
	 * Lag bildetekst
	 */
	private function get_image_text($image) {
		$text = $image['gi_description'];
		
		if ($text && $image['gi_shot_person']) $text .= " ";
		if ($image['gi_shot_person']) $text .= "Foto: " . $image['gi_shot_person'];
		
		if ($text && $image['gi_shot_date']) $text .= " ";
		if ($image['gi_shot_date']) $text .= "(".$image['gi_shot_date'].")";
		
		return $text;
	}
	
	/**
	 * Returner et bilde utifra ID
	 */
	private function get_img($id) {
		return $this->galleries[$this->images_gallery[$id]]['images'][$id];
	}
	
	/**
	 * Finn ID for forrige og neste bilde
	 */
	private function get_prev_next() {
		$prev = false;
		$next = false;
		
		$last_img = 0;
		foreach ($this->galleries as $gal_id => $gallery) {
			foreach ($gallery['images'] as $row) {
				if ($prev !== false) {
					$next = $row['gi_id'];
					break 2;
				}
				
				if ($row['gi_id']  == $this->image_id) {
					$prev = $last_img;
					continue;
				}
				
				$last_img = $row['gi_id'];
			}
		}
		
		// siste bildet er prev
		if (!$prev) {
			$gal = end($this->galleries);
			$img = end($gal['images']);
			$prev = $img['gi_id'];
		}
		
		// første bildet er next
		if (!$next) {
			$gal = reset($this->galleries);
			$img = reset($gal['images']);
			$next = $img['gi_id'];
		}
		
		return array($prev, $next);
	}
}

new studentbolig__omvisning();
