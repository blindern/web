<?php

require "base.php";

// sjekk SID
if (getval("sid") != login::$info['ses_id'])
{
	ess::$b->page->add_message("Kan ikke logge ut. Mangler verifikasjons ID. Prøv på nytt.", "error");
	ess::$b->page->load();
}

login::logout();
ess::$b->page->add_message("Du er nå logget ut.");
redirect::handle("logginn.php");

?>