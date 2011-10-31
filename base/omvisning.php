<?php

class omvisning {
	protected $galleries; // alle galleriene
	protected $images_gallery = array(); // bilde->galleri relasjon
	protected $image_id;
	
	const PATH = "/studentbolig/omvisning";
	
	/**
	 * Last inn bildegalleriene og bildene i dem
	 */
	protected function get_images() {
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
	 * Lag array for javascript over bildene
	 */
	protected function get_js_array() {
		$data = array();
		
		$img_i = 0;
		$i = 0;
		foreach ($this->galleries as $gallery_id => $gallery) {
			foreach ($gallery['images'] as $row) {
				if ($row['gi_id'] == $this->image_id) $img_i = $i;
				$data[] = array(
					$gallery['title'],
					$row['gi_id'],
					$this->get_image_text($row),
					$gallery_id
				);
				$i++;
			}
		}
		
		return array($img_i, $data);
	}
	
	/**
	 * Lag bildetekst
	 */
	protected function get_image_text($image) {
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
	protected function get_img($id) {
		return $this->galleries[$this->images_gallery[$id]]['images'][$id];
	}
	
	/**
	 * Finn ID for forrige og neste bilde
	 */
	protected function get_prev_next() {
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