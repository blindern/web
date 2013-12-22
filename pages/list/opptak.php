<?php

bs_side::set_title("Opptak");
bs_side::$lang_crosslink['en'] = "en/application";

$thisYear = date("Y");

echo get_right_img("paerealle.jpg", null, "", "Foto: Cecilie Sæle Merkesvik");
echo get_right_img("glade.jpg", null, "", "Det er et fantastisk miljø på Blindern Studenterhjem. Foto: Anders Fagereng");

echo '
<h1>Informasjon om søknad</h1>
<p class="boligtorget_lenke">
	<a href="https://www.boligtorget.no/blindern/">
		Alle søknader leveres gjennom Boligtorget. Trykk for å gå til Boligtorget.<br />
		<img src="/graphics/images/boligtorget.jpg" alt="Boligtorget" />
	</a>
</p>';

/*
<p>
	Opptak av beboere for h&oslash;sten <?php echo $thisYear; ?> skjer
	fortl&oslash;pende fra og med februar <?php echo $thisYear; ?>.
</p>*/

echo '
<h2>&Aring;pent for alle studenter</h2>
<p>
	Blindern Studenterhjem er &aring;pent for alle studenter.
	Geografisk spredning samt lik fordeling
	av gutter og jenter legges vekt p&aring; n&aring;r
	s&oslash;knadene vurderes. Det finnes ingen religi&oslash;s
	form&aring;lsparagraf ved Blindern Studenterhjem.
</p>

<h2>Et sosialt engasjement</h2>
<p>
	Noe av det mest unike ved Blindern Studenterhjem er
	det sosiale milj&oslash;et, med en rekke arrangementer
	og fester, klubber, foreninger og verv. Av denne grunn
	&oslash;nsker vi beboere med evner og kapasitet til
	&aring; bidra til et levende studentmilj&oslash;.</p>
<p>Dersom du liker &aring; organisere fester, bidra til
	&aring; f&aring; et arrangement p&aring; bena, spiller
	et instrument, synger, skriver tekster eller lignende,
	er dette et stort pluss. Skriv gjerne om dine interesser
	og erfaringer i s&oslash;knaden.
</p>

<h2>Fordel med langvarig tidsperspektiv</h2>
<p>
	De fleste fagomr&aring;der er representert blant beboerne
	p&aring; Blindern Studenterhjem, og mangfoldet av
	klubber, idrettsgrupper og foreninger s&oslash;ker
	&aring; ivareta beboernes forskjellige interesser
	og hobbyer. Aktivitetene er i stor grad avhengig av
	engasjement fra beboernes side.</p>
<p>For at tradisjonene
	skal videref&oslash;res m&aring; nye beboere sosialiseres
	inn i det sterke milj&oslash;et ved studenterhjemmet.
	Derfor er et perspektiv p&aring; minst to &aring;rs
	botid en fordel dersom du &oslash;nsker &aring; flytte
	inn p&aring; Blindern Studenterhjem. Dette anses imidlertid
	som et pluss i s&oslash;knaden snarere enn et krav.
</p>

<h2>Anbefaling fra person med tilknytning til Blindern Studenterhjem</h2>
<p>
	Mange av beboerne p&aring; Studenterhjemmet har hatt
	b&aring;de besteforeldre og foreldre som har bodd
	her. Fordi disse s&oslash;kerne kjenner til stedet
	fra f&oslash;r og er innstilt p&aring; &aring; delta
	i milj&oslash;et, kan dette v&aelig;re et pluss i
	s&oslash;knaden.</p>
<p>Det teller ogs&aring; positivt hvis
	du blir anbefalt av en tidligere eller n&aring;v&aelig;rende
	beboer som har bidratt positivt til livet p&aring;
	Studenterhjemmet. Dette kan skje gjennom et vedlagt
	brev, eller ved at beboeren p&aring; forh&aring;nd
	kontakter administrasjonen.</p>
<p>En anbefaling er imidlertid
	ingen n&oslash;dvendighet, og ofte vil en entusiastisk
	s&oslash;knad v&aelig;re tilstrekkelig til &aring;
	sikre deg plass.
</p>

<h2>Nulltoleranse mot narkotika</h2>
<p>
	P&aring; Blindern Studenterhjem er det nulltoleranse
	for bruk av narkotika. Brudd p&aring; denne regelen
	medf&oslash;rer utkastelse fra Studenterhjemmet.
</p>

<p><a href="https://www.boligtorget.no/blindern/">Søk om plass ved Blindern Studenterhjem &raquo;</a></p>';