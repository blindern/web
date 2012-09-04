<?php

class bs
{
	/**
	 * Sjekk om vi har status som beboer
	 */
	public static function is_beboer()
	{
		// sjekk IP
		if (substr($_SERVER['REMOTE_ADDR'], 0, 10) == "37.191.255") return true;
		return (self::beboer_cookie_check() || login::$logged_in);
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
}
