<?php

class tilpasning {
	public $data;

	public function __construct() {
		$this->load();
	}

	public function load() {
		$this->data = (array) json_decode(file_get_contents(TILPASNING_FIL));
	}

	public function save() {
		file_put_contents(TILPASNING_FIL, json_encode($this->data));
	}

	public function get($var, $default = null) {
		if (!isset($this->data[$var])) return $default;
		return $this->data[$var];
	}

	public function set($var, $value) {
		$this->data[$var] = $value;
		$this->save();
	}
}