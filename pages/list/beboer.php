<?php

bs_side::set_title("Beboere");
bs_side::$head .= '
<meta name="robots" content="noindex, nofollow" />';

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
</ul>

<h2 id="nyttig">Nyttige dokumenter/ressurser</h2>
<ul>
	<li><a href="/velkommen.pdf">Velkomsthefte for Blindern Studenterhjem</a> (PDF, revidert høst 2011)</li>
	<li><a href="/dokumenter/Statutter_2011-11-16.pdf">Statutter for Blinderen Studenterhjem</a> (PDF, oppdatert 16. november 2011)</li>
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

';
