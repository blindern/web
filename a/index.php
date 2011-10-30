<?php

require "base.php";
ess::$b->page->add_title("Administrasjon");

// slå på debug av spørringer
if (isset($_POST['queries_info']) && access::has("sadmin"))
{
	if (isset($_POST['queries_info_on']))
	{
		setcookie("show_queries_info", 1, NULL, "/");
		ess::$b->page->add_message("Viser nå utvidet database informasjon.");
	}
	elseif (isset($_COOKIE['show_queries_info']))
	{
		setcookie("show_queries_info", false, NULL, "/");
		ess::$b->page->add_message("Viser ikke lengre utvidet database informasjon.");
	}
	redirect::handle();
}


// sett opp tilgangsgrupper
$groups = explode(",", login::$user->data['u_groups']);
$groups_text = array();
foreach (access::$accesses as $name => $d)
{
	if (in_array($d[0], $groups))
	{
		$groups_text[] = $name;
	}
}
$groups = implode(", ", $groups_text);
if (empty($groups)) $groups = "Ingen";


echo '
<h2>Administrasjon</h2>
<p>Du er logget inn som <b>'.htmlspecialchars_utf8(login::$user->data['u_user']).'</b>. <a href="loggut.php?sid='.login::$info['ses_id'].'">Logg ut</a></p>
<p>Dette er administrasjonsidene til blindernuka.no sine hjemmesider.</p>
<ul>
	<li>E-post: <a href="'.htmlspecialchars_utf8(login::$user->data['u_email']).'">'.htmlspecialchars_utf8(login::$user->data['u_email']).'</a></li>
	<li>Tilgangsgrupper: '.htmlspecialchars_utf8($groups).'</li>
</ul>';

if (access::has("sadmin"))
{
	echo '
<h3>Utvidet database informasjon</h3>
<form action="" method="post">
	<input type="hidden" name="queries_info" />'.(isset($_COOKIE['show_queries_info']) ? '
	<ul>
		<li>Aktiv status: <b>Viser</b> informasjon '.show_sbutton("Skjul informasjon").'</li>
	</ul>' : '
	<ul>
		<li>Aktiv status: Viser <b>ikke</b> informasjon '.show_sbutton("Vis informasjon", 'name="queries_info_on"').'</li>
	</ul>').'
</form>';
}

ess::$b->page->load();