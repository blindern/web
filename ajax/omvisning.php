<?php

require "../base/base.php";
require "../base/cache.php";
require "../base/omvisning.php";

file_put_contents("omvisning.log", print_r($_POST, true), FILE_APPEND);

// flytte?
if (isset($_GET['move']) && isset($_POST['id']) && isset($_POST['cat']) && isset($_POST['order']))
{
	$id = (int) $_POST['id'];
	$cat = $_POST['cat'];
	$order = (int) $_POST['order'];
	
	// hent nåværende info
	$result = db_query("SELECT o_category, o_order FROM omvisning WHERE o_id = $id");
	$row = mysql_fetch_assoc($result);
	if (!$row) die("404");
	
	// finn maks nummer for sortering
	$max_result = db_query("SELECT MAX(o_order) FROM omvisning WHERE o_category = ".db_quote($cat));
	$max_order = mysql_result($max_result, 0);
	$order = max(1, min($max_order, $order));
	
	// endre kategori?
	if ($row['o_category'] != $cat)
	{
		// korriger order på gammel kategori
		db_query("UPDATE omvisning SET o_order = o_order - 1 WHERE o_category = ".db_quote($row['o_category'])." AND o_order > {$row['o_order']}");
		
		// korriger order i ny kategori
		db_query("UPDATE omvisning SET o_order = o_order + 1 WHERE o_category = ".db_quote($cat)." AND o_order >= $order");
		
		// flytt
		db_query("UPDATE omvisning SET o_order = $order, o_category = ".db_quote($cat)." WHERE o_id = $id");
	}
	
	// ikke flyttet?
	elseif ($row['o_order'] == $order)
	{
		die("NOT MOVED");
	}
	
	// flytt i samme kategori
	else
	{
		// korriger order
		$neg = $order < $row['o_order'] ? "+" : "-";
		$order_min = min($order, $row['o_order']);
		$order_max = max($order, $row['o_order']);
		db_query("UPDATE omvisning SET o_order = o_order $neg 1 WHERE o_category = ".db_quote($row['o_category'])." AND o_order >= $order_min AND o_order <= $order_max");
		
		// flytt
		db_query("UPDATE omvisning SET o_order = $order WHERE o_id = $id");
	}
	
	die("OK");
}

// endre navn på kategori?
