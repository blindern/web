<?php

bs_side::set_title("Arrangementplan");

ess::$b->page->add_js('
$(document).ready(function() {
	function show_period(id) {
		$(".arrangementer_group").hide();
		$("#"+id).show();
	}
	
	// vis kun nyeste periode
	show_period($(".arrangementer_group").first().attr("id"));
	
	// periode-lenker
	$("#arrangementer_head").show().find("a").click(function()
	{
		show_period($(this).attr("id").substring(0, 7));
		return false;
	});
});');

echo get_right_img_gal(192, "Schussrennet våren 2010", "Schussrennet våren 2010.", "Foto: Anders Fagereng");
echo get_right_img_gal(172, null, "Beboerne er her samlet under julemøtet. Da er det god julemiddag, en rekke kåringer for semesteret som gis ut og hyggelig underholdning.", "Foto: Henrik Steen");
echo get_right_img_gal(162, null, "IFBS-sommerleker fra 2012.", "Foto: Henrik Steen");

echo '
<h1>Arrangementer<!-- <a href="http://www.google.com/calendar/render?cid=http%3A%2F%2Fwww.google.com%2Fcalendar%2Ffeeds%2Fg16bhv7hcpirfk0sdhq0ggl48o%2540group.calendar.google.com%2Fpublic%2Fbasic" target="_blank"><img src="http://www.google.com/calendar/images/ext/gc_button1.gif" style="border: none; vertical-align: -8px; margin-left: 30px" alt="" /></a>--></h1>

<ul id="arrangementer_head" style="display: none">
	<li><a href="#" id="arr_nyy_group">Nyeste</a></li>
	<li><a href="#" id="arr_v13_group">Vår 2013</a></li>
	<li><a href="#" id="arr_h12_group">Høst 2012</a></li>
	<li><a href="#" id="arr_v12_group">Vår 2012</a></li>
	<li><a href="#" id="arr_h11_group">Høst 2011</a></li>
	<li><a href="#" id="arr_v11_group">Vår 2011</a></li>
	<li><a href="#" id="arr_h10_group">Høst 2010</a></li>
</ul>

<div class="arrangementer_group" id="arr_nyy">
	<h2>Arrangementplan flyttet</h2>
	<p>Arrangementplanen er fra og med våren 2014 flyttet til <a href="https://blindern-studenterhjem.no/intern/arrplan">ny side</a>.
Historisk plan for høsten 2013 er per tidspunkt kun tilgjengelig for beboere.</p>';

if (bs_side::$is_beboer) {
	echo '
	<p>(Du har status som beboer siden du har vært innom beboersiden: Arrangementplanen for høsten 2013 <a href="https://blindern-studenterhjem.no/wiki/Arrangementplan_h%C3%B8st_2013">ligger i wikien</a>.)</p>';
}

echo '
</div>

<div class="arrangementer_group" id="arr_v13">
	<h2>Arrangementplan for våren 2013</h2>
	<p>Merk endringer i måltider for hverdager fra nyttår:<br />
		Frokost: 07.15 – 09.00<br />
		Middag: kl. 14.30 – 17.30<br />
		Kveldsmat: kl. 19.30 – 20.30</p>
	<dl class="arrangementer">
		<dt>5. januar</dt>
		<dd>Uoffisiell velkommen hjem-fest</dd>
		
		<dt>10. januar</dt>
		<dd>Pygmémøte</dd>

		<dt>11. januar</dt>
		<dd>Velkommen hjem-fest</dd>
		
		<dt>13. januar</dt>
		<dd>Pygmémiddag</dd>

		<dt>19. januar</dt>
		<dd>UKEvors</dd>
		
		<dt>23. jan - 3. feb</dt>
		<dd>UKA på Blindern 2013</b> - se <a href="http://blindernuka.no/">blindernuka.no</a></dd>

		<dt>15.-16. februar</dt>
		<dd>Pygmétur til <a href="'.bs_side::$pagedata->doc_path.'/smaabruket">Småbruket</a> (hytta) - være over til søndag de som ønsker</dd>

		<dt>16. februar</dt>
		<dd>Temafest</dd>

		<dt>20.-24. februar</dt>
		<dd><a href="http://sl2013.no/">Studentlekene i Trondheim</a> (IFBS)</dd>
		
		<dt>2. mars</dt>
		<dd>UKEball</dd>

		<dt>3. mars</dt>
		<dd>Café Avec</dd>

		<dt>10. mars</dt>
		<dd>Seriemaraton i peisestua (BSG)</dd>

		<dt>15. mars</dt>
		<dd>Pigefaarsamlingens semestermøte og PPP</dd>

		<dt>17. mars</dt>
		<dd>Holmenkollsøndag med Haarn oc Blaese, IFBS m.fl.</dd>

		<dt>6. april</dt>
		<dd>Schussrenn</dd>

		<dt>13. april</dt>
		<dd>UKAs funksjonærfest</dd>

		<dt>30. april</dt>
		<dd>Russefest</dd>

		<dt>1. mai</dt>
		<dd>Recoveryday i Billa og Gymsalen (FFC)</dd>
		
		<dt>3.-5. mai</dt>
		<dd>Hyttedugnad til <a href="'.bs_side::$pagedata->doc_path.'/smaabruket">Småbruket</a></dd>

		<dt>6. mai</dt>
		<dd>Åpent kollegiemøte kl 20</dd>

		<dt>11. mai</dt>
		<dd><a href="http://www.holmenkollstafetten.no/">Holmenkollstafetten (IFBS)</a></dd>

		<dt>7. mai</dt>
		<dd>Allmannamøte (obs: tirsdag)</dd>

		<dt>10. mai</dt>
		<dd>Frist for meldelse av valgkandiatur for kollegievalget til Vice-Præces.</dd>

		<dt>17. mai</dt>
		<dd>Café Avec</dd>

		<dt>13.-15. mai</dt>
		<dd>Kollegievalg</dd>

		<dt>23. mai</dt>
		<dd>Foreningens semestermøte</dd>

		<dt>24.-25. mai</dt>
		<dd>Sommerleker m/IFBS og BSG</dd>

		<dt>31. mai</dt>
		<dd>Kollegiekonstituering</dd>

		<dt>7. juni</dt>
		<dd>Bukkehaugsfestivalen</dd>
	</dl>
	
	<p>IFBS arrangerer også regelmessige aktiviteter i ukedagene. Se IFBS-tavlen for nærmere informasjon.
		Tidspunktene nedenfor er kun veiledende og de vanlige tidspunktene aktivitetene foregår.</p>
	<dl class="arrangementer">
		<dt>Tirsdager</dt>
		<dd>Zumba kl 20-21</dd>
		<dt>Onsdager</dt>
		<dd>Styrkesirkel (&quot;styrkel&quot;) kl 18</dd>
		<dt>Torsdager</dt>
		<dd>Ballspill kl 16 (på Blindern Athletica)</dd>
	</dl>

	<p>Festforeningen arrangerer &quot;Billa kino&quot; (som hovedregel) kl 19 hver søndag.</p>

	<!--<p><i>Hjemmesideoppmann har ikke hørt noe om:</i></p>
	<ul>
		<li>Sikkert mange andre ting...</li>
	</ul>-->
	<p><i>Annen informasjon:</i></p>
	<ul>
		<li>Hemsedaltur utgår grunnet Studentlekene i Trondheim.</li>
	</ul>
	
	<!--<p><i>Utgått/ukjent:</i></p>
	<dl class="arrangementer">
	</dl>-->
	
	<p><i>Historikk:</i></p>
	<ul>
		<li>30. desember 2012: Foreløpig arrangementplan lagt inn.</li>
		<li>19. februar 2013: Oppdatert:<ul>
			<li>Allmannamøte fra 15. mai til 7. mai.</li>
			<li>Frist for å melde valgkandidatur for kollegievalg fra 18. mai til 10. mai.</li>
			<li>Kollegievalget fra perioden 21.-23. mai til perioden 13.-15. mai.</li>
		</ul></li>
		<li>17. mars 2013: Lagt inn:<ul>
			<li>Seriemaraton (BSG) 10. mars.</li>
			<li>Holmenkollsøndag 17. mars.</li>
			<li>UKAs funksjonærfest 13. april.</li>
			<li>Foreningens semestermøte 23. mai.</li>
			<li>Info om &quot;Billa kino&quot; og IFBS-arrangementer.</li>
		</ul></li>
		<li>18. mars 2013: Oppdateringer fra FFC:<ul>
			<li>Lagt inn recoveryday 1. mai.</li>
			<li>Lagt inn sommerleker 24.-25. mai.</li>
			<li>Flyttet dato for Bukkehaugsfestivalen fra 1. juni til 31. mai.</li>
		</ul></li>
		<li>18. mars 2013: La inn Zumba på tirsdager for IFBS.</li>
		<li>4. april 2013: Flyttet dato for Bukkehaugsfestivalen fra 31. mai til 7. juni.</li>
	</ul>
</div>

<div class="arrangementer_group" id="arr_h12">
	<h2>Arrangementplan for høsten 2012</h2>
	<dl class="arrangementer">
		<dt>20. august</dt>
		<dd><a href="http://blindernuka.no/2012/">miniUKA</a> - Pub-til-pub</dd>
		
		<dt>21. august</dt>
		<dd><a href="http://blindernuka.no/2012/">miniUKA</a> - Konsertkveld</dd>
		
		<dt>22. august</dt>
		<dd><a href="http://blindernuka.no/2012/">miniUKA</a> - Internaften</dd>
		
		<dt>23. august</dt>
		<dd>Pygmémøte</dd>
		
		<dt>25. august</dt>
		<dd>Rebusløp og velkommen hjem-fest</dd>
		
		<dt>26. august</dt>
 		<dd>Pygmémiddag m/café avec</dd>
 		
 		<dt>31. august</dt>
		<dd>Pygmétur til <a href="'.bs_side::$pagedata->doc_path.'/smaabruket">Småbruket</a> (hytta)</dd>
		
		<dt>8. september</dt>
		<dd>Sølecup</dd>
		
		<dt>18. september</dt>
		<dd>Båltur (IFBS) - avreise BS kl 19</dd>
		
		<dt>22. september</dt>
		<dd>Temafest<dd>
		
		<dt>28.-30. september</dt>
		<dd>Hyttedugnad til <a href="'.bs_side::$pagedata->doc_path.'/smaabruket">Småbruket</a> (hytta)</dd>
		
		<dt>5. oktober</dt>
		<dd>Pigefaarsamlingens semestermøte og PPP</dd>
		
		<dt>11.-14. oktober</dt>
		<dd><a href="http://bc2012.no/">Bergen Challenge</a> med IFBS</dd>
		
		<dt>15. oktober</dt>
		<dd>Åpent kollegiemøte kl 19:30</dd>
		
		<dt>20. oktober</dt>
		<dd>Høstball</dd>
		
		<dt>21. oktober</dt>
		<dd>Café avec</dd>
		
		<dt>27. oktober</li>
		<dd>Tur med biblioteksutvalget til Det Norske Teateret for å se Himmlers fødselsdag av østerrikeren Thomas Bernhard. Påmelding innen 16. september (Lars Hektoen)</dd>
		
		<dt>3. november</dt>
		<dd>Togafest</dd>
		
		<dt>8. november</dt>
		<dd>Allmannamøte</dd>
		
		<dt>12.-14. november</dt>
		<dd>Kollegievalg</dd>

		<dt>27. januar</dt>
		<dd>RISK-turnering (BSG)</dd>
		
		<dt>17. november</dt>
		<dd>Revysus</dd>
		
		<dt>22. november</dt>
		<dd>Foreningens semestermøte</dd>

		<dt>23. november</dt>
		<dd>Kollegiekonstituering</dd>

		<dt>2. desember</dt>
		<dd>Pigefaarsamlingens juleverksted</dd>
		
		<dt>7. desember</dt>
		<dd>Julemøte</dd>
	</dl>
	
	<p>IFBS arrangerer også regelmessige aktiviteter i ukedagene. Se IFBS-tavlen for nærmere informasjon.
		Tidspunktene nedenfor er kun veiledende og de vanlige tidspunktene aktivitetene foregår.</p>
	<dl class="arrangementer">
		<dt>Mandager</dt>
		<dd>Løpetreninger kl 18.</dd>
		<dt>Tirsdager</dt>
		<dd>Hiphop kl 18-19</dd>
		<dt>Onsdager</dt>
		<dd>Styrkesirkel</dd>
		<dt>Torsdager</dt>
		<dd>Ballspill kl 16 (på Blindern Athletica)</dd>
		<dt>Fredager</dt>
		<dd>Sprint-trening med Tormod</dd>
	</dl>
	
	<p>Festforeningen arrangerer &quot;Billa kino&quot; med visning av to filmer på søndager.</p>
	
	<p><i>Utgått/ukjent:</i></p>
	<dl class="arrangementer">
		<dt>24. november</dt>
		<dd><strike>Temafest (ubekreftet dato)</strike> (ikke avholdt)</dd>
		<dt>14. desember</dt>
		<dd><strike>Julemiddag</strike> (feil i tilsendt plan)</dd>
	</dl>
	
	<p><i>Historikk:</i></p>
	<ul>
		<li>27. juli 2012: Foreløpig arrangementplan lagt inn.</li>
		<li>27. juli 2012: Korrigert dato pygmétur 1. september til 31. august.</li>
		<li>29. juli 2012: Korrigert oppført dato for pygmétur fra 30. august til 31. august.</li>
		<li>4. august 2012: La inn hyttedugnad 28. til 30. september.</li>
		<li>4. september 2012: La inn info om løpetreninger, styrkesirkler, ballspill, sprint-treninger samt Billa kino.</li>
		<li>4. september 2012: Tur med biblioteksutvalget 27. oktober.</li>
		<li>4. september 2012: La inn info om hiphop på tirsdager.</li>
		<li>10. september 2012: La inn dato for revysus, åpent kollegiemøte, allmannamøte og kollegievalg.</li>
		<li>18. september 2012: La inn dato for båltur 18. september.</li>
		<li>27. september 2012: Flyttet revysus fra 3. november til 17. november.</li>
		<li>27. september 2012: Flyttet togafest fra 10. november til 3. november.</li>
		<li>9. oktober 2012: Korrigert dato for kollegievalg fra 12.-15. nov til 12.-14. nov.</li>
		<li>9. oktober 2012: La inn Bergen Challenge med IFBS fra 11. til 14. oktober.</li>
		<li>29. november 2012: Fjernet julemiddag 14. desember (feil i tilsendt plan). Fjernet ubekreftet temafest 24. november. La in juleverksted 2. desember. La inn allerede avholdte arrangementer: Foreningens semestermøte (22. nov), BSG sin RISK-turnering (15. nov) og kollegiekonstituering (23. nov).</li>
	</ul>
</div>

<div class="arrangementer_group" id="arr_v12">
	<h2>Arrangementplan for våren 2012</h2>
	<dl class="arrangementer">
		<dt>11. januar</dt>
		<dd>Uoffisiell velkommen hjem-fest</dd>
		
		<dt>13. januar</dt>
		<dd>Pygmétur til <a href="'.bs_side::$pagedata->doc_path.'/smaabruket">Småbruket</a> (hytta)</dd>
		
		<dt>14. januar</dt>
		<dd>Skitur til Småbruket ifm. pygmétur (IFBS)</dd>
		
		<dt>14. januar</dt>
		<dd>Velkommen hjem-fest</dd>
		
		<dt>15. januar</dt>
		<dd>Pygmémiddag</dd>
		
		<dt>20.-21. januar</dt>
		<dd>Overnattingstur til Katnosdammen (IFBS) <sup><a href="#note12-1">note 1</a></sup></dd>
		
		<dt>21. januar</dt>
		<dd><a href="https://www.facebook.com/events/311279098892859/">Beer Olympics</a></dd>
		
		<dt>27. januar</dt>
		<dd>Filmmaraton (BSG)</dd>
		
		<dt>28. januar</dt>
		<dd>Temafest</dd>
		
		<dt>29. januar</dt>
		<dd>Spillkveld (BSG)</dd>
		
		<dt>3.-5. februar</dt>
		<dd>Skiweekend i Hamar (IFBS) <sup><a href="#note12-2">note 2</a></sup></dd>
		
		<dt>15. februar</dt>
		<dd>Juridisk aften</dd>
		
		<dt>16. februar</dt>
		<dd>Ekstraordinært allmannamøte</dd>
		
		<dt>22. februar</dt>
		<dd>Båltur til Sognsvann (IFBS)</dd>
		
		<dt>24. februar</dt>
		<dd>Smørekurs (IFBS)</dd>
		
		<dt>25. februar</dt>
		<dd>Ulympiske vinterleker (FFR/IFBS)</dd>
		
		<dt>26. februar</dt>
		<dd>Spillkveld (BSG)</dd>
		
		<dt>3. mars</dt>
		<dd>Bukkefest</dd>
		
		<dt>4. mars</dt>
		<dd>Café Avec</dd>
		
		<dt>10.-11. mars</dt>
		<dd>Tur til Snøhetta (IFBS) <sup><a href="#note12-3">note 3</a></sup></dd>
		
		<dt>11. mars</dt>
		<dd>Sjakkturnering (BSG)</dd>
		
		<dt>16. mars</dt>
		<dd>Pigefaarsamlingens semestermøte og PPP</dd>
		
		<dt>23.-25. mars</dt>
		<dd>Hemsedaltur (IFBS) <sup><a href="#note12-4">note 4</a></sup></dd>
		
		<dt>25. mars</dt>
		<dd>Spillkveld (BSG)</dd>
		
		<dt>26. mars - 1. april</dt>
		<dd>Påskejakten (BSG)</dd>
		
		<dt>28. mars</dt>
		<dd>Uoffisiell utflyttingsfest ifm. oppussingen fra 1. april</dd>
		
		<dt>29. mars</dt>
		<dd>Utflyttingsfest ifm. oppussingen fra 1. april</dd>
		
		<dt>14. april</dt>
		<dd>Schussrenn</dd>
		
		<dt>20.-21. april</dt>
		<dd>Filmmaraton (BSG)</dd>
		
		<dt>24. april</dt>
		<dd>Elefantfest (kun for elefanter)</dd>
		
		<dt>29. april</dt>
		<dd>Spillkveld (BSG)</dd>
		
		<dt>30. april</dt>
		<dd>Russefest</dd>
		
		<dt>4.-6. mai</dt>
		<dd>Hyttedugnad til <a href="'.bs_side::$pagedata->doc_path.'/smaabruket">Småbruket</a></dd>
		
		<dt>7. mai</dt>
		<dd>Åpent kollegiemøte</dd>
		
		<dt>9. mai</dt>
		<dd>Foredrag om eugenikk og rasehygienisk tenkning i Norge, holdes av Espen Søbye (Biblioteksutvalget og FFR)</dd>
		
		<dt>10. mai</dt>
		<dd>Allmannamøte</dd>
		
		<dt>12. mai</dt>
		<dd><a href="http://www.holmenkollstafetten.no/">Holmenkollstafetten (IFBS)</a></dd>
		
		<dt>14.-16. mai</dt>
		<dd>Kollegievalg</dd>
		
		<dt>16. mai</dt>
		<dd>Temafest</dd>
		
		<dt>17. mai</dt>
		<dd>17. maifeiring på Hardangerjøkulen (IFBS) <sup><a href="#note12-5">note 5</a></sup></dd>
		
		<dt>17. mai</dt>
		<dd>Café Avec</dd>
		
		<dt>24. mai</dt>
		<dd>Foreningens semestermøte</dd>
		
		<dt>26. mai</dt>
		<dd>Sommerleker (IFBS)</dd>
		
		<dt>1. juni</dt>
		<dd>Bukkehaugsfestivalen</dd>
		
		<dt>1. juni</dt>
		<dd>Kollegiekonstituering</dd>
	</dl>
	
	<p>IFBS arrangerer også regelmessige aktiviteter i ukedagene. Se IFBS-tavlen for nærmere informasjon.
		Tidspunktene nedenfor er kun veiledende og de vanlige tidspunktene aktivitetene foregår.</p>
	<dl class="arrangementer">
		<dt>Mandager</dt>
		<dd>Løpetreninger kl 18. (Vintertid: Intervalltrening på ski)</dd>
		<dt>Onsdager</dt>
		<dd>Ballspill kl 16</dd>
		<dt>Torsdager</dt>
		<dd>&quot;Back-to-basic&quot;-styrkesirkel kl 20</dd>
	</dl>
	
	<p>Festforeningen arrangerer &quot;kino&quot; med visning av to filmer på søndager.</p>
	
	<p><i>Noter:</i></p>
	<ol>
		<li id="note12-1"><b>Skitur til Katnosdammen:</b> Toget til Hakadalen lørdag formiddag. 28 km på ski inn til Katnosdammen hvor vi
			lager middag og overnatter. Katnosdammen er en gammel damvokterbolig som akkurat ha fått nyoppusset kjøkken og
			freshet opp stue! Søndag går vi tilbake til Blindern via Kikut. Vil man ikke gå så lang tur går man tilbake
			til Hakadalen og tar toget derfra.</li>
		<li id="note12-2"><b>Langrenn-, skøyte- og slalåm/snowboard/telemark-weekend i Hamar:</b>
			Tuva inviterer til skihelg i Hamar. Vi bor i et hus nede ved Mjøsa, med 18 sengeplasser,
			en koie og en rød stuga. Vi tar toget til Hamar fredag ettermiddag (1 1/2 time).
			Pris 390 kr, tur-retur, og eneste nødvendige utgift for turen. Kost og losji er gratis.<br />
			<br />
			Lørdag:
			<ul>
				<li>Alt. 1:Langrenn i Vangsåsa (folk velger tur etter nivå), evt. Steinfjellrunden som seeding til Birken.</li>
				<li>Alt. 2: Skøytebane rett utenfor huset dersom Mjøsa er islagt.</li>
				<li>Alt. 3: Svømmehall med det beste stupetårnet i landet!</li>
				<li>Alt. 4: Bli igjen i huset og kose seg.</li>
			</ul>
			Søndag: Hafjell (1 times kjøring) eller langrenn og ellers samme alternativer som lørdag.</li>
		<li id="note12-3"><b>Skitur til Snøhetta:</b>
			Vi tar toget/kjører til Dovrefjell og Kongsvold Fjellstue. Her starter kvisteløypa på 17 km som tar oss inn
			til Reinheim, selvbetjent turisthytte hvor vi overnatter.<br />
			Neste dag går vi opp til Snøhetta. Vi avslutter dagen med en skikkelig hyttemiddag på Reinheim
			før vi neste dag spenner på skiene og kommer oss tilbake til Kongsvold.</li>
		<li id="note12-4"><b>Hemsedaltur:</b> Tradisjonstro arrangerer IFBS tur til Hemsedal. Vi har allerede booket to leiligheter,
			hvor vi tilsammen har plass til 16 stk. Påmelding i slutten av januar etter prinsippet førstemann til mølla.
			Er påmeldingen stor kan vi prøve å booke enda en leilighet.</li>
		<li id="note12-5"><b>Nasjonaldagen på Finse:</b> 17. mai-feiringen på Finse har blitt en tradisjon. Opptil 3.000 mennesker
			velger å feire nasjonaldagen med å gå på ski fra Finse til Hardangerjøkulen. Ved 1.800 meters høyde ved Jøkulhytta
			holdes det en gudstjeneste, før det arrangeres 17. mai-tog og en legendarisk fotballkamp.</li>
	</ol>
	
	<p><i>Dato kommer:</i></p>
	<ul>
		<li>Padletur i Oslofjorden eller på Mjøsa i juni (IFBS)</li>
		<li>Stupekurs i juni (IFBS)</li>
	</ul>
	
	<p><i>Utgått/ukjent:</i></p>
	<ul>
		<li>Skøytetur i januar (IFBS)</li>
		<li>Innebandyturnerig i april (IFBS)</li>
	</ul>
	
	<p><i>Endringer:</i></p>
	<ul>
		<li>2. januar 2012: Foreløpig arrangementplan lagt inn.</li>
		<li>4. januar 2012: Korrigert dato for uoffisiell utflyttingsfest ifm. vestfløyen fra 24. til 28. mars.</li>
		<li>5. januar 2012: La inn Beer Olympics 21. januar.</li>
		<li>17. januar 2012: La inn arrangementer for BSG.</li>
		<li>17. januar 2012: La inn hyttedugnad 4.-6. mai.</li>
		<li>3. februar 2012: La inn juridisk aften 15. februar og ekstraordinært allmannamøte 16. februar.</li>
		<li>8. mai 2012: La inn foredrag 9. mai, allmannamøtet 10. mai, kollegievalg 14.-16. mai, sommerleker 26. mai og kollegiekonstituering 1. juni. Lagt inn noen mindre arrangementer som allerede har blitt avholdt.</li>
		<li>11. mai 2012: La inn foreningens semestermøte 24. mai.</li>
	</ul>
</div>

<div class="arrangementer_group" id="arr_h11">
	<h2>Arrangementplan for høsten 2011</h2>
	<dl class="arrangementer">
		<dt>20. august</dt>
		<dd>Velkommen hjem-fest</dd>
		
		<dt>25. august</dt>
		<dd>Pygmémøte</dd>
		
		<dt>26. august</dt>
		<dd>Pygmétur til <a href="'.bs_side::$pagedata->doc_path.'/smaabruket">Småbruket</a> (hytta)</dd>
		
		<dt>27. august</dt>
		<dd>Rebusløp</dd>
		
		<dt>28. august</dt>
		<dd>Pygmemiddag m/cafe avec</dd>
		
		<dt>10. september</dt>
		<dd>Sølecup</dd>
		
		<dt>23. september</dt>
		<dd>Filmmaraton med Pirates of the Caribbean (BSG)</d>
		
		<dt>24. september</dt>
		<dd>Temafest</dd>
		
		<dt>25. september</dt>
		<dd>Spillkveld og kaffebar (BSG)</dd>
		
		<dt>30. sep - 2. okt</dt>
		<dd>Hyttedugnad til <a href="'.bs_side::$pagedata->doc_path.'/smaabruket">Småbruket</a> - IFBS tar turen opp på lørdagen og blir over til søndag</dd>
		
		<dt>7. oktober</dt>
		<dd>Pigefaarsamlingens semestermøte og PPP</dd>
		
		<dt>8. oktober</dt>
		<dd>Barskingen (IFBS)</dd>
		
		<dt>9. oktober</dt>
		<dd>Stupekurs (IFBS)</dd>
		
		<dt>9. oktober</dt>
		<dd>Spillkveld og kaffebar (BSG)</dd>
		
		<dt>16. oktober</dt>
		<dd>Bocketurnering (BSG)</d>
		
		<dt>22. oktober</dt>
		<dd>Høstball</dd>
		
		<dt>23. oktober</dt>
		<dd>Café avec</dd>
		
		<dt>7. november</dt>
		<dd>Åpent Kollegiemøte</dd>
		
		<dt>9. november</dt>
		<dd>Båltur i Oslomarka (IFBS)</dd>
		
		<dt>10. november</dt>
		<dd>Allmannamøte</dd>
		
		<dt>12. november</dt>
		<dd>Togafest</dd>
		
		<dt>13. november</dt>
		<dd>Filmmaraton med Twilight (BSG)</d>
		
		<dt>15.-17. november</dt>
		<dd>Kollegievalg</dd>
		
		<dt>16. november</dt>
		<dd>Foreningens semestermøte</dd>
		
		<dt>27. november</dt>
		<dd>Spillkveld og kaffebar (BSG)</dd>
		
		<dt>27. november</dt>
		<dd>Pigefaarsamlingens juleverksted</dd>
		
		<dt>2. desember</dt>
		<dd>Julemøte</dd>
		
		<dt>4. desember</dt>
		<dd>Spillkveld og kaffebar (BSG)</dd>
		
		<dt>7. desember</dt>
		<dd>Nansen-foredrag av Carl Emil Vogt (Biblioteket)</dd>
		
		<dt>10. desember</dt>
		<dd>Filmmaraton med Harry Potter (BSG)</d>
		
		<dt>16.-24. desember</dt>
		<dd>Skiferie på Tynset (IFBS)</dd>
	</dl>
	<p>IFBS arrangerer også regelmessige aktiviteter i ukedagene. Se IFBS-tavlen for nærmere informasjon. Tidspunktene nedenfor er kun veiledelde og de vanlige tidspunktene aktivitetene foregår.</p>
	<dl class="arrangementer">
		<dt>Mandager</dt>
		<dd>Løping kl 18</dd>
		<dt>Onsdager</dt>
		<dd>Ballspill kl 16</dd>
		<dt>Torsdager</dt>
		<dd>&quot;Back-to-basic&quot;-styrkesirkel kl 20</dd>
		<dt>Søndager</dt>
		<dd>Svømming/bading kl 12</dd>
	</dl>
	<p><i>Endringer:</i></p>
	<ul>
		<li>22. juni 2011: Foreløpig semesterplan lagt inn.</li>
		<li>9. august 2011: Hyttedugnad 30. sep - 2. okt lagt inn</li>
		<li>15. august 2011: Pygmémøtet flyttet fra 18. august til 25. august</li>
		<li>24. august 2011: La til Barskingen 26. september</li>
		<li>26. august 2011: Korrigerte dato på Barskingen til 24. september</li>
		<li>26. august 2011: La inn foreningens semestermøte 16. november</li>
		<li>13. september 2011: La inn stupekurs 9. oktober og skiferie i desember og la inn informasjon om IFBS-aktiviteter på ukedagene</li>
		<li>19. september 2011: Flyttet barskingen fra 24. september til 8. oktober</li>
		<li>19. september 2011: La inn arrangementer for BSG.</li>
		<li>10. oktober 2011: La inn Nansen-foredrag 7. desember.</li>
		<li>22. november 2011: Flyttet spillkveld og kaffebarg med BSG fra 20. november til 27. november.</li>
		<li>27. november 2011: La inn Pigefaarsamlingens juleverksted 27. nov</li>
	</ul>
</div>

<div class="arrangementer_group" id="arr_v11">
	<h2>Arrangementplan for våren 2011</h2>
	<dl class="arrangementer">
		<dt>8. januar</dt>
		<dd>Uoffisiell velkommen hjem-fest</dd>
		
		<dt>13. januar</dt>
		<dd>Pygmémøte</dd>
		
		<dt>14. januar</dt>
		<dd>Velkommen hjem-fest</dd>
		
		<dt>16. januar</dt>
		<dd>Pygmemiddag m/cafe avec</dd>
		
		<dt>22. januar</dt>
		<dd>UKEvors</dd>
		
		<dt>26. jan - 6. feb</dt>
		<dd><b>UKA på Blindern 2011</b> - se <a href="http://blindernuka.no/">blindernuka.no</a></dd>
		
		<dt>5. februar</dt>
		<dd>Holmenkollen skimaraton (IFBS)</dd>
		
		<dt>18. februar</dt>
		<dd>Pygmétur til <a href="'.bs_side::$pagedata->doc_path.'/smaabruket">Småbruket</a> (hytta)</dd>
		
		<dt>19. februar</dt>
		<dd>Temafest</dd>
		
		<dt>23. feb - 6. mar</dt>
		<dd>Ski-VM i Oslo (IFBS arrangerer camp)</dd>
		
		<dt>5. mars</dt>
		<dd>UKEball m/cafe avec</dd>
		
		<dt>18. mars</dt>
		<dd>Pigefaarsamlingens semestermøte og PPP</dd>
		
		<dt>19. mars</dt>
		<dd>Birkebeinerrennet (IFBS)</dd>
		
		<dt>1.-3. april</dt>
		<dd>Skitur til Hemsedal (IFBS)</dd>
		
		<dt>9. april</dt>
		<dd>Schussrenn</dd>
		
		<dt>17. april</dt>
		<dd>Sjakkturnering (BSG)</dd>
		
		<dt>30. april</dt>
		<dd>Russefest</dd>
		
		<dt>7. mai</dt>
		<dd>Temafest</dd>
		
		<dt>10. mai</dt>
		<dd>Foreningens semestermøte</dd>
		
		<dt>14. mai</dt>
		<dd><a href="http://www.holmenkollstafetten.no/">Holmenkollstafetten (IFBS)</a></dd>
		
		<dt>14.-16. mai</dt>
		<dd>Hyttedugnad til <a href="'.bs_side::$pagedata->doc_path.'/smaabruket">Småbruket</a> (etter Holmenkollstafetten)</dd>
		
		<dt>17. mai</dt>
		<dd>17. mai med cafe avec</dd>
		
		<dt>19. mai</dt>
		<dd>Allmannamøte</dd>
		
		<dt>20. mai</dt>
		<dd>UKAs funksjonærfest</dd>
		
		<dt>29. mai</dt>
		<dd>IFBS-sommerleker</dd>
		
		<dt>3. juni</dt>
		<dd><a href="http://www.facebook.com/event.php?eid=191738997538769"><b>Bukkehaugsfestivalen</b></a> <span style="color: #FF0000">NB! Ny dato!</span></dd>
	</dl>
	<p><i>Endringer:</i></p>
	<ul>
		<li>31. januar 2011: Korrigert dato for temafest fra 9. mai til 7. mai.</li>
		<li>10. februar 2011: Flyttet hyttedugnaden fra 22. april til 13. mai (kollisjon med påske).</li>
		<li>22. mars 2011: Lagt til Holmenkollstafetten 14. mai.</li>
		<li>28. mars 2011: Flyttet hyttedugnaden fra 13. mai til 14. mai (kollisjon med Holmenkollstafetten).</li>
		<li>29. mars 2011: Lagt til sjakkturnering til BSG 17. april.</li>
		<li>8. april 2011: Lagt til UKAs funksjonærfest 20. mai.</li>
		<li>10. mai 2011: Lagt til Foreningens semestermøte 12. mai.</li>
		<li>19. mai 2011: Flyttet Bukkehaugsfestivalen fra 4. juni til 3. juni.</li>
		<li>20. mai 2011: Lagt til IFBS-sommerleker 29. mai.</li>
	</ul>
</div>

<div class="arrangementer_group" id="arr_h10">
	<h2>Arrangementplan for h&oslash;sten 2010</h2>
	<dl class="arrangementer">
		<dt>21. august</dt>
		<dd>Rebusløp og velkommen hjem fest</dd>
		
		<dt>29. august</dt>
		<dd>Pygmemiddag m/cafe avec</dd>
		
		<dt>4. september</dt>
		<dd>Pygmetur til Småbruket (hytta)</dd>
		
		<dt>11. september</dt>
		<dd>Temafest (tema: eventyr)</dd>
		
		<dt>25. september</dt>
		<dd>Sølecup</dd>
		
		<dt>1. oktober</dt>
		<dd>Pigefaarsamlingens semestermøte og PPP</dd>
		
		<dt>16. oktober</dt>
		<dd>Høstball</dd>
		
		<dt>17. oktober</dt>
		<dd>Cafe avec</dd>
		
		<dt>6. november</dt>
		<dd>Togafest</dd>
		
		<dt>12. november</dt>
		<dd>Hyttedugnad</dd>
		
		<dt>20. november</dt>
		<dd>Revysus</dd>
		
		<dt>27. november</dt>
		<dd>Temafest</dd>
		
		<dt>3. desember</dt>
		<dd>Julemøte</dd>
	</dl>
	<p>Sist oppdatert 14. oktober 2010.</p>
</div>

';
