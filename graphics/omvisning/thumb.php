<?php

if (!isset($_GET['file'])) die;

$file = "./".$_GET['file'];
if (!preg_match("/^[a-z0-9_\\-\\. æøåÆØÅ]+$/i", $_GET['file']) || !file_exists($file))
{
	die("hmf");
}


// har vi cache?
$cache_file = dirname(__FILE__)."/thumbs/".$file;
if (file_exists($cache_file))
{
	$last_mod = filemtime($file);
	
	// headers
	header("Content-Length: ".filesize($cache_file));
	header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_mod)." GMT");
	header("Cache-Control: public");
	
	// vis bildet
	header("Content-Type: image/jpeg");
	echo file_get_contents($cache_file);
	
	die;
}


ob_start();


// maksimal størrelse
$max_width = 180;
$max_height = 300;

$last_mod = filemtime($file);
$data = @file_get_contents($file);

// forsøk å åpne bildet
$img = @imagecreatefromstring($data);
if (!$img)
{
	die();
}

$img_width = imagesx($img);
$img_height = imagesy($img);

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
if (!imagejpeg($img, null, 85)) die("imagejpeg feilet");
$data = ob_get_contents();
@ob_clean();

// forsøk å lagre bildet
@file_put_contents($cache_file, $data);

ob_end_clean();

// headers
header("Content-Length: ".strlen($data));
header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_mod)." GMT");
header("Cache-Control: public");

// vis bildet
header("Content-Type: image/jpeg");
die($data);