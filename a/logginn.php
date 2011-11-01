<?php

define("ALLOW_GUEST", true);
require "base.php";
access::no_user();

// fjern mulige cookies
setcookie($__server['cookie_prefix']."sid", "", time()-86400);

ess::$b->page->add_title("Logg inn");

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	// skjekk logg inn formen
	$err = false;
	if (!isset($_POST['user']) || empty($_POST['user']))
	{
		// mangler brukernavn
		ess::$b->page->add_message("Mangler brukernavn!", "error");
		$err = true;
	}
	if (!isset($_POST['pass']) || empty($_POST['pass']))
	{
		// mangler passord
		ess::$b->page->add_message("Mangler passord!", "error");
		$err = true;
	}
	$type = intval(postval('expire_type'));
	if ($type < 0 || $type > 2)
	{
		// ugyldig expire type
		ess::$b->page->add_message("Ugyldig expire type!", "error");
		$err = true;
	}

	if (!$err)
	{
		// prøv å logg inn
		switch (login::do_login($_POST['user'], $_POST['pass'], $type))
		{
			case LOGIN_ERROR_USER_OR_PASS:
			ess::$b->page->add_message("Feil brukernavn eller passord!", "error");
			break;
			
			case LOGIN_ERROR_ACTIVATE:
			ess::$b->page->add_message("Din bruker er deaktivert!", "error");
			break;
			
			default:
			if (!login::$logged_in)
			{
				ess::$b->page->add_message("Ukjent innloggingsfeil!", "error");
			}
			else
			{
				// logget inn
				if (isset($_GET['orign'])) redirect::handle($_GET['orign'], redirect::SERVER);
				redirect::handle("index.php");
			}
		}
	}
	
	redirect::handle(PHP_SELF.(isset($_GET['orign']) ? '?orign='.urlencode($_GET['orign']) : ''), redirect::SERVER);
}

echo '
<h2>Administrasjon</h2>
<form action="'.PHP_SELF.(isset($_GET['orign']) ? '?orign='.urlencode($_GET['orign']) : '').'" method="post">
	<dl class="dd_right dl_2x center300">
		<dt>Brukernavn</dt>
		<dd><input type="text" name="user" id="user" class="w125" value="'.htmlspecialchars_utf8(requestval("user")).'" /></dd>
		
		<dt>Passord</dt>
		<dd><input type="password" name="pass" class="w125" /></dd>
		
		<dt>Varighet</dt>
		<dd>
			<select name="expire_type">
				<option value="0">15 minutter uten aktivitet</option>
				<option value="1">Nettleseren blir lukket</option>
				<option value="2">Alltid innlogget</option>
			</select>
		</dd>
		
		<dd><div id="logginn">'.show_sbutton("Logg inn").'</dd>
	</dl>
</form>';

ess::$b->page->add_body_post('<script type="text/javascript">ge("user").focus()</script>');
ess::$b->page->load();

?>