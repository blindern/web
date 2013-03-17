<?php

bs_side::set_title("Livet på BS");
bs_side::$lang_crosslink['en'] = "en/associations";
bs_side::$page_class = "foreninger";

require ROOT."/base/foreninger.php";
$foreninger = new foreninger();

// echo get_right_img("IFBS1.jpg");
echo get_right_img_gal(188, null, "Blindern Studenterhjem er et unikt, godt og trygt sted å bo.", "Foto: Anders Fagereng");
echo get_right_img_gal(163, null, "Et godt samhold betyr mye felles aktiviteter. Tradisjonene på BS strekker seg langt tilbake i tid.", "Foto: Henrik Steen");

echo '
<h1>Livet på BS</h1>

<p>P&aring; disse sidene f&aring;r du en oversikt over hva de ulike foreningene vil gj&oslash;re for
deg som nyinnflyttet.</p>
<p>Det er mange tradisjoner p&aring; BS, og det er derfor du omtrent fra dag en vil f&oslash;le
at du er n&oslash;dt til &aring; f&aring; et innblikk i de sosiale aktivitene, tradisjonene og foreningene
som finnes p&aring; BS.</p>
<p>Man er alltid på utkikk etter nytt mot, og nye beboere som vil engasjere seg tas godt i mot. Det
skal ikke mye til før man føler seg inkludert på studenterhjemmet.</p>
<p>Studenterhjemmet har egen skjenkebevilling og bar med alle rettigheter.</p>

<h2>Nyinnflyttet</h2>
<p>Som nyinnflyttet (pygmé) er det et par ting man bør få med seg:</p>
<ol>
	<li style="max-width: 410px"><b>Pygmémøte</b> - her gis det en rekke praktiske opplysninger om hjemmet, mange av foreningene
		presenterer seg og det er en god mulighet for å kunne stille evt. spørsmål man måtte ha.</li>
	<li style="max-width: 410px"><b>Pygmétur</b> - blir du med på pygméturen er du garantert å ha en kompisgjeng på kort tid. På pygméturen
		blir det rebus opp til studenterhjemmet hytte, middag på hytta og gode opplevelser ut kvelden.</li>
	<li style="max-width: 410px"><b>Rebusløp</b> - rebusløpet gjør deg godt kjent med studenterhjemmet og dets foreninger og vil være
		noe du sent vil glemme.</li>
	<li style="max-width: 410px"><b>Pygmémiddag</b> - middag til ære for alle nyinnflyttede. Her vil du sannsynligvis oppleve ditt første midtspiel!</li>
</ol>
<p>Du kan lese mer om disse arrangementene og de ulike foreningene som arrangerer det under <a href="/livet/liste">foreninger og grupper på BS</a>.</p>';


/*bs_side::$head .= '
 	<script type="text/javascript" src="/lib/kaltura-html5player-widget/jquery-1.4.2.min.js"></script> 
	<style type="text/css"> 
		@import url("/lib/kaltura-html5player-widget/skins/jquery.ui.themes/redmond/jquery-ui-1.7.2.css");
	</style>  
	<style type="text/css"> 
		@import url("/lib/kaltura-html5player-widget/mwEmbed-player-static.css");
	</style>	
	<script type="text/javascript" src="/lib/kaltura-html5player-widget/mwEmbed-player-static.js" ></script>';

echo '
<h2>Olav Trygvason fremført av cHorus Buchus på Bukkeballet våren 2010</h2>
<div style="margin: 15px 15px 25px">
	<video id="vid1" poster="" width="830" height="466">
		<source src="/10150138573435697_26751.mp4" />
	</video>
</div>
<p class="creds">Video: Anders Fagereng</p>';*/

$foreninger->set_active_menu = false;
$foreninger->gen_page();