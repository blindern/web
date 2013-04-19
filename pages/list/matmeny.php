<?php

bs_side::set_title("Redigering av matmeny");

// sett opp uker
$weeks = array();
$d = ess::$b->date->get();
$d->modify("+7 days");
$default_week = $d->format("Y-W");
$d->modify("-21 days");
$d->modify("-".($d->format("N")-1)." days");
for ($i = 0; $i < 5; $i++) {
	$weeks[$d->format("Y-W")] = $d->format("\\U\\k\\e W Y (\\f\\r\\a d.m)").(bs_matmeny::has_week($d->format("Y"), $d->format("W")) ? ' (har innhold)' : '');
	$d->modify("+7 days");
}


$week_selected = isset($_POST['week']) && isset($weeks[$_POST['week']]) ? $_POST['week'] : false;


echo '
<h1>Redigering av matmeny</h1>

<form action="" method="post" enctype="multipart/form-data">';


// har vi valgt uke?
if ($week_selected) {
	$matmeny = bs_matmeny::get_week($week_selected);

	if ($week_selected && isset($_POST['content'])) {
		$days = array();
		foreach ($_POST['content'] as $day => $lines) {
			$day = (int) $day;
			if ($day < 1 || $day > 7) continue;

			$new = array();
			foreach ($lines as $line_id => $line) {
				if (empty($line)) continue;
				$new[] = array(
					"info" => isset($_POST['info'][$day][$line_id]),
					"content" => trim($line)
				);
			}

			$days[$day] = $new;
		}

		$matmeny->replace_data($days);
		if ($matmeny->save()) {
			ess::$b->page->add_message("Matmenyen for uke $matmeny->week ($matmeny->year) ble oppdatert!");
			redirect::handle("matmeny");
		}
	}

	echo '
	<input type="hidden" name="week" value="'.$week_selected.'" />
	<p>'.$weeks[$week_selected].' <a href="matmeny">Avbryt</a></p>';

	// lastet opp fil?
	$edited = false;
	if (isset($_FILES['fil']) && !empty($_FILES['fil']['tmp_name'])) {
		$result = $matmeny->load_file($_FILES['fil']['tmp_name']);
		if (!$result) {
			echo '
	<p>Behandling av opplastet fil feilet: '.htmlspecialchars($result).'</p>';
		}
		else $edited = true;
	}

	if ($edited) {
		echo '
	<p><b>OBS! Du må fullføre siden for at menyen blir lagret.</b></p>';
	}

	// vis tabell for å redigere
	echo '
	<table class="table">
		<thead>
			<tr>
				<th>Dag</th>
				<th>Info?</th>
				<th>Linjetekst</th>
			</tr>
		</thead>
		<tbody>';

	$data = $matmeny->get_data();
	global $_lang;
	foreach ($data as $day_id => $lines) {
		// blanke linjer vi kan bruke
		$max = max(3, count($lines)+2);
		for ($i = count($lines); $i < $max; $i++)
			$lines[] = array("info" => false, "content" => "");
		
		$day_name = $_lang['weekdays'][$day_id == 7 ? 0 : $day_id];

		echo '
			<tr>
				<th rowspan="'.count($lines).'">'.htmlspecialchars($day_name).'</th>';

		$first = true;
		foreach ($lines as $line_id => $line) {
			if ($line_id > 0) echo '
			</tr>
			<tr>';

			echo '
				<td><input type="checkbox" name="info['.$day_id.']['.$line_id.']"'.($line['info'] ? ' checked="checked"' : '').' /></td>
				<td><input type="text" style="width: 280px" name="content['.$day_id.']['.$line_id.']" value="'.htmlspecialchars($line['content']).'" /></td>';
		}

		echo '
			</tr>';
	}

	echo '
		</tbody>
	</table>
	<p><i>Rader som markeres som &laquo;Info?&raquo; får rød tekst. Anses som informasjon, og ikke matbeskrivelse.</i></p>
	<p><input type="submit" value="Lagre" /></p>';
}


else {
	// valg av uke
	echo '
	<p>Velg uke:
		<select name="week">';

	foreach ($weeks as $id => $week) {
		echo '
			<option value="'.$id.'"'.($id == $default_week ? ' selected="selected"' : '').'>'.$week.'</option>';
	}

	echo '
		</select></p>';


	// valg av fil
	echo '
	<p><label for="fil">Velg dokument: </label><input type="file" name="fil" id="fil" />
	<br /><i>Fil kan utelates for manuell inntasting/redigering av meny.</i></p>';


	echo '
	<p><input type="submit" value="Gå videre" /></p>
	<p><i>OBS! Malen for matmeny må benyttes og må være lagret i .doc-format. Andre typer dokumenter støttes ikke.</i></p>';
}


echo '
</form>';


/*




<form action="upload_file.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file"><br>
<input type="submit" name="submit" value="Submit">
</form>';*/