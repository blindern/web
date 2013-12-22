<?php

bs_side::set_title("Småbruket studenthytte");
#bs_side::$lang_crosslink['en'] = "en/smaabruket";

ess::$b->page->add_keyword("Småbruket", "Brunkollen", "studenthytte", "Blindern Studenterhjem", "bærumsmarka", "utleiehytte");
ess::$b->page->description = "Småbruket er Blindern Studenterhjem sin hytte i Bærumsmarka. Hytta brukes av beboere på studenterhjemmet, og leies ut til studenter, bedrifter og ivrige turmennesker.";

jquery();

bs_side::$head .= '
<style>
.hytte_box {
	max-width: 400px;
	border: 1px dotted #888;
	padding: 0 10px;
	margin: 10px 0;
}
</style>';

require ROOT."/base/smaabruket.php";

echo '
						<div class="hytta">
							<p style="float: right">Trykk for større bilder og bildegalleri.</p>
							'.get_right_img_gal(87, null, "Skilt som peker i retningen mot Småbruket ved Brunkollen.", "Foto: Henrik Steen").'
							'.get_right_img_gal(104, null, "Småbruket tar seg vakkert ut i Bærumsmarka.", "Foto: Henrik Steen").'
							'.get_right_img_gal(92, null, "Hovedsoverommet med 8 soveplasser. I tillegg er det 16 senger i annekset og 10 madrasser på hemsen.", "Foto: Henrik Steen").'
							'.get_right_img_gal(94, null, "Hytta har en stor stue.", "Foto: Henrik Steen").'
							'.get_right_img_gal(106, null, "Lite slår den gode stemningen med en kveld rundt peisen.", "Foto: Henrik Steen").'
							'.get_right_img_gal(99, null, "Stua rommer en hel folkemasse. Her fra tur med hele 49 personer, hvor også alle overnattet.", "Foto: Henrik Steen").'
							'.get_right_img_gal(91, null, "Hytta er godt utstyrt med mye servise.", "Foto: Henrik Steen").'
							'.get_right_img_gal(105, null, "Flott utsikt utover Oslofjorden.", "Foto: Henrik Steen").'
							'.get_right_img_gal(102, null, "Ute er det en flott bålplass med benker rundt.", "Foto: Henrik Steen").'
							'.get_right_img_gal(97, null, "Flott vedfyrt badstue.", "Foto: Henrik Steen").'
							'.get_right_img_gal(108, null, "Pygmétur høsten 2010.", "Foto: Henrik Steen").'
							';

/*
							
							'.get_right_img("hytta_fra_bekken.jpg", null, "", "Foto: Henrik Steen").' <!-- Foto: Henrik Steen, V2010 -->
							'.get_right_img("hytta_utenfor_dugnad_v2010.jpg", null, "", "Hyttedugnad våren 2010. Foto: Henrik Steen").' <!-- Foto: Henrik Steen, V2010 -->
							'.get_right_img("hytta_ved_peisen1.jpg", null, "", "Foto: Henrik Steen").' <!-- Foto: Henrik Steen, V2010 -->
							'.get_right_img("hytta_baal.jpg", null, "", "Foto: Henrik Steen").' <!-- Foto: Henrik Steen, V2010 -->
							'.get_right_img("hytta_bordet.jpg", null, "", "Pygmétur høsten 2010. Foto: Henrik Steen").' <!-- Foto: Henrik Steen, H2010 -->*/

echo '
							<h1>Småbruket studenthytte</h1>
							
						<div class="subsection">
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
								fra byens mas og jag. En meget stor stue gjør muligheter for mange
								ulike aktiviteter.
							</p>
						</div>
							
						<div class="subsection">
							<h2>Hva kan Sm&aring;bruket tilby?</h2>
							<ul>
								<li>24 sengeplasser og hems med madrasser (senger/madrasser til 34 personer)</li>
								<li>Stor stue med peis og ovn</li>
								<li>Brettspill, kort, gitar og stereoanlegg</li>
								<li>Flott kj&oslash;kken (oppf&oslash;rt i 2007) med stort kj&oslash;leskap, komfyr, mye servise, og det du ellers skulle trenge for &aring; lage et gourmetm&aring;ltid</li>
								<li>Vedfyrt badstue og 2 dusjer</li>
								<li>Utendørs vannkran åpen året rundt</li>
								<li>Utedo</li>
								<li>Flott utsikt over Oslofjorden</li>
							</ul>
						</div>
						
						<!--<div class="subsection">
							<h2>Bildegalleri</h2>
							<p>Kommer!</p>
						</div>-->
						
						<div class="subsection">
							<h2>Ankomstmuligheter</h2>
							<p>Sommerløype: Se eget <a href="http://maps.google.com/maps/ms?ie=UTF&msa=0&msid=205357112404663307536.000492263fbcdabf214fa">kart med anbefalte løyper</a>.</p>
							<p>Vintertraseer: Se <a href="http://maps.google.no/?q=http://www.skiforeningen.no/markadb/kml/loypestatus/1.kml">kart fra markadatabasen</a>. Hytta ligger like ved Brunkollen. Den store grusveien på kartet ovenfor er også måkt og kan brukes som gangvei.</p>
							<p>Det er ikke anledning å kjøre bil frem til hytta/Brunkollen. Løvenskiold Skog innvilger ikke kjøretillatelser på veiene til leietakere.</p>
							
							<iframe width="540" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.no/maps/ms?ie=UTF8&amp;hl=no&amp;msa=0&amp;msid=205357112404663307536.000492263fbcdabf214fa&amp;ll=59.963462,10.588868&amp;spn=0.1,0.1&amp;output=embed"></iframe>
							<br /><small>Vis <a href="http://maps.google.no/maps/ms?ie=UTF8&amp;hl=no&amp;msa=0&amp;msid=205357112404663307536.000492263fbcdabf214fa&amp;ll=59.963462,10.588868&amp;spn=0.1,0.1&amp;source=embed" style="color:#0000FF;text-align:left">Småbruket</a> i et større kart</small>
						</div>
						
						<div class="subsection">
							<h2>Leie Småbruket</h2>
							
							<p>Dersom du er interessert i &aring; leie Sm&aring;bruket kontakt oss på <a href="mailto:hyttestyret@gmail.com">hyttestyret@gmail.com</a>. Nedenfor kan du også se hvilke datoer hytta er ledig.</p>
							
							<p><b>Tidsgrenser:</b> Man kan oppholde seg på Småbruket frem til senest kl 14. Småbruket er tilgjengelig for leie fra kl 15. Det kan avtales andre tidspunkter ved spesielle behov.</p>
							
							<h3>Reservasjonsdepositum</h3>
							<p>Et reservasjonsdepositum tilsvarende minstepris m&aring; betales
							senest en uke etter reservering av hytta. Du har da
							gjort endelig reservering. Dette må være innbetalt før nøkkel kan hentes. Ved
							reservasjoner rett før utleiedato kan depositumet evt. betales kontant ved henting av nøkkel.</p>
							<div class="showoff">
								<p><a href="#" class="activate">Vis flere bestemmelser om depositumet</a></p>
							</div>
							<div class="showon">
								<ul>
									<li>Betales ikke depositum innen 7 dager vil reservasjonen bli strøket for å gi andre muligheten til å betale leie til de aktuelle datoene.
								Vi gir beskjed hvis vi stryker en reservasjon.</li>
									<li>Depositumet innbetales til kontonr. 6094.05.44834 etter at reservasjon er bekreftet av oss. Merkes navn og utleiedato.</li>
									<li>Hvis utleien avlyses når det er under 14 dager før utleie vil ikke depositumet bli refundert.</li>
									<li>Depositumet refunderes etter innbetalt leie. Normalt trekker vi depositumet fra totalbeløpet.</li>
								</ul>
							</div>
							
							<h3>Henting av nøkkel og kontrakt</h3>
							<p>Senest en uke f&oslash;r avreise tar du kontakt med utleieansvarlig for &aring;
								avtale overlevering av n&oslash;kkel, samt skrive under en leiekontrakt.</p>
							<p>Etter turen tar du kontakt med utleieansvarlig for &aring; levere tilbake n&oslash;kkel.
								Du m&aring; ogs&aring; opplyse hvor mange personer som brukte hytta samt hvor mange vedsekker som er brukt.</p>
							<p><a href="https://docs.google.com/file/d/0B8mINoGULmbPWVJvX1hkXy1uT3M/edit?usp=sharing">Last ned leiekontrakt</a></p>
						</div>
						
						<div class="subsection">
							<h2>Priser for leie av Småbruket</h2>
							<p style="color: #FF0000">Vedprisen endres fra 1. januar 2014. Informasjon kommer. Pris nedenfor gjelder 2013.</p>
							<ul>
								<li>Minstepris:
									<ul>
										<li>Per døgn til en hverdag: kr 300</li>
										<li>Per døgn til en helgdag: kr 500</li>
										<li>Vedforbruk regnes utenom minsteprisen</li>
									</ul>
								</li>
								<li>Per person SiO-medlem: kr 100 per natt</li>
								<li>Per person andre: kr 130 per natt</li>
								<li>Per vedsekk (80-liter-sekk): kr 120</li>
							</ul>
							<p>For beboere ved Blindern Studenterhjem gjelder egne priser. Gamle beboere ved studenterhjemmet får pris tilsvarende SiO-medlemmer.</p>
							<div class="showoff">
								<p><a href="#" class="activate">Vis priseksempler</a></p>
							</div>
							<div class="showon">
								<hr />
								<p><b>Eksempler på reservasjonsdepositum (minstepris):</b></p>
								<ul>
									<li>Overnatting mandag-onsdag: kr 300 + kr 300 = <u>kr 600</u></li>
									<li>Overnatting fredag-søndag: kr 500 + kr 500 = <u>kr 1000</u></li>
									<li>Overnatting fredag-lørdag: kr 500 = <u>kr 500</u></li>
								</ul>
								<p><b>Priseksempel: 1 døgn i helg, 10 SiO-medlemmer, 2 vedsekker</b></p>
								<ul>
									<li>10 SiO-medlemmer 1 døgn: kr 100 * 10 = <u>kr 1 000</u></li>
									<li>Totalt gjester: <u>kr 1 000</u></li>
									<li>Minstepris: kr 500 (totalbeløpet er over minsteprisen)</li>
									<li>2 vedsekker: kr 120 * 2 = <u>kr 240</u></li>
									<li>Å betale: kr 1 000 + kr 240 = <b><u>kr 1 240</u></b></li>
								</ul>
								<p><b>Priseksempel: 2 døgn i helg, 4 SiO-medlemmer, 10 øvrige (5 kun ett døgn), 5 vedsekker</b></p>
								<ul>
									<li>4 SiO-medlemmer 2 døgn: kr 100 * 4 * 2 = <u>kr 800</u></li>
									<li>10 øvrige 1 døgn: kr 130 * 10 * 1 = <u>kr 1 300</u></li>
									<li>5 øvrige 1 døgn: kr 130 * 5 * 1 = <u>kr 650</u></li>
									<li>Totalt gjester: kr 800 + kr 1 300 + kr 650 = <u>kr 2 750</u></li>
									<li>Minstepris: kr 500 * 2 = kr 1 000 (totalbeløpet er over minsteprisen)</li>
									<li>5 vedsekker: kr 120 * 5 = <u>kr 600</u></li>
									<li>Å betale: kr 2 750 + kr 600 = <b><u>kr 3 350</u></b></li>
								</ul>
								<p><b>Priseksempel: 1 døgn i hverdag og 1 døgn i helg, 3 SiO-medlemmer, 2 vedsekker</b></p>
								<ul>
									<li>3 SiO-medlemmer 2 døgn: kr 100 * 3 * 2 = <u>kr 600</u></li>
									<li>Minstepris: kr 300 + kr 500 = <u>kr 800</u></li>
									<li>Totalt gjester: <u>kr 800</u> (minstepris blir gjeldende)</li>
									<li>2 vedsekker: kr 120 * 2 = <u>kr 240</u></li>
									<li>Å betale: kr 800 + kr 240 = <b><u>kr 1 040</u></b></li>
								</ul>
							</div>
						</div>
							
						<div class="subsection">
							<h2>Ledige datoer for utleie</h2>
							<p>Her er en oversikt som viser hvilke dager hytta er reservert/utleid.</p>
							<ul>
								<li><b>Reservert:</b> Vi har ikke mottatt depositum fra leietaker.</li>
								<li><b>Reservert av hyttestyret:</b> Hyttestyret holder av flere helger før fastsettelse av dato for egne arrangementer. Sannsynligvis blir kun ett alternativ beholdt.</li>
								<li><b>Reservert for beboere:</b> Datoene holdes av for beboere ved Blindern Studenterhjem. Beboere tar kontakt med hyttestyret for å reservere utleie. Datoene blir <i>ikke</i> frigjort for andre interessenter.</li>
								<li><b>Opptatt:</b> Depositum er mottatt. Leien <i>kan</i> fremdeles bli avlyst.</li>
							</ul>';

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
							<table class="hyttestyret_table hyttestyret_kalender">
								<thead>
									<tr>
										<th>Uke</th>
										<th>Mandag <span>til tirsdag</span></th>
										<th>Tirsdag <span>til onsdag</span></th>
										<th>Onsdag <span>til torsdag</span></th>
										<th>Torsdag <span>til fredag</span></th>
										<th>Fredag <span>til lørdag</span></th>
										<th>Lørdag <span>til søndag</span></th>
										<th>Søndag <span>til mandag</span></th>
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
		elseif ($status == "Reservert2") $class = "reservert2";
		elseif ($status == "Reservert3") $class = "reservert3";
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
								<p class="hyttestyret_legend reservert2"><span></span>Reservert av hyttestyret</p>
								<p class="hyttestyret_legend reservert3"><span></span>Reservert for beboere</p>
								<p class="hyttestyret_legend opptatt"><span></span>Opptatt</p>
							</div>
							<!--<p><b>Utleiedatoer for 2012 er ikke tilgjengelig enda.</b> Dette grunnet planlegging av egne turer og fortrinnsrett for beboere ved Blindern Studenterhjem. Ta evt. kontakt for muligheter rundt reservasjon.</p>-->
						</div>
						</div>';
}
