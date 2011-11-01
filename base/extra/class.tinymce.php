<?php

class tinymce
{
	/**
	 * Plugins som skal lastes inn (for alle)
	 */
	public static $plugins_all = "emoticons,preview,contextmenu,inlinepopups,safari,resizeable";
	
	/**
	 * Plugins som skal lastes inn (for admin)
	 */
	public static $plugins_admin = "table,save,advhr,iespell,insertdatetime,searchreplace,print,fullscreen,advimage,advlink";
	
	/**
	 * Plugins som skal lastes inn (for vanlige brukere)
	 */
	public static $plugins_others = "";
	
	/**
	 * Elementene
	 */
	public static $elements = array();
	
	/**
	 * Holder orden på om js filen eer lasta inn eller ikke
	 */
	protected static $loaded = false;
	
	/**
	 * Legg til element
	 * @param $elm_id
	 * @param $mode_admin
	 */
	public static function add_element($elm_id, $mode_admin = null)
	{
		// sjekk admin
		if (is_null($mode_admin))
		{
			if (login::$logged_in)
			{
				$mode_admin = true;
			}
			else
			{
				$mode_admin = false;
			}
		}
		elseif (!is_bool($mode_admin))
		{
			$mode_admin = false;
		}
		$mode = $mode_admin ? "admin" : "normal";
		
		// legg til i lista
		self::$elements[] = array($elm_id, $mode);
	}
	
	function load()
	{
		// ingenting å laste inn?
		if (count(self::$elements) == 0)
		{
			return;
		}
		
		// laste inn hovedelementer?
		if (!self::$loaded)
		{
			self::$loaded = true;
			ess::$b->page->add_js_file(LIB_HTTP.'/tinymce/tinymce/tiny_mce_gzip.js');
			
			// compressor js
			ess::$b->page->add_js_domready('
tinyMCE_GZ.init({
	plugins : \''.implode(",", array(self::$plugins_all, self::$plugins_admin)).'\',
	themes: \'advanced\',
	languages: \'no\',
	disk_cache: true,
	debug: false
});');
		}
		
		// sett opp elementer
		$elms = array();
		foreach (self::$elements as $row)
		{
			if (!isset($elms[$row[1]]))
				$elms[$row[1]] = array();
			$elms[$row[1]][] = $row[0];
		}
		
		foreach ($elms as $mode => $elms2)
		{
			$d = implode(",", array_map("htmlspecialchars_utf8", $elms2));
			
			// legg til
			if ($mode == "admin")
			{
				ess::$b->page->add_js_domready('
tinyMCE.init({
	mode: "exact",
	elements: "'.$d.'",
	plugins: "'.implode(",", array(self::$plugins_all, self::$plugins_admin)).'",
	language: "no",
	theme: "advanced",
	skin: "o2k7",
	skin_variant: "black",
	theme_advanced_buttons1_add_before: "save,separator",
	theme_advanced_buttons1_add: "fontselect,fontsizeselect",
	theme_advanced_buttons2_add_before: "cut,copy,paste,separator,search,replace,separator",
	theme_advanced_buttons2_add: "separator,insertdate,inserttime,preview,separator,forecolor,backcolor",
	theme_advanced_buttons3_add_before: "tablecontrols,separator",
	theme_advanced_buttons3_add: "emotions,iespell,advhr,separator,print,fullscreen",
	theme_advanced_toolbar_location: "top",
	theme_advanced_toolbar_align: "left",
	theme_advanced_statusbar_location: "bottom",
	theme_advanced_resizing: true,
	theme_advanced_resize_horizontal: false,
	content_css: "'.ess::$s['relative_path'].'/themes/editor.css?'.@filemtime(ROOT."/themes/editor.css").'",
	apply_source_formatting: true,
	convert_fonts_to_spans: true,
	width: "100%",
	relative_urls: true,
	document_base_url: '.json_encode(ess::$s['path']."/").',
	extended_valid_elements: "iframe[src|style|width|height|scrolling|marginwidth|marginheight|frameborder]"
});');
			}
			
			// normal
			else
			{
				ess::$b->page->add_js_domready('
tinyMCE.init({mode: "exact",
	elements: "'.$d.'",
	plugins: "'.implode(",", array(self::$plugins_all, self::$plugins_others)).'",
	language: "no",
	theme: "advanced",
	theme_advanced_buttons1: "bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,hr,removeformat,serparator,sub,sup,separator,charmap,emotions,preview",
	theme_advanced_buttons2: "bullist,numlist,separator,outdent,indent,separator,undo,redo,separator,link,unlink,image,cleanup",
	theme_advanced_buttons3: "",
	theme_advanced_toolbar_location: "top",
	theme_advanced_toolbar_align: "left",
	theme_advanced_statusbar_location: "none",
	theme_advanced_resizing: true,
	content_css: "'.ess::$s['relative_path'].'/themes/editor.css?'.@filemtime(ROOT."/themes/editor.css").'",
	relative_urls: true,
	document_base_url: '.json_encode(ess::$s['path']."/").',
	extended_valid_elements: "iframe[src|style|width|height|scrolling|marginwidth|marginheight|frameborder]"
});');
			}
		}
	}
}