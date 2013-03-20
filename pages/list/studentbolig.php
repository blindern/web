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

<p>Romfordelingen på Blindern Studenterhjem er basert på ansiennitetsprinsippet.
Det betyr at du ikke kan velge rom når du skal flytte inn. Vanligvis flytter
det inn ca 100 studenter i høstsemesteret og ca 40 av disse flytter inn på dobbeltrom.</p>

<!--<p>
	Det er plass til over 220 studenter p&aring;
	studenterhjemmet. For &aring; hjelpe beboerne inn i
	studenterhjemmets unike sosiale milj&oslash; flytter
	de aller fleste f&oslash;rst inn p&aring; dobbeltrom
	eller kombinasjonsrom. Et kombinasjonsrom er to rom
	hvor man m&aring; g&aring; gjennom det ene rommet for
	&aring; komme til det andre.</p>-->



<div class="mattider">
	<h2>Mat-tider</h2>
	<p><u>Mandag-fredag:</u><br />Frokost 07.15-09.00. Middag 14.30-17.30. Kveldsmat 19.30-20.30.</p>
	<p><u>Lørdag:</u><br />Frokost 08.00-10.00. Middag 14.00-15.30. Kveldsmat 18.00-19.30.</p>
	<p><u>Søndag:</u><br />Frokost 10.00-11.30. Middag 17.00-18.30. Ingen kveldsmat.</p>
</div>

<p>Vanlig botid på dobbeltrom er ca et halvt år. Ettersom botiden og ansienniteten øker kan du
søke deg over til kombinasjonsrom eller enkeltrom, og etter hvert større og mer attraktive rom.</p>
<p>Prisene på enkeltrom, kombinasjonsrom og dobbeltrom er den samme for nye og eldre beboere. <a href="/studentbolig/leiepriser">Se leiepriser &raquo;</a></p>


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
		<div class="showon">Rommet er fullt m&oslash;blert n&aring;r du flytter inn, men du har ogs&aring;
		mulighet til &aring; bytte ut noen av studenterhjemmets
		m&oslash;bler med dine egne.</div></li>

	<li>Internett</li>

	<li>Strøm</li>

	<li>Vaskeri</li>

	<li>Et unikt <a href="studentbolig/velferdstilbud">velferdstilbud</a> samt et godt og sosialiserende <a href="/livet">miljø</a></li>
</ul>


<h2>Sommerutflytting</h2>
<p>Årlig botid på Blindern Studenterhjem er 10 måneder, dvs fom. 15. august tom. 15. juni.
Det betyr at du betaler kun 10 måneders leie hvert år. Om sommeren må du flytte ut av rommet ditt, men du kan lagre tingene dine i boder på BS.
I de to månedene midt på sommeren leies BS ut til Den Internasjonale Sommerskolen på Universitetet i Oslo.
Dette bidrar til økte inntekter til BS og å holde husleien lav for studentene.</p>



<h2>Romtyper</h2>
<p>Bilder fra ulike rom kan sees i <a href="/omvisning/oversikt#c4">den digitale omvisningen</a>.</p>

<p><i>Enkeltrom</i><br />De fleste bor på enkeltrom. Disse er alt fra xx kvm opp til xx kvm for de største rommene.</p>
<p>I tillegg finnes også &quot;porten&quot; hvor det er fire enkeltrom som deler entré, kjøkken, bad
og stor stue, men de som bor her har som regel bodd lenge på studenterhjemmet.</p>

<p><i>Gjennomgangsrom</i><br />Gjennomgangsrom betyr at et rom ligger innenfor det andre. Det ytterste rommet
kalles for &quot;gjennomgangsrommet&quot; og det innerste for &quot;midtstuen&quot;.
Noen av midtstuene har også adgang ut til plenen.</p>
<p>Det er også populært at par bor på disse rommene, slik at man får et
soverom og en stue.</p>

<p><i>Dobbeltrom</i><br />Det finnes 20 dobbeltrom på studenterhjemmet, og dette er det vanligste rommet
man flytter inn på. Rommene er fra xx opp til xx kvm. Etter å ha bodd på dobbeltrom sitter man
igjen med et godt og nært vennskap med personen man har delt rom med.</p>

';