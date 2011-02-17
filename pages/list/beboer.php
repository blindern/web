<?php

bs_side::set_title("Beboere");
bs_side::$head .= '
<meta name="robots" content="noindex, nofollow" />';

bs_side::$head .= '
<style type="text/css">
#content h2 {
	font-size: 18px;
	margin-top: 30px;
	margin-bottom: 10px;
}
</style>';

echo '
<h1>Beboer ved Blindern Studenterhjem</h1>

<p style="color: #FF0000">Dette er en intern side for beboere ved Blindern Studenterhjem.</p>

<h2>Nyttige dokumenter/ressurser</h2>
<ul>
	<li><a href="/velkommen.pdf">Velkomsthefte for Blinderen Studenterhjem</a> (PDF, revidert høst 2010)</li>
	<li><a href="/dokumenter/Statutter_BS_01.01.11.pdf">Statutter for Stiftelsen Blinderen Studenterhjem</a> (PDF, oppdatert 1. januar 2011)</li>
	<li><a href="/foreninger/arrangementsplan">Arrangementsplan</a> (oppdateres fortløpende)</li>
</ul>

<h2>Dugnaden</h2>
<p>Ved hvert semester blir du satt opp på to dugnader du plikter å gjennomføre.</p>
<ul>
	<li>Du kan <a href="/dugnaden/">bytte dugnad på dugnaddsiden</a></li>
</ul>

<h2>E-postliste (internmail)</h2>
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
	<li>Send en e-post til <b>sympa@studorg.uoi.no</b> med emnet:<br />
		<code>unsubscribe blindernbeboere</code></li>
	<li>Du vil motta en bekreftelse for at du ble avmeldt</li>
	<li>Se <a href="http://www.uio.no/tjenester/it/e-post-kalender/e-postlister/abonnere/unsub.html">brukerveiledningen</a> for hjelp</li>
</ol>
<p><b>Sende e-post til lista:</b></p>
<p>Send e-posten til <code>blindernbeboere@studorg.uio.no</code> så blir den sendt ut til alle som er på lista.</p>
<p>Hvis e-postadressen du sender fra ikke ligger inne i systemet vil e-posten bli godkjent av internmailoppmann før den blir sendt ut.</p>';