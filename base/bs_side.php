<?php

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
		//phpinfo();
		//die;
		
		$script = $_SERVER['SCRIPT_NAME'];
		$this->doc_path = substr($script, 0, strrpos($script, "/"));
		
		if (!isset($_SERVER['REQUEST_URI']) && !isset($_SERVER['PATH_INFO']))
		{
			$this->path = "";
			$this->path_parts = array();
			return;
		}
		
		if (isset($_SERVER['REQUEST_URI']))
		{
			$this->redirect = $_SERVER['REQUEST_URI'];
			
			//$this->path = substr($this->redirect, strlen($this->doc_path)+1);
			$this->path = substr($_SERVER['REQUEST_URI'], 1);
			if (($pos = strpos($this->path, "?")) !== false) $this->path = substr($this->path, 0, $pos);
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
	public static $footer;
	public static $title = null;
	
	public static $description = null;
	public static $description_default = array(
		"en" => "In a stunning gardens located at Blindern, near the University of Oslo, Blindern Studenterhjem offer a rich homeshare for 220 students.",
		"other" => "I et praktfullt beliggende hageanlegg på Blindern, like ved Universitetet i Oslo, kan Blindern Studenterhjem tilby et rikt bofelleskap for 220 studenter."
	);
	
	public static $lang = "no";
	public static $lang_crosslink = array();
	
	public static $page_class;
	
	public static $keywords;
	protected static $keywords_default = array(
		"en" => array("Blindern Studenterhjem", "Blindern Student Home", "student home", "student residence", "blindern", "oslo"),
		"other" => array("Blindern Studenterhjem", "studentbolig i oslo", "studenthybel", "student", "bolig", "blindern", "oslo")
	);
	
	protected static $title_default = array(
		"en" => "Blindern Studenterhjem - A good home for students",
		"other" => "Blindern Studenterhjem - Et godt hjem for studenter"
	);
	/*protected static $title_format = array(
		"en" => "%s - Blindern Studenterhjem",
		"other" => "%s - Blindern Studenterhjem"
	);*/
	
	public static $menu_main;
	public static $menu_main_list = array();
	public static $menu_sub;
	public static $menu_active = null;
	public static $menu_all = array();
	
	/**
	 * Er vi på internt nettverk?
	 */
	public static $is_beboer;
	
	public static function main()
	{
		self::$pagedata = new pagedata();
		
		// har vi beboerstatus?
		if (bs::is_beboer()) self::$is_beboer = true;
		
		self::check_request();
	}
	
	public static $redirs = array(
		"foreninger/hyttestyret" => "smaabruket",
		"smabruket" => "smaabruket",
		"småbruket" => "smaabruket"
	);
	
	protected static function check_redirect($path)
	{
		if (isset(self::$redirs[$path]))
		{
			redir(self::$redirs[$path], true);
			die;
		}
	}
	
	protected static function check_request()
	{
		$request = str_replace("/", "__", self::$pagedata->path);
		if (preg_match("/[^a-zA-Z0-9_æøåÆØÅ\\-]/", $request)) self::page_not_found();
		
		if ($request === "") $request = "index";
		
		// omvisning med underside?
		if (substr($request, 0, 11) == "omvisning__") {
			if ($request != "omvisning__oversikt") self::$menu_active = "omvisning";
			if ($request != "omvisning__admin") $request = "omvisning";
		}
		
		// finnes denne filen?
		$file = "pages/list/$request.php";
		if (file_exists($file))
		{
			if (!self::$menu_active) self::$menu_active = self::$pagedata->path ? self::$pagedata->path : "index";
			require $file;
		}
		
		else
		{
			self::check_redirect(self::$pagedata->path);
			self::page_not_found();
		}
		
		self::load_page();
	}
	
	public static function show_page()
	{
		self::load_page();
	}
	
	protected static function load_page()
	{
		// sett opp variabler avhengig av språk etc
		$p = ess::$b->page;
		if (count($p->title) == 1) {
			$p->title[0] = self::get_title();
		}
		if (count($p->keywords) == 0) $p->keywords = array_merge(self::get_keywords(), $p->keywords);
		if (!$p->description) $p->description = self::get_description();
		
		if (self::$head) ess::$b->page->add_head(self::$head);
		
		// sett opp meny
		self::load_menu();
		
		if (self::$content) {
			self::$content .= ob_get_contents();
			ob_clean();
			
			echo self::$content;
		}
		
		ess::$b->page->load();
	}
	
	public static function load_menu()
	{
		// allerede lastet inn?
		if (self::$menu_main) return;
		
		// filen vi skal hente fra
		if (self::$lang == "en") $file = "pages/map_en.txt";
		else $file = "pages/map.txt";
		
		$data = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
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
		
		if (bs_side::$is_beboer)
		{
			self::$menu_main .= '
			<li class="'.(self::$menu_active == "beboer" ? "active activesub " : "").'beboerlenke" lang="no"><a href="'.self::$pagedata->doc_path.'/beboer">Beboer</a>
				<ul>
					<li class="beboerlenke_quicklinks_desc">Hurtiglenker:</li>
					<li><a href="'.self::$pagedata->doc_path.'/foreninger/arrangementplan">Arrangementplan</a></li>
					<li><a href="/dugnaden/">Dugnaden</a></li>
					<li><a href="/dokumenter/statutter">Statuttene</a></li>
				</ul>
			</li>';
		}
		
		foreach (self::$menu_main_list as $key => $item)
		{
			$highlight = $category_active == $key
				? ' class="active activesub"'
				: (isset(self::$menu_all[$key][1][$category_active])
					? ' class="activesub"'
					: '');
			if ($key == "index") $key = "";
			
			self::$menu_main .= '
			<li'.$highlight.'><a href="'.self::$pagedata->doc_path.'/'.$key.'">'.htmlspecialchars($item).'</a></li>';
		}
		
		// språkvalg
		if (self::$lang != "no")
		{
			$link = isset(self::$lang_crosslink['no']) ? self::$lang_crosslink['no'] : '';
			
			self::$menu_main .= '
			<li class="langsel langsel_no" lang="no"><a href="'.self::$pagedata->doc_path.'/'.$link.'">På norsk</a></li>';
		}
		
		if (self::$lang != "en")
		{
			$link = isset(self::$lang_crosslink['en']) ? self::$lang_crosslink['en'] : 'en';
			
			self::$menu_main .= '
			<li class="langsel langsel_en" lang="en"><a href="'.self::$pagedata->doc_path.'/'.$link.'">In English</a></li>';
		}
		
		self::$menu_main .= '
		</ul>';
	}
	
	protected static function menu_add($category, $category_first, $subs, $active)
	{
		self::$menu_all[$category_first] = array(
			$category,
			$subs
		);
		
		self::$menu_main_list[$category_first] = $category;
		
		// mekk html for undermeny
		if ($active)
		{
			self::$menu_sub = '
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
	
	/**
	 * Endre tittel
	 */
	public static function set_title($title)
	{
		ess::$b->page->add_title($title);
	}
	
	/**
	 * Hent ut nøkkelord
	 */
	public static function get_keywords()
	{
		if (isset(self::$keywords_default[self::$lang])) return self::$keywords_default[self::$lang];
		return self::$keywords_default['other'];
	}
	
	/**
	 * Hent ut tittel
	 */
	public static function get_title()
	{
		if (isset(self::$title_default[self::$lang])) return self::$title_default[self::$lang];
		return self::$title_default['other'];
	}
	
	/**
	 * Hent ut beskrivelse
	 */
	public static function get_description()
	{
		if (isset(self::$description_default[self::$lang])) return self::$description_default[self::$lang];
		return self::$description_default['other'];
	}
}

function redir($page = "", $permanent = false)
{
	$addr = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['SERVER_NAME'];
	$https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? "s" : "";
	$port = $_SERVER['SERVER_PORT'] != 80 ? ($_SERVER['SERVER_PORT'] == 443 && $https ? "" : ":".$_SERVER['SERVER_PORT']) : "";
	$location = "http".$https."://".$addr.$port.rtrim(dirname($_SERVER['SCRIPT_NAME']), "/") . "/$page";
	
	// send til siden
	$code = $permanent ? "301 Moved Permanently" : "302 Found";
	header("HTTP/1.1 $code");
	header("Location: $location");
	die('<HTML><HEAD><TITLE>'.$code.'</TITLE></HEAD><BODY><H1>Found</H1>You have been redirected <A HREF="'.$location.'">here</A>.<P></BODY></HTML>');
}

function get_right_img($name, $gallery_id = null, $alt = "", $text = "")
{
	$d = '<img src="'.bs_side::$pagedata->doc_path.'/graphics/images/'.$name.'" alt="'.htmlspecialchars($alt).'" />';
	if ($gallery_id) $d = '<a href="'.bs_side::$pagedata->doc_path.'/studentbolig/omvisning#?img='.$gallery_id.'">'.$d.'</a>';
	
	if ($text) $text = '<span>'.$text.'</span>';
	
	return '<p class="img img_right">'.$d.$text.'</p>';
}

function get_right_img_gal($gallery_id, $alt, $text, $fototext = null) {
	return get_img_p($gallery_id, $alt, $text, $fototext, "img img_right");
}

function get_img_p($gallery_id, $alt, $text, $fototext = null, $class = null, $type = "pageright") {
	if ($alt === null && $text) $alt = strip_tags($text);
	
	if ($fototext) $text .= ($text ? " " : "").$fototext;
	if ($text) $text = '<span class="imgtext">'.$text.'</span>';

	if ($class) $class = ' class="'.htmlspecialchars($class).'"';
	
	return '<p'.$class.'><a href="/studentbolig/omvisning/'.$gallery_id.'"><img src="/o.php?a=gi&amp;gi_id='.$gallery_id.'&amp;gi_size='.$type.'" alt="'.htmlspecialchars($alt).'" />'.$text.'</a></p>';
}

function get_img_line(array $img_list) {
	$ret = '
<div class="img_line">';

	foreach ($img_list as $img) {
		for ($i = 1; $i <= 3; $i++) {
			if (!isset($img[$i])) $img[$i] = null;
		}

		// 0 => gallery_id, alt, text, fototext
		$ret .= preg_replace("~(<img.+?/>)~", '<span class="imgwrap1"><span class="imgwrap2">$1</span></span>', get_img_p($img[0], $img[1], $img[2], $img[3], null, "pageline"));
	}

	$ret .= '
</div>';

	return $ret;
}