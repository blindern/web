<?php

bs_side::set_title("Søk om plass");
bs_side::$lang_crosslink['en'] = "en/who_can_apply/application";

class bs_soknad
{
	protected static $error = array();
	protected static $sent = false;
	
	protected static $lang = array(
		"missing"          => array("Må fylles inn", "Must be filled"),
		"invalid_birth"    => array("Ugyldig, må være på formen dd.mm.yyyy", "Invalid, must be dd.mm.yyyy"),
		"invalid"          => array("Ugyldig", "Invalid"),
		"to_short"         => array("For kort", "To short"),
		"number_missing"   => array("Minst ett nummer må fylles inn", "At least one number must be filled"),
		"address_missing"  => array("Minst en adresse må fylles inn", "At least one address must be filled"),
		"desc_missing"     => array("Du må skrive litt om deg selv og dine interesser.", "You must write a bit about yourself and your interests."),
		"sent"             => array('
			<h2>Søknad sendt</h2>
			<p>Takk for din søknad!</p>
			<p>Søknaden din er nå sendt, og du skal også ha mottatt en kvittering på e-posten din. Din søknad inneholdt følgende:</p>
			<p class="soknad_sendt_tekst">%s</p>
			<p>Dersom du skulle ha ytterligere spørsmål eller det er noe galt med søknaden, ta kontakt med oss på <a href="mailto:post@blindern-studenterhjem.no">post@blindern-studenterhjem.no</a>. Svar gjerne på kvitteringen du har fått på e-post.</p>', '
			<h2>Application sent</h2>
			<p>Thank you for your appliaction!</p>
			<p>Your appliaction is now sent. You will receive a receipt on your email. Your application contained the following:</p>
			<p class="soknad_sendt_tekst">%s</p>
			<p>If you have any further questions or you miswrote anything, please contact us at <a href="mailto:post@blindern-studenterhjem.no">post@blindern-studenterhjem.no</a>. You may reply to your receipt on your email as well.</p>'),
		
		"app_1"            => array('
			<h2>Elektronisk s&oslash;knad</h2>
			<p>
				Fyll ut alle feltene i formularet under
				for &aring; sende en elektronisk s&oslash;knad. Dersom
				du ikke har f&aring;tt svar innen 7 arbeidsdager s&aring;
				ber vi deg om &aring; sende en ny s&oslash;knad p&aring;
				e-post til <a href="mailto:post@blindern-studenterhjem.no">post@blindern-studenterhjem.no</a>.
			</p>', '
			<h2>Electronic application</h2>
			<p>Fill in the fields below to send an electronic application. If you do not get any reply within 7 work days,
				we ask you to send a new application by email to <a href="mailto:post@blindern-studenterhjem.no">post@blindern-studenterhjem.no</a>.</p>'),
		"app_error"        => array('
			<p class="soknad_feil_info">Søknaden ble ikke korrekt fylt ut og er <span class="u">ikke</span> sendt inn. Korriger feilene nedenfor og send inn på nytt.</p>', '
			<p class="soknad_feil_info">Your application was not filled correctly and is <span class="u">not</span> sent. Correct the errors below and try again.</p>'),
		"app_legend"       => array('Søknad om plass på Blindern Studenterhjem', 'Application for Blindern Studenterhjem'),
		"app_personal"     => array("Personalia", "Personal"),
		"app_name"         => array("Navn", "Name"),
		"app_gender"       => array("Kjønn", "Gender"),
		"app_gender_select" => array("Velg..", "Select.."),
		"app_gender_Mann"  => array("Mann", "Male"),
		"app_gender_Kvinne" => array("Kvinne", "Female"),
		"app_birth"        => array("Fødselsdato", "Date of birth"),
		"app_mobile"       => array("Mobiltelefonnr.", "Mobile number"),
		"app_phone"        => array("Evt. fasttelefon", "Any landline"),
		"app_email"        => array("E-post", "Email"),
		"app_studyplace"   => array("Studiested", "Study place"),
		"app_study"        => array("Studium", "Study"),
		"app_homeaddr"     => array("Hjemstedsadresse", "Home address"),
		"app_addr"         => array("Addresse", "Street address"),
		"app_place"        => array("Postnummer og sted", "Postal code, city and country"),
		"app_nowaddr"      => array("Nåværende bosted", "Current residence"),
		"app_rel"          => array("Relevante opplysninger", "Relevant information"),
		"app_allergies"    => array("Allergier", "Allergies"),
		"app_about"        => array("Om søknaden", "About the application"),
		"app_joindate"     => array("Ønsket innflyttingsdato", "Desired date to move in"),
		"app_num_months"   => array('Dersom du ikke får plass ved hjemmet til den datoen du ønsker, hvor mange måneder vil du at søknaden skal gjelde etter denne datoen?',
		                          'If you cannot move in at this date, for how many months do you want the application to be valid after this date?'),
		"app_about_person" => array('Skriv en beskrivelse av deg selv og dine interesser. Dette kreves for at din søknad skal tas i betraktning. Skriv også navn på tidligere beboere eller nåværende beboer du ønsker/har referanser.',
		                          'Write a description of yourself and your interests. This is required for your application to be considered. Write the names of former residents or current residents should you have any references.'),
		"app_comment"      => array('Kommentarer eller øvrige opplysninger', 'Comments or other information'),
		"app_submit"       => array("Send søknad", "Send application"),
		
		"receipt_subject"  => array('Kvittering for =?UTF-8?B?c8O4a25hZCB0aWwgQmxpbmRlcm4gU3R1ZGVu?=  =?UTF-8?B?dGVyaGplbQ==?=' /* Kvittering for søknad til Blindern Studenterhjem */, 'Receipt for application for Blindern Studenterhjem'),
		"email"            => array(
			'Søknad mottatt for Blindern Studenterhjem:

Navn:               %s
Kjønn:              %s
Fødselsdato:        %s (%s år)

Mobil:              %s
Telefon:            %s
E-post:             %s

Studiested:         %s
Studium:            %s

Hjemstedsadresse
Adresse:            %s
Postnr og sted:     %s

Nåværende bosted
Adresse:            %s
Postnr og sted:     %s

Allergi:            %s

Ønsket innflyttingsdato:   %s
Ant. mnd søknaden gjelder: %s

Beskrivelse:
%s

Annet:
%s


Søknaden ble sendt %s',
		'Application for Blindern Studenterhjem received:

Name:               %s
Gender:             %s
Date of birth:      %s (%s years)

Mobile:             %s
Phone:              %s
E-mail:             %s

Study place:        %s
Study:              %s

Home address
Street address:     %s
Postal code etc.:   %s

Current residence
Street address:     %s
Postal code etc.:   %s

Allergies:          %s

Wanted move in date:                %s
Months for application to be valid: %s

Description:
%s

Comments:
%s


Application was sent on %s'),
		"receipt_text" => array(
			'Kvittering for mottatt søknad:

%s

Behandlingstiden er maks 7 dager. Dersom vi ikke har tatt kontakt innen dette, kan det være at vi allikevel ikke har mottatt din søknad. Vi ber deg derfor svare på denne e-posten, slik at vi kan bekrefte at den er mottatt.

Skulle du ha ytterligere spørsmål, kan du kontakte kontoret på telefon 23 33 15 00 i kontortiden mellom 09.00 - 15.00 på hverdager. Se også www.blindern-studenterhjem.no for oppdatert informasjon.',
			'Receipt for application:

%s

Processing time is maximum 7 days. If we do not contact you within this, it might be because we accidentally didn\'t receive your application. We then ask you to reply to this e-mail, so that we can confirm it has been received.

If you have any futher questions, you can contact the administration on phone (+47) 23 33 15 00 in office time between 09.00-15.00 weekdays (CET/CEST). See also www.blindern-studenterhjem.no/en for updated information.')
	);
	
	protected static function get_lang($name)
	{
		if (!isset(self::$lang[$name])) throw new Exception("Språkdata mangler.");
		
		if (bs_side::$lang == "en") return self::$lang[$name][1];
		return self::$lang[$name][0];
	}
	
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
			"annet" => postval("kommentar"),
			"allergi" => postval("allergi")
		);
		foreach ($data as &$val) $val = trim($val);
		
		// kontroller navn
		if (empty($data['name']))
		{
			self::$error['name'] = self::get_lang("missing");
		}
		elseif (mb_strlen($data['name']) < 5)
		{
			self::$error['name'] = self::get_lang("to_short");
		}
		
		// kontroller kjønn
		if ($data['gender'] != "Mann" && $data['gender'] != "Kvinne")
		{
			self::$error['gender'] = self::get_lang("missing");
		}
		
		// kontroller fødselsdato
		if (empty($data['birth']))
		{
			self::$error['birth'] = self::get_lang("missing");
		}
		elseif (!self::check_birth($data['birth']))
		{
			self::$error['birth'] = self::get_lang("invalid_birth");
		}
		
		// kontroller telefonnummer
		$phone = false;
		
		if (!empty($data['mobile']))
		{
			$phone = true;
			if (!self::check_phone($data['mobile']))
			{
				self::$error['mobile'] = self::get_lang("invalid");
			}
		}
		
		if (!empty($data['tlf']))
		{
			$phone = true;
			if (!self::check_phone($data['tlf']))
			{
				self::$error['tlf'] = self::get_lang("invalid");
			}
		}
		
		if (!$phone)
		{
			self::$error['mobile'] = self::get_lang("number_missing");
		}
		
		// kontroller e-post
		if (empty($data['email']))
		{
			self::$error['email'] = self::get_lang("missing");
		}
		elseif (!self::check_email($data['email']))
		{
			self::$error['email'] = self::get_lang("invalid");
		}
		
		// kontroller studiested
		if (empty($data['studiested']))
		{
			self::$error['studiested'] = self::get_lang("missing");
		}
		if (empty($data['studium']))
		{
			self::$error['studium'] = self::get_lang("missing");
		}
		
		// kontroller adresser
		$addr = false;
		
		if (!empty($data['adresse']))
		{
			$addr = true;
			if (empty($data['postnr']))
			{
				self::$error['postnr'] = self::get_lang("missing");
			}
		}
		
		if (!empty($data['hjem_adresse']))
		{
			$addr = true;
			if (empty($data['hjem_postnr']))
			{
				self::$error['hjem_postnr'] = self::get_lang("missing");
			}
		}
		
		if (!$addr)
		{
			self::$error['hjem_adresse'] = self::get_lang("address_missing");
		}
		
		// kontroller ønsket dato for innflytting
		if (empty($data['onsket_dato']))
		{
			self::$error['onsket_dato'] = self::get_lang("missing");
		}
		
		// kontroller antall måneder søknaden skal være gyldig
		if ($data['antall_mnd'] == "")
		{
			self::$error['antall_mnd'] = self::get_lang("missing");
		}
		elseif (!is_numeric($data['antall_mnd']))
		{
			self::$error['antall_mnd'] = self::get_lang("invalid");
		}
		
		// kontroller beskrivelse
		if (empty($data['beskrivelse']))
		{
			self::$error['beskrivelse'] = self::get_lang("desc_missing");
		}
		
		// skal vi sende søknaden?
		if (count(self::$error) == 0)
		{
			// send søknad
			$ret = self::send_email($data);
			
			$ret = self::create_html($ret);
			
			echo sprintf(self::get_lang("sent"), $ret);
			self::$sent = true;
		}
	}
	
	protected static function create_html($text)
	{
		$text = htmlspecialchars($text, null, "UTF-8");
		$text = str_replace("  ", "&nbsp;&nbsp;", $text);
		$text = nl2br($text);
		
		return $text;
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
		echo self::get_lang("app_1");
		
		if (count(self::$error) > 0)
		{
			echo self::get_lang("app_error");
		}
		
		echo '
			<form action="" method="POST">
				<fieldset class="soknadsskjema">
					<legend>'.self::get_lang("app_legend").'</legend>
					<h3 style="margin-top: 0">'.self::get_lang("app_personal").'</h3>
					<dl>
						<dt><label for="navn">'.self::get_lang("app_name").'</label></dt>
						<dd><input type="text" class="soknad_felt" name="navn" id="navn" value="'.htmlspecialchars(postval("navn")).'" />*'.self::get_error("name").'</dd>
						
						<dt><label for="kjonn">'.self::get_lang("app_gender").'</label></dt>
						<dd><select name="kjonn" id="kjonn">';
		
		$opt = postval("kjonn");
		if ($opt != "Mann" && $opt != "Kvinne" && $opt != "") $opt =  "";
		
		if ($opt == "") echo '
								<option value="">'.self::get_lang("app_gender_select").'</option>';
		
		echo '
								<option value="Mann"'.($opt == "Mann" ? ' selected="selected"' : '').'>'.self::get_lang("app_gender_Mann").'</option>
								<option value="Kvinne"'.($opt == "Kvinne" ? ' selected="selected"' : '').'>'.self::get_lang("app_gender_Kvinne").'</option>
						</select>*'.self::get_error("gender").'</dd>
						
						<dt><label for="birth">'.self::get_lang("app_birth").'</label></dt>
						<dd><input type="text" class="soknad_felt_lite" name="birth" id="birth" value="'.htmlspecialchars(postval("birth")).'" />*'.self::get_error("birth").'</dd>
						
						<dt><label for="mob">'.self::get_lang("app_mobile").'</label></dt>
						<dd><input type="text" class="soknad_felt_lite" name="mob" id="mob" value="'.htmlspecialchars(postval("mob")).'" />'.self::get_error("mobile").'</dd>
						
						<dt><label for="tlf">'.self::get_lang("app_phone").'</label></dt>
						<dd><input type="text" class="soknad_felt_lite" name="tlf" id="tlf" value="'.htmlspecialchars(postval("tlf")).'" />'.self::get_error("phone").'</dd>
						
						<dt><label for="epost">'.self::get_lang("app_email").'</label></dt>
						<dd><input type="text" class="soknad_felt" name="epost" id="epost" value="'.htmlspecialchars(postval("epost")).'" />*'.self::get_error("email").'</dd>
						
						<dt><label for="studiested">'.self::get_lang("app_studyplace").'</label></dt>
						<dd><input type="text" class="soknad_felt" name="studiested" id="studiested" value="'.htmlspecialchars(postval("studiested")).'" />*'.self::get_error("studiested").'</dd>
						
						<dt><label for="studium">'.self::get_lang("app_study").'</label></dt>
						<dd><input type="text" class="soknad_felt" name="studium" id="studium" value="'.htmlspecialchars(postval("studium")).'" />*'.self::get_error("studium").'</dd>
					</dl>
					
					<h3>'.self::get_lang("app_homeaddr").'</h3>
					<dl>
						<dt><label for="hjemaddr">'.self::get_lang("app_addr").'</label></dt>
						<dd><input type="text" class="soknad_felt" name="hjemaddr" id="hjemaddr" value="'.htmlspecialchars(postval("hjemaddr")).'" />'.self::get_error("hjem_adresse").'</dd>
						
						<dt><label for="hjempostnr">'.self::get_lang("app_place").'</label></dt>
						<dd><input type="text" class="soknad_felt" name="hjempostnr" id="hjempostnr" value="'.htmlspecialchars(postval("hjempostnr")).'" />'.self::get_error("hjem_postnr").'</dd>
					</dl>
					
					<h3>'.self::get_lang("app_nowaddr").'</h3>
					<dl>
						<dt><label for="addr">'.self::get_lang("app_addr").'</label></dt>
						<dd><input type="text" class="soknad_felt" name="addr" id="addr" value="'.htmlspecialchars(postval("addr")).'" />'.self::get_error("adresse").'</dd>
						
						<dt><label for="postnr">'.self::get_lang("app_place").'</label></dt>
						<dd><input type="text" class="soknad_felt" name="postnr" id="postnr" value="'.htmlspecialchars(postval("postnr")).'" />'.self::get_error("postnr").'</dd>
					</dl>
					
					<h3>'.self::get_lang("app_rel").'</h3>
					<dl>
						<dt><label for="allergi">'.self::get_lang("app_allergies").'</label></dt>
						<dd><input type="text" class="soknad_felt_stor" name="allergi" id="allergi" value="'.htmlspecialchars(postval("allergi")).'" />'.self::get_error("allergi").'</dd>
					</dl>
					
					<h3>'.self::get_lang("app_about").'</h3>
					<dl>
						<dt><label for="onsketdato">'.self::get_lang("app_joindate").'</label></dt>
						<dd><input type="text" class="soknad_felt" name="onsketdato" id="onsketdato" value="'.htmlspecialchars(postval("onsketdato")).'" />*'.self::get_error("onsket_dato").'</dd>
					</dl>
					
					<p><label for="antMnd">'.self::get_lang("app_num_months").'</label>
						<select name="antMnd" id="antMnd">';
		
		for ($i = 1; $i <= 6; $i++)
		{
			echo '
								<option value="'.$i.'"'.($i == postval("antMnd") ? ' selected="selected"' : '').'>'.$i.'</option>';
		}
		
		echo '
						</select>'.self::get_error("antall_mnd").'
					</p>
					
					<p><label for="omperson">'.self::get_lang("app_about_person").' *</label><br />'.self::get_error("beskrivelse", '%s<br />').'
						<textarea name="omperson" cols="40" rows="8" id="omperson">'.htmlspecialchars(postval("omperson")).'</textarea>
					</p>
					
					<p>
						<label for="kommentar">'.self::get_lang("app_comment").'</label><br />'.self::get_error("annet", '%s<br />').'
						<textarea name="kommentar" cols="40" rows="5" class="text_contact" id="kommentar">'.htmlspecialchars(postval("kommentar")).'</textarea>
					</p>
					
					<p class="soknad_submit"><input type="submit" value="'.self::get_lang("app_submit").'" name="submit" /></p>
				</fieldset>
			</form>';
	}
	
	/**
	 * Kontroller telefonnnummer
	 * @param $tlf
	 */
	protected static function check_phone($value)
	{
		return preg_match("/^\\+?[\\d]{7,}$/u", $value);
	}
	
	protected static function check_date($value)
	{
		return strlen($value) >= 4;
	}
	
	protected static function check_email($value)
	{
		$pattern = "/^((\\\"[^\\\"\\f\\n\\r\\t\\b]+\\\")|([A-Za-z0-9_][A-Za-z0-9_\\!\\#\\$\\%\\&\\'\\*\\+\\-\\~\\/\\=\\?\\^\\`\\|\\{\\}]*(\\.[A-Za-z0-9_\\!\\#\\$\\%\\&\\'\\*\\+\\-\\~\\/\\=\\?\\^\\`\\|\\{\\}]*)*))@((\\[(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))\\])|(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))|((([A-Za-z0-9])(([A-Za-z0-9\\-])*([A-Za-z0-9]))?(\\.(?=[A-Za-z0-9\\-]))?)+[A-Za-z]+))$/Du";
		return preg_match($pattern, $value);
	}
	
	protected static function send_email($data)
	{
		#$to = "post@blindern-studenterhjem.no";
		$to = "henrist@gmail.com";
		$subject = "=?UTF-8?B?U8O4a25hZCBmb3IgQmxpbmRlcm4gU3R1ZGVudGVyaGplbQ==?="; #Søknad for Blindern Studenterhjem
		
		$headers = "To: Henrik Steen <henrist@gmail.com>\r\n";
		$headers .= "From: {$data['name']} <{$data['email']}>\r\n";
		$headers .= "Reply-To: {$data['email']} <{$data['email']}>\r\n";
		$headers .= "Content-Type: text/plain; charset=utf-8\r\n";
		#$headers .= "Cc: hjemmesideoppmann@blindern-studenterhjem.no\r\n";
		
		$message = sprintf(self::get_lang("email"),
			$data['name'],
			self::get_lang("app_gender_".$data['gender']),
			$data['birth'], self::calc_age($data['birth']),
			$data['mobile'],
			$data['phone'],
			$data['email'],
			$data['studiested'], $data['studium'],
			$data['hjem_adresse'], $data['hjem_postnr'],
			$data['adresse'], $data['postnr'],
			$data['allergi'],
			$data['onsket_dato'], $data['antall_mnd'],
			$data['beskrivelse'], $data['annet'],
			date("j.n.Y H:i:s"));
		
		mail($to, $subject, $message, $headers);
		
		// melding til avsender
		$message_receipt = sprintf(self::get_lang("receipt_text"), $message);
		
		$headers = "To: {$data['name']} <{$data['email']}>\r\n";
		$headers .= "From: Blindern Studenterhjem <post@blindern-studenterhjem.no>\r\n";
		$headers .= "Content-Type: text/plain; charset=utf-8\r\n";
		
		mail($data['email'], self::get_lang("receipt_subject"), $message_receipt, $headers);
		
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

switch (bs_side::$lang)
{
	case "en":
		echo '
			<h1>Application</h1>';
		
		// TODO: se tekst nedenfor
	break;
	
	default:
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
}

bs_soknad::main();