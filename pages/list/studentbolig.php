<?php

bs_side::set_title("Studentbolig i Oslo");
bs_side::$lang_crosslink['en'] = "en/housing";

echo get_rand_images_right(
	array(
		115, // biblioteket
		137, // skilt ved pærealeen
		//155, // oversiktsbilde fra universitetet
		160, // mat 17. mai
		190, // østfløy fra sørsiden
		//195, // alette i peisestua
		197, // dobbeltrom hovedbygget
		198, // dobbeltrom med standardinventar på vestfløy
		199, // bad på vestfløy
		//154, // personlig innredet rom østfløy
		200, // enkeltrom vestfløy
		206, // kjøkkenpersonal
		208, // matsal med personer
		210, // peisestua
		216, // porten fra uio
		//218, // skilt fra oslo byes vel
		//219, // skulptur dør hovedbygg
	),
	3);

echo '
<h1>Studentbolig i Oslo</h1>

<div style="text-align: center; margin: 30px 0">
	<iframe width="560" height="315" src="//www.youtube.com/embed/_TLJbfVuFDE" frameborder="0" allowfullscreen></iframe>
</div>

<div class="mattider">
	<h2>Mat-tider</h2>
	<p><u>Mandag-fredag:</u><br />Frokost 07.15-09.00. Middag 14.30-17.30. Kveldsmat 19.30-20.30.</p>
	<p><u>Lørdag:</u><br />Frokost 08.00-10.00. Middag 14.00-15.30. Kveldsmat 18.00-19.30.</p>
	<p><u>Søndag:</u><br />Frokost 10.00-11.30. Middag 17.00-18.30. Ingen kveldsmat.</p>
</div>

<h2>Hva er inkludert i husleien?</h2>

<ul class="spaced">
	<li><span class="showoff keepon"><a href="#" class="activate">Tre måltider og matpakke hver dag</a></span>
		<div class="showon">

			<p>Menyen som serveres tar utgangspunkt i at det skal være norsk hverdagsmat,
			med gode råvarer og variert meny, som skal følge ernæringsmessige anbefalinger.
			Blant annet kan nevnes; havregrøt, vegetarmat, supper, internasjonale retter,
			hjemmebakt brød og friske grønnsaker.</p>

			<ul>
				<li>Frokost</li>
				<li>Middag</li>
				<li>Kveldsmat</li>
				<li>Matpakke til frokost og kveldsmat</li>
			</ul>

		</div></li>

	<li><div class="showoff keepon"><a href="#" class="activate">Møblert rom</a></div>
		<div class="showon">
			<p>Rommet er fullt m&oslash;blert n&aring;r du flytter inn og du kan deretter innrede slik du ønsker.</p>
			<p>Alle rommene har seng, skrivebord, stol, bokhylle, kommode, bordlampe, søppelbøtte og skap.</p>

		</div></li>

	<li>Internett</li>

	<li>Strøm</li>

	<li>Vaskeri</li>

	<li>Et unikt <a href="studentbolig/velferdstilbud">velferdstilbud</a> samt et godt og sosialiserende <a href="/livet">miljø</a></li>
</ul>

<p>Romfordelingen på Blindern Studenterhjem er basert på ansiennitetsprinsippet.
Det betyr at du ikke kan velge rom når du skal flytte inn. Vanligvis flytter
det inn ca 100 studenter i høstsemesteret og ca 40 av disse flytter inn på dobbeltrom.</p>

<p>Vanlig botid på dobbeltrom er ca et halvt år. Ettersom botiden og ansienniteten øker kan du
søke deg over til kombinasjonsrom eller enkeltrom, og etter hvert større og mer attraktive rom.</p>
<p>Prisene på enkeltrom, kombinasjonsrom og dobbeltrom er den samme for nye og eldre beboere. <a href="/studentbolig/leiepriser">Se leiepriser &raquo;</a></p>


<h2>Sommerutflytting</h2>
<p>Årlig botid på Blindern Studenterhjem er 10 måneder, dvs fom. 15. august tom. 15. juni.
Det betyr at du betaler kun 10 måneders leie hvert år. Om sommeren må du flytte ut av rommet ditt, men du kan lagre tingene dine i boder på BS.
I de to månedene midt på sommeren leies BS ut til Den Internasjonale Sommerskolen på Universitetet i Oslo.
Dette bidrar til økte inntekter til BS og å holde husleien lav for studentene.</p>



<h2>Romtyper</h2>
<p>Bilder fra ulike rom kan sees i <a href="/omvisning/oversikt#Beboerrom">den digitale omvisningen</a>.</p>

<h3>Enkeltrom</h3>
<p>De fleste bor på enkeltrom. Disse er alt fra ca. 10 kvm opp til ca. 15 kvm for de største rommene.</p>
<p>I tillegg finnes også &quot;porten&quot; hvor det er fire enkeltrom som deler entré, kjøkken, bad
og stor stue, men de som bor her har som regel bodd lenge på studenterhjemmet.</p>

<h3>Kombinasjonsrom</h3>
<p>Kombinasjonsrom betyr at et rom ligger innenfor det andre,
slik at den som bor på det innerste rommet gå gjennom rommet til den som bor ytterst.
Det ytterste rommet
kalles for &quot;gjennomgangsrommet&quot; og det innerste for &quot;mellomstuen&quot;.
Noen av mellomstuene har også adgang ut til plenen/atriet.</p>
<p>Det er også populært at par bor på disse rommene, slik at man får et
soverom og en stue. Hvert enkelt rom er ca. 10-15 kvm.</p>

<h3>Dobbeltrom</h3>
<p>Det finnes 18 dobbeltrom på studenterhjemmet, og dette er det vanligste rommet
man flytter inn på. Rommene er ca. 15-20 kvm. Etter å ha bodd på dobbeltrom sitter man
igjen med et godt og nært vennskap med personen man har delt rom med.</p>

';