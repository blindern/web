<?php

if (!defined("SCRIPT_START")) {
	die("Mangler hovedscriptet! Kan ikke fortsette!");
}

jquery();

class theme_a_default
{
	protected static $date_now;
	protected static $class_browser;
	
	/**
	 * Behandle template
	 */
	public static function main($params)
	{
		self::$date_now = ess::$b->date->get();
		
		global $class_browser;
		require "include_top.php";
		
		self::$class_browser = $class_browser;
		self::generate_page($params);
	}
	
	protected static function generate_page($params)
	{
		#$middle = ess::$b->page->content_get("middle");
		#$right = defined("ADMIN_AREA") ? '' : ess::$b->page->content_get("right");
		$content = ess::$b->page->content_get();
		
		echo '<!DOCTYPE html>
<html lang="no">
<head>
<title>'.ess::$b->page->generate_title().'</title>'.ess::$b->page->generate_head().'</head>
<body class="'.self::$class_browser.'">'.ess::$b->page->body_start.'
	<div id="a_wrap">
		<div id="a_top">
			<p>Administrasjon <a href="'.ess::$s['rpath'].'/">blindern-studenterhjem.no</a></p>
		</div>
		<div id="a_main">
			<div id="a_menu_bg"></div>
			<div id="a_menu">';
		
		if (login::$logged_in)
		{
			echo '
				<p>Innlogget som <b>'.htmlspecialchars_utf8(login::$user->data['u_user']).'</b></p>
				<ul>
					<li><a href="'.ess::$s['rpath'].'/a/index.php">Admin forside</a></li>
				</ul>
				<ul>
					<li><a href="'.ess::$s['rpath'].'/a/sessions.php">Mine økter</a></li>
					<li><a href="'.ess::$s['rpath'].'/a/loggut.php?sid='.login::$info['ses_id'].'">Logg ut</a></li>
				</ul>';
			
			if (access::has("web") || access::has("grafikk") || access::has("galleri"))
			{
				echo '
				<ul>';
				
				if (access::has("galleri")) echo '
					<li><a href="'.ess::$s['rpath'].'/a/galleries.php">Bildegalleri</a></li>';
				
				echo '
				</ul>';
			}
		}
		
		else
		{
			echo '
				<p>Du må logge inn.</p>';
		}
		
		echo '
			</div>
			<div id="a_content">'.$content.'
				<div style="clear: both"></div>
			</div>
		</div>
		<div id="a_footer">
			<p>Utviklet av <a href="http://hsw.no/">Henrik Steen Webutvikling</a></p>
		</div>
	</div>
	<!--
	'.self::$date_now->format(date::FORMAT_SEC).'
	Script: '.round(microtime(true)-SCRIPT_START-ess::$b->db->time, 4).' sek
	Database: '.round(ess::$b->db->time, 4).' sek ('.ess::$b->db->queries.' spørring'.(ess::$b->db->queries == 1 ? '' : 'er').')
	-->
'.ess::$b->page->body_end;
		
		// debug time
		$time = SCRIPT_START;
		ess::$b->dt("end");
		$dt = 'start';
		foreach (ess::$b->time_debug as $row)
		{
			$dt .= ' -> '.round(($row[1]-$time)*1000, 2).' -> '.$row[0];
			$time = $row[1];
		}
		
		echo '
	<!-- '.$dt.' -->
</body>
</html>';
	}
}

theme_a_default::main($params);