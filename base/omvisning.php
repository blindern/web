<?php

// last inn database
require BASE."/database.php";

class omvisning_category {
	public $id;
	public $data;
	public $active;
	public $images = array();
	
	public function __construct($data) {
		$this->data = $data;
		$this->id = $data['oc_id'];
		$this->active = $data['oc_active'];
	}
	
	public function add_image($data) {
		$this->images[$data['oi_id']] = new omvisning_item($data);
	}
	
	/**
	 * Behandle opplasting av bilde
	 */
	public static function handle_upload($file)
	{
		$src = $file['tmp_name'];
		$org = $file['name'];
		$name = basename($org);
		
		// skjekk om det er et gyldig bilde
		if (!is_uploaded_file($src))
		{
			print_r($file);
			return "error";
		}
		
		// gyldig filendelse?
		if (!preg_match("/(^.+?)\\.(jpe?g|gif|png)$/i", strtolower(preg_replace("/[^a-z0-9_\\-\\.]/i", "_", $name)), $match))
		{
			return "error_ext";
		}
		$name_prefix = $match[1];
		$name_suffix = $match[2];
		
		// les bildet
		$image = @imagecreatefromstring(@file_get_contents($src));
		if (!$image)
		{
			return "error";
		}
		
		// resize
		$w = imagesx($image);
		$h = imagesy($image);
		
		// dimensjoner
		$width = 840;
		$max_h = 900;
		$height = floor($width / $w * $h);
		if ($height > $max_h) $height = $max_h;
		elseif ($height < 1) $height = 10;
		
		// opprett nytt bilde
		$img_new = imagecreatetruecolor($width, $height);
		
		// kopier det andre bildet over hit
		imagecopyresampled($img_new, $image, 0, 0, 0, 0, $width, $height, $w, $h);
		
		// finn nytt filnavn (som ikke er i bruk)
		$i = 1;
		do
		{
			$new_name = $name_prefix.($i <= 1 ? "" : "($i)").".jpg";
			$new = omvisning::$dir."/".$new_name;
			$i++;
		} while(file_exists($new));
		
		// lagre bildet
		if (!imagejpeg($img_new, $new, 85))
		{
			return "error_move";
		}
		imagedestroy($image);
		imagedestroy($img_new);
		
		// finn bildesortering
		$order = omvisning_item::get_next_order($this->id);
		
		// legg til i databasen
		db_query("INSERT INTO omvisning_item SET oi_order = $order, oi_oc_id = $this->id, oi_file = ".db_quote($new_name).", oi_size = ".filesize($new));
		
		return array($new_name, $new, mysql_insert_id());
	}
	
	/**
	 * Gjør endringer til galleriet
	 */
	public function edit(array $edit_set) {
		$fields = array("active" => "oc_active", "title" => "oc_title", "order" => "oc_order");
		$update = array();
		
		foreach ($fields as $name => $field) {
			if (isset($edit_set[$name])) {
				$update[] = "$field = ".db_quote($edit_set[$name]);
				unset($edit_set[$name]);
			}
		}
		
		if (count($edit_set) > 0) throw new Exception("Unknown fields to update found.");
		
		if (count($update) > 0) {
			db_query("UPDATE omvisning_category SET ".implode(", ", $update)." WHERE oc_id = $this->id");
		}
	}
}

class omvisning_item {
	public $id;
	public $data;
	
	public function __construct($data) {
		$this->data = $data;
		$this->id = $data['oi_id'];
	}
	
	/**
	 * Finn neste sorteringsnummer for bildene i et galleri
	 */
	public static function get_next_order($category) {
		$result = db_query("SELECT MAX(oi_order) FROM omvisning_item WHERE oi_oc_id = ".db_quote($category));
		return mysql_result($result, 0);
	}
	
	/**
	 * Gjør endringer til bildet
	 */
	public function edit(array $edit_set) {
		$fields = array(
			"active" => "oi_active",
			"title" => "oi_title",
			"order" => "oi_order",
			"text" => "oi_text",
			"date" => "oi_date",
			"foto" => "oi_foto"
		);
		$update = array();
		
		foreach ($fields as $name => $field) {
			if (isset($edit_set[$name])) {
				$update[] = "$field = ".db_quote($edit_set[$name]);
				unset($edit_set[$name]);
			}
		}
		
		if (count($edit_set) > 0) throw new Exception("Unknown fields to update found.");
		
		if (count($update) > 0) {
			db_query("UPDATE omvisning_item SET ".implode(", ", $update)." WHERE oc_id = $this->id");
		}
	}
}

class omvisning {
	public static $dir;
	public static $link;
	public static $datafile;
	
	public static $categories;
	public static $images_category;
	
	public static function load_data() {
		self::load_categories();
		self::load_images();
	}
	
	public static function load_categories() {
		self::$categories = array();
		
		$result = db_query("
			SELECT oc_id, oc_active, oc_title, oc_order
			FROM omvisning_category
			ORDER BY oc_order");
		
		while ($row = mysql_fetch_assoc($result)) {
			self::$categories[$row['oc_id']] = new omvisning_category($row);
		}
	}
	
	public static function load_images() {
		self::$images_category = array();
		
		$result = db_query("
			SELECT *
			FROM omvisning_item
			ORDER BY oi_order");
		
		while ($row = mysql_fetch_assoc($result)) {
			self::$categories[$row['oi_oc_id']]->add_image($row);
			self::$images_category[$row['oi_id']] = $row['oi_oc_id'];
		}
	}
	
	public static function init()
	{
		// last inn data
		self::load_data();
	}
}

omvisning::$dir = dirname(BASE)."/graphics/omvisning";
if (bs_side::$pagedata) omvisning::$link = bs_side::$pagedata->doc_path."/graphics/omvisning";
omvisning::$datafile = BASE."/omvisning_data.txt";