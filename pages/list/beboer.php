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
	<li><a href="/foreninger/arrangementsplan">Arrangementsplan</a> (oppdateres fortløpende)</li>
</ul>

<h2 id="dugnaden">Dugnaden</h2>
<p>Ved hvert semester blir du satt opp på to dugnader du plikter å gjennomføre.</p>
<ul>
	<li>Du kan <a href="/dugnaden/">bytte dugnad på dugnaddsiden</a></li>
</ul>

<h2 id="matmeny">Matmeny</h2>
<p>Frem til sommeren 2012 vil matmenyen bli lagt ut her. Menyen legges ut helgen før den aktuelle uken.</p>
<p>Det gjøres oppmerksom på at det kan forekomme endringer i menyen, og at ikke nødvendigvis alle endringer blir oppdatert på nettsiden.</p>
<p>Få matmenyen rett inn i kalenderen din! <a href="http://www.google.com/calendar/render?cid=https%3A%2F%2Fwww.google.com%2Fcalendar%2Ffeeds%2Ftfcd2k5j3vu6lmoif5dqs8lb4g%2540group.calendar.google.com%2Fpublic%2Fbasic" target="_blank"><img src="//www.google.com/calendar/images/ext/gc_button1.gif" style="border: 0; vertical-align: -9px"></a></p>
<div style="margin-right: 5px"><iframe src="https://docs.google.com/document/pub?id=1QHc5IH2enxtrPeKI_ehrUSA35nE5VxLggiUq-E-KYBQ&amp;embedded=true" width="100%" height="550" frameborder="0" marginheight="0" marginwidth="0"></iframe></div>

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
<iframe src="https://www.google.com/calendar/embed?showTitle=0&amp;mode=WEEK&amp;height=600&amp;wkst=2&amp;bgcolor=%23ffffff&amp;src=pssckmifkj9dk4qqd3hmp15n78%40group.calendar.google.com&amp;color=%232F6309&amp;ctz=Europe%2FOslo" style=" border-width:0 " width="800" height="600" frameborder="0" scrolling="no"></iframe>
';
