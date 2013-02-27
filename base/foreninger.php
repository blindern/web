<?php

class foreninger
{
	private $active;
	public $set_active_menu = true;

	public $list = array(
		"fbs" => array(
			array(
				"foreningsstyret",
				"Foreningsstyret",
				"Foreningsstyret"),
			array(
				"festforeningen",
				"Festforeningen",
				"- Festforeningen"),
			array(
				"hyttestyret",
				"Hyttestyret for Småbruket",
				"- Hyttestyret"),
			array(
				"ifbs",
				"Idrettsforeningen Blindern Studenterhjem (IFBS)",
				"- IFBS"),
			array(
				"uka",
				"UKA på Blindern",
				"- UKA"),
			array(
				"velferden",
				"Velferden",
				"- Velferden")
		),
		"andref" => array(
			array(
				"bbb",
				"Blindern Bad og Badstu forening (BBB)",
				"BBB"),
			array(
				"brunsprit",
				"Brun Sprit",
				"Brun Sprit"),
			array(
				"bsg",
				"Blindern Spill & Gåte (BSG)",
				"BSG"),
			array(
				"chorus_buchus",
				"cHorus Buchus",
				"cHorus Buchus"),
			array(
				"haarn_oc_blaese",
				"Blindern Haarn oc Blaese Orchester",
				"Haarn oc Blaese"),
			array(
				"katiba",
				"Katiba", // TODO: langt navn
				"Katiba"),
			array(
				"pigefaarsamlingen",
				"Pigefaarsamlingen",
				"Pigefaarsamlingen"),
			array(
				"pms",
				"Pigenes Musikalske Selskab (PMS)",
				"PMS")
		),
		"andre" => array(
			array(
				"bukkekollegiet",
				"Bukkekollegiet",
				"Bukkekollegiet"),
			array(
				"ball",
				"Ballkomitéer",
				"Ballkomitéer"),
			array(
				"biblioteksutvalget",
				"Biblioteksutvalget",
				"Biblioteksutvalget"),
			array(
				"kollegiet",
				"Blindern Studenterkollegium",
				"Kollegiet")
		)
	);

	public function set_active($value) {
		$this->active = $value;
	}

	private function group($id, $text) {
		if (!isset($this->list[$id])) throw new Exception("Fant ikke foreningsgruppe.");
		
		$ret = '
		<p>'.$text.'</p>
		<ul>';

		foreach ($this->list[$id] as $data) {
			$ret .= '
			<li'.($data[0] == $this->active ? ' class="active"' : '').'><a href="/livet/'.$data[0].'">'.$data[2].'</a></li>';
		}

		$ret .= '
		</ul>';

		return $ret;
	}

	public function gen_page() {
		bs_side::$page_class = "foreninger foreninger_liste";
		if ($this->set_active_menu) bs_side::$menu_active = "livet/liste";

		$data = ob_get_contents();
		ob_clean();

		echo '
<div class="foreninger_wrap">
	<section class="foreninger_left">
		'.$this->group("fbs", "Underlagt Foreningen").'
		'.$this->group("andref", "Øvrige foreninger").'
		'.$this->group("andre", "Annet").'
	</section><!--
	--><section class="foreninger_content">
		'.$data.'
	</section>
</div>';
	}

	public function sitemap() {
		return $this->sitemap_group("fbs", "Underlagt Foreningen")
			.$this->sitemap_group("andref", "Øvrige foreninger")
			.$this->sitemap_group("andre", "Annet");
	}

	public function sitemap_group($group, $text) {
		if (!isset($this->list[$group])) throw new Exception("Fant ikke foreningsgruppe.");
		
		$ret = '<span style="display: block">'.$text.'</span>
		<ul>';

		foreach ($this->list[$group] as $data) {
			$ret .= '
			<li><a href="/livet/'.$data[0].'">'.$data[1].'</a></li>';
		}

		$ret .= '
		</ul>';

		return $ret;
	}
}