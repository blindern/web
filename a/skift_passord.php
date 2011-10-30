<?php

require "base.php";

ess::$b->page->add_message("Ikke mulig for øyeblikket.", "error");
redirect::handle("index.php");

die("TODO");

// bytt passord
if (isset($_POST['pass']))
{
	$pass0 = postval("pass");
	$pass1 = postval("pass1");
	$pass2 = postval("pass2");
	
	if (empty($pass0) || empty($pass1) || empty($pass2))
	{
		ess::$b->page->add_message("Fyll ut alle feltene.", "error");
	}
	
	else
	{
		// stememr ikke det gamle passordet?
		if (md5($pass0) != $_user['info']['u_pass'])
		{
			ess::$b->page->add_message("Det gamle passordet stemte ikke!", "error");
		}
		
		// for dårlig nytt passord?
		elseif (strlen($pass1) < 6)
		{
			ess::$b->page->add_message("Det nye passordet må inneholde minst 6 tegn.", "error");
		}
		
		// stemmer ikke de nye passordene med hverandre?
		elseif ($pass1 != $pass2)
		{
			ess::$b->page->add_message("De to nye passordene stemte ikke med hverandre.", "error");
		}
		
		// samme som det gamle?
		elseif ($pass0 == $pass1)
		{
			ess::$b->page->add_message("Det nye passordet var det samme som det gamle.", "error");
		}
		
		else
		{
			// bytt passord
			db::query("UPDATE users SET u_pass = ".db::quote_text(md5($pass1))." WHERE u_id = ".login::$user->id, __FILE__, __LINE__);
			
			// logg ut eksisterende økter
			db::query("UPDATE sessions SET ses_active = 0, ses_logout = ".time()." WHERE ses_active = 1 AND ses_u_id = ".login::$user->id." AND ses_id != ".login::$info['ses_id'], __FILE__, __LINE__);
			
			ess::$b->page->add_message("Passordet ble endret.");
			redirect::handle("index.php");
		}
	}
}

ess::$b->page->add_title("Skift passord");

echo '
<h1>Skift passord</h1>
<p>
	Her endrer du ditt passord du bruker til å logge inn på siden.
</p>
<form action="" method="post">
	<dl class="dl_20 dl_2x">
		<dt>Gammelt passord</dt>
		<dd><input type="password" class="w125" name="pass" /></dd>
		
		<dt>Nytt passord</dt>
		<dd><input type="password" class="w125" name="pass1" /></dd>
		
		<dt>Gjenta nytt</dt>
		<dd><input type="password" class="w125" name="pass2" /></dd>
	</dl>
	<p>'.show_sbutton("Skift passord").'</p>
</form>';

ess::$b->page->load();

?>