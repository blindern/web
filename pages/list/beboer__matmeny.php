<?php

echo '
<!DOCTYPE html>
<html>
<head>
<meta name="robots" content="noindex, nofollow" />
<title>Matmeny</title>
<style>
.table {
	border: 1px solid black;
	border-collapse: collapse;
	/*width: 54%;*/
	margin-bottom: 1em;
}

.table th {
	text-align: left;
	background-color: #EEEEEE;
}

.table td, .table th {
	border: 1px solid black;
	padding: 2px 4px;
}
</style>
</head>
<body>
<table class="table matmeny">
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Forrige uke</th>
			<th>Denne uke</th>
			<th>Neste uke</th>
		</tr>
	</thead>
	<tbody>';

// les inn matmenyen
class matmeny {
	public $data = array();
	public $uke;
	public $dag;

	public function load_data() {
		$c = file_get_contents(dirname(__FILE__)."/../matmeny.csv");
		$c = explode("\n", str_replace("\r", "", $c));

		foreach ($c as $r) {
			$row = str_getcsv($r);
			if (count($row) != 4) continue; // four cols in each entry

			$this->data[$row[0]."-".$row[1]][$row[2]] = $row[3];
		}

		$this->uke = date("o-W");
	}

	public function get_meny($uke_rel, $dag) {
		$uke = date("o-W", time()+$uke_rel*86400*7);
		
		if (!isset($this->data[$uke][$dag])) {
			return '<i style="color: #CCC">Ingen data</i>';
		}

		// sett farge på infotekst
		$data = $this->data[$uke][$dag];
		$data = explode("<br />", $data);
		foreach ($data as &$row) {
			if (substr($row, 0, 2) == "I:") $row = '<span style="color: #FF0000">'.substr($row, 2).'</span>';
		}
		$data = implode("<br />", $data);

		return $data;
	}

	public function print_rows() {
		$ignores = array();
		$days = array(1 => "Mandag", "Tirsdag", "Onsdag", "Torsdag", "Fredag", "Lørdag", "Søndag");

		$y = date("N");
		$this_day = date("z");
		for ($i = 1; $i <= 7; $i++) {
			echo '
		<tr>
			<th>'.$days[$i].'</th>';

			for ($x = -1; $x <= 1; $x++) {
				$d = date("z", time()+$x*7*86400+($i-$y)*86400);
				echo '
			<td'.($d == $this_day ? ' style="background-color: #00FF00"' : '').'>'.$this->get_meny($x, $i).'</td>';
			}

			echo '
		</tr>';
		}
	}
}

$mat = new matmeny();
$mat->load_data();
$mat->print_rows();

echo '
	</tbody>
</table>
<p><span style="background-color: #00FF00">Grønt</span> er dagens. Kjøkkensjefen oppdaterer selv denne menyen på nett.</p>
</body>
</html>';

die();
