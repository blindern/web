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
		/*$navigation = '
				<ul class="menu">
					<li class="item54"><a href="'.ess::$s['rpath'].'/artister"><span class="bsm_normal"><img src="'.ess::$s['rpath'].'/draw/draw.php?text=%7Bs12%7DARTISTER" alt="Artister" /></span><span class="bsm_active"><img src="'.ess::$s['rpath'].'/draw/draw.php?text=%7Bs12cFFE007%7DARTISTER" alt="" /></span></a></li>
					<li class="parent item53">
						<a href="'.ess::$s['rpath'].'/revy"><span class="bsm_normal"><img src="'.ess::$s['rpath'].'/draw/draw.php?text=%7Bs12%7DREVY" alt="Revy" /></span><span class="bsm_active"><img src="'.ess::$s['rpath'].'/draw/draw.php?text=%7Bs12cFFE007%7DREVY" alt="" /></span></a>
						<ul>
							<li class="item58"><a href="'.ess::$s['rpath'].'/revy/skuespillere"><span class="bsm_normal"><img src="'.ess::$s['rpath'].'/draw/draw.php?text=%7Bw2s8f3%7DSKUESPILLERE" alt="Skuespillere" /></span><span class="bsm_active"><img src="'.ess::$s['rpath'].'/draw/draw.php?text=%7Bw2s8f3cFFE007%7DSKUESPILLERE" alt="" /></span></a></li>
						</ul></li>
					<li class="item55"><a href="'.ess::$s['rpath'].'/program"><span class="bsm_normal"><img src="'.ess::$s['rpath'].'/draw/draw.php?text=%7Bs12%7DPROGRAM" alt="Program" /></span><span class="bsm_active"><img src="'.ess::$s['rpath'].'/draw/draw.php?text=%7Bs12cFFE007%7DPROGRAM" alt="" /></span></a></li>
					<li class="parent item56">
						<a href="'.ess::$s['rpath'].'/om-uka/historie"><span class="bsm_normal"><img src="'.ess::$s['rpath'].'/draw/draw.php?text=%7Bs12%7DOM+UKA" alt="Om UKA" /></span><span class="bsm_active"><img src="'.ess::$s['rpath'].'/draw/draw.php?text=%7Bs12cFFE007%7DOM+UKA" alt="" /></span></a>
						<ul>
							<li class="item60"><a href="'.ess::$s['rpath'].'/om-uka/historie"><span class="bsm_normal"><img src="'.ess::$s['rpath'].'/draw/draw.php?text=%7Bw2s8f3%7DHISTORIE" alt="Historie" /></span><span class="bsm_active"><img src="'.ess::$s['rpath'].'/draw/draw.php?text=%7Bw2s8f3cFFE007%7DHISTORIE" alt="" /></span></a></li>
							<li class="item61"><a href="'.ess::$s['rpath'].'/om-uka/ukestyret"><span class="bsm_normal"><img src="'.ess::$s['rpath'].'/draw/draw.php?text=%7Bw2s8f3%7DUKESTYRET" alt="UKEstyret" /></span><span class="bsm_active"><img src="'.ess::$s['rpath'].'/draw/draw.php?text=%7Bw2s8f3cFFE007%7DUKESTYRET" alt="" /></span></a></li>
							<li class="item69"><a href="'.ess::$s['rpath'].'/om-uka/minner-fra-miniuka"><span class="bsm_normal"><img src="'.ess::$s['rpath'].'/draw/draw.php?text=%7Bw2s8f3%7DMINNER+FRA+MINIUKA" alt="Minner fra miniUKA" /></span><span class="bsm_active"><img src="'.ess::$s['rpath'].'/draw/draw.php?text=%7Bw2s8f3cFFE007%7DMINNER+FRA+MINIUKA" alt="" /></span></a></li>
						</ul></li>
					<li class="item57"><a href="'.ess::$s['rpath'].'/kontakt"><span class="bsm_normal"><img src="'.ess::$s['rpath'].'/draw/draw.php?text=%7Bs12%7DKONTAKT" alt="Kontakt" /></span><span class="bsm_active"><img src="'.ess::$s['rpath'].'/draw/draw.php?text=%7Bs12cFFE007%7DKONTAKT" alt="" /></span></a></li>
				</ul>';*/
		
		if (isset($params['no_right']))
		{
			ess::$b->page->add_css('
#content_right { display: none }
#content { width: 960px }');
		}
		
		if (!isset($params['no_feature'])) uka_feature::attach();
		#uka_countdown::attach();
		uka_gallery_glimt::attach();
		if (!isset($params['no_upcoming_program'])) uka_program_kommende::attach();
		
		ess::$b->page->content_add('
			<!-- samarbeidspartnere -->
			<div class="samarb_wrap">
				<div class="samarb_box_w">
					<div class="samarb_box_bg"></div>
					<div class="samarb_box">
						<p class="samarb_title">Våre <span>samarbeidspartnere</span></p>
						<a href="http://www.akademika.no/" target="_blank" alt="Akademika"><img src="'.ess::$s['rpath'].'/img/sponsorer/akademika.png" alt="Akademika" /></a>
						<a class="samarb_right" href="http://www.dagsavisen.no/" target="_blank" alt="Dagsavisen"><img src="'.ess::$s['rpath'].'/img/sponsorer/dagsavisen.png" alt="Dagsavisen" /></a>
						<a href="http://www.copycat.no/" target="_blank" alt="Akademika"><img src="'.ess::$s['rpath'].'/img/sponsorer/copycat.png" alt="CopyCat" /></a>
						<a class="samarb_right" href="http://www.olden.no/" target="_blank" alt="Olden"><img src="'.ess::$s['rpath'].'/img/sponsorer/olden.png" alt="Olden" /></a>
					</div>
				</div>
				<div class="uprogram_link">
					<p><a href="/2011/om-uka/samarbeidspartnere">Alle samarbeidspartnere &raquo;</a></p>
				</div>
			</div>
			<!-- /samarbeidspartnere -->', "right");
		
		if (!isset($params['no_random_news'])) uka_random_nyhet::attach();
		
		$navigation = nodes::build_menu(0, 0, '
			');
		$middle = ess::$b->page->content_get("middle");
		$right = defined("ADMIN_AREA") ? '' : ess::$b->page->content_get("right");
		$content = ess::$b->page->content_get();
		
		
		// legg til artikkelramme rundt
		if (!isset($params['no_container']) || !$params['no_container'])
		{
			$content = '
<div class="bs_article_page"'.(defined("ADMIN_AREA") ? ' style="width: 920px"' : '').'>'.$content.'
	<div style="clear: both"></div>
</div>';
		}
		
		// kommer vi fra egen side?
		$referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
		$more_classes = '';
		if ($referer)
		{
			if ($referer == $_SERVER['SERVER_NAME'])
			{
				$more_classes = " doscroll";
			}
		}
		
		echo '<!DOCTYPE html>
<html lang="no"'.(MAIN_SERVER ? '' : ' class="devserver"').'>
<head>
<title>'.ess::$b->page->generate_title().'</title>'.ess::$b->page->generate_head().'</head>
<body class="'.self::$class_browser.$more_classes.'">'.ess::$b->page->body_start.'
	<div id="containero">
	<div id="container">
		<div id="banner">
			<a href="https://www.banknorwegian.no/Pages/Kredittkort.aspx" title="Kredittkort fra Bank Norwegian" target="_blank"><img src="/2011/img/template/940x144_stud.jpg" style="height: 144px; width: 940px" alt="Bank Norwegian Kredittkort - Spar til hjemreisen gjennom hele semesteret!" /></a>
		</div>
		<div id="top">
			<div id="logo">
				<a href="'.ess::$s['rpath'].'/"><span>UKA på Blindern</span></a>
			</div>
			<div id="slogan">
				<h1>
					<a href="'.ess::$s['rpath'].'/"><span>UKA PÅ BLINDERN
					<br/>26.01 - 06.02 | <strong>2011</strong></span></a>
				</h1>
			</div>
			<div id="navigation">'.$navigation.'
			</div>
		</div>';
		
		if ($middle) echo '
		<div id="middle">'.$middle.'
		</div>';
		
		echo '
		<div id="content"'.(!$middle ? ' class="content_no_middle"' : '').'>'.$content.'
		</div>
		<div id="content_right">'.$right.'
		</div>
		<div style="clear: both"></div>
		
		<div id="bs_footer">
			<div id="bs_footer_logo"><a href="'.ess::$s['rpath'].'/"></a></div>
			<div id="bs_footer_addr"><p><a href="http://blindern-studenterhjem.no"><b>Blindern Studenterhjem</b><br />Blindernveien 41<br />0313 OSLO</a></p></div>
			<div id="bs_footer_map"><a href="'.ess::$s['rpath'].'/kontakt/kart"></a></div>
			
			<a id="bs_footer_email" href="mailto:kontakt@blindernuka.no">kontakt@blindernuka.no</a>
			<div id="bs_footer_phone">+47 984 86 809</div>
			
			<a id="bs_footer_rss" href="'.ess::$s['rpath'].'/rss"><span>RSS-feed</span></a>
			<a id="bs_footer_facebook" href="http://www.facebook.com/uka11" target="_blank"><span>Find us at Facebook</span></a>
			<a id="bs_footer_twitter" href="http://www.twitter.com/blindernuka" target="_blank"><span>Twitter</span></a>
		</div>
	</div>
	</div>';
		
		// aktivere google-analytics?
		if (($_SERVER['HTTP_HOST'] == "blindernuka.no" && !login::$logged_in) || ess::$b->page->gaq)
		{
			echo '
	<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(["_setAccount", "UA-19030223-1"]);
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