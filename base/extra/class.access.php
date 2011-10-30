<?php

/**
 * Tilgangssystem
 */
class access
{
	/**
	 * De ulike tilgangene
	 */
	public static $accesses = array(
		"inaktiv" => array(0),
		"bruker" => array(1),
		"admin" => array(9, 10),
		"sadmin" => array(10),
		"vakt" => array(2),
		"billett" => array(3),
		"grafikk" => array(4),
		"web" => array(5, 4),
		"galleri" => array(6, 5)
	);
	
	/**
	 * Sjekk for tilgang
	 * @param string $access_name
	 * @param boolean $allow_admin
	 * @param array $groups
	 * @param mixed $skip_extended_access_check "login" for å logge sende til logg inn siden
	 */
	public static function has($access_name, $allow_admin = NULL, $groups = NULL)
	{
		if ($groups === NULL || !is_array($groups))
		{
			if (!login::$logged_in) return false;
			$groups = login::$user->data['u_groups'];
			if ($groups == "") return false;
			$groups = explode(",", $groups);
		}
		
		$exists = isset(self::$accesses[$access_name]);
		$access = $exists ? self::$accesses[$access_name] : NULL;
		
		// bruker er admin? => true
		if (($allow_admin === true || $allow_admin === NULL) && $access_name != "sadmin" && (in_array(self::$accesses['admin'][0], $groups) || in_array(self::$accesses['sadmin'][0], $groups)))
		{
			return true;
		}
		
		// skjekk om brukeren har en av tilgangsid-ene til tilgangen => true
		if ($exists)
		{
			foreach ($access as $a)
			{
				if (in_array($a, $groups)) return true;
			}
		}
		
		// tilgangen finnes ikke eller brukeren har ikke tilgang => false
		return false;
	}
	
	/**
	 * Krev at brukeren må ha en bestemt tilgang for å vise siden
	 * @param string $access_name
	 * @param boolean $allow_admin
	 * @param integer $access_level
	 * @param boolean $skip_extended_access_check
	 */
	public static function need($access_name, $allow_admin = NULL, $groups = NULL)
	{
		if (self::has($access_name, $allow_admin, $groups))
		{
			// har tilgang
			return;
		}
		
		#$name = self::name($access_name);
		$name = $access_name;
		
		// ajax?
		if (defined("SCRIPT_AJAX")) ajax::text("ERROR:NO-ACCESS,NEED:$name", ajax::TYPE_INVALID);
		
		// har ikke tilgang
		echo "<h1>Ikke tilgang!</h1><p>Du har ikke tilgang til denne siden!</p><p>Den er forebeholdt <b>$name</b>.</p>";
		ess::$b->page->load();
	}
	
	/**
	 * Ikke tillatt gjester på denne siden
	 */
	public static function no_guest()
	{
		// ikke logget inn?
		if (!login::$logged_in)
		{
			$param = "";
			if ($_SERVER['REQUEST_URI'] != ess::$s['relative_path']) $param = "?orign=".urlencode($_SERVER['REQUEST_URI']);
			
			// send til logg inn siden
			redirect::handle("/a/logginn.php".$param, redirect::ROOT);
		}
	}
	
	/**
	 * Ikke tillatt innloggede brukere på denne siden
	 */
	public static function no_user()
	{
		// logget inn?
		if (login::$logged_in)
		{
			// send til hovedsiden
			redirect::handle("", redirect::ROOT);
		}
	}
}