<?php

bs_side::set_title("Hyttestyret - Foreningen Småbruket");

class smaabruket_kalender
{
	const WEEKS_SHOW = 20;
	
	public static $xml_files = array(
		// utleid
		"http://www.google.com/calendar/feeds/hyttestyret%40gmail.com/private-ab4f8e009eaf37cfa69cc113a4f98cf0/full",
		
		// reservert
		"http://www.google.com/calendar/feeds/8iosbn0p0pn8fegofi5o2n88v0%40group.calendar.google.com/private-619428ecdc4fb56774f2727bec3f1b2d/full",
		
		// blindern studenterhjem
		"http://www.google.com/calendar/feeds/km7ghn4c18busf05t4e22q0bgk%40group.calendar.google.com/private-24ccc8d119f49e7feec147f859531957/full"
	);
	
	public static function get_xml()
	{
		$data = cache::fetch("smaabruket_xml_data");
		if ($data && is_array($data)) return $data;
		
		$end = time() + 86400 * 7 * self::WEEKS_SHOW;
		$start = time() - 86400 * 7;
		
		$start_text = date("Y-m-d\\TH:i:s", $start);
		$end_text = date("Y-m-d\\TH:i:s", $end);
		
		$data = array();
		foreach (self::$xml_files as $file)
		{
			$data[] = file_get_contents($file."?singleevents=true&start-min=$start_text&start-max=$end_text&max-results=50");
		}
		
		cache::store("smaabruket_xml_data", $data, 600);
		return $data;
	}
	
	public static function get_data()
	{
		$datas = self::get_xml();
		if (!$datas) return null;
		
		$start = array();
		$items = array();
		$confirmed = 'http://schemas.google.com/g/2005#event.confirmed';
		foreach ($datas as $data)
		{
			$xml = simplexml_load_string($data);
			foreach ($xml->entry as $item)
			{
				$gd = $item->children('http://schemas.google.com/g/2005');
				if ($gd->eventStatus->attributes()->value != $confirmed) continue;
				
				// $item->title
				$startTime = 0;
				$endTime = 0;
				if ($gd->when)
				{
					$startTime = strtotime($gd->when->attributes()->startTime);
					$endTime = strtotime($gd->when->attributes()->endTime);
				}
				elseif ($gd->recurrence)
				{
					$startTime = strtotime($gd->recurrence->when->attributes()->startTime);
					$endTime = strtotime($gd->recurrence->when->attributes()->endTime);
				}
				
				$start[] = $startTime;
				$items[] = array(
					"title" => (string) $item->title,
					"start" => $startTime,
					"start_text" => date("r", $startTime),
					"end" => $endTime,
					"end_text" => date("r", $endTime),
					"value" => (string) $gd->where->attributes()->valueString,
					"calendar" => (string) $xml->title
				);
			}
		}
		
		array_multisort($start, SORT_ASC, $items);
		return $items;
	}
	
	public static function get_calendar_status()
	{
		$items = self::get_data();
		if (!$items) return null;
		
		$date_start = new DateTime();
		$date_start->setTimeZone(new DateTimeZone("Europe/Oslo"));
		$date_start->setTime(0, 0, 0);
		while ($date_start->format("N") != 1)
		{
			$date_start->modify("-1 day");
		}
		
		$days = array();
		$show_days = 7 * self::WEEKS_SHOW;
		for ($i = 0; $i < $show_days; $i++)
		{
			$days[$date_start->format("Y-m-d")] = false;
			$date_start->modify("+1 day");
		}
		
		foreach ($items as $item)
		{
			$start = new DateTime("@".$item['start']);
			$start->setTimeZone(new DateTimeZone("Europe/Oslo"));
			$start->setTime(0, 0, 0);
			#if ($start->format("H:i:s") !== "00:00:00") continue;
			
			$end = new DateTime("@".$item['end']);
			$end->setTimeZone(new DateTimeZone("Europe/Oslo"));
			
			// marker datoene med kalendernavnet
			do
			{
				$day = $start->format("Y-m-d");
				if (isset($days[$day]))
				{
					$days[$day] = $item['calendar'];
				}
				$start->modify("+1 day");
			} while ($start->format("U") < $end->format("U"));
		}
		
		return $days;
	}
}

?>
							<h1>Hyttestyret</h1>
							
							<img src="<?php echo bs_side::$pagedata->doc_path; ?>/graphics/images/hytte_dugnad.jpg" width="200" height="133" border="1" align="right" />
							<h2>Kort om Sm&aring;bruket</h2>
							<p>
								Sm&aring;bruket er en t&oslash;mmerhytte som ligger
								vakkert til midt i B&aelig;rumsmarka. Den er omkranset
								av gode tur- og skimuligheter som kan gi flotte naturopplevelser.</p>
								<p>For dem som trives best inne, varmer peisen i den
								store stua, mens badstuen gj&oslash;r seg klar i kjelleren.
								Det er et godt utstyrt kj&oslash;kken som gir matlagingsmuligheter.</p>
								<p>Sm&aring;bruket passer til kollokvieturer, rekreasjon,
								klasseturer og til alle som &oslash;nsker et avbrekk
								fra byens mas og jag.
							</p>
							
							<h2>Hva kan Sm&aring;bruket tilby?</h2>
							<ul>
								<li>24 sengeplasser og hems med madrasser (plass til 34 personer)</li>
								<li>Stor stue med peis</li>
								<li>Brettspill, kort, gitar og stereoanlegg</li>
								<li>Flott kj&oslash;kken (oppf&oslash;rt i 2007) med stort kj&oslash;leskap, komfyr, nytt servise, og det du ellers skulle trenge for &aring; lage et gourmetm&aring;ltid</li>
								<li>Vedfyrt badstue</li>
							</ul>
							
							<h2>Leie Småbruket</h2>
							<p>Dersom du er interessert i &aring; leie Sm&aring;bruket s&aring; kontakt utleieansvarlig på <a href="mailto:hyttestyret@gmail.com">hyttestyret@gmail.com</a>. Nedenfor kan du også se hvilke datoer hytta er ledig.</p>
							<p>
								S&aring; snart du har tatt kontakt med oss s&aring;
								vil du motta en epost fra oss med veibeskrivelse
								og videre informasjon.
							</p>
							<p>
								Et reserveringsdepositum p&aring; kr 600,- m&aring; betales
								senest en uke etter reservering av hytta. Du har da
								gjort endelig reservering. Husk &aring; merke giroen
								med navn og dato for leien. Minst en uke f&oslash;r
								avreise tar du kontakt med utleieansvarlig for &aring;
								avtale overlevering av n&oslash;kkel, samt skrive
								under en leiekontrakt.
							</p>
							<p>
								Etter turen tar du kontakt med utleieansvarlig for
								&aring; levere tilbake n&oslash;kkel og lignende.
								Du m&aring; ogs&aring; opplyse hvor mange personer
								som brukte hytta samt hvor mange vedsekker som er
								brukt.
							</p>

							<h2>Priser for leie av Småbruket</h2>
							<p>Per døgn per person:</p>
							<ul>
								<li>BS-beboer: kr 30,-</li>
								<li>SiO-medlem: kr 70,-</li>
								<li>Andre: kr 90,-</li>
							</ul>
							<p>Minstepris er kr 300,- for BS-beboere og kr 600,- for SiO-medlemmer og andre per helg.</p>
							
							<h2>Ledige datoer for utleie</h2>
							<p>Her er en oversikt som viser hvilke dager hytte er reservert/utleid.</p>
<?php

$calendar_data = smaabruket_kalender::get_calendar_status();
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
										<td class="uke">'.$uke.'</td>';
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
							</table>
							<p class="hyttestyret_legend ledig"><span></span>Ledig</p>
							<p class="hyttestyret_legend reservert"><span></span>Reservert</p>
							<p class="hyttestyret_legend opptatt"><span></span>Opptatt</p>';
}

?>