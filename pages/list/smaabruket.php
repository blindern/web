<?php

bs_side::set_title("Hyttestyret for Småbruket");
#bs_side::$lang_crosslink['en'] = "en/smaabruket";

bs_side::$keywords = "Småbruket, Brunkollen, studenthytte, Blindern Studenterhjem, bærumsmarka, utleiehytte";
bs_side::$description = "Småbruket er Blindern Studenterhjem sin hytte i Bærumsmarka. Hytta brukes av beboere på studenterhjemmet, og leies ut til studenter, bedrifter og ivrige turmennesker.";

require BASE."/smaabruket.php";

echo '
							<div style="float: right">
								<iframe width="220" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.no/maps/ms?ie=UTF8&amp;hl=no&amp;msa=0&amp;msid=205357112404663307536.000492263fbcdabf214fa&amp;ll=59.963462,10.588868&amp;spn=0.1,0.1&amp;output=embed"></iframe><br /><small>Vis <a href="http://maps.google.no/maps/ms?ie=UTF8&amp;hl=no&amp;msa=0&amp;msid=205357112404663307536.000492263fbcdabf214fa&amp;ll=59.963462,10.588868&amp;spn=0.1,0.1&amp;source=embed" style="color:#0000FF;text-align:left">Småbruket</a> i et større kart</small>
							</div>
							'.get_right_img("hytta_fra_bekken.jpg", null, "", "Foto: Henrik Steen").' <!-- Foto: Henrik Steen, V2010 -->
							'.get_right_img("hytta_utenfor_dugnad_v2010.jpg", null, "", "Hyttedugnad våren 2010. Foto: Henrik Steen").' <!-- Foto: Henrik Steen, V2010 -->
							'.get_right_img("hytta_ved_peisen1.jpg", null, "", "Foto: Henrik Steen").' <!-- Foto: Henrik Steen, V2010 -->
							'.get_right_img("hytta_baal.jpg", null, "", "Foto: Henrik Steen").' <!-- Foto: Henrik Steen, V2010 -->
							'.get_right_img("hytta_bordet.jpg", null, "", "Pygmétur høsten 2010. Foto: Henrik Steen").' <!-- Foto: Henrik Steen, H2010 -->
							<h1>Hyttestyret for Småbruket</h1>
							
							<h2>Kort om Sm&aring;bruket</h2>
							<p>
								Sm&aring;bruket er en t&oslash;mmerhytte som ligger
								vakkert til midt i B&aelig;rumsmarka. Den er omkranset
								av gode tur- og skimuligheter som kan gi flotte naturopplevelser.</p>
								<p>For dem som trives best inne, varmer peisen i den
								store stua, mens badstuen gj&oslash;r seg klar i kjelleren.
								Det er et godt utstyrt kj&oslash;kken som gir gode matlagingsmuligheter.</p>
								<p>Sm&aring;bruket passer til kollokvieturer, rekreasjon,
								klasseturer og til alle som &oslash;nsker et avbrekk
								fra byens mas og jag.
							</p>
							
							<h2>Hva kan Sm&aring;bruket tilby?</h2>
							<ul>
								<li>24 sengeplasser og hems med madrasser (plass til 34 personer)</li>
								<li>Stor stue med peis og ovn</li>
								<li>Brettspill, kort, gitar og stereoanlegg</li>
								<li>Flott kj&oslash;kken (oppf&oslash;rt i 2007) med stort kj&oslash;leskap, komfyr, mye servise, og det du ellers skulle trenge for &aring; lage et gourmetm&aring;ltid</li>
								<li>Vedfyrt badstue</li>
								<li>Utendørs vannkran åpen året rundt</li>
								<li>2 dusjer</li>
								<li>Utedo</li>
								<li>Flott utsikt over Oslofjorden</li>
							</ul>
							
							<h2>Leie Småbruket</h2>
							
							<p>Dersom du er interessert i &aring; leie Sm&aring;bruket s&aring; kontakt utleieansvarlig på <a href="mailto:hyttestyret@gmail.com">hyttestyret@gmail.com</a>. Nedenfor kan du også se hvilke datoer hytta er ledig.</p>
							<p>
								Et reserveringsdepositum p&aring; kr 600,- m&aring; betales
								senest en uke etter reservering av hytta. Du har da
								gjort endelig reservering. Senest en uke f&oslash;r
								avreise tar du kontakt med utleieansvarlig for &aring;
								avtale overlevering av n&oslash;kkel, samt skrive
								under en leiekontrakt.
							</p>
							<p>
								Etter turen tar du kontakt med utleieansvarlig for
								&aring; levere tilbake n&oslash;kkel.
								Du m&aring; ogs&aring; opplyse hvor mange personer
								som brukte hytta samt hvor mange vedsekker som er
								brukt.
							</p>
							<p>Flere praktiske opplysninger rundt leien kan leses i <a href="/dokumenter/Infoskriv_hyttestyret.pdf">infoskrivet</a> vårt.</p>
							
							<h2>Priser for leie av Småbruket</h2>
							<p>Per døgn per person:</p>
							<ul>
								<li>BS-beboer: kr 30,-</li>
								<li>SiO-medlem: kr 70,-</li>
								<li>Andre: kr 90,-</li>
							</ul>
							<p>Minstepris er kr 300,- for BS-beboere og kr 600,- for SiO-medlemmer og andre per helg. I tillegg tilkommer forbruk av ved med kr 120,- per vedsekk.</p>
							
							<h2>Ledige datoer for utleie</h2>
							<p>Her er en oversikt som viser hvilke dager hytta er reservert/utleid.</p>';

$kal = new smaabruket_kalender();
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
							<div id="hyttestyret_legends">
								<p class="hyttestyret_legend ledig"><span></span>Ledig</p>
								<p class="hyttestyret_legend reservert"><span></span>Reservert</p>
								<p class="hyttestyret_legend opptatt"><span></span>Opptatt</p>
							</div>';
}