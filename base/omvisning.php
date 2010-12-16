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
			SELECT o_id, o_category, o_order, o_file, o_size, o_text, o_date, o_foto
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
}

omvisning::$dir = dirname(BASE)."/graphics/omvisning";
if (bs_side::$pagedata) omvisning::$link = bs_side::$pagedata->doc_path."/graphics/omvisning";
omvisning::$datafile = BASE."/omvisning_data.txt";
omvisning::init();