<?php

bs_side::set_title("Søk om plass");

class bs_soknad
{
	protected static $error = array();
	protected static $sent = false;
	
	public static function main()
	{
		if (isset($_POST['submit']))
		{
			self::process();
		}
		
		if (!self::$sent) self::show_form();
	}
	
	protected static function process()
	{
		$data = array(
			"name" => postval("navn"),
			"gender" => postval("kjonn"),
			"birth" => postval("birth"),
			"mobile" => postval("mob"),
			"phone" => postval("tlf"),
			"email" => postval("epost"),
			"studiested" => postval("studiested"),
			"studium" => postval("studium"),
			"adresse" => postval("addr"),
			"postnr" => postval("postnr"),
			"hjem_adresse" => postval("hjemaddr"),
			"hjem_postnr" => postval("hjempostnr"),
			"onsket_dato" => postval("onsketdato"),
			"antall_mnd" => postval("antMnd"),
			"beskrivelse" => postval("omperson"),
			"annet" => postval("kommentar")
		);
		foreach ($data as &$val) $val = trim($val);
		
		// kontroller navn
		if (empty($data['name']))
		{
			self::$error['name'] = "Må fylles inn";
		}
		elseif (mb_strlen($data['name']) < 5)
		{
			self::$error['name'] = "For kort";
		}
		
		// kontroller kjønn
		if ($data['gender'] != "Mann" && $data['gender'] != "Kvinne")
		{
			self::$error['gender'] = "Må fylles inn";
		}
		
		// kontroller fødselsdato
		if (empty($data['birth']))
		{
			self::$error['birth'] = "Må fylles inn";
		}
		elseif (!self::check_birth($data['birth']))
		{
			self::$error['birth'] = "Ugyldig, må være på formen dd.mm.yyyy";
		}
		
		// kontroller telefonnummer
		$phone = false;
		
		if (!empty($data['mobile']))
		{
			$phone = true;
			if (!self::check_phone($data['mobile']))
			{
				self::$error['mobile'] = "Ugyldig";
			}
		}
		
		if (!empty($data['tlf']))
		{
			$phone = true;
			if (!self::check_phone($data['tlf']))
			{
				self::$error['tlf'] = "Ugyldig";
			}
		}
		
		if (!$phone)
		{
			self::$error['mobile'] = "Minst ett nummer må fylles inn";
		}
		
		// kontroller e-post
		if (empty($data['email']))
		{
			self::$error['email'] = "Må fylles inn";
		}
		elseif (!self::check_email($data['email']))
		{
			self::$error['email'] = "Ugyldig";
		}
		
		// kontroller studiested
		if (empty($data['studiested']))
		{
			self::$error['studiested'] = "Må fylles inn";
		}
		if (empty($data['studium']))
		{
			self::$error['studium'] = "Må fylles inn";
		}
		
		// kontroller adresser
		$addr = false;
		
		if (!empty($data['adresse']))
		{
			$addr = true;
			if (empty($data['postnr']))
			{
				self::$error['postnr'] = "Må fylles inn";
			}
		}
		
		if (!empty($data['hjem_adresse']))
		{
			$addr = true;
			if (empty($data['hjem_postnr']))
			{
				self::$error['hjem_postnr'] = "Må fylles inn";
			}
		}
		
		if (!$addr)
		{
			self::$error['adresse'] = "Minst en adresse må fylles inn";
		}
		
		// kontroller ønsket dato for innflytting
		if (empty($data['onsket_dato']))
		{
			self::$error['onsket_dato'] = "Må fylles inn";
		}
		#elseif (!self::check_date($data['onsket_dato']))
		#{
		#	self::$error['onsket_dato'] = "Ugyldig";
		#}
		
		// kontroller antall måneder søknaden skal være gyldig
		if ($data['antall_mnd'] == "")
		{
			self::$error['antall_mnd'] = "Må fylles inn";
		}
		elseif (!is_numeric($data['antall_mnd']))
		{
			self::$error['antall_mnd'] = "Ugyldig";
		}
		
		// kontroller beskrivelse
		if (empty($data['beskrivelse']))
		{
			self::$error['beskrivelse'] = "Du må skrive litt om deg selv og dine interesser.";
		}
		
		// skal vi sende søknaden?
		if (count(self::$error) == 0)
		{
			// send søknad
			$ret = self::send_email($data);
			
			echo '
		<h2>Søknad sendt</h2>
		<p>Takk for din søknad!</p>
		<p>Søknaden din er nå sendt, og du skal også ha mottatt en kvittering på e-posten din. Din søknad inneholdt følgende:</p>
		<pre class="soknad_sendt_tekst">
'.htmlspecialchars($ret).'</pre>
		<p>Dersom du skulle ha ytterligere spørsmål eller det er noe galt med søknaden, ta kontakt med oss på <a href="mailto:post@blindern-studenterhjem.no">post@blindern-studenterhjem.no</a>. Svar gjerne på kvitteringen du har fått på e-post.</p>';
			
			self::$sent = true;
		}
	}
	
	protected static function get_error($name, $format = null)
	{
		if (isset(self::$error[$name]))
		{
			$data = ' <span class="soknad_feil">'.self::$error[$name].'</span>';
			if ($format) return sprintf($format, $data);
			return $data;
		}
		
		return '';
	}
	
	protected static function show_form()
	{
		echo '
			<h2>Elektronisk s&oslash;knad</h2>
			<p>
				Fyll ut alle feltene i formularet under
				for &aring; sende en elektronisk s&oslash;knad. Dersom
				du ikke har f&aring;tt svar innen 7 arbeidsdager s&aring;
				ber vi deg om &aring; sende en ny s&oslash;knad p&aring;
				e-post til <a href="mailto:post@blindern-studenterhjem.no">post@blindern-studenterhjem.no</a>.
			</p>';
		
		if (count(self::$error) > 0)
		{
			echo '
			<p class="soknad_feil_info">Søknaden ble ikke korrekt fylt ut og er <u>ikke</u> sendt inn. Korriger feilene nedenfor og send inn på nytt.</p>';
		}
		
		echo '
			<form action="" method="POST">
				<fieldset class="soknadsskjema">
					<legend>Søknad om plass på Blindern Studenterhjem</legend>
					<h3>Personalia</h3>
					<dl>
						<dt><label for="navn">Navn</label></dt>
						<dd><input type=text name="navn" id="name" value="'.htmlspecialchars(postval("navn")).'" />*'.self::get_error("name").'</dd>
						
						<dt><label for="kjonn">Kjønn</label></dt>
						<dd><select name="kjonn" id="kjonn">';
		
		$opt = postval("kjonn");
		if ($opt != "Mann" && $opt != "Kvinne" && $opt != "") $opt =  "";
		
		if ($opt == "") echo '
								<option value="">Velg..</option>';
		
		echo '
								<option value="Mann"'.($opt == "Mann" ? ' selected="selected"' : '').'>Mann</option>
								<option value="Kvinne"'.($opt == "Kvinne" ? ' selected="selected"' : '').'>Kvinne</option>
						</select>*'.self::get_error("gender").'</dd>
						
						<dt><label for="birth">Fødselsdato</label></dt>
						<dd><input type="text" name="birth" id="birth" value="'.htmlspecialchars(postval("birth")).'" />*'.self::get_error("birth").'</dd>
						
						<dt><label for="mob">Mobiltelefonnr</label></dt>
						<dd><input type="text" name="mob" id="mob" value="'.htmlspecialchars(postval("mob")).'" />'.self::get_error("mobile").'</dd>
						
						<dt><label for="tlf">Evt. fasttelefon</label></dt>
						<dd><input type="text" name="tlf" id="tlf" value="'.htmlspecialchars(postval("tlf")).'" />'.self::get_error("phone").'</dd>
						
						<dt><label for="epost">E-post</label></dt>
						<dd><input type="text" name="epost" id="epost" value="'.htmlspecialchars(postval("epost")).'" />*'.self::get_error("email").'</dd>
						
						<dt><label for="studiested">Studiested</label></dt>
						<dd><input type="text" name="studiested" id="studiested" value="'.htmlspecialchars(postval("studiested")).'" />*'.self::get_error("studiested").'</dd>
						
						<dt><label for="studium">Studium</label></dt>
						<dd><input type="text" name="studium" id="studium" value="'.htmlspecialchars(postval("studium")).'" />*'.self::get_error("studium").'</dd>
					</dl>
					
					<h3>N&aring;v&aelig;rende Bosted</h3>
					<dl>
						<dt><label for="addr">Adresse</label></dt>
						<dd><input type="text" name="addr" id="addr" value="'.htmlspecialchars(postval("addr")).'" />'.self::get_error("adresse").'</dd>
						
						<dt><label for="postnr">Postnummer og sted</label></dt>
						<dd><input type="text" name="postnr" id="postnr" value="'.htmlspecialchars(postval("postnr")).'" />'.self::get_error("postnr").'</dd>
					</dl>
					
					<h3>Opprinnelig bosted (hjemstedsadresse)</h3>
					<dl>
						<dt><label for="hjemaddr">Adresse</label></dt>
						<dd><input type="text" name="hjemaddr" id="hjemaddr" value="'.htmlspecialchars(postval("hjemaddr")).'" />'.self::get_error("hjem_adresse").'</dd>
						
						<dt><label for="hjempostnr">Postnummer og sted</label></dt>
						<dd><input type="text" name="hjempostnr" id="hjempostnr" value="'.htmlspecialchars(postval("hjempostnr")).'" />'.self::get_error("hjem_postnr").'</dd>
					</dl>
					
					<h3>Om søknaden</h3>
					<dl>
						<dt><label for="onsketdato">&Oslash;nsket innflyttningsdato</label></dt>
						<dd><input type="text" name="onsketdato" id="onsketdato" value="'.htmlspecialchars(postval("onsketdato")).'" />*'.self::get_error("onsket_dato").'</dd>
					</dl>
					
					<p><label for="antMnd">Dersom du ikke får plass ved hjemmet til den datoen du ønsker, hvor mange måneder vil du at søknaden skal gjelde etter denne datoen?</label>
						<select name="antMnd" id="antMnd">';
		
		for ($i = 1; $i <= 6; $i++)
		{
			echo '
								<option value="'.$i.'"'.($i == postval("antMnd") ? ' selected="selected"' : '').'>'.$i.'</option>';
		}
		
		echo '
						</select>'.self::get_error("antall_mnd").'
					</p>
					
					<p><label for="omperson">
							Skriv en beskrivelse av deg selv og dine
							interesser. Dette kreves for at din søknad
							skal tas i betraktning. Skriv ogs&aring; navn på
							tidligere beboere eller n&aring;v&aelig;rende beboere
							dersom du ønsker/har referanser. <!--Se tekst
							om hva som legges vekt på ved søknad her.-->
							</label><br />'.self::get_error("beskrivelse", '%s<br />').'
						<textarea name="omperson" cols="40" rows="8" id="omperson">'.htmlspecialchars(postval("omperson")).'</textarea>*
					</p>
					
					<p>
						<label for="kommentar">Kommentarer eller &oslash;vrige opplysninger</label><br />'.self::get_error("annet", '%s<br />').'
						<textarea name="kommentar" cols="40" rows="5" class="text_contact" id="kommentar">'.htmlspecialchars(postval("kommentar")).'</textarea>
					</p>
					
					<p class="soknad_submit"><input type="submit" value="Send søknad" name="submit" /></p>
				</fieldset>
			</form>';
	}
	
	/**
	 * Kontroller telefonnnummer
	 * @param $tlf
	 */
	protected static function check_phone($value)
	{
		return preg_match("/^\\+?[\\d]{7,}$/", $value);
	}
	
	protected static function check_date($value)
	{
		return strlen($value) >= 4;
	}
	
	protected static function check_email($value)
	{
		$pattern = "/^((\\\"[^\\\"\\f\\n\\r\\t\\b]+\\\")|([A-Za-z0-9_][A-Za-z0-9_\\!\\#\\$\\%\\&\\'\\*\\+\\-\\~\\/\\=\\?\\^\\`\\|\\{\\}]*(\\.[A-Za-z0-9_\\!\\#\\$\\%\\&\\'\\*\\+\\-\\~\\/\\=\\?\\^\\`\\|\\{\\}]*)*))@((\\[(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))\\])|(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))|((([A-Za-z0-9])(([A-Za-z0-9\\-])*([A-Za-z0-9]))?(\\.(?=[A-Za-z0-9\\-]))?)+[A-Za-z]+))$/D";
		return preg_match($pattern, $value);
	}
	
	protected static function send_email($data)
	{
		#$to = "post@blindern-studenterhjem.no";
		$to = "henrist@henrist.net";
		$subject = "Søknad for Blindern Studenterhjem";
		
		$headers = "To: Henrik Steen <henrist@henrist.net>\r\n";
		$headers .= "From: {$data['name']} <{$data['email']}>\r\n";
		$headers .= "Reply-To: {$data['email']} <{$data['email']}>\r\n";
		$headers .= "Content-Type: text/plain; charset=utf-8\r\n";
		$headers .= "Cc: hjemmesideoppmann@blindern-studenterhjem.no\r\n";
		
		$message = 'Søknad mottatt for Blindern Studenterhjem:

Navn:               '.$data['name'].'
Kjønn:              '.$data['gender'].'
Fødselsdato:        '.$data['birth'].' ('.self::calc_age($data['birth']).' år)

Mobil:              '.$data['mobile'].'
Telefon:            '.$data['phone'].'
E-post:             '.$data['email'].'

Studiested:         '.$data['studiested'].'
Studium:            '.$data['studium'].'

Nåværende bosted
Adresse:            '.$data['adresse'].'
Postnr og sted:     '.$data['postnr'].'

Opprinnelig bosted
Adresse:            '.$data['hjem_adresse'].'
Postnr og sted:     '.$data['hjem_postnr'].'

Ønsket innflyttingsdato:   '.$data['onsket_dato'].'
Ant. mnd søknaden gjelder: '.$data['antall_mnd'].'

Beskrivelse:
'.$data['beskrivelse'].'

Annet:
'.$data['annet'].'


Søknaden ble sendt '.date("j.n.Y H:i:s");
		
		mail($to, $subject, $message, $headers);
		
		// melding til avsender
		$message_receipt = 'Kvittering for mottatt søknad:

'.$message.'

Behandlingstiden er maks 7 dager. Dersom vi ikke har tatt kontakt innen dette, kan det være at vi allikevel ikke har mottatt din søknad. Vi ber deg derfor svare på denne e-posten, slik at vi kan bekrefte at den er mottatt.

Skulle du ha ytterligere spørsmål, kan du kontakte kontoret på telefon 23 33 15 00 i kontortiden mellom 09.00 - 15.00 på hverdager. Se også www.blindern-studenterhjem.no for oppdatert informasjon.';
		
		$headers = "To: {$data['name']} <{$data['email']}>\r\n";
		$headers .= "From: Blindern Studenterhjem <post@blindern-studenterhjem.no>\r\n";
		$headers .= "Content-Type: text/plain; charset=utf-8\r\n";
		
		mail($data['email'], "Kvittering for søknad til Blindern Studenterhjem", $message_receipt, $headers);
		
		return $message;
	}
	
	/**
	 * Kontroller fødselsdato
	 */
	protected static function check_birth($value)
	{
		return preg_match("/^(0?[1-9]|[1-2][0-9]|3[0-1])\\.(0?[1-9]|1[0-2])\\.((?:19|20)\\d\\d)\$/", $value);
	}
	
	/**
	 * Kalkuler alder
	 */
	protected static function calc_age($birth)
	{
		// fødselsdato
		$birth = explode(".", $birth);
		
		// alder
		$date = new DateTime();
		$date->setTimezone(new DateTimeZone("Europe/Oslo"));
		$n_day = $date->format("j");
		$n_month = $date->format("n");
		$n_year = $date->format("Y");
		
		return ($n_year - $birth[2] - (($n_month < $birth[1] || ($birth[1] == $n_month && $n_day < $birth[0])) ? 1 : 0));
	}
}

$thisYear = date("Y");

echo '
			<h1>S&oslash;knad om plass</h1>
			<h2>S&oslash;knadsskjema</h2>
			<p>
				Dersom du har lest gjennom denne Internettsiden og
				er klar for &aring; s&oslash;ke deg inn p&aring; BS
				s&aring; har du valget mellom &aring; sende en skriftlig,
				eller en elektronisk s&oslash;knad. Begge typer s&oslash;knad
				blir behandlet med lik verdi.
			</p>
			<h2>Opptak av beboere for h&oslash;sten '.$thisYear.'</h2>
			<p>
				Opptak av beboere for h&oslash;sten '.$thisYear.' skjer
				fortl&oslash;pende fra og med februar '.$thisYear.'.
			</p>';

bs_soknad::main();