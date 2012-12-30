<?php

bs_side::set_title("Beboere");
bs_side::$head .= '
<meta name="robots" content="noindex, nofollow" />';

// gi status som beboer siden vi ser på denne siden
bs::beboer_cookie_set();

bs_side::$head .= '
<style type="text/css">
#content h2 {
	font-size: 18px;
	margin-top: 60px;
	margin-bottom: 10px;
}
.info_beboer {
	margin: 0 0 25px;
	padding: 10px;
	background-color: #FCF0AD;
	border: 1px solid #000;
	max-width: 600px;
}
.info_kontakter {
	color: #FF0000;
}

</style>';

echo '
<p class="info_beboer">Dette er en intern side for beboere ved Blindern Studenterhjem. Ikke videreformidle denne siden til eksterne.</p>
<h1>Beboer ved Blindern Studenterhjem</h1>


<ul>
	<li><a href="#nyttig">Nyttige dokumenter/ressurser</a></li>
	<li><a href="#dugnaden">Dugnaden</a></li>
	<li><a href="#matmeny">Matmeny</a></li>
	<li><a href="#internmail">E-postliste (internmail)</a></li>
	<li><a href="#velferden">Velferdens oppmenn</a></li>
	<li><a href="#kollegiet">Kollegiets stillinger</a></li>
	<li><a href="#tennis">Booking av tennisbanen</a> <span style="color: red; font-weight: bold; font-size: 11px">NY</span></li>
</ul>

<h2 id="nyttig">Nyttige dokumenter/ressurser</h2>
<ul>
	<li><a href="/velkommen.pdf">Velkomsthefte for Blindern Studenterhjem</a> (PDF, revidert høst 2012)</li>
	<li><a href="/dokumenter/statutter/">Statutter for Blinderen Studenterhjem</a> (egen nettside med katalog)</li>
	<li><a href="/foreninger/arrangementplan">Arrangementplan</a> (oppdateres fortløpende)</li>
	<li>Facebook-gruppen <a href="/fb">&laquo;Oppslagstavle Blindern Studenterhjem&raquo;</a></li>
</ul>

<h2 id="dugnaden">Dugnaden</h2>
<p>Ved hvert semester blir du satt opp på to dugnader du plikter å gjennomføre.</p>
<ul>
	<li>Du kan <a href="/dugnaden/">bytte dugnad på dugnaddsiden</a></li>
</ul>

<h2 id="matmeny">Matmeny</h2>
<p>Matmenyen er tilbake! Matmenyen ble lagt ut våren 2012 ifm. rehabiliteringen av vestfløy og folk som bodde midlertidig på SiO-hyblene. På grunn av stor interesse kommer denne fra nå (midten av november 2012) til å legges ut hver uke.</p>

<table class="table matmeny">
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Forrige uke</th>
			<th>Denne uke</th>
			<th>Neste uke</th>
		</tr>
	</thead>
	<tbody>';

// les inn matmenyen
class matmeny {
	public $data = array();
	public $uke;
	public $dag;

	public function load_data() {
		$c = file_get_contents(dirname(__FILE__)."/../matmeny.csv");
		$c = explode("\n", str_replace("\r", "", $c));

		foreach ($c as $r) {
			$row = str_getcsv($r);
			if (count($row) != 3) continue; // three cols in each entry

			$this->data[$row[0]][$row[1]] = $row[2];
		}

		$this->uke = date("W");
	}

	public function get_meny($uke_rel, $dag) {
		$uke = date("W", time()+$uke_rel*86400*7);
		
		if (!isset($this->data[$uke][$dag])) {
			return '<i style="color: #CCC">Ingen data</i>';
		}

		return $this->data[$uke][$dag];
	}

	public function print_rows() {
		$ignores = array();
		$days = array(1 => "Mandag", "Tirsdag", "Onsdag", "Torsdag", "Fredag", "Lørdag", "Søndag");

		$y = date("N");
		$this_day = date("z");
		for ($i = 1; $i <= 7; $i++) {
			echo '
		<tr>
			<th>'.$days[$i].'</th>';

			for ($x = -1; $x <= 1; $x++) {
				$d = date("z", time()+$x*7*86400+($i-$y)*86400);
				echo '
			<td'.($d == $this_day ? ' style="background-color: #00FF00"' : '').'>'.$this->get_meny($x, $i).'</td>';
			}

			echo '
		</tr>';
		}
	}
}

$mat = new matmeny();
$mat->load_data();
$mat->print_rows();

echo '
	</tbody>
</table>
<p><i>Genereres automatisk. Oppsettet for tabellen skal forbedres. Dette er bare et kjapt og enkelt oppsett.</i> <span style="background-color: #00FF00">Grønt</span> er dagens.</p>
<p>Det blir til og med kanskje mulig å hente historikk og statistikk over matmenyen etter hvert! Gøy med data!</p>


<h2 id="internmail">E-postliste (internmail)</h2>
<p>På internmailen kommer beskjeder fra andre beboere og vedlikehold/administrasjonen. Det kan være veldig praktisk å få med seg beskjedene gitt på denne listen.</p>
<p><b>Påmelding:</b></p>
<ol>
	<li>Send en e-post til <b>sympa@studorg.uio.no</b> med emnet:<br />
		<code>subscribe blindernbeboere <i>Fornavn Etternavn</i></code></li>
	<li>Oppmannen for internmailen godkjenner påmeldingen</li>
	<li>Du får en bekreftelse på at du er lagt til i lista</li>
	<li>Du kan deretter sende ut e-poster og vil motta e-poster som sendes til lista</li>
</ol>
<p><b>Avmelding:</b></p>
<ol>
	<li>Send en e-post til <b>sympa@studorg.uio.no</b> med emnet:<br />
		<code>unsubscribe blindernbeboere</code></li>
	<li>Du vil motta en bekreftelse for at du ble avmeldt</li>
	<li>Se <a href="http://www.uio.no/tjenester/it/e-post-kalender/e-postlister/abonnere/unsub.html">brukerveiledningen</a> for hjelp</li>
</ol>
<p><b>Sende e-post til lista:</b></p>
<p>Send e-posten til <code>blindernbeboere@studorg.uio.no</code> så blir den sendt ut til alle som er på lista.</p>
<p>Hvis e-postadressen du sender fra ikke ligger inne i systemet vil e-posten bli godkjent av internmailoppmann før den blir sendt ut.</p>

<h2 id="velferden">Velferdens oppmenn</h2>
<p class="info_kontakter">Denne oversikten er kun ment for beboere og skal ikke videreformidles utenfor bruket.</p>
<iframe width="700" height="500" frameborder="0" src="https://docs.google.com/spreadsheet/ccc?hl=no&key=0AsmINoGULmbPdG15RG1vYk5EdlR2bEk5dkpVbHUydVE&single=true&gid=0&output=html&widget=true"></iframe>

<h2 id="kollegiet">Kollegiets stillinger</h2>
<p class="info_kontakter">Denne oversikten er kun ment for beboere og skal ikke videreformidles utenfor bruket.</p>
<iframe width="700" height="600" frameborder="0" src="https://docs.google.com/spreadsheet/ccc?hl=no&key=0AsmINoGULmbPdDBnR21XWHUzWXFTanhoaGM1b3EwekE&single=true&gid=0&output=html&widget=true"></iframe>

<h2 id="tennis">Booking av tennisbanen</h2>
<p>Tennisbanen bookes ved å bruke Google Calendar. Logg inn med <i>ifbs.tennis@gmail.com</i> på <a href="https://www.google.com/calendar/">https://www.google.com/calendar/</a>. Passordet er <i>togafest</i>.</p>
<p>Regler for booking av banen:</p>
<ul>
	<li>Du kan ikke reservere banen lenger enn syv dager frem i tid</li>
	<li>Maksimal spilletid er 90 minutter</li>
	<li>Du må møte opp til reservert tid. Hvis du er mer enn fem minutter for sen, blir reservasjonen ugyldig. Da kan hvem som helst spille</li>
</ul>
<p>Husk at vi leier ut banen til eksterne mellom 11.00 og 13.00 hver mandag. Da kan vi dessverre ikke benytte oss av banen.</p>
<iframe src="https://www.google.com/calendar/embed?showTitle=0&amp;mode=WEEK&amp;height=1200&amp;wkst=2&amp;bgcolor=%23ffffff&amp;src=pssckmifkj9dk4qqd3hmp15n78%40group.calendar.google.com&amp;color=%232F6309&amp;ctz=Europe%2FOslo" style=" border-width:0 " width="800" height="1200" frameborder="0" scrolling="no"></iframe>
';
