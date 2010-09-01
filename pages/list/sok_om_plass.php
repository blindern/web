<?php
	$thisYear = date("Y");
?>
							<h1>S&oslash;knad om plass</h1>
                            <h2>S&oslash;knadsskjema</h2>
                            <p>
                            	Dersom du har lest gjennom denne Internettsiden og
                            	er klar for &aring; s&oslash;ke deg inn p&aring; BS
                            	s&aring; har du valget mellom &aring; sende en skriftlig,
                            	eller en elektronisk s&oslash;knad. Begge typer s&oslash;knad
                            	blir behandlet med lik verdi.
                            </p>
                          	<h2>Opptak av beboere for h&oslash;sten <?php echo $thisYear;?></h2>
                          	<p>
							  	Opptak av beboere for h&oslash;sten <?php echo $thisYear;?> skjer
							  	fortl&oslash;pende fra og med februar <?php echo $thisYear;?>.
							</p>
                          	<h2>Elektronisk s&oslash;knad</h2>
                          	<p>
                            	Fyll ut alle feltene i formularet under
                            	for &aring; sende en elektronisk s&oslash;knad. Dersom
                            	du ikke har f&aring;tt svar innen 7 arbeidsdager s&aring;
                            	ber vi deg om &aring; sende en ny s&oslash;knad p&aring;
                            	e-post til post@blindern-studenterhjem.no
                            </p>
<?php

$scheme = file_get_contents(dirname(__FILE__)."/../skjema.php");
$navn="";
$kjonn="";
$foednr="";
$mob="";
$tlf="";
$epost="";
$studiested="";
$studium="";
$addr="";
$postnr="";
$hjemaddr="";
$hjempostnr="";
$onsketdato="";
$antMnd="";
$omperson="";
$kommentar="";

if(!isset($_POST['submit'])){
	printf($scheme, $navn, "selected", "", $foednr, $mob, $tlf, $epost, $studiested, $studium, $addr, $postnr, $hjemaddr,
		$hjempostnr,$onsketdato, "selected", "", "", "", "", "", $omperson, $kommentar);
} else {
	$proceed = true;

	//Checks that name is set, it is longer than 5 letters, and contains at least one space
	if(!isset($_POST['navn']) || strlen($_POST['navn']) < 5 || strpos($_POST['navn'], " ")==FALSE){
		$proceed = false;
		$errorMsg[] = "Du har glemt &aring; fylle ut navnet ditt. Både for- og etternavn må fylles inn.";
	} else
		$navn = strip_tags($_POST['navn']);

	//Validates the "Kjønn"
	$kjonn = explode(" ", $_POST['kjonn']);
	$kjonn = strip_tags($kjonn[0]);

	//Checks that personnummer is valid
	if(!sjekkFoedselsNr($_POST['personnummer'])){
		$proceed = false;
		$errorMsg[] = "Du har ikke fyllt ut et korrekt personnummer.";
	} else
		$foednr = $_POST['personnummer'];

	//Validates that the phonenumbers are valid, and at leas one of them is correct
	if((isset($_POST['mob']) && sjekkTlf($_POST['mob'])) || (isset($_POST['tlf'])&&sjekkTlf($_POST['tlf']))){
		if(isset($_POST['mob']) && sjekkTlf($_POST['mob']))
			$mob = $_POST['mob'];
		if(isset($_POST['tlf']) && sjekkTlf($_POST['tlf']))
			$tlf = $_POST['tlf'];
	} else {
		$proceed = false;
		$errorMsg[] = "Du m&aring; fylle ut minst ett mobilnummer.";
	}

	//Validates the epost.
	if(!sjekkEpost($_POST['epost'])){
		$proceed = false;
		$errorMsg[] = "Du m&aring; fylle ut en korrekt e-post adresse.";
	} else
		$epost = $_POST['epost'];

	//Validates that at studiested is set
	if(!isset($_POST['studiested']) || strlen($_POST['studiested']) < 1){
		$proceed = false;
		$errorMsg[] = "Du m&aring; fylle ut studiested.";
	} else
		$studiested = strip_tags($_POST['studiested']);

	//Validates that studium is set
	if(!isset($_POST['studium'])|| strlen($_POST['studium'])<1 ){
		$proceed = false;
		$errorMsg[] = "Du m&aring; fylle ut studium.";
	} else
		$studium = strip_tags($_POST['studium']);

	//Validates that at least one adress is set
	if((isset($_POST['hjemaddr'])&& isset($_POST['hjempostnr'])) || (isset($_POST['addr']) && isset($_POST['postnr']))){
		if(isset($_POST['hjemaddr'])&&isset($_POST['hjempostnr'])){
			$hjemaddr = strip_tags($_POST['hjemaddr']);
			$hjempostnr = strip_tags($_POST['hjempostnr']);
		}
		if(isset($_POST['addr'])&&isset($_POST['postnr'])) {
			$addr = strip_tags($_POST['addr']);
			$postnr = strip_tags($_POST['postnr']);
		}
	} else {
		$proceed = false;
		$errorMsg[] = "Du m&aring; fylle ut adresse og postnummer p&aring; opprinnelig bosted";
	}

	//Validates that a wished date for moving in is pressent
	if(!sjekkDato($_POST['onsketdato'])){
		$proceed = false;
		$errorMsg[] = "Du m&aring; fylle ut en &oslash;nsket innflyttingsdato";
	} else {
		$onsketdato = strip_tags($_POST['onsketdato']);
	}

	//Validates that number of months wished is set
	$antMnd = explode(" ", $_POST['antMnd']);
	$antMnd = (is_numeric($antMnd[0])) ? $antMnd[0] : "1";

	//Validates that omperson is filled in
	if(!isset($_POST['omperson'])||strlen($_POST['omperson']) <1 ){
		$proceed = false;
		$errorMsg[] = "Du m&aring; skrive litt om deg selv, og dine interesser.";
	} else
		$omperson = strip_tags($_POST['omperson']);

	//Validates the kommentar-field
	if(isset($_POST['kommentar']))
		$kommentar = strip_tags($_POST['kommentar']);

	if($proceed){
		$sendtMessage = sendEmail($navn, $kjonn, $foednr, $mob, $tlf, $epost,
				$studiested, $studium, $addr, $postnr, $hjemaddr, $hjempostnr,
				$onsketdato, $antMnd, $omperson, $kommentar);
	} else {
		echo "<h2 style='background-color:red'>S&oslash;knaden ble ikke sendt!</h2>";
		foreach($errorMsg as $melding)
			echo "<p>".$melding."</p>";
		$scheme = file_get_contents(dirname(__FILE__)."/../skjema.php");

		$antMndSel[$antMnd-1] = "selected";
		printf($scheme, $navn, $kjonnSel[0], $kjonnSel[1], $foednr, $mob, $tlf, $epost,
				$studiested, $studium, $addr, $postnr, $hjemaddr, $hjempostnr,
				$onsketdato, $antMndSel[0], $antMndSel[1], $antMndSel[2], $antMndSel[3],
				$antMndSel[4], $antMndSel[5], $omperson, $kommentar);
	}
	echo "<h2>Meldingen er sendt</h2>";
	echo "<p>F&oslash;lgende s&oslash;knad er sendt, og du skal ha mottatt en kopi av den per mail:</p><pre>";
	echo $sendtMessage."</pre><br><br><p>Dersom du skulle ha yttligere sp&oslash;rsm&aring;l, ";
	echo "eller noe er galt med s&oslash;knaden, ta kontakt med oss p&aring; <a href='mailto:post@blinderen-studenterhjem.no'>";
	echo "post@blinderen-studenterhjem.no</a></p>";
}

function sjekkFoedselsNr($foedselsnr) {
	if(is_numeric($foedselsnr) && strlen($foedselsnr) > 10)
		return true;
	else
		return false;
}
function sjekkTlf($tlf){
	if(is_numeric($tlf)&& strlen($tlf) > 7)
		return true;
	else
		return false;
}
function sjekkDato($dato){
	if(strlen($dato)<4)
		return false;
	else
		return true;
}
function sjekkEpost($epost){
	$pattern = "/^((\\\"[^\\\"\\f\\n\\r\\t\\b]+\\\")|([A-Za-z0-9_][A-Za-z0-9_\\!\\#\\$\\%\\&\\'\\*\\+\\-\\~\\/\\=\\?\\^\\`\\|\\{\\}]*(\\.[A-Za-z0-9_\\!\\#\\$\\%\\&\\'\\*\\+\\-\\~\\/\\=\\?\\^\\`\\|\\{\\}]*)*))@((\\[(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))\\])|(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))|((([A-Za-z0-9])(([A-Za-z0-9\\-])*([A-Za-z0-9]))?(\\.(?=[A-Za-z0-9\\-]))?)+[A-Za-z]+))$/D";
	return preg_match($pattern, $epost);
}
function sendEmail($navn, $kjonn,$foednr, $mob, $tlf, $epost, $studiested, $studium, $addr, $postnr, $hjemaddr, $hjempostnr,$onsketdato, $antMnd, $omperson, $kommentar){
	$to = "post@blindern-studenterhjem.no";
	$subject = "Soknad: Blindern-Studenterhjem";
	$headers .= "To: Blindern Studenterhjem <post@blindern-studenterhjem.no> \r\n";
	$headers = "From: ".$navn." <".$epost."> \r\n";
	$headers .= "Replay-To: ".$epost."\r\nContent-Type: text/plain; charset=UTF-8\r\n";
	$headers .= "Cc: hjemmesideoppmann@blindern-studenterhjem.no \r\n";
	$message = 	"Navn: ".$navn."\r\n" .
				"Kjønn: ".$kjonn."\r\n" .
				"Personnummer: ".$foednr."\r\n" .
				"Mobil tlf.: ".$mob."\r\n" .
				"Fast tlf.: ".$tlf."\r\n" .
				"E-post: ".$epost."\r\n" .
				"Studiested: ".$studiested."\r\n" .
				"Studium: ".$studium."\r\n" .
				"Nåværende Bosted \r\n" .
				"Adresse: ".$addr."\r\n" .
				"Postnr og sted: ".$postnr."\r\n".
				"Opprinnelig bosted\r\n".
				"Adresse: ".$hjemaddr."\r\n".
				"Postnr og sted: ".$hjempostnr."\r\n".
				"Ønsket innflyttningsdato: ".$onsketdato."\r\n".
				"Ant. mnd søknaden gjelder: ".$antMnd."\r\n".
				"Beskrivelse: ".$omperson."\r\n".
				"Annet: ".$kommentar."\r\n".
				"\r\n\r\nSøknad sendt dato: ".date("d.M Y \k\l:H:i:s");
	mail($to, $subject, $message, $headers);
	$messageToSender = "Følgende søknad er bekreftet mottatt:\n".$message;
	$messageToSender .= "\n\nBehandlingstiden er maks 7 dager. Dersom vi ikke har tatt kontakt innen dette, ".
						"kan det være at vi alikevell ikke har mottatt din søknad. Vi ber deg derfor sende en beskjed ".
						"til post@blindern-studenterhjem.no og legge ved denne søknaden.\n\n".
						"Skulle du ha yttligere spørsmål, kan du kontakte kontoret på telefon 23 33 15 00 i kontortiden ".
						"mellom 09.00 - 15.00 på hverdager.";

	//Dette er en funksjon som aktiveres når søknaden ikke vil bli besvart innen syv dager.
/*
	if(date("md")>"0509" && date("md")< "0518"){
		$awayMessage = "\n\nOBS! OBS!\nPå grunn av ferie vil ikke søknaden din bli behandlet før tidligst\n18.Mai, og senest 26.Mai. ".
					"Spørsmål kan i \nmellomtiden rettes til daglig leder på tlf 23 33 15 58, og vi \nvil ta kontakt når søknaden er behandlet.";
		$message .= $awayMessage;
		$messageToSender .= $awayMessage;
	}

	//Varsling om at dette må fjernes når tider er ute...
	if(date("md") == "0504" || date("md")> "0519"){
		mail("simen@buodd.no", "Fjern away-melding", "Nå må du huske å fjerne 'away' meldingen fra BS-sidene!!!", "Replay-To: none");
	}
*/
	$headers = "To: ".$navn." <".$epost."> \r\n";
	$headers .= "From: Blindern Studenterhjem <post@blindern-studenterhjem.no> \r\n";
	$headers .= "Replay-To: post@blindern-studenterhjem.no \r\n";
	$headers .= "Replay-To: ".$epost."\r\nContent-Type: text/plain; charset=UTF-8\r\n";
	mail($epost, "Bekreftelse paa soknad til Blindern Studenterhjem", $messageToSender, $headers);
	return $message;
}
?>