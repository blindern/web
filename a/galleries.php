<?php

class a_galleries
{
	protected $active = false;
	protected $galleries = array();
	protected $galleries_sub = array();
	protected $i = 0;
	
	protected $prefix = array(
		"normal" => '&#9500;&nbsp;',
		"last" => '&#9492;&nbsp;',
		"jump" => '&#9474;&nbsp;',
		"none" => '&nbsp;&nbsp;'
	);
	
	protected $action;
	protected $subaction;
	
	public function handle()
	{
		// for å hindre java applet i å sende til feil side
		if ($_SERVER['REQUEST_METHOD'] == "HEAD") die();
		
		// sjekk om vi skal laste opp bilder
		$this->handle_upload_java();
		
		require "base.php";
		ess::$b->page->add_title("Gallerier");
		
		// hent inn gallerier
		$this->load_galleries();
		
		// css for gallerier
		// TODO
		ess::$b->page->add_css('
.g_icon img { border: 1px solid #EEEEEE }
.g_icon:hover img { background-color: #FAFAFA }');
		
		$this->handle_check();
		
		echo $this->view();
		ess::$b->page->load();
	}
	
	protected function handle_upload_java()
	{
		if (!isset($_GET['gc_id']) || !isset($_GET['gi_add']) || $_SERVER['REQUEST_METHOD'] != "POST") return;
		
		require "../base/ajax.php";
		ajax::essentials();
		
		ob_start();
		
		// ikke tilgang?
		ajax::require_user();
		
		// hent galleriet
		$gallery = gallery::get($_GET['gc_id']);
		if (!$gallery)
		{
			ajax::text("ERROR: Galleriet du forsøker å laste opp til eksisterer ikke.", ajax::TYPE_404);
		}
		
		$i = -1;
		foreach ($_FILES as $row)
		{
			$i++;
			
			// samle informasjon
			$pathinfo = isset($_POST['pathinfo'][$i]) ? $_POST['pathinfo'][$i] : "";
			$title = $row['name'];
			
			// sett opp tittel (filnavn uten etternavn)
			if (($pos = strrpos($title, ".")) !== false)
			{
				$title = substr($title, 0, $pos);
			}
			if (strlen($title) > 150) $title = substr($title, 0, 150);
			
			// sett opp full adresse til filen (fra brukeren)
			$delimiter = preg_match("/^[^\\\\\\/]+([\\\\\\/])/", $pathinfo, $match) ? $match[1] : "";
			$path = $pathinfo . $delimiter . $row['name'];
			
			// sjekk om det er et gyldig bilde
			if (!is_uploaded_file($row['tmp_name']))
			{
				ess::$b->page->add_message("Noe gikk galt under opplasting av filen ".htmlspecialchars($path).".", "error");
				continue;
			}
			
			// har vi modifikasjonsdato?
			$date = null;
			if (isset($_POST['filemodificationdate'.$i])) {
				$p = explode("/", substr($_POST['filemodificationdate'.$i], 0, 10));
				if (count($p) == 3) $date = "{$p[2]}-{$p[1]}-{$p[0]}";
			}
			
			// forsøk å åpne og legge til bildet
			$data = @file_get_contents($row['tmp_name']);
			$result = $gallery->image_add($data, $title, null, $date);
			
			if (!$result)
			{
				ess::$b->page->add_message("Filen ".htmlspecialchars($path)." kunne ikke legges til i galleriet.", "error");
				continue;
			}
			
			ess::$b->page->add_message("Bildet <b>".htmlspecialchars($path)."</b> ble lagt til.");
		}
		
		die("SUCCESS");
	}
	
	protected function load_galleries()
	{
		// hent alle galleriene
		$result = ess::$b->db->query("
			SELECT gc_id, gc_parent_gc_id, gc_title, gc_description, gc_gi_id, gc_views, gc_created, gc_visible, gc_priority, COUNT(gi_id) AS gi_count
			FROM gallery_categories
				LEFT JOIN gallery_images ON gc_id = gi_gc_id
			GROUP BY gc_id
			ORDER BY gc_priority, gc_title");
		
		while ($row = mysql_fetch_assoc($result))
		{
			$this->galleries[$row['gc_id']] = $row;
			$this->galleries_sub[$row['gc_parent_gc_id']][] = $row['gc_id'];
		}
	}
	
	protected function handle_check()
	{
		// opprette nytt galleri?
		if (isset($_GET['gc_add']))
		{
			$this->gc_add();
		}
		
		// har vi valgt et galleri?
		if (isset($_GET['gc_id']))
		{
			$this->handle_gallery();
		}
	}
	
	protected function gc_add()
	{
		ess::$b->page->add_title("Nytt galleri");
		# TODO nodes::add_node(0, "Nytt galleri", ess::$s['relative_path']."/a/galleries.php?gc_add");
	
		// finn ut hvor galleriet skal plasseres
		$parent_gc = 0;
		$previous_gc = 0;
		# _GET parent_gc
		# _GET previous_gc
		if (isset($_GET['parent_gc']))
		{
			// finnes denne?
			$parent_gc = intval($_GET['parent_gc']);
			if (isset($this->galleries[$parent_gc]))
			{
				// sjekk rekkefølge
				if (isset($_GET['previous_gc']))
				{
					$previous_gc = intval($_GET['previous_gc']);
					if (!in_array($previous_gc, $this->galleries_sub[$parent_gc]))
					{
						// finnes ikke
						$previous_gc = 0;
					}
				}
			}
			else
			{
				$parent_gc = 0;
			}
		}
	
		// legge til?
		if (isset($_POST['title']))
		{
			$title = trim(postval("title"));
			$description = trim(postval("description"));
	
			// sjekk lengden på tittelen
			// minimum: 3
			// maksimum: 150
			if (strlen($title) < 3)
			{
				ess::$b->page->add_message("Tittelen må inneholde minst 3 tegn.", "error");
			}
			elseif (strlen($title) > 150)
			{
				ess::$b->page->add_message("Tittelen kan ikke overskride 150 tegn.", "error");
			}
			else
			{
				// legg til
				// finn endelige priority
				$priority = 0;
				if ($previous_gc > 0)
				{
					$priority = $this->galleries[$previous_gc]['gc_priority'] + 1;
				}
	
				// øk prioriteringen på galleriene
				ess::$b->db->query("UPDATE gallery_categories SET gc_priority = gc_priority + 1 WHERE gc_parent_gc_id = $parent_gc AND gc_priority >= $priority");
	
				// legg til selve galleriet
				ess::$b->db->query("INSERT INTO gallery_categories SET gc_parent_gc_id = $parent_gc, gc_title = ".ess::$b->db->quote($title).", gc_description = ".ess::$b->db->quote($description).", gc_created = ".time().", gc_priority = $priority");
	
				// finn id
				$id = mysql_insert_id();
	
				ess::$b->page->add_message("Galleriet ble lagt til. Du kan nå legge til bilder og publisere galleriet.");
				redirect::handle("galleries.php?gc_id=$id");
			}
		}
	
		// sett opp plasseringen
		$items = array();
		while (isset($this->galleries[$parent_gc]) && $item = $this->galleries[$parent_gc])
		{
			$items[] = $item['gc_title'];
			$parent_gc = $item['gc_parent_gc_id'];
		}
		$items[] = "Toppnivå";
	
		echo '
	<h2>Nytt galleri</h2>
	<p><a href="galleries.php">Tilbake</a></p>
	<form action="" method="post">
		<dl class="dl_2x dl_20">
			<dt>Plassering</dt>
			<dd>'.implode("\\", array_reverse($items)).'</dd>
	
			<dt>Tittel</dt>
			<dd><input type="text" name="title" class="w300" value="'.htmlspecialchars(postval("title")).'" maxlength="150" /></dd>
	
			<dt>Beskrivelse</dt>
			<dd>
				<textarea name="description" cols="30" rows="10" class="bbkode w400">'.htmlspecialchars(postval("description")).'</textarea>
			</dd>
	
			<dt>&nbsp;</dt>
			<dd>'.show_sbutton("Opprett galleri").'</dd>
		</dl>
	</form>';
	
		ess::$b->page->load();
	}
	
	protected function handle_gallery()
	{
		// finn galleriet
		$g = getval("gc_id");
		if (isset($this->galleries[$g]))
		{
			$this->active = new gallery($this->galleries[$g]);
		}
		if (!$this->active)
		{
			// fant ikke galleriet
			ess::$b->page->add_message("Fant ikke galleriet.", "error");
			redirect::handle();
		}
		
		// sett opp titteler
		$items = array();
		$parent_gc = $this->active->data['gc_parent_gc_id'];
		while (isset($this->galleries[$parent_gc]) && $item = $this->galleries[$parent_gc])
		{
			$items[] = array($item['gc_title'], ess::$s['relative_path']."/a/galleries.php?gc_id={$item['gc_id']}");
			$parent_gc = $item['gc_parent_gc_id'];
		}
		$items = array_reverse($items);
		
		foreach ($items as $item)
		{
			# TODO nodes::add_node(0, $item[0], $item[1]);
			ess::$b->page->add_title($item[0]);
		}
		
		// tittel på denne siden
		ess::$b->page->add_title($this->active->data['gc_title']);
		# TODO nodes::add_node(0, $this->active->data['gc_title'], ess::$s['relative_path']."/a/galleries.php?gc_id={$this->active->id}");
		redirect::store("galleries.php?gc_id={$this->active->id}");
		
		$this->handle_gallery_check();
	}
	
	protected function handle_gallery_check()
	{
		// vise galleriet?
		if (isset($_GET['gc_visible']))
		{
			$this->gallery_visible();
		}
		
		// slett galleri
		if (isset($_GET['gc_delete']))
		{
			$this->gallery_delete();
		}
		
		// handlinger med bildene
		if (isset($_POST['gi_action']))
		{
			$this->gallery_gi_action();
		}
		
		// rediger galleri
		if (isset($_GET['gc_edit']))
		{
			$this->gallery_edit();
		}
		
		// flytt galleri
		if (isset($_GET['gc_move']))
		{
			$this->gallery_move();
		}
		
		// last opp bilder (java applet)
		if (isset($_GET['gi_add']))
		{
			$this->gallery_gi_add();
		}
		
		// last opp bilder
		if (isset($_GET['gi_add_manual']))
		{
			$this->gallery_gi_add_manual();
		}
	}
	
	protected function gallery_visible()
	{
		$visible = $_GET['gc_visible'] != 0;
		
		if ($visible)
		{
			if ($this->active->data['gc_visible'] != 0)
			{
				ess::$b->page->add_message("Galleriet er allerede synlig.", "error");
			}
			else
			{
				ess::$b->db->query("UPDATE gallery_categories SET gc_visible = 1 WHERE gc_id = {$this->active->id}");
				ess::$b->page->add_message("Galleriet er nå synlig.");
			}
		}
		else
		{
			if ($this->active->data['gc_visible'] == 0)
			{
				ess::$b->page->add_message("Galleriet er allerede skjult.", "error");
			}
			else
			{
				ess::$b->db->query("UPDATE gallery_categories SET gc_visible = 0 WHERE gc_id = {$this->active->id}");
				ess::$b->page->add_message("Galleriet er nå skjult.");
			}
		}
		
		redirect::handle();
	}
	
	protected function gallery_delete()
	{
		// finnes det noen gallerier eller bilder inni dette galleriet?
		$count_sub = isset($this->galleries_sub[$this->active->id]) ? count($this->galleries_sub[$this->active->id]) : 0;
		$count_imgs = $this->active->data['gi_count'];
		
		if ($count_sub > 0 || $count_imgs > 0)
		{
			if ($count_sub == 0)
			{
				ess::$b->page->add_message("Galleriet inneholder <b>".format_num($count_imgs)."</b> bilde".($count_imgs == 1 ? '' : 'r').". Bildene må flyttes eller slettes før dette galleriet kan slettes.", "error");
			}
			elseif ($count_imgs == 0)
			{
				ess::$b->page->add_message("Galleriet inneholder <b>".format_num($count_sub)."</b> galleri".($count_sub == 1 ? '' : 'er').". Galleriene må flyttes eller slettes før dette galleriet kan slettes.", "error");
			}
			else
			{
				ess::$b->page->add_message("Galleriet inneholder <b>".format_num($count_sub)."</b> galleri".($count_sub == 1 ? '' : 'er')." og <b>".format_num($count_imgs)."</b> bilde".($count_imgs == 1 ? '' : 'r').". Galleriene og bildene må flyttes eller slettes før dette galleriet kan slettes.", "error");
			}
		}
		
		else
		{
			// slett galleriet
			ess::$b->db->query("DELETE FROM gallery_categories WHERE gc_id = {$this->active->id}");
			ess::$b->page->add_message("Galleriet ble slettet.");
			redirect::handle("galleries.php");
		}
		
		redirect::handle();
	}
	
	protected function gallery_gi_action()
	{
		// finn ut hvilke bilder som er markert
		if (!isset($_POST['gi_id']) || !is_array($_POST['gi_id']))
		{
			ess::$b->page->add_message("Ingen bilder var markert.", "error");
			redirect::handle();
		}
		$gi_id = array_unique(array_map("intval", $_POST['gi_id']));
		
		if (count($gi_id) == 0)
		{
			ess::$b->page->add_message("Ingen bilder var markert.", "error");
			redirect::handle();
		}
		
		// sjekk handling
		switch ($_POST['gi_action'])
		{
			// vis bildene
			case "gi_show":
				ess::$b->db->query("UPDATE gallery_images SET gi_visible = 1 WHERE gi_gc_id = {$this->active->id} AND gi_id IN (".implode(",", $gi_id).")");
				ess::$b->page->add_message("<b>".mysql_affected_rows()."</b> bilde(r) ble synlig(e).", "error");
				redirect::handle();
				
			// skjul bildene
			case "gi_hide":
				ess::$b->db->query("UPDATE gallery_images SET gi_visible = 0 WHERE gi_gc_id = {$this->active->id} AND gi_id IN (".implode(",", $gi_id).")");
				ess::$b->page->add_message("<b>".mysql_affected_rows()."</b> bilde(r) ble skjult.", "error");
				redirect::handle();
				
			// sett som galleri bilde
			case "gc_img":
				if (count($gi_id) > 1)
				{
					ess::$b->page->add_message("Du kan ikke merke flere enn 1 bilde når du skal sette et bilde som forside for galleriet.", "error");
					redirect::handle();
				}
				
				// kontroller at bildet ligger i dette galleriet
				$gi_id = current($gi_id);
				$result = ess::$b->db->query("SELECT gi_id FROM gallery_images WHERE gi_id = $gi_id AND gi_gc_id = {$this->active->id}");
				
				if (mysql_num_rows($result) == 0)
				{
					ess::$b->page->add_message("Fant ikke bildet.", "error");
					redirect::handle();
				}
				
				// sett som galleri bilde
				ess::$b->db->query("UPDATE gallery_categories SET gc_gi_id = $gi_id WHERE gc_id = {$this->active->id}");
				ess::$b->page->add_message("Bildet ble satt som forside for galleriet.");
				redirect::handle();
				
			// flytt bildene
			case "gi_move":
				ess::$b->page->add_message("Denne muligheten kommer etter hvert.");
				redirect::handle();
				break;
				
			// slett bildene
			case "gi_delete":
				$this->gallery_gi_delete($gi_id);
				
			case "gi_edit":
				$this->gallery_gi_edit($gi_id);
				
			default:
				// ukjent
				ess::$b->page->add_message("Ukjent handling.", "error");
				redirect::handle();
		}
	}
	
	protected function gallery_gi_delete($gi_id)
	{
		// avbryte
		if (isset($_POST['abort']))
		{
			ess::$b->page->add_message("Bildene ble ikke slettet.");
			redirect::handle();
		}
		
		// bekreftet
		elseif (isset($_POST['confirm']))
		{
			// hent filnavn for bildene
			$result = ess::$b->db->query("SELECT gi_filename FROM gallery_images WHERE gi_gc_id = {$this->active->id} AND gi_id IN (".implode(",", $gi_id).")");
			while ($row = mysql_fetch_assoc($result))
			{
				// slett mulige bilder
				@unlink(GALLERY_FOLDER."/original/{$row['gi_filename']}.jpg");
				@unlink(GALLERY_FOLDER."/inside/{$row['gi_filename']}.jpg");
				@unlink(GALLERY_FOLDER."/thumb/{$row['gi_filename']}.jpg");
			}
			
			// slett bildene fra databasen
			ess::$b->db->query("DELETE FROM gallery_images WHERE gi_gc_id = {$this->active->id} AND gi_id IN (".implode(",", $gi_id).")");
			ess::$b->page->add_message("<b>".mysql_affected_rows()."</b> bilde(r) ble slettet.");
			redirect::handle();
		}
		
		// hent bildene
		$result = ess::$b->db->query("SELECT gi_id, gi_title FROM gallery_images WHERE gi_gc_id = {$this->active->id} AND gi_id IN (".implode(",", $gi_id).") ORDER BY gi_priority");
		
		echo '
<h2>'.htmlspecialchars($this->active->data['gc_title']).'</h2>
<p><a href="galleries.php?gc_id='.$this->active->id.'">Tilbake</a></p>
<h3>Slette bilder</h3>
<p style="color: #FF0000">Er du sikker på at du vil slette disse bildene? Handlingen blir permanent dersom det ikke finnes backup.</p>';
		
		// vis bildene på denne siden
		$table = new tbody(min(mysql_num_rows($result), 3));
		page::add_css('.gi_list td { padding: 10px } .gi_list a { text-decoration: none; margin: -10px; padding: 10px; display: block; width: 100%; height: 100% } .gi_list a:hover { text-decoration: none; background-color: #EEEEEE }');
		
		echo '
<table class="table align_center" width="'.round(100/3*$table->cols).'%">
	<tbody class="c gi_list">';
		
		$ids = array();
		while ($row = mysql_fetch_assoc($result))
		{
			$ids[] = $row['gi_id'];
			$title = empty($row['gi_title']) ? '<i>Tittel mangler</i>' : htmlspecialchars($row['gi_title']);
			$td = '<img src="'.ess::$s['relative_path'].'/o.php?a=gi&amp;gi_id='.$row['gi_id'].'&amp;gi_size=thumbnail" alt="Bilde" /><br />'.$title;
		
			$table->append('<a href="'.ess::$s['relative_path'].'/galleri/bilde/'.$row['gi_id'].'" alt="Vis stort format">'.$td.'</a>');
		}
		
		$table->clean();
		
		echo '
	</tbody>
</table>
		
<form action="" method="post">
	<input type="hidden" name="gi_action" value="gi_delete" />';
		
		foreach ($ids as $id)
		{
			echo '
	<input type="hidden" name="gi_id[]" value="'.$id.'" />';
		}
		
		echo '
	<p>
		<span class="red">'.show_sbutton("Slett bildene", 'name="confirm"').'</span>
		'.show_sbutton("Avbryt", 'name="abort"').'
	</p>
</form>';
		
		ess::$b->page->load();
	}
	
	protected function gallery_gi_edit($gi_id)
	{
		// rediger bildene
		
		// lagre endringer
		if (isset($_POST['title']))
		{
			if (!is_array($_POST['title']) || !isset($_POST['description']) || !is_array($_POST['description']))
			{
				ess::$b->page->add_message("Noe gikk galt.", "error");
			}
			else
			{
				$updated = 0;
				foreach ($_POST['title'] as $key => $title)
				{
					$key = intval($key);
					if (!in_array($key, $gi_id)) continue;
					
					// sett opp det vi skal ha
					$title = trim($title);
					if (strlen($title) > 150) $title = substr($title, 0, 150);
					$description = isset($_POST['description'][$key]) ? $_POST['description'][$key] : "";
					$visible = isset($_POST['visible'][$key]) ? 1 : 0;
					
					$shot_person = isset($_POST['shot_person'][$key]) ? $_POST['shot_person'][$key] : "";
					$shot_date = isset($_POST['shot_date'][$key]) ? $_POST['shot_date'][$key] : "";
					
					// oppdater
					ess::$b->db->query("UPDATE gallery_images SET gi_title = ".ess::$b->db->quote($title).", gi_description = ".ess::$b->db->quote($description).", gi_shot_person = ".ess::$b->db->quote($shot_person).", gi_shot_date = ".ess::$b->db->quote($shot_date).", gi_visible = $visible WHERE gi_id = $key AND gi_gc_id = {$this->active->id}");
					$updated += mysql_affected_rows();
				}
				
				ess::$b->page->add_message("<b>$updated</b> bilde".($updated == 1 ? '' : 'r')." ble oppdatert.");
				redirect::handle();
			}
		}
		
		// hent bildene
		$result = ess::$b->db->query("SELECT gi_id, gi_title, gi_description, gi_shot_person, gi_shot_date, gi_visible FROM gallery_images WHERE gi_gc_id = {$this->active->id} AND gi_id IN (".implode(",", $gi_id).") ORDER BY gi_priority");
		
		if (mysql_num_rows($result) == 0)
		{
			ess::$b->page->add_message("Fant ingen bilder.", "error");
			redirect::handle();
		}
		
		echo '
<h2>'.htmlspecialchars($this->active->data['gc_title']).'</h2>
<p><a href="galleries.php?gc_id='.$this->active->id.'">Tilbake</a></p>
<h3>Rediger bilder</h3>
<p>Nedenfor er alle bildene du merket av listet opp. Rediger bildene du vil redigere og trykk <u>lagre endringer</u> når du er ferdig.</p>
<form action="" method="post">
	<input type="hidden" name="gi_action" value="gi_edit" />';
		
		// vis bildene på denne siden
		$table = new tbody(min(mysql_num_rows($result), 3));
		page::add_css('.gi { padding: 5px; background-color: #F8F8F8; border: 1px solid #DDDDDD }');
		
		while ($row = mysql_fetch_assoc($result))
		{
			$title = isset($_POST['title'][$row['gi_id']]) ? $_POST['title'][$row['gi_id']] : $row['gi_title'];
			$description = isset($_POST['description'][$row['gi_id']]) ? $_POST['description'][$row['gi_id']] : $row['gi_description'];
			
			$shot_person = isset($_POST['shot_person'][$row['gi_id']]) ? $_POST['shot_person'][$row['gi_id']] : $row['gi_shot_person'];
			$shot_date = isset($_POST['shot_date'][$row['gi_id']]) ? $_POST['shot_date'][$row['gi_id']] : $row['gi_shot_date'];
			
			echo '
	<div class="hr"></div>
	<input type="hidden" name="gi_id[]" value="'.$row['gi_id'].'" />
	<dl class="dl_20 dl_2x">
		<dt>Bilde</dt>
		<dd><img src="'.ess::$s['relative_path'].'/o.php?a=gi&amp;gi_id='.$row['gi_id'].'&amp;gi_size=thumbnail" alt="Bildet" class="gi" /></dd>
		<dt>Synlig</dt>
		<dd><input type="checkbox" name="visible['.$row['gi_id'].']"'.($row['gi_visible'] != 0 ? ' checked="checked"' : '').' /></dd>
		<dt>Tittel</dt>
		<dd><input type="text" name="title['.$row['gi_id'].']" class="w350" value="'.htmlspecialchars($title).'" maxlength="150" /></dd>
		<dt>Fotograf</dt>
		<dd><input type="text" name="shot_person['.$row['gi_id'].']" class="w200" value="'.htmlspecialchars($shot_person).'" maxlength="100" /></dd>
		<dt>Bildedato</dt>
		<dd><input type="text" name="shot_date['.$row['gi_id'].']" class="w80" value="'.htmlspecialchars($shot_date).'" maxlength="50" /> YYYY-MM-DD</dd>
		<dt>Beskrivelse</dt>
		<dd><textarea name="description['.$row['gi_id'].']" cols="30" rows="10" class="bbkode w400">'.htmlspecialchars($description).'</textarea></dd>
	</dl>';
		}
		
		echo '
	<div class="hr"></div>
	<p>'.show_sbutton("Lagre endringer").'</p>
</form>';
		
		ess::$b->page->load();
	}
	
	protected function gallery_edit()
	{
		// lagre endringer?
		if (isset($_POST['title']))
		{
			$title = trim(postval("title"));
			$description = trim(postval("description"));
			
			// sjekk lengden på tittelen
			// minimum: 3
			// maksimum: 150
			if (strlen($title) < 3)
			{
				ess::$b->page->add_message("Tittelen må inneholde minst 3 tegn.", "error");
			}
			elseif (strlen($title) > 150)
			{
				ess::$b->page->add_message("Tittelen kan ikke overskride 150 tegn.", "error");
			}
			else
			{
				// oppdater
				ess::$b->db->query("UPDATE gallery_categories SET gc_title = ".ess::$b->db->quote($title).", gc_description = ".ess::$b->db->quote($description)." WHERE gc_id = {$this->active->id}");
				
				ess::$b->page->add_message("Galleriet ble oppdatert.");
				redirect::handle();
			}
		}
		
		// sett opp plasseringen
		$items = array();
		$parent_gc = $this->active->data['gc_parent_gc_id'];
		while (isset($this->galleries[$parent_gc]) && $item = $this->galleries[$parent_gc])
		{
			$items[] = $item['gc_title'];
			$parent_gc = $item['gc_parent_gc_id'];
		}
		$items[] = "Toppnivå";
		
		// tittel
		ess::$b->page->add_title("Rediger galleri");
		# TODO nodes::add_node(0, "Rediger galleri", ess::$s['relative_path']."/a/galleries.php?gc_id={$this->active->id}&amp;gc_edit");
		
		echo '
<h2>'.htmlspecialchars($this->active->data['gc_title']).'</h2>
<p><a href="galleries.php?gc_id='.$this->active->id.'">Tilbake</a></p>

<h3>Rediger galleri</h3>
<form action="" method="post">
	<dl class="dl_2x dl_20">
		<dt>Plassering</dt>
		<dd>'.implode("\\", array_reverse($items)).'</dd>
		
		<dt>Tittel</dt>
		<dd><input type="text" name="title" class="w300" value="'.htmlspecialchars(postval("title", $this->active->data['gc_title'])).'" maxlength="150" /></dd>
		
		<dt>Beskrivelse</dt>
		<dd>
			<textarea name="description" cols="30" rows="10" class="bbkode w400">'.htmlspecialchars(postval("description", $this->active->data['gc_description'])).'</textarea>
		</dd>
		
		<dt>&nbsp;</dt>
		<dd>'.show_sbutton("Lagre endringer").'</dd>
	</dl>
</form>';
		
		ess::$b->page->load();
	}
	
	protected function gallery_move()
	{
		// hent tree
		$root = array(0 => array(
			"number" => 0,
			"prefix" => "",
			"prefix_node" => "",
			"gc" => array(
				"gc_id" => 0,
				"gc_parent_gc_id" => 0,
				"gc_title" => "Gallerier (toppnivå)",
				"gc_description" => "Gallerier",
				"gc_gi_id" => NULL,
				"gc_views" => "0",
				"gc_created" => NULL,
				"gc_visible" => "1",
				"gc_priority" => "0",
				"gi_count" => "0"
			)
		));
		
		$tree = new tree($this->galleries_sub);
		$data = $tree->generate(0, $root, $this->galleries, "gc");
		
		// sett opp totalt antall bilder
		end($data);
		while ($row = current($data))
		{
			$row = &$data[key($data)];
			if (!isset($row['gc']['gi_count_total']))
			{
				$data[$row['gc']['gc_id']]['gc']['gi_count_total'] = 0;
				$data[$row['gc']['gc_id']]['gi_count'] = 0;
			}
			
			$data[$row['gc']['gc_id']]['gc']['gi_count_total'] += $row['gc']['gi_count'];
			
			if ($row['gc']['gc_id'] != 0)
			{
				if (!isset($data[$row['gc']['gc_parent_gc_id']]['gc']['gi_count_total']))
				{
					$data[$row['gc']['gc_parent_gc_id']]['gc']['gi_count_total'] = 0;
					$data[$row['gc']['gc_parent_gc_id']]['gi_count'] = 0;
				}
				
				$data[$row['gc']['gc_parent_gc_id']]['gc']['gi_count_total'] += (int)$row['gc']['gi_count_total'];
				$data[$row['gc']['gc_parent_gc_id']]['gi_count'] += $row['gi_count'] + 1;
			}
			
			unset($row);
			prev($data);
		}
		
		// sett opp data og finn ut hvor ting kan plasseres
		$number_last = 1;
		$disabled = 0;
		
		$list = array(0 => 0);
		foreach ($data as &$row)
		{
			if ($disabled != 0 && $row['number'] <= $disabled) $disabled = 0;
			$number_last = $row['number'];
			
			$row['inside'] = $disabled == 0 && $this->active->id != $row['gc']['gc_id'];
			$row['under'] = $disabled == 0 && $this->active->id != $row['gc']['gc_id'];
			
			if ($this->active->id == $row['gc']['gc_id'])
			{
				if (isset($list[$row['number']])) $active = array("under", $list[$row['number']]);
				else $active = array("inside", $list[$row['number']-1]);
				
				$disabled = $row['number'];
			}
			
			$list[$row['number']] = $row['gc']['gc_id'];
		}
		unset($row);
		$data[0]['under'] = false;
		
		// lagre endringer?
		if (isset($_POST['destination_gc_id']))
		{
			$match = preg_match("/^(under_)?(\d+)$/", postval("destination_gc_id"), $matches);
			$type = $match && $matches[1] == "under_" ? "under" : "inside";
			$dest_gc_id = $match ? $matches[2] : -1;
			$parent_gc_id = $type == "inside" ? $dest_gc_id : $this->galleries[$dest_gc_id]['gc_parent_gc_id'];
			
			// finnes?
			if (!isset($data[$dest_gc_id]))
			{
				ess::$b->page->add_message("Fant ikke målkategori.", "error");
			}
			
			// kan plasseres her?
			elseif (!$data[$dest_gc_id][$type])
			{
				ess::$b->page->add_message("Du kan ikke plassere kategorien her.", "error");
			}
			
			// samme som nå?
			elseif ($type == $active[0] && $dest_gc_id == $active[1])
			{
				ess::$b->page->add_message("Du må velge en ny plassering.", "error");
			}
			
			else
			{
				// TODO: database transaction
				
				// flytt de andre kategoriene
				ess::$b->db->query("UPDATE gallery_categories SET gc_priority = gc_priority - 1 WHERE gc_parent_gc_id = {$this->active->data['gc_parent_gc_id']} AND gc_priority > {$this->active->data['gc_priority']}");
				ess::$b->db->query("UPDATE gallery_categories SET gc_priority = gc_priority + 1 WHERE gc_parent_gc_id = $parent_gc_id".($type == "under" ? " AND gc_priority > {$this->galleries[$dest_gc_id]['gc_priority']}" : ""));
				
				// flytt den valgte kategorien
				ess::$b->db->query("UPDATE gallery_categories SET gc_parent_gc_id = $parent_gc_id, gc_priority = ".($type == "inside" ? 0 : $this->galleries[$dest_gc_id]['gc_priority'] + 1)." WHERE gc_id = {$this->active->id}");
				
				ess::$b->page->add_message("Galleriet ble flyttet.");
				redirect::handle();
			}
		}
		
		// sett opp plasseringen
		$items = array();
		$parent_gc = $this->active->data['gc_parent_gc_id'];
		while (isset($this->galleries[$parent_gc]) && $item = $this->galleries[$parent_gc])
		{
			$items[] = $item['gc_title'];
			$parent_gc = $item['gc_parent_gc_id'];
		}
		$items[] = "Toppnivå";
		
		// tittel
		ess::$b->page->add_title("Flytt galleri");
		# TODO nodes::add_node(0, "Flytt galleri", ess::$s['relative_path']."/a/galleries.php?gc_id={$this->active->id}&amp;gc_move");
		
		echo '
<h2>'.htmlspecialchars($this->active->data['gc_title']).'</h2>
<p><a href="galleries.php?gc_id='.$this->active->id.'">Tilbake</a></p>

<h3>Flytt galleri</h3>
<form action="" method="post">
	<dl class="dl_2x dd_right">
		<dt>Nåværende plassering</dt>
		<dd>'.implode("\\", array_reverse($items)).'</dd>
		
		<dt>Ny plassering</dt>
		<dd>
			<table class="table" style="margin-left: auto">
				<thead>
					<tr>
						<th>Galleri</th>
						<th>Bilder</th>
						<th>Inni</th>
						<th>Nedenfor</th>
					</tr>
				</thead>
				<tbody class="c">';
		$i = 0;
		foreach ($data as $row)
		{
			$i++;
			$class = $this->active->id == $row['gc']['gc_id'] ? ' class="highlight"' : ($i % 2 == 0 ? ' class="color"' : '');
			$link = $row['gc']['gc_id'] == 0 ? $row['gc']['gc_title'] : '<a href="galleries.php?gc_id='.$row['gc']['gc_id'].'">'.htmlspecialchars($row['gc']['gc_title']).'</a>';
			
			echo '
					<tr'.$class.'>
						<td class="l"><span class="plain">'.$row['prefix'].$row['prefix_node'].'</span>'.$link.($row['gc']['gc_visible'] == 0 ? ' <span style="color:#FF0000">(skjult)</span>' : '').'</td>
						<td class="r">'.($row['gc']['gc_id'] == 0 ? 'Totalt '.format_num($row['gc']['gi_count_total']) : format_num($row['gc']['gi_count']).($row['gi_count'] == 0 ? '' : ' ('.format_num($row['gc']['gi_count_total']).')')).'</td>
						<td>'.($row['inside'] ? '<input type="radio" name="destination_gc_id" value="'.$row['gc']['gc_id'].'"'.($active[0] == "inside" && $active[1] == $row['gc']['gc_id'] ? ' checked="checked"' : '') : ' x').'</td>
						<td>'.($row['under'] ? '<input type="radio" name="destination_gc_id" value="under_'.$row['gc']['gc_id'].'"'.($active[0] == "under" && $active[1] == $row['gc']['gc_id'] ? ' checked="checked"' : '') : ' x').'</td>
					</tr>';
		}
		
		echo '
				</tbody>
			</table>
		</dd>
		
		<dt>&nbsp;</dt>
		<dd>'.show_sbutton("Lagre endringer").'</dd>
	</dl>
</form>';

		ess::$b->page->load();
	}
	
	protected function gallery_gi_add()
	{
		// tittel
		ess::$b->page->add_title("Last opp bilder");
		# TODO nodes::add_node(0, "Last opp bilder", ess::$s['relative_path']."/a/galleries.php?gc_id={$this->active->id}&amp;gi_add");
		
		echo '
<h2>'.htmlspecialchars($this->active->data['gc_title']).'</h2>
<p><a href="galleries.php?gc_id='.$this->active->id.'">Tilbake</a></p>
<h3>Last opp bilder</h3>
<p>Hvis du ikke klarer å laste opp bilder på denne siden kan du bruke den <a href="galleries.php?gc_id='.$this->active->id.'&amp;gi_add_manual">gamle siden</a>.</p>
<p>Denne siden benytter en java applet til å laste opp bilder. For å endre tittel eller beskrivelse må du redigere bildene etter de er lastet opp.</p>
<p><b>Tips:</b> Åpne en vanlig mappe og dra filene inn til listen nedenfor. På den måten kan du forhåndsvise bildene og velge kun de riktige bildene!</p>
<div style="margin-bottom: 10px">
<applet code="wjhk.jupload2.JUploadApplet" archive="'.ess::$s['absolute_path'].'/lib/jupload/jupload.jar" width="100%" height="400" alt="" mayscript="mayscript">
	<param name="postURL" value="'.ess::$s['relative_path'].'/a/galleries.php?gc_id='.$this->active->id.'&amp;gi_add" />
	<param name="serverProtocol" value="HTTP/1.1" />
	<param name="uploadPolicy" value="PictureUploadPolicy" />
	<param name="nbFilesPerRequest" value="1" />
	<param name="lang" value="no" />
	<param name="showLogWindow" value="false" />
	<param name="showStatusBar" value="false" />
	<param name="maxPicWidth" value="1600" />
	<param name="maxPicHeight" value="1600" />
	<param name="pictureCompressionQuality" value="0.9" />
	<param name="fileChooserIconFromFileContent" value="-1" />
	<param name="afterUploadURL" value="'.ess::$s['relative_path'].'/a/galleries.php?gc_id='.$this->active->id.'" />
</applet>
</div>';
		
		ess::$b->page->load();
	}
	
	protected function gallery_gi_add_manual()
	{
		// laste opp?
		if (isset($_POST['title']) && is_array($_POST['title']) && isset($_POST['description']) && is_array($_POST['description']))
		{
			// gi_KEY (_FILES)
			// title[KEY]
			// description[KEY]

			/*
			array(1) {
			  ["gi_0"]=>
			  array(5) {
			    ["name"]=>
			    string(13) "SmokeyPoT.jpg"
			    ["type"]=>
			    string(10) "image/jpeg"
			    ["tmp_name"]=>
			    string(14) "/tmp/phpXNDn0i"
			    ["error"]=>
			    int(0)
			    ["size"]=>
			    int(53042)
			  }
			}
			*/

			$i = 0;
			$added = 0;
			foreach ($_POST['title'] as $key => $title)
			{
				$i++;

				// sjekk for bildet
				if (!isset($_FILES['gi_'.$key]))
				{
					unset($_POST['title'][$key]);
					continue;
				}

				$title = trim($title);
				if (strlen($title) > 150) $title = substr($title, 0, 150);
				$description = isset($_POST['description'][$key]) ? $_POST['description'][$key] : "";

				// informasjon om bildet
				$src = $_FILES['gi_'.$key]['tmp_name'];
				$name = $_FILES['gi_'.$key]['name'];

				// sett opp filnavnet uten etternavn og forkort om nødvendig
				if (($pos = strrpos($name, ".")) !== false)
				{
					$name = substr($name, 0, $pos);
				}
				if (strlen($name) > 150) $name = substr($name, 0, 150);

				// filnavn til tittel?
				if (empty($title) && isset($_POST['use_org_name']))
				{
					$title = $name;
				}
				else
				{
					// legg til filnavnet i beskrivelsen
					$description = "[hide]".$name."[/hide]".$description;
				}

				// sjekk om det er et gyldig bilde
				if (!is_uploaded_file($src))
				{
					ess::$b->page->add_message("Noe gikk galt under opplasting av bilde nummer $i.", "error");
					continue;
				}

				// forsøk å åpne bildet
				$img = @imagecreatefromstring(@file_get_contents($src));
				if (!$img)
				{
					ess::$b->page->add_message("Kunne ikke lese bilde nummer $i.", "error");
					continue;
				}

				$img_width = imagesx($img);
				$img_height = imagesy($img);

				// maksimal størrelse:
				// bredde: 1600
				// høyde: 1600
				$max_width = 1600;
				$max_height = 1600;

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
				$pre_content = ob_get_contents();
				@ob_clean();
				imagejpeg($img, null, 90);
				$data = ob_get_contents();
				@ob_clean();
				echo $pre_content;

				// finn høyeste prioritering
				$result = ess::$b->db->query("SELECT MAX(gi_priority) FROM gallery_images WHERE gi_gc_id = {$this->active->id}");
				$priority = mysql_result($result, 0) + 1;
				
				// start transaksjon
				ess::$b->db->query("BEGIN");
				
				// legg til i databasen
				ess::$b->db->query("INSERT INTO gallery_images SET gi_gc_id = {$this->active->id}, gi_title = ".ess::$b->db->quote($title).", gi_description = ".ess::$b->db->quote($description).", gi_time = ".time().", gi_priority = $priority");
				
				// hent ut ID
				$id = mysql_insert_id();
				
				// lagre bildet til disk
				$filename = $id.str_pad(dechex((float)sprintf("%u", crc32($data))), 8, "0", STR_PAD_LEFT);
				$p = GALLERY_FOLDER."/original/$filename.jpg";
				if (!file_put_contents($p, $data))
				{
					ess::$b->db->query("ROLLBACK"); // avbryt transaksjon
					
					ess::$b->page->add_message("Kunne ikke lagre bildet ".htmlspecialchars($path)." på disk. Kontakt Henrik. Avbryter.", "error");
					break;
				}
				
				// lagre filnavn
				ess::$b->db->query("UPDATE gallery_images SET gi_filename = ".ess::$b->db->quote($filename)." WHERE gi_id = $id");
				
				// fullfør transaksjon
				ess::$b->db->query("COMMIT");
				
				ess::$b->page->add_message("Bilde nummer <b>$i</b> med tittel <b>".htmlspecialchars($title)."</b> ble lagt til.");
				unset($_POST['title'][$key]);
				$added++;
			}
			
			// antall bilder som ble lastet opp
			#ess::$b->page->add_message("<b>$added</b> bilde(r) ble lastet opp.");

			// sjekk om det var noen bilder som ikke ble lastet opp
			$incomplete = count($_POST['title']);

			if ($incomplete > 0)
			{
				#ess::$b->page->add_message("<b>$incomplete</b> bilde(r) ble ikke lagt til.", "error");
			}
			else
			{
				redirect::handle("galleries.php?gc_id={$this->active->id}");
			}
		}

		// tittel
		ess::$b->page->add_title("Last opp bilder (manuelt)");
		# TODO nodes::add_node(0, "Last opp bilder", ess::$s['relative_path']."/a/galleries.php?gc_id={$this->active->id}&amp;gi_add_manual");

		echo '
<h2>'.htmlspecialchars($this->active->data['gc_title']).'</h2>
<p><a href="galleries.php?gc_id='.$this->active->id.'">Tilbake</a></p>
<h3>Last opp bilder</h3>
<p>Du kan velge å laste opp flere bilder for hver gang. Dessto flere bilder som blir lastet opp på en gang, dess lengre tid tar det. Skjer det noe galt under opplastingen risikerer man at ingen av bildene man laster opp blir lastet opp.</p>
<p>Etter du har trykket <u>last opp</u> knappen, må du vente mens bildene blir lastet opp fra din PC til serveren.</p>
<p>
	Antall rader i beskrivelse feltet:
	<select onchange="setDescRows(this.value)">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10" selected="selected">10</option>
		<option value="11">11</option>
		<option value="12">12</option>
		<option value="13">13</option>
		<option value="14">14</option>
		<option value="15">15</option>
		<option value="16">16</option>
		<option value="17">17</option>
		<option value="18">18</option>
		<option value="18">19</option>
		<option value="20">20</option>
	</select>
</p>

<form action="" method="post" enctype="multipart/form-data">
	<p><input type="checkbox" name="use_org_name" checked="checked" id="use_org_name" /><label for="use_org_name"> Sett tittel til filnavnet dersom tittelfeltet ikke blir fylt ut.</label></p>
	<div id="gi_add_wrap">';

		// sett opp liste med enheter vi skal vise
		$list = array();
		if (isset($_POST['title']) && is_array($_POST['title']) && isset($_POST['description']) && is_array($_POST['description']))
		{
			foreach ($_POST['title'] as $key => $title)
			{
				// beskrivelse
				$description = isset($_POST['description'][$key]) ? $_POST['description'][$key] : "";

				// feilet bilde? har vi bildenavn?
				$name = isset($_FILES['gi_'.$key]) ? $_FILES['gi_'.$key]['name'] : "";

				// legg til i listen
				$list[] = array($title, $description);
			}
		}
		for ($i = count($list); $i < 1; $i++)
		{
			$list[] = array("", "", "");
		}

		foreach ($list as $key => $item)
		{
			echo '
		<div class="gi_add_item">
			<div class="hr"></div>
			<dl class="dl_20 dl_2x">
				<dt>Bilde'.(!empty($item[2]) ? ' <br /><span style="color:#FF0000">'.htmlspecialchars($item[2]).'</span>' : '').'</dt>
				<dd><input type="file" name="gi_'.$key.'" class="w400" size="55" onchange="previewImage(this)" /></dd>
				<dt>Forhåndsvisning</dt>
				<dd>Venter på bilde (funker ikke i Firefox og enkelte andre nettlesere)</dd>
				<dt>Tittel</dt>
				<dd><input type="text" name="title['.$key.']" class="w350" value="'.htmlspecialchars($item[0]).'" maxlength="150" /></dd>
				<dt>Beskrivelse</dt>
				<dd><textarea name="description['.$key.']" cols="30" rows="10" class="bbkode w400">'.htmlspecialchars($item[1]).'</textarea></dd>
			</dl>
		</div>';
		}

		echo '
	</div>
	<div class="hr"></div>
	<p>'.show_button("Legg til skjema", 'onclick="addUploadScheme()"').' '.show_sbutton("Last opp bildene").'</p>
</form>';

		// javascript for å legge til nytt skjema
		page::add_js('
function addUploadScheme()
{
	var list = getElementsByClassName(document, "div", "gi_add_item");
	var key = list.length;
	var item = list[0].cloneNode(true);
	var d = item.getElementsByTagName("dt")[0]; d.innerHTML="Bilde";
	var d = item.getElementsByTagName("dd")[0]; d.firstChild.value=""; d.firstChild.name="gi_"+key;
	var d = item.getElementsByTagName("dd")[1]; d.innerHTML="Venter på bilde (funker ikke i Firefox og enkelte andre nettlesere)";
	var d = item.getElementsByTagName("dd")[2]; d.firstChild.value=""; d.firstChild.name="title["+key+"]";
	var d = item.getElementsByTagName("dd")[3]; d.firstChild.value=""; d.firstChild.name="description["+key+"]";
	ge("gi_add_wrap").appendChild(item);

	// scroll
	document.documentElement.scrollTop = document.body.scrollTop = getTopPos(ge("gi_add_wrap").lastChild, true) - 15;
}
function previewImage(elm)
{
	var p = elm.parentNode.parentNode.getElementsByTagName("dd")[1];
	p.innerHTML = \'<img src="" width="200" style="border: 1px solid #000000; background: #000000" alt="Valgt bilde" />\';
	p.firstChild.src = elm.value;
	elm.parentNode.parentNode.getElementsByTagName("input")[1].focus();
}
function setDescRows(int)
{
	var list = ge("gi_add_wrap").getElementsByTagName("textarea");
	for (var i = 0; i < list.length; i++)
	{
		list[i].rows = int;
	}
}
');

		ess::$b->page->load();
	}
	
	protected function view()
	{
		$content = '';
		
		// vis oversikt over alle galleriene
		$content .= '
<h2>Gallerier</h2>';
		
		$content .= $this->view_galleries();
		$content .= $this->view_active();
		
		return $content;
	}
	
	protected function view_galleries()
	{
		$content = '
<h3>Eksisterende gallerier</h3>
<p class="h_right_big"><a href="galleries.php?gc_add" class="g_icon op75"><img src="../img/gallerier/a/gc_add.gif" alt="Nytt galleri" /></a></p>';
		
		if (count($this->galleries) == 0)
		{
			$content .= '
<p>Ingen gallerier er opprettet.</p>';
		}
		
		else
		{
			$content .= '
<table class="table tablemb" width="100%">
	<thead>
		<tr>
			<th>Galleri</th>
			<th>Antall bilder</th>
			<th>Verktøy</th>
		</tr>
	</thead>
	<tbody class="c">'.$this->galleries_show_table(0).'
	</tbody>
</table>';
		}
		
		return $content;
	}
	
	protected function view_active()
	{
		if (!$this->active) return;
		
		echo '
<h2 id="scroll_here" style="margin-top: 20px">'.htmlspecialchars($this->active->data['gc_title']).'</h2>
<henrist:info_placeholder />
<h3>Beskrivelse</h3>';
		
		if (!empty($this->active->data['gc_gi_id']))
		{
			page::add_css('.gc_gi { float: right; padding: 5px; background-color: #F8F8F8; border: 1px solid #DDDDDD; margin: -10px 0 10px 10px }');
			
			echo '
<p class="gc_gi"><img src="'.ess::$s['relative_path'].'/o.php?a=gi&amp;gi_id='.$this->active->data['gc_gi_id'].'&amp;gi_size=thumbnail" alt="Galleri bildet" /></p>';
		}
	
		// beskrivelse
		if (!empty($this->active->data['gc_description']))
		{
			echo '
<div class="gc_a_desc">'.$this->active->data['gc_description'].'</div>';
		}
		else
		{
			echo '
<p>Ingen beskrivelse er oppgitt.</p>';
		}
	
		// hent antall bilder som er skjult
		$result = ess::$b->db->query("SELECT COUNT(gi_id) FROM gallery_images WHERE gi_gc_id = {$this->active->id} AND gi_visible = 0");
		$skjult = mysql_result($result, 0);
	
		echo '
<h3 class="clear">Informasjon</h3>
<p style="float: right">'.($this->active->data['gc_visible'] == 0 ? '<a href="galleries.php?gc_id='.$this->active->id.'&amp;gc_visible=1" class="g_icon op75"><img src="../img/gallerier/a/gc_show.gif" alt="Vis galleri" /></a>' : '<a href="galleries.php?gc_id='.$this->active->id.'&amp;gc_visible=0" class="g_icon op75"><img src="../img/gallerier/a/gc_hide.gif" alt="Skjul galleri" /></a>').'</p>
<p><a href="'.ess::$s['relative_path'].'/galleri/'.$this->active->id.'">Vis det virkelige galleriet</a></p>
<p>
	Opprettet: '.ess::$b->date->get($this->active->data['gc_created'])->format().'<br />
	Galleriet blir vist på siden: '.($this->active->data['gc_visible'] == 0 ? '<b style="color: #FF0000">Nei</b>' : '<b>Ja</b>').'<br />
	Inneholder <b>'.format_num($this->active->data['gi_count']).'</b> bilde'.($this->active->data['gi_count'] == 1 ? '' : 'r').'. <b>'.format_num($skjult).'</b> bilde'.($skjult == 1 ? '' : 'r').' er skjult.
</p>
<p>
	<a href="galleries.php?gc_id='.$this->active->id.'&amp;gi_add" class="g_icon op75"><img src="../img/gallerier/a/gi_add.gif" alt="Last opp bilder" /></a>
	<a href="galleries.php?gc_id='.$this->active->id.'&amp;gc_edit" class="g_icon op75"><img src="../img/gallerier/a/gc_edit.gif" alt="Rediger galleri" /></a>
	<a href="galleries.php?gc_id='.$this->active->id.'&amp;gc_move" class="g_icon op75"><img src="../img/gallerier/a/gc_move.gif" alt="Flytt galleriet" /></a>
	<a href="galleries.php?gc_id='.$this->active->id.'&amp;gc_delete" class="g_icon op75"> <img src="../img/gallerier/a/gc_delete.gif" alt="Slett galleriet" /></a>
</p>

<h3>Bildeoversikt</h3>';
	
		if ($this->active->data['gi_count'] == 0)
		{
			echo '
<p class="c" style="color: #7F9DB9">
	Ingen bilder er lastet opp.<br />
	<br />
	<a href="galleries.php?gc_id='.$this->active->id.'&amp;gi_add" class="g_icon op75"><img src="../img/gallerier/a/gi_add.gif" alt="Last opp bilder" /></a>
</p>';
		}
	
		else
		{
			// sideoversikt
			$pageinfo = new pagei(pagei::ACTIVE_GET, "gi_page", pagei::PER_PAGE, 102, pagei::TOTAL, $this->active->data['gi_count']);
	
			echo '
<form action="" method="post">';
	
			// hent bildene på denne siden
			$result = $pageinfo->query("SELECT gi_id, gi_title, gi_description, gi_shot_person, gi_shot_date, gi_time, gi_visible FROM gallery_images WHERE gi_gc_id = {$this->active->id} ORDER BY gi_priority");
	
			// vis bildene på denne siden
			$table = new tbody(min($pageinfo->total, 3));
			$width = 100/$table->cols;
			
	
			page::add_css('.gi_list td { padding: 10px }');
	
			echo '
	<table class="table align_center" width="'.round(100/3*$table->cols).'%">
		<tbody class="c pointer gi_list">';
	
			$i = 0;
			$hiddens = false;
			while ($row = mysql_fetch_assoc($result))
			{
				$title = empty($row['gi_title']) ? '<i>Tittel mangler</i>' : htmlspecialchars($row['gi_title']);
				$attribs = 'id="gi_id_'.$row['gi_id'].'"';// . (++$i < $table->cols ? ' width="'.$width.'%"' : '');
				
				$class = array("box_handle");
				
				// skjult?
				if ($row['gi_visible'] == 0)
				{
					$class[] = "gi_hidden";
					$hiddens = true;
				}
				
				if ($class) $attribs .= ' class="'.implode(" ", $class).'"';
				
				$td = '<input type="checkbox" name="gi_id[]" value="'.$row['gi_id'].'" /> <img src="../o.php?a=gi&amp;gi_id='.$row['gi_id'].'&amp;gi_size=thumbnail" alt="Bilde" /><br />'.$title;
				
				$table->append($td, $attribs);
			}
	
			$table->clean(' class="nopointer"');
			$js = array();
			$js = implode(";", $js);
	
			echo '
		</tbody>
	</table>
	<p><a href="#" class="box_handle_toggle" rel="gi_id[]">Inverter markering</a></p>
	<p>
		Med valgte bilder:
		<select name="gi_action">
			<option value="gi_show">Vis bildene (dersom de er skjult)</option>
			<option value="gi_hide">Skjul bildene</option>
			<option value="gc_img">Sett som forside for galleriet</option>
			<option value="gi_move">Flytt bildene</option>
			<option value="gi_delete">Slett bildene</option>
			<option value="gi_edit">Rediger bildene</option>
		</select>
		'.show_sbutton("Utfør").'
	</p>'.($hiddens > 0 ? '
	<p>Bilder markert med rød bakgrunn er bilder som er skjult.</p>' : '').'
</form>';
			
			if ($pageinfo->pages > 1)
			{
				echo '
<p>Side: '.$pageiinfo->pagenumbers().'</p>';
			}
		}
	}
	
	protected function galleries_show_table($parent_gc, $indent = "\n\t\t")
	{
		global $_g;
		
		// generer data
		$tree = new tree($this->galleries_sub);
		$tree->prefix = $this->prefix;
		$data = $tree->generate($parent_gc);
		
		// hent data
		#$data = galleries_load_tree("\n\t\t", $parent_gc);
		
		$html = '';
		$i = 0;
		foreach ($data as $key => $row)
		{
			$gc = $this->galleries[$key];
			
			$i++;
			$class = $this->active && $this->active->id == $gc['gc_id'] ? ' class="highlight"' : ($i % 2 == 0 ? ' class="color"' : '');
			
			$html .= $indent . '<tr'.$class.'>' .
					'<td class="l"><span class="plain">'.$row['prefix'].$row['prefix_node'].'</span><a href="galleries.php?gc_id='.$gc['gc_id'].'">'.htmlspecialchars($gc['gc_title']).'</a>'.($gc['gc_visible'] == 0 ? ' <span style="color:#FF0000">(skjult)</span>' : '').'</td>' .
					'<td class="r">'.format_num($gc['gi_count']).'</td>' .
					'<td><a href="galleries.php?gc_id='.$gc['gc_id'].'&amp;gi_add">last opp bilder</a> nytt galleri: <a href="galleries.php?gc_add&amp;parent_gc='.$gc['gc_id'].'" title="Opprett nytt galleri innunder dette galleriet">inni</a> <a href="galleries.php?gc_add&amp;parent_gc='.$gc['gc_parent_gc_id'].'&amp;previous_gc='.$gc['gc_id'].'" title="Opprett nytt galleri under dette galleriet">under</a></td>' .
				'</tr>';
		}
		
		return $html;
	}
}

$g = new a_galleries();
$g->handle();