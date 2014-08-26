<?php

class bs
{
	/**
	 * Sjekk om vi har status som beboer
	 */
	public static function is_beboer()
	{
		// sjekk IP
		if (substr($_SERVER['REMOTE_ADDR'], 0, 10) == "37.191.255" || self::is_adm()) return true;
		return self::beboer_cookie_check();
	}
	
	/**
	 * Sett status om beboer i cookie
	 */
	public static function beboer_cookie_set()
	{
		setcookie("is_beboer", "1", time()+86400*170, "/");
		$_COOKIE['is_beboer'] = "1";
		bs_side::$is_beboer = true;
	}
	
	/**
	 * Sjekk om vi har beboer-cookie
	 */
	public static function beboer_cookie_check()
	{
		if (isset($_COOKIE['is_beboer'])) return true;
	}

	/**
	 * Sjekk om det er adresse tilhørende administrasjonen
	 */
	public static function is_adm()
	{
		$network = "158.36.185.160/28";
		return self::cidr_match($_SERVER['REMOTE_ADDR'], $network);
	}

	/**
	 * Sjekk adresse mot CIDR
	 * hentet fra http://stackoverflow.com/questions/594112/matching-an-ip-to-a-cidr-mask-in-php5
	 */
	public static function cidr_match($ip, $range)
	{
		list ($subnet, $bits) = explode('/', $range);
		$ip = ip2long($ip);
		$subnet = ip2long($subnet);
		$mask = -1 << (32 - $bits);
		$subnet &= $mask; # nb: in case the supplied subnet wasn't correctly aligned
		return ($ip & $mask) == $subnet;
	}
}
