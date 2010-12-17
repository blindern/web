<?php

// last inn database
require BASE."/database.php";

class omvisning
{
	public static $dir;
	public static $link;
	public static $datafile;
	
	public static $groups;
	public static $images_group;
	
	public static function get_images()
	{
		self::$groups = array();
		self::$images_group = array();
		
		$result = db_query("
			SELECT o_id, o_active, o_category, o_order, o_file, o_size, o_text, o_date, o_foto
			FROM omvisning
			ORDER BY o_category_order, o_order");
		
		while ($row = mysql_fetch_assoc($result))
		{
			self::$groups[$row['o_category']][$row['o_id']] = $row;
			self::$images_group[$row['o_id']] = &self::$groups[$row['o_category']][$row['o_id']];
		}
	}
	
	public static function init()
	{
		// last inn data
		self::get_images();
	}
	
	/**
	 * Lagre endringer til bilder
	 */
	public static function handle_edit($changeset)
	{
		// changeset = [ key => [ col => new_data, ... ], ... ]
		
		$num = 0;
		foreach ($changeset as $key => $data)
		{
			$key = (int) $key;
			
			$upd = array();
			foreach ($data as $col => $value)
			{
				$upd[] = "$col = ".db_quote($value, $col != "o_active");
			}
			
			// kjør oppdatering for denne raden
			db_query("UPDATE omvisning SET ".implode(", ", $upd)." WHERE o_id = $key");
			$num++;
		}
		
		return $num;
	}
	
	/**
	 * Behandle opplasting av bilde
	 */
	public static function handle_upload($file, $category)
	{
		if (empty($category)) $category = "Annet";
		
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
			$new_name = $name_prefix.($i <= 1 ? "" : "($i)").".png";
			$new = omvisning::$dir."/".$new_name;
			$i++;
		} while(file_exists($new));
		
		// lagre bildet
		if (!imagepng($img_new, $new))
		{
			return "error_move";
		}
		imagedestroy($image);
		imagedestroy($img_new);
		
		// har vi denne kategorien?
		$order = 1;
		$result = db_query("SELECT o_category_order FROM omvisning WHERE o_category = ".db_quote($category)." LIMIT 1");
		$c_order = mysql_result($result, 0);
		if (!$c_order)
		{
			// finn høyeste sortering
			$result = db_query("SELECT MAX(o_category_order) FROM omvisning");
			$c_order = mysql_result($result, 0);
			if (!$c_order) $c_order = 1;
		}
		
		else
		{
			// finn bildesortering
			$result = db_query("SELECT MAX(o_order) FROM omvisning WHERE o_category = ".db_quote($category));
			$order = mysql_result($result, 0);
			if (!$order) $order = 1;
			else $order++;
		}
		
		// legg til i databasen
		db_query("INSERT INTO omvisning SET o_order = $order, o_category = ".db_quote($category).", o_category_order = $order, o_file = ".db_quote($new_name).", o_size = ".filesize($new));
		
		return array($new_name, $new, mysql_insert_id());
	}
}

omvisning::$dir = dirname(BASE)."/graphics/omvisning";
if (bs_side::$pagedata) omvisning::$link = bs_side::$pagedata->doc_path."/graphics/omvisning";
omvisning::$datafile = BASE."/omvisning_data.txt";
omvisning::init();