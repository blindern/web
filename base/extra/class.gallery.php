<?php

class gallery
{
	public static $root_data = array(
		"gc_id" => 0,
		"gc_parent_gc_id" => null,
		"gc_title" => "Glimt fra UKA",
		"gc_description" => null,
		"gc_gi_id" => null,
		"gc_views" => 0,
		"gc_created" => null
	);
	
	/**
	 * Finn galleri
	 * @return gallery
	 */
	public static function get($id = null)
	{
		// hovedgalleriet?
		if ($id === null)
		{
			return new static(self::$root_data);
		}
		
		// hent informasjon
		$result = ess::$b->db->query("
			SELECT gc_id, gc_parent_gc_id, gc_title, gc_description, gc_gi_id, gc_views, gc_created, gc_visible
			FROM gallery_categories
			WHERE gc_id = ".ess::$b->db->quote($id));
		
		$gallery = mysql_fetch_assoc($result);
		if (!$gallery)
		{
			return null;
		}
		
		return new static($gallery);
	}
	
	public $id;
	public $data;
	public $parents;
	public $sub_gc;
	public $images;
	
	protected static $galleries;
	protected static $galleries_sub;
	
	public function __construct($data)
	{
		$this->id = $data['gc_id'];
		$this->data = $data;
	}
	
	/**
	 * Hent liste over alle gallerier for parents
	 */
	protected static function get_galleries_parents()
	{
		if (self::$galleries) return;
		
		// hent foreldrene
		$result = ess::$b->db->query("
			SELECT gc_id, gc_parent_gc_id, gc_title
			FROM gallery_categories");
		
		self::$galleries = array(0 => self::$root_data);
		self::$galleries_sub = array();
		
		while ($row = mysql_fetch_assoc($result))
		{
			self::$galleries[$row['gc_id']] = $row;
			self::$galleries_sub[$row['gc_parent_gc_id']][] = $row['gc_id'];
		}
	}
	
	/**
	 * Hent parents
	 */
	public function get_parents()
	{
		self::get_galleries_parents();
		
		// sett opp titteler
		$parents = array();
		$parent_gc = $this->data['gc_parent_gc_id'];
		while (isset(self::$galleries[$parent_gc]) && $item = self::$galleries[$parent_gc])
		{
			$parents[] = array($item['gc_title'], ess::$s['relative_path']."/node/gc/{$item['gc_id']}", $item['gc_id']);
			$parent_gc = $item['gc_parent_gc_id'];
		}
		$this->parents = array_reverse($parents);
	}
	
	/**
	 * Hent galleriene i dette
	 */
	public function get_galleries(pagei $pagei)
	{
		// hent galleriene i dette galleriet
		$result = $pagei->query("
			SELECT gc_id, gc_title, gc_gi_id, gc_views, gc_created, gc_description
			FROM gallery_categories
			WHERE gc_parent_gc_id = $this->id AND gc_visible != 0
			ORDER BY gc_priority");
		
		$this->sub_gc = array();
		while ($row = mysql_fetch_assoc($result))
		{
			$this->sub_gc[] = $row;
		}
	}
	
	/**
	 * Hent bildene i dette
	 */
	public function get_images(pagei $pagei)
	{
		// bildene i dette galleriet
		$result = $pagei->query("
			SELECT gi_id, gi_title, gi_description
			FROM gallery_images
			WHERE gi_gc_id = $this->id AND gi_visible != 0
			ORDER BY gi_priority");
		
		$this->images = array();
		while ($row = mysql_fetch_assoc($result))
		{
			$this->images[] = $row;
		}
	}
	
	/**
	 * Hent alle bildene i dette for presentasjon
	 * @param gallery_image $image aktivt bilde
	 */
	public function get_images_presentation(gallery_image $image)
	{
		// hent alle bildene i galleriet
		$result = ess::$b->db->query("
			SELECT gi_id, gi_title, gi_description
			FROM gallery_images
			WHERE gi_gc_id = {$image->data['gi_gc_id']}
			ORDER BY gi_priority");
		$images = array();
		$ref = array();
		$i = 0;
		$id = 0;
		
		while ($row = mysql_fetch_assoc($result))
		{
			$images[] = array((int)$row['gi_id'], $row['gi_title'], $row['gi_description']);
			$ref[(int)$row['gi_id']] = $i++;
			if ($row['gi_id'] == $image->id)
			{
				$id = count($images)-1;
			}
		}
		
		// forrige bilde
		if ($id == 0)
		{
			$prev = $images[count($images)-1];
		}
		else
		{
			$prev = $images[$id-1];
		}
		
		// neste bilde
		if ($id == count($images)-1)
		{
			$next = $images[0];
		}
		else
		{
			$next = $images[$id+1];
		}
		
		return array($images, $prev, $next);
	}
	
	/**
	 * Last opp bilde
	 * @return array($id, $filename, $p);
	 */
	public function image_add($data, $title, $description, $shot_date = null)
	{
		// forsøk å åpne bildet
		$img = @imagecreatefromstring($data);
		if (!$img)
		{
			return false;
		}
		
		$img_width = imagesx($img);
		$img_height = imagesy($img);
		
		// maksimal størrelse:
		// bredde: 1280
		// høyde: 1024
		$max_width = 1280;
		$max_height = 1024;
		
		$copy = true;
		
		if ($img_width > $max_width)
		{
			$width = $max_width;
			$height = floor($width / $img_width * $img_height);
			
			if ($height > $max_height)
			{
				$height = $max_height;
				$width = floor($height / $img_height * $img_width);
			}
		}
		elseif ($img_height > $max_height)
		{
			$height = $max_height;
			$width = floor($height / $img_height * $img_width);
		}
		else
		{
			$width = $img_width;
			$height = $img_height;
			$copy = false;
		}
		
		if ($copy)
		{
			// opprett nytt bilde med nedskalert størrelse
			$new = imagecreatetruecolor($width, $height);
			
			// kopier det andre bildet over hit (skaler)
			imagecopyresampled($new, $img, 0, 0, 0, 0, $width, $height, $img_width, $img_height);
			
			// slett gamle bildet og erstatt
			imagedestroy($img);
			$img = $new;
		}
		
		// eksporter bildet og legg til i databasen
		$pre_content = @ob_get_contents();
		@ob_clean();
		imagejpeg($img, null, 90);
		$data = ob_get_contents();
		@ob_clean();
		if ($pre_content != "") echo $pre_content;
		
		// finn høyeste prioritering
		$result = ess::$b->db->query("
			SELECT MAX(gi_priority)
			FROM gallery_images
			WHERE gi_gc_id = $this->id");
		$priority = mysql_result($result, 0) + 1;
		
		// start transaksjon
		ess::$b->db->query("BEGIN");
		
		// legg til i databasen
		ess::$b->db->query("
			INSERT INTO gallery_images
			SET gi_gc_id = $this->id, gi_title = ".ess::$b->db->quote($title).", gi_description = ".ess::$b->db->quote($description).", gi_shot_date = ".ess::$b->db->quote($shot_date).", gi_time = ".time().", gi_priority = $priority, gi_visible = 0");
		
		// hent ut ID
		$id = mysql_insert_id();
		
		// lagre bildet til disk
		$filename = $id.str_pad(dechex((float)sprintf("%u", crc32($data))), 8, "0", STR_PAD_LEFT);
		$p = GALLERY_FOLDER."/original/$filename.jpg";
		if (!file_put_contents($p, $data))
		{
			ess::$b->db->query("ROLLBACK"); // avbryt transaksjon
			
			sysreport::log("Kunne ikke lagre bildet ".htmlspecialchars($p)." på disk.");
			return false;
		}
		
		// lagre filnavn
		ess::$b->db->query("
			UPDATE gallery_images
			SET gi_filename = ".ess::$b->db->quote($filename)."
			WHERE gi_id = $id");
		
		// fullfør transaksjon
		ess::$b->db->query("COMMIT");
		
		return array($id, $filename, $p);
	}
}

class gallery_image
{
	/**
	 * @return gallery_image
	 */
	public static function get($id)
	{
		// hent informasjon
		$result = ess::$b->db->query("
			SELECT gi_id, gi_gc_id, gi_title, gi_description, gi_time, gi_priority
			FROM gallery_images
			WHERE gi_id = ".ess::$b->db->quote($id));
		
		$row = mysql_fetch_assoc($result);
		if (!$row) return null;
		
		return new static($row);
	}
	
	public $id;
	public $data;
	
	/**
	 * @var gallery
	 */
	public $gallery;
	
	public function __construct($data)
	{
		$this->id = $data['gi_id'];
		$this->data = $data;
	}
	
	public function get_gallery()
	{
		if ($this->gallery) return;
		$this->gallery = gallery::get($this->data['gi_gc_id']);
	}
}