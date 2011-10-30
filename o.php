<?php

require "base/essentials.php";

// script for å hente ressurser
// _GET: a => action

if (!isset($_GET['a']))
{
	page_not_found("<p>What to do?!</p>");
}

switch ($_GET['a'])
{
	case "gi": // gallery image
		// gi_id
		ob_start();
		if (!isset($_GET['gi_id']))
		{
			page_not_found("<p>gi_id?</p>");
		}
		$gi_id = intval($_GET['gi_id']);
		
		// gi_size
		if (!isset($_GET['gi_size']))
		{
			page_not_found("<p>gi_size?</p>");
		}
		$sizes = array(
			"original" => array("original"),
			"thumbnail" => array(
				"thumb",	// navn på mappe på disk
				150,	// maks bredde
				200		// maks høyde
			),
			"inside" => array(
				"inside",
				600,
				600
			),
			"fullside" => array(
				"fullside",
				920,
				920
			),
			"gclist" => array(
				"gclist",
				140,
				140
			),
			"glimt" => array(
				"glimt",
				80,
				160
			)
		);
		if (!isset($sizes[$_GET['gi_size']]))
		{
			page_not_found("<p>gi_size unknown</p>");
		}
		
		// størrelsen vi skal bruke
		$size = $sizes[$_GET['gi_size']];
		$field = $size[0];
		
		// hent fra databasen
		$result = ess::$b->db->query("SELECT gi_filename, gi_time FROM gallery_images WHERE gi_id = $gi_id");
		
		// fant ikke?
		if (mysql_num_rows($result) == 0)
		{
			page_not_found();
		}
		
		$filename = mysql_result($result, 0);
		$last_mod = mysql_result($result, 0, 1);
		
		// hent data om vi har det
		$data = null;
		$sp = $field == "original" ? "original/" : "resized/{$field}_";
		$filepath = GALLERY_FOLDER."/$sp$filename.jpg";
		if (file_exists($filepath))
		{
			$data = @file_get_contents($filepath);
		}
		
		// mangler?
		if (empty($data))
		{
			if ($field == "original")
			{
				page_not_found("<p>Mangler kildedata for bildet!</p>");
			}
			elseif (!isset($size[2]))
			{
				page_not_found("<p>Mangler konvertert bilde. Mangler nye dimensjoner.</p>");
			}
			
			// hent src
			$data = @file_get_contents(GALLERY_FOLDER."/original/$filename.jpg");
			if (empty($data))
			{
				page_not_found("<p>Mangler kildedata for bildet! Kan ikke konvertere til annet format.</p>");
			}
			
			// forsøk å åpne bildet
			$img = @imagecreatefromstring($data);
			if (!$img)
			{
				page_not_found("<p>Kunne ikke åpne kildedata som bilde.</p>");
			}
			
			$img_width = imagesx($img);
			$img_height = imagesy($img);
			
			// maksimal størrelse:
			$max_width = intval($size[1]);
			$max_height = intval($size[2]);
			
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
			
			// eksporter bildet
			@ob_clean();
			if (!imagejpeg($img, null, 90)) page_not_found("<p>Kunne ikke eksportere bildet.</p>");
			#if (!imagepng($img)) page_not_found("<p>Kunne ikke eksportere bildet.</p>");
			$data = ob_get_contents();
			@ob_clean();
			
			// forsøk å lagre bildet
			@file_put_contents($filepath, $data);
		}
		
		ob_end_clean();
		
		// headers
		$filename = $gi_id.".jpg";
		header("Content-Length: ".strlen($data));
		header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_mod)." GMT");
		header("Cache-Control: public");
		header("Content-Disposition: inline; filename=$filename");
		
		// vis bildet
		header("Content-Type: image/jpeg");
		die($data);
		
	break;
	
	default:
		page_not_found();
}
