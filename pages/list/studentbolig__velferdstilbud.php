<?php

bs_side::set_title("Velferdstilbud");

echo get_rand_images_right(
	array(
		9, // sykkelkjeller
		12, // møbelkjeller
		15, // bordtennis
		17, // tennis
		48, // valhall
		52, // uteområder
		58, // gymsal
		110, // studentkjøkkenet
		111, // bandrommet
		112, // musikkrommet
		113, // musikkrommet
		114, // tv-stua
		115, // biblioteket
		125, // sandvolleybalbanen
		127, // badstua
		140, // studentvaskeriet
		141, // gressbane
		162, // volleyballbane
		209, // musikksalongen (flygelet)
		210, // peisestua
	),
	4);


/*echo get_right_img_gal(127, null, "Badstua er fast tilholdssted for Blindern Bad og Badstueforening, men kan også brukes av alle øvrige beboere.", "Foto: Henrik Steen");
echo get_right_img_gal(111, null, "På et av stedets svært mange rom finner man her bandrommet.", "Foto: Henrik Steen");
echo get_right_img_gal(114, null, "TV-stua kan benyttes fritt av alle beboere. Her får man inn alle kanalene man skulle ha behov for.", "Foto: Henrik Steen");
echo get_right_img_gal(115, null, "Biblioteket har mange plasser og er et fint sted og jobbe med studier. Med varm kaffe fra matsalen har man alt man trenger.", "Foto: Henrik Steen");
*/

echo '
<h1>Velferdstilbud</h1>

<p>Det finnes en rekke felles velferdstilbud p&aring; Blindern Studenterhjem. De fleste
drives av studentene gjennom oppmennstillingene under Kollegiet og Velferden. Alle
rom som er tilgjengelig for studentene brukes fritt av beboerne.</p>

<ul>
	<li>Dagens aviser til frokost</li>
	<li><a href="omvisning/114">TV-stue</a></li>
	<li><a href="omvisning/115">Bibliotek og lesesal</a></li>
	<li>Nyoppusset kollokvierom (biblionette)</li>
	<li>Møterom (&quot;oldfruekontoret&quot;)</li>
	<li><a href="omvisning/210">Peisestue med trådløst nettverk</a></li>
	<li><a href="omvisning/110">Studentkjøkken</a> med mulighet for bakst og egne måltider</li>
	<li><a href="omvisning/127">Badstue</a></li>
	<li>Biljardbord</li>
	<li><a href="omvisning/112">Musikkrom</a>, <a href="omvisning/209">musikksallong med flygel</a>, <a href="omvisning/111">bandrom</a></li>
	<li><a href="omvisning/52">Store grøntområder ute</a></li>
</ul>

<p class="ul_header">Sportslig:</p>
<ul>
	<li><a href="omvisning/58">Gymsal og styrkerom</a></li>
	<li><a href="omvisning/17">Tennisbane</a></li>
	<li><a href="omvisning/141">Fotballbane</a></li>
	<li><a href="omvisning/125">Sandvolleyballbane</a></li>
	<li><a href="omvisning/15">Bordtennisbord</a></li>
</ul>

<p class="ul_header">Sosialt:</p>
<ul>
	<li>Mange forskjellige hagespill</li>
	<li><a href="omvisning/186">En rekke brettspill</a></li>
	<li><a href="omvisning/109">Egen pub og festlokaler</a></li>
	<li><a href="../smaabruket">Egen <i>hytte</i> i Bærumsmarka</a></li>
	<li><a href="omvisning/48">Festrom som tåler en støyt</a></li>
</ul>

<p class="ul_header">Oppbevaring:</p>
<ul>
	<li><a href="omvisning/9">Sykkelkjeller</a></li>
	<li><a href="omvisning/12">Møbelkjeller</a></li>
	<li>Skistall</li>
</ul>

<p class="ul_header">Praktiske formål:</p>
<ul>
	<li>Projektor til utlån</li>
	<li>Videokamera til utlån</li>
	<li>Felles kopimaskin og fargeskriver</li>
</ul>
	

';

/*
<ul>
	<li><u>Egen pub og festlokaler</u> -
	Blindern Studenterhjem har egen pub, "Billa",
	med alle rettigheter. "Billa" &aring;pnes
	hver onsdag, og er i helgene ogs&aring; &aring;sted
	for de fleste av Studenterhjemmets mange fester.</li>
	
	<li><u><a href="../smaabruket">Hytte i Bærumsmarka</a></u> -
	Blindern Studenterhjem eier en stor hytte i
	B&aelig;rumsmarka til fri benyttelse for beboerne.
	Studenter som skal p&aring; hyttetur kan f&aring;
	sendt med mat fra kj&oslash;kkenet.</li>
	
	<li><u>Vaskeri</u> -
	P&aring; Blindern Studenterhjem finnes et eget studentvaskeri,
	som beboere kan benytte fritt uten &aring; betale
	ekstra</li>
</ul>

<?php echo get_right_img("lesesalen_2.jpg"); ?> <!-- Foto: -->
<ul>
	
	<li><u>Bibliotek og lesesal</u> -
	P&aring; Studenterhjemmets bibliotek er det femti
	lesesalsplasser til fri benyttelse.</li>
	
	<li><u>Kollokvierom</u> -
	Kollokvierommet i Studenterhjemmets kjeller kan benyttes
	til seminarer og gruppearbeid.</li>
	
	<li><u>Kopimaskin</u> -
	Kopimaskinen kan benyttes fritt av alle beboere</li>
	
	<li><u>Peisestue med tr&aring;dl&oslash;st nettverk</u> -
	I Studenterhjemmets gamle peisestue kan beboerne
	drikke kaffe, kose seg foran peisen og anvende
	det tr&aring;dl&oslash;se nettverket.</li>
	
	<li><u>TV-stue</u> -
	TV-stuen p&aring; Studenterhjemmet har ViaSat- og
	Canal Digital-abonnement.</li>
	
	<li><u>Badstue</u> -
	Stor og flott badstue er til fri disposisjon for beboere.</li>
</ul>

<?php echo get_right_img("peisestuen.jpg"); ?> <!-- Foto: -->
<ul>
	<li><u>Flere musikkrom</u> -
	Det finnes flere musikkrom p&aring; Blindern Studenterhjem,
	blant annet en musikksalong med flygel, et &oslash;vingsrom
	beregnet p&aring; band, og et musikkrom egnet for
	orkester og kor.</li>
	
	<li><u>Gymsal og styrkerom</u> -
	I den nyoppussede gymsalen kan man drive med styrketrening,
	innebandy, bordtennis og andre aktiviteter.</li>
	
	<li><u>Sandvolleyballbane, fotballbane og tennisbane</u> -
	P&aring; utearealene finnes en sandvolleyballbane
	som er i flittig bruk gjennom &aring;rets varmere
	halvdel. Like ved sandvolleyballbanen finnes Studenterhjemmets
	fotballbane og to tennisbaner.</li>
	
	<li><u>Hageanlegget</u> -
	I Studenterhjemmets velholdte hageanlegg kan man slappe
	av mellom lese&oslash;ktene eller ha kollokvier p&aring;
	gresset, eller bare nyte noen timer i solen.</li>
</ul>
*/