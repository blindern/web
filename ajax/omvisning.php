<?php

require "../base/ajax.php";
ajax::essentials();

require "../base/omvisning.php";

// flytte?
if (isset($_GET['move']) && isset($_POST['id']) && isset($_POST['cat']) && isset($_POST['order']))
{
	$id = (int) $_POST['id'];
	$cat = (int) $_POST['cat'];
	$order = (int) $_POST['order'];
	
	// hent nåværende info
	$res = ess::$b->db->q("
		SELECT gi_id, gi_gc_id, gi_priority
		FROM gallery_images
		WHERE gi_id = $id");
	$row = $res->fetch();
	
	if (!$row) ajax::text("Not found", ajax::TYPE_404);
	
	// finn maks nummer for sortering
	$max_result = ess::$b->db->q("
		SELECT MAX(gi_priority)
		FROM gallery_images
		WHERE gi_gc_id = $cat");
	$max_order = $max_result->fetch_row();
	$max_order = $max_order[0];
	
	if (!$max_order) ajax::TEXT("GALLERY NOT FOUND", ajax::TYPE_INVALID);
	
	$order = max(1, min($max_order, $order));
	
	// endre kategori?
	if ($row['gi_gc_id'] != $cat)
	{
		// korriger order på gammel kategori
		ess::$b->db->query("UPDATE gallery_images SET gi_priority = gi_priority - 1 WHERE gi_gc_id = {$row['gi_gc_id']} AND gi_priority > {$row['gi_priority']}");
		
		// korriger order i ny kategori
		ess::$b->db->query("UPDATE gallery_images SET gi_priority = gi_priority + 1 WHERE gi_gc_id = $cat AND gi_priority >= $order");
		
		// flytt
		ess::$b->db->query("UPDATE gallery_images SET gi_priority = $order, gi_gc_id = $cat WHERE gi_id = $id");
	}
	
	// ikke flyttet?
	elseif ($row['gi_priority'] == $order)
	{
		ajax::text("NOT MOVED", ajax::TYPE_INVALID);
	}
	
	// flytt i samme kategori
	else
	{
		// korriger order
		$neg = $order < $row['gi_priority'] ? "+" : "-";
		$order_min = min($order, $row['gi_priority']);
		$order_max = max($order, $row['gi_priority']);
		ess::$b->db->query("UPDATE gallery_images SET gi_priority = gi_priority $neg 1 WHERE gi_gc_id = {$row['gi_gc_id']} AND gi_priority >= $order_min AND gi_priority <= $order_max");
		
		// flytt
		ess::$b->db->query("UPDATE gallery_images SET gi_priority = $order WHERE gi_id = $id");
	}
	
	ajax::text("OK");
}