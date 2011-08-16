<?php

bs_side::set_title("Arrangementplan");
bs_side::$head .= '
<script src="/lib/mootools/mootools-1.2.x-core-nc.js" type="text/javascript"></script>
<script src="/lib/mootools/mootools-1.2.x-more-nc.js" type="text/javascript"></script>
<script src="'.bs_side::$pagedata->doc_path.'/default.js"></script>
<script>
window.addEvent("domready", function()
{
	function show_period(id) {
		$$(".arrangementer_group").setStyle("display", "none");
		$(id).setStyle("display", "block");
	}
	
	// vis kun nyeste periode
	show_period($$(".arrangementer_group")[0].get("id"));
	
	// periode-lenker
	document.id("arrangementer_head").setStyle("display", "block").getElements("a").addEvent("click", function()
	{
		show_period(this.get("id").substring(0, 7));
		return false;
	});
});
</script>';


echo get_right_img("schussrenn_2010v.jpg", null, "Schussrennet våren 2010", "Schussrennet våren 2010. Foto: Anders Fagereng").' <!-- Foto: Anders Fagereng -->';

echo '
<h1>Arrangementer</h1>

<ul id="arrangementer_head" style="display: none">
	<li><a href="#" id="arr_h11_group">Høst 2011</a></li>
	<li><a href="#" id="arr_v11_group">Vår 2011</a></li>
	<li><a href="#" id="arr_h10_group">Høst 2010</a></li>
</ul>

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
		
		<dt>24. september</dt>
		<dd>Temafest</dd>
		
		<dt>30. sep - 2. okt</dt>
		<dd>Hyttedugnad til <a href="'.bs_side::$pagedata->doc_path.'/smaabruket">Småbruket</a></dd>
		
		<dt>7. oktober</dt>
		<dd>Pigefaarsamlingens semestermøte og PPP</dd>
		
		<dt>22. oktober</dt>
		<dd>Høstball</dd>
		
		<dt>23. oktober</dt>
		<dd>Café avec</dd>
		
		<dt>7. november</dt>
		<dd>Åpent Kollegiemøte</dd>
		
		<dt>10. november</dt>
		<dd>Allmannamøte</dd>
		
		<dt>12. november</dt>
		<dd>Togafest</dd>
		
		<dt>15.-17. november</dt>
		<dd>Kollegievalg</dd>
		
		<dt>2. desember</dt>
		<dd>Julemøte</dd>
	</dl>
	<p><i>Endringer:</i></p>
	<ul>
		<li>22. juni 2011: Foreløpig semesterplan lagt inn.</li>
		<li>9. august 2011: Hyttedugnad 30. sep - 2. okt lagt inn</li>
		<li>15. august 2011: Pygmémøtet flyttet fra 18. august til 25. august</li>
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

<p><a href="http://www.google.com/calendar/render?cid=http%3A%2F%2Fwww.google.com%2Fcalendar%2Ffeeds%2Fg16bhv7hcpirfk0sdhq0ggl48o%2540group.calendar.google.com%2Fpublic%2Fbasic" target="_blank"><img src="http://www.google.com/calendar/images/ext/gc_button1.gif" style="border: none" alt="" /></a></p>

';
