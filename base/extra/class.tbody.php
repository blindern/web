<?php

// for å mekke kolonner etc i tabeller
class tbody
{
	public $cols = 0;
	public $current = -1;
	public $row = 0;

	// construct
	function tbody($cols)
	{
		$this->cols = $cols;
	}

	// vis en <td>
	function append($content, $attribs = '')
	{
		if (++$this->current == $this->cols)
		{
			echo '
		</tr>';
			$this->current = 0;
		}

		if ($this->current == 0)
		{
			echo '
		<tr'.(++$this->row % 2 == 0 ? ' class="color"' : '').'>';
		}

		echo '
			<td'.(!empty($attribs) ? ' '.$attribs : '').'>'.$content.'</td>';
	}

	// send ut siste <td> elementer
	function clean()
	{
		if (++$this->current < $this->cols)
		{
			for (;$this->current < $this->cols; $this->current++)
			{
				echo '
			<td>&nbsp;</td>';
			}
		}

		echo '
		</tr>';
	}
}

// for å mekke kolonner etc i tabeller (vertikal sortering)
/*class tbody_vertical
{
	public $cols = 0;
	public $buffer = array();

	// construct
	function tbody_vertical($cols)
	{
		$this->cols = $cols;
	}

	// legg til i buffer
	function append($content)
	{
		$this->buffer[] = $content;
	}

	// sett opp alle <tr> elementene
	function build()
	{
		// ingen elementer?
		if (count($this->buffer) == 0) return;

		// antall rader totalt
		$rows_c = ceil(count($this->buffer)/$this->cols);
		#$cols = array();
		$rows = array();

		// legg til elementene i riktig kolonne
		$col = 0;
		$i = 0;

		foreach ($this->buffer as $elm)
		{
			$rows[$i][$col] = $elm;

			$i++;
			if ($i == $rows_c) { $i = 0; $col++; }
			#if ($i % $rows == $e) $col++;
		}

		// sett opp sluttelementene
		while ($col < $this->cols)
		{
			if ($i == $rows_c) { break; }

			$rows[$i][$col] = '&nbsp;';

			$i++;
		}


		// sett opp hver <tr>
		$i = 0;
		foreach ($rows as $row)
		{
			echo '
		<tr'.($i % 2 ? ' class="color"' : '').'>';

			foreach ($row as $col)
			{
				echo '
			<td>'.$col.'</td>';
			}

			echo '
		</tr>';

			$i++;
		}
	}
}*/