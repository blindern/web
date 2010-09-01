<?php

ob_start();

class pagedata
{
	public $path;
	public $path_parts;
	
	public $doc_path = "";
	public $redirect;
	
	public function __construct()
	{
		$this->load_page_path();
	}
	
	public function load_page_path()
	{
		$script = $_SERVER['SCRIPT_NAME'];
		$this->doc_path = substr($script, 0, strrpos($script, "/"));
		
		if (!isset($_SERVER['REDIRECT_URL']) && !isset($_SERVER['PATH_INFO']))
		{
			$this->path = "";
			$this->path_parts = array();
			return;
		}
		
		if (isset($_SERVER['REDIRECT_URL']))
		{
			$this->redirect = $_SERVER['REDIRECT_URL'];
			$this->path = substr($this->redirect, strlen($this->doc_path)+1);
		}
		else
		{
			$this->path = substr($_SERVER['PATH_INFO'], 1);
		}
		
		$this->path_parts = explode("/", $this->path);
	}
}

class bs_side
{
	/**
	 * @var pagedata
	 */
	public static $pagedata;
	
	public static $content;
	public static $head;
	public static $title = "Blindern Studenterhjem - Et godt hjem for studenter";
	
	public static $menu_main;
	public static $menu_main_list = array();
	public static $menu_sub;
	public static $menu_active = "index";
	
	public static function main()
	{
		self::$pagedata = new pagedata();
		self::check_request();
	}
	
	protected static function check_request()
	{
		$request = str_replace("/", "__", self::$pagedata->path);
		if (preg_match("/[^a-zA-Z0-9_\\-]/", $request)) self::page_not_found();
		
		if ($request === "") $request = "index";
		
		// finnes denne filen?
		$file = "pages/list/$request.php";
		if (file_exists($file))
		{
			self::$menu_active = self::$pagedata->path ? self::$pagedata->path : "index";
			require $file;
		}
		
		else
		{
			self::page_not_found();
		}
		
		self::load_page();
	}
	
	protected static function load_page()
	{
		// sett opp meny
		self::load_menu();
		
		self::$content .= ob_get_contents();
		ob_clean();
		
		require "pages/template.php";
	}
	
	protected static function load_menu()
	{
		$data = file("pages/map.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		if (!$data) throw new Exception("Mangler menykartet.");
		
		$category = null; // teksten på kategorien
		$category_first = null; // navnet på første underside
		$category_active = null; // navnet på første underside til kategorien som er aktiv
		$subs = array(); // assosiativ liste over undersidene
		$active = null; // ja hvis aktiv undermeny (blir vist)
		
		foreach ($data as $line)
		{
			// ignorer kommentar
			if (substr($line, 0, 1) == "#") continue;
			
			// sub?
			if (substr($line, 0, 1) == "\t")
			{
				if (!$category) throw new Exception("Mangler menykategori.");
				list($name, $text) = explode("\t", substr($line, 1));
				
				$subs[$name] = $text;
				if ($name == self::$menu_active)
				{
					$active = true;
					$category_active = $name;
				}
				
				if (!$category_first) $category_first = $name;
			}
			
			// main
			else
			{
				if ($category) self::menu_add($category, $category_first, $subs, $active);
				$category = trim($line);
				$category_first = null;
				$active = null;
				$subs = array();
			}
		}
		
		if ($category) self::menu_add($category, $category_first, $subs, $active);
		
		// mekk html for hovedmenyen
		self::$menu_main = '
		<ul id="menu_main">';
		
		foreach (self::$menu_main_list as $key => $item)
		{
			$highlight = $key == $category_active ? ' class="active"' : '';
			if ($key == "index") $key = "";
			
			self::$menu_main .= '
			<li'.$highlight.'><a href="'.self::$pagedata->doc_path.'/'.$key.'">'.htmlspecialchars($item).'</a></li>';
		}
		
		self::$menu_main .= '
		</ul>';
	}
	
	protected static function menu_add($category, $category_first, $subs, $active)
	{
		self::$menu_main_list[$category_first] = $category;
		
		// mekk html for undermeny
		if ($active)
		{
			self::$menu_sub = '
		<p id="active_page">'.htmlspecialchars($category).'</p>
		<ul id="menu_sub">';
			
			foreach ($subs as $key => $item)
			{
				$highlight = $key == self::$menu_active ? ' class="active"' : '';
				if ($key == "index") $key = "";
				
				self::$menu_sub .= '
			<li'.$highlight.'><a href="'.self::$pagedata->doc_path.'/'.$key.'">'.htmlspecialchars($item).'</a></li>';
			}
			
			self::$menu_sub .= '
		</ul>';
		}
	}
	
	/**
	 * Ugyldig side (404)
	 */
	public static function page_not_found($more_info = NULL)
	{
		$more_info = empty($more_info) ? '' : $more_info;
		
		// siden finnes ikke (404)
		header("HTTP/1.1 404 Not Found");
		
		// har vi hentet inn page?
		//if (isset(ess::$b->page))
		{
			echo '
<h1>404 Not found</h1>
<p>Siden du ba om finnes ikke.</p>
<dl class="dl_50px">
	<dt>Adresse</dt>
	<dd>'.htmlspecialchars($_SERVER['REQUEST_URI']).'</dd>
</dl>'.$more_info;
			
			self::load_page();
			die;
		}
			
		// sett opp html etc
		echo '<!DOCTYPE html>
<html lang="no">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="author" content="Henrik Steen; http://www.henrist.net" />
<title>404 Not Found</title>
<style>
<!--
body { font-family: tahoma; font-size: 14px; }
h1 { font-size: 23px; }
.hsws { color: #CCCCCC; font-size: 12px; }
.subtitle { font-size: 16px; font-weight: bold; }
-->
</style>
</head>
<body>
<h1>404 Not Found</h1>
<p>Siden du ba om finnes ikke.</p>
<dl>
	<dt>Adresse</dt>
	<dd>'.htmlspecialchars($_SERVER['REQUEST_URI']).'</dd>
</dl>'.$more_info.'
<p class="hsws"><a href="http://www.henrist.net">HenriSt Websystem</a></p>
</body>
</html>';
		
		die;
	}
}

bs_side::main();