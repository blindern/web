<?php

class bs_matmeny {
	private static $data;

	public static function has_week($year, $week) {
		if (!self::$data) self::load();
		return isset(self::$data[$year][$week]);
	}

	public static function get_week($weekid) {
		try {
			$week = new bs_matmeny_uke($weekid);
			return $week;
		} catch (Exception $e) {
			return false;
		}
	}

	public static function load() {
		$c = file_get_contents(ROOT."/pages/matmeny.csv");
		$c = explode("\n", str_replace("\r", "", $c));

		foreach ($c as $r) {
			$row = str_getcsv($r);
			if (count($row) != 4) continue; // four cols in each entry

			self::$data[$row[0]][$row[1]][$row[2]] = $row[3];
		}
	}

	public static function get_week_days($year, $week) {
		if (!self::$data) self::load();
		if (isset(self::$data[$year][$week])) return self::$data[$year][$week];

		$days = array();
		for ($i = 1; $i <= 7; $i++) $days[$i] = "";

		return $days;
	}

	public static function replace_week($year, $week, $days) {
		self::load();
		self::$data[$year][$week] = $days;
		return self::save();
	}

	private static function save() {
		$data = array();
		foreach (self::$data as $year => $weeks) {
			foreach ($weeks as $week => $days) {
				foreach ($days as $day => $content) {
					$data[] = "$year,$week,$day,$content";
				}
			}
		}
		$data = implode("\n", $data);

		return file_put_contents(ROOT."/pages/matmeny.csv", $data);
	}
}

class bs_matmeny_uke {
	public $year;
	public $week;
	public $days;

	public function __construct($weekid) {
		if (strlen($weekid) != 7) throw new Exception("Ugyldig uke.");

		$this->year = substr($weekid, 0, 4);
		$this->week = substr($weekid, 5);

		// verifiser
		$d = ess::$b->date->get();
		if (!$d->setISODate($this->year, $this->week)) throw new Exception("Ugyldig uke.");

		if ($d->format("W") != $this->week || $d->format("Y") != $this->year) throw new Exception("Ugyldig uke.");

		$this->preload();
	}

	public function load_file($file) {
		$fil = new bs_matmeny_fil($file);
		$result = $fil->get();
		if (!$result) return $fil::get_text_error($fil->error);

		foreach ($result as &$day) {
			$day = implode("<br />", $day);
		}

		$this->replace($result);
		return true;
	}

	public function free() {
		$this->days = array();
		for ($i = 1; $i <= 7; $i++) $this->days[$i] = "";
	}

	/**
	 * Last inn innhold fra nåværende matmeny
	 */
	public function preload() {
		$this->free();
		$this->days = bs_matmeny::get_week_days($this->year, $this->week);
	}

	/**
	 * Erstatt innhold
	 */
	public function replace($days) {
		$this->days = $days;
	}

	/**
	 * Lagre nytt innhold
	 */
	public function save() {
		return bs_matmeny::replace_week($this->year, $this->week, $this->days);
	}

	/**
	 * Hent innhold detaljert
	 */
	public function get_data() {
		$data = array();
		foreach ($this->days as $day => $value) {
			$new = array();
			$lines = explode("<br />", $value);
			foreach ($lines as $line) {
				$info = false;
				if (substr($line, 0, 2) == "I:") {
					$info = true;
					$line = substr($row, 2);
				}

				$new[] = array(
					"info" => $info,
					"content" => $line
				);
			}

			$data[$day] = $new;
		}

		return $data;
	}

	public function replace_data($data) {
		$this->free();
		foreach ($data as $day_id => $day) {
			$text = array();
			foreach ($day as $line) {
				$text[] = ($line['info'] ? 'I:' : '') . $line['content'];
			}
			$this->days[$day_id] = implode("<br />", $text);
		}
	}
}

class bs_matmeny_fil {
	public $file;
	public $error;
	const ERROR_TOO_FEW = -1;
	const ERROR_DAY_TOO_LONG = -2;

	public function __construct($file) {
		$this->file = $file;
	}

	public static function get_text_error($id) {
		switch ($id) {
			case self::ERROR_TOO_FEW:
				return 'Fant ikke mange nok dager.';
			
			case self::ERROR_DAY_TOO_LONG:
				return 'Formatet i filen var ikke gyldig.';
		}

		return 'Ukjent feil.';
	}

	public function get() {
		$text = $this->load_contents();
		if (!$text) return false;

		return $this->load_parts($text);
	}

	private function load_contents() {
		// hent ut tekst
		$text = utf8_encode(shell_exec("antiword -w 0 ".escapeshellarg($this->file)));

		if (!$text) return false;
		return $text;
	}

	private function load_parts($text) {
		$dager = "(Mandag|Tirsdag|Onsdag|Torsdag|Fredag|Lørdag|Søndag)";
		$result = preg_split("/$dager/u", $text, null, PREG_SPLIT_DELIM_CAPTURE);

		if (count($result) < 15) {
			$this->error = self::ERROR_TOO_FEW;
			return false;
		}

		$data = array();
		reset($result); next($result);
		$day_id = 1;
		while (($row = current($result)) !== false) {
			$dag = $row;
			$content = next($result);

			if (strlen($dag) > 10) {
				$this->error = self::ERROR_DAY_TOO_LONG;
				return false;
			}

			$data[$day_id++] = $this->parse_part($content);
			next($result);
		}

		return $data;
	}

	private function parse_part($content) {
		if (!preg_match_all("/^(\s+|\\|\s+)\\|(.+?)\s+\\|/mu", $content, $matches)) {
			return "";
		}

		$res = array();
		foreach ($matches[2] as $row) {
			$row = trim($row);
			if ($row == "") continue;

			// er alt store bokstaver?
			if (mb_strtoupper($row) == $row) {
				$row = mb_substr($row, 0, 1).mb_strtolower(mb_substr($row, 1));
			}

			$res[] = $row;
		}

		return $res;
	}
}