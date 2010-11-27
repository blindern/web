<?php

bs_side::set_title("Historisk kalender - Småbruket");
#bs_side::$lang_crosslink['en'] = "en/smaabruket";

require BASE."/smaabruket.php";

$kal = new smaabruket_kalender();
$kal->weeks_show_before = 52;
$calendar_data = $kal->get_calendar_status();
if (!$calendar_data)
{
	echo '
							<p><b>Kalenderen er for øyeblikket ikke tilgjengelig.</b> Ta kontakt for informasjon om ledige datoer.</p>';
}

else
{
	echo '
							<table class="hyttestyret_kalender">
								<thead>
									<tr>
										<th>Uke</th>
										<th>Mandag</th>
										<th>Tirsdag</th>
										<th>Onsdag</th>
										<th>Torsdag</th>
										<th>Fredag</th>
										<th>Lørdag</th>
										<th>Søndag</th>
									</tr>
								</thead>
								<tbody>';
	
	$i = 0;
	
	$months = array(
		1 => "januar",
		"februar",
		"mars",
		"april",
		"mai",
		"juni",
		"juli",
		"august",
		"september",
		"oktober",
		"november",
		"desember");
	
	$first = true;
	$today = date("Y-m-d");
	foreach ($calendar_data as $date => $status)
	{
		if ($i == 7)
		{
			$i = 0;
			echo '
									</tr>';
		}
		
		$d = new DateTime($date);
		$d->setTimeZone(new DateTimeZone("Europe/Oslo"));
		
		if ($i == 0)
		{
			$uke = $d->format("W");
			
			echo '
									<tr>
										<td class="uke">'.$uke.' <span style="color: #888">/'.$d->format("Y").'</span></td>';
		}
		
		if (!$status) $class = 'ledig';
		elseif ($status == "Reservert") $class = "reservert";
		else $class = "opptatt";
		
		$is_today = $date == $today;
		if ($is_today) $class .= " idag";
		
		$dayofm = $d->format("j");
		echo '
										<td class="'.$class.'">'.$dayofm.($dayofm == 1 || $first ? '. <span class="month">'.$months[$d->format("n")].'</span>' : '').'</td>';
		
		$i++;
		$first = false;
	}
	
	if ($i > 0) echo '
									</tr>';
	
	echo '
								</tbody>
							</table>';
}