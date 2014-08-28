<?php

/**
 * Object representing a image
 */
class omvisning_image {
	public $data;

	public function __construct($data)
	{
		$this->data = $data;
	}

	/**
	 * Lag bildetekst
	 */
	public function get_image_text() {
		$text = $this->data['desc'];
		
		if ($text && $this->data['photographer']) $text .= " ";
		if ($this->data['photographer']) $text .= "Foto: " . $this->data['photographer'];
		
		if ($text && $this->data['photographer']) $text .= " ";
		if ($this->data['date']) $text .= "(".$this->data['date'].")";
		
		return $text;
	}
}

/**
 * Just a simple class to fetch the images from file
 */
class omvisning_repo {
	private static $images = array();
	private static $images_obj = array();

	/**
	 * Fetch data from file
	 */
	private static function fetch_data($clear_cache = NULL)
	{
		if (!$clear_cache && static::$images) return;

		$file = ROOT."/images.json";
		$data = json_decode(file_get_contents($file), true);

		// sett opp ny struktur for dataen
		static::$images = $data;
		static::$images_obj = array();
	}

	/**
	 * Get data
	 *
	 * @param bool Get hidden images as well
	 * @return array('galleries' => array(...), 'images' => array(...))
	 */
	public static function get_data($show_hidden = false)
	{
		$galleries = array();
		$images = array();
		static::fetch_data();
		
		// sett opp ny struktur for dataen
		foreach (static::$images as $row)
		{
			if (!$show_hidden && $row['visible'] == 0) continue;
			$obj = static::get_img($row);

			if (!isset($galleries[$row['category']]))
			{
				$galleries[$row['category']] = array(
					"title" => $row['category'],
					"images" => array()
				);
			}

			$galleries[$row['category']]['images'][] = $obj;
			$images[$row['id']] = $obj;
		}

		return array(
			'galleries' => $galleries,
			'images' => $images
		);
	}

	/**
	 * Get image object or create it
	 */
	private static function get_img($row)
	{
		if (!isset(static::$images_obj[$row['id']]))
		{
			$obj = new omvisning_image($row);
			static::$images_obj[$row['id']] = $obj;
		} else {
			$obj = static::$images_obj[$row['id']];
		}

		return $obj;
	}

	/**
	 * Get a specific image object by ID
	 *
	 * @param int image ID
	 */
	public static function get_img_by_id($id)
	{
		static::fetch_data();
		foreach (static::$images as $row)
		{
			if ($row['id'] == $id)
				return static::get_img($row);
		}
	}
}

class omvisning {
	protected $galleries; // alle galleriene
	protected $images = array(); // bilde->galleri relasjon

	/**
	 * Active image
	 */
	public $active_image_id;
	
	public function __construct($show_hidden = false)
	{
		$data = omvisning_repo::get_data();
		$this->galleries = $data['galleries'];
		$this->images = $data['images'];
	}
	
	/**
	 * Get random images
	 *
	 * @param integer number of images to return
	 * @param array categories to skip
	 * @param array list of IDs to select from
	 * @return array list of images
	 */
	public function get_rand_images($num = 1, $skip_categories = array(), $id_list = NULL)
	{
		$list = array();
		if (!empty($id_list) && is_array($id_list)) {
			// select valid images from ID list
			foreach ($id_list as $id)
			{
				if (isset($this->images[$id]))
					$list[] = $id;
			}
		} else {
			$list = array_keys($this->images);
		}

		$ret = array();

		while (($key = array_rand($list)) !== NULL) {
			$item = $this->images[$list[$key]];
			unset($list[$key]);

			if (in_array($item->data['category'], $skip_categories))
				continue;

			$ret[] = $item;

			if (count($ret) == $num)
				break;
		}

		return $ret;
	}

	/**
	 * Lag array for javascript over bildene
	 */
	protected function get_js_array() {
		$data = array();
		
		$img_i = 0;
		$i = 0;
		foreach ($this->galleries as $gallery_id => $gallery) {
			foreach ($gallery['images'] as $obj) {
				if ($obj->data['id'] == $this->active_image_id) $img_i = $i;
				$data[] = array(
					$gallery['title'],
					$obj->data['id'],
					$obj->get_image_text(),
					$gallery_id
				);
				$i++;
			}
		}
		
		return array($img_i, $data);
	}
	
	/**
	 * Returner et bilde utifra ID
	 */
	public function get_img($id) {
		if (isset($this->images[$id]))
			return $this->images[$id];

		return null;
	}
	
	/**
	 * Finn ID for forrige og neste bilde
	 */
	protected function get_prev_next() {
		$prev = false;
		$next = false;
		
		$last_img = 0;
		foreach ($this->galleries as $gal_id => $gallery) {
			foreach ($gallery['images'] as $obj) {
				if ($prev !== false) {
					$next = $obj->data['id'];
					break 2;
				}
				
				if ($obj->data['id'] == $this->active_image_id) {
					$prev = $last_img;
					continue;
				}
				
				$last_img = $obj->data['id'];
			}
		}
		
		// siste bildet er prev
		if (!$prev) {
			$gal = end($this->galleries);
			$obj = end($gal['images']);
			$prev = $obj->data['id'];
		}
		
		// første bildet er next
		if (!$next) {
			$gal = reset($this->galleries);
			$obj = reset($gal['images']);
			$next = $obj->data['id'];
		}
		
		return array($prev, $next);
	}
}