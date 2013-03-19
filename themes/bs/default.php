<?php

if (!defined("SCRIPT_START")) {
	die("Mangler hovedscriptet! Kan ikke fortsette!");
}

class theme_bs_default
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
		jquery();
		$content = ess::$b->page->content_get();
		
		echo '<!DOCTYPE html>
<html lang="no"'.(MAIN_SERVER ? '' : ' class="devserver"').'>
<head>
<title>'.ess::$b->page->generate_title().'</title>'.ess::$b->page->generate_head().'</head>
<body class="lang_'.bs_side::$lang.' '.self::$class_browser.(bs_side::$page_class ? ' '.bs_side::$page_class : '').'">'.ess::$b->page->body_start.'
<div id="body_wrap">
	<div id="container"><div id="main">
		<div id="header">
			<h1><a href="'.ess::$s['rpath'].'/'.(bs_side::$lang != "no" ? bs_side::$lang : '').'"><span>Blindern Studenterhjem<br />';
		
		switch (bs_side::$lang)
		{
			case "en":
				echo 'A good home for students';
			break;
			
			default:
				echo 'Et godt hjem for studenter';
		}
		
		echo '</span></a></h1>';
		
		$show_application_box = true;
		if ($show_application_box)
		{
			echo '
			<div class="ledigeplasser">';
		
			switch (bs_side::$lang)
			{
				case "en":
					echo '
				<h2>Applications</h2>
				<p>Applications for fall 2011 are evaluated throughout the summer.</p>
				<p>Apply an <a href="'.ess::$s['rpath'].'/en/application">electronic application &raquo;</a></p>';
				break;
				
				default:
					echo '
				<h2>Søk deg inn</h2>
				<p>Søknad for plass til høsten 2013 behandles fortløpende utover våren.</p>
				<p class="soknadsknapp">
					<a href="/opptak/sok_om_plass">Send søknad &raquo;</a>
				</p>';
			}
			
			echo '
			</div>';
		}
		
		echo '
		</div>
		'.bs_side::$menu_main.'
		'.bs_side::$menu_sub.'
		<div id="content"'.(!bs_side::$menu_sub ? ' class="content_no_sub"' : '').'>
			'.$content.'
			<div id="content_clear"></div>
		</div>
		<div id="footer">
			<p>Blindern Studenterhjem '.ess::$b->date->get()->format("Y");

		switch (bs_side::$lang)
		{
			case "en":
				if (bs_side::$menu_active != "en/sitemap") echo ' | <a href="'.ess::$s['rpath'].'/en/sitemap">Sitemap</a>';
			break;
		
			default:
				if (bs_side::$menu_active != "sitemap") echo ' | <a href="'.ess::$s['rpath'].'/sitemap">Sidekart</a>';
		}
		
		echo '</p>
		</div>
		</div>';
		
/*
		<div id="banner"><a href="'.ess::$s['rpath'].'/foreninger/arrangementsplan"><img src="'.ess::$s['rpath'].'/graphics/images/bukkehaug2011.jpg" alt="Bukkehaugsfestivalen 2011" /></a></div>*/
		
		echo '
	</div>
	<div id="footer_spacer"></div>
</div>';
		
		// aktivere google-analytics?
		if (($_SERVER['HTTP_HOST'] == "blindern-studenterhjem.no" && !login::$logged_in) || ess::$b->page->gaq)
		{
			echo '
	<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(["_setAccount", "UA-13059225-1"]);
	_gaq.push(["_trackPageview", '.json_encode($_SERVER['REQUEST_URI']).']);';
			
			foreach (ess::$b->page->gaq as $gaq)
			{
				echo '
	_gaq.push('.$gaq.');';
			}
			
			echo '
	
	(function() {
	var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
	ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
	var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
	})();
	</script>';
		}
		
		echo '
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

theme_bs_default::main($params);