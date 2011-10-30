<?php

/**
 * Attributter til HTML elementer
 */
class attr
{
	public $name = NULL;
	public $items = array();
	public $split = " ";
	public function __construct($name = NULL, $items = NULL, $split = NULL)
	{
		if (!$name) throw new HSException("Mangler navn til attributt.");
		$this->name = $name;
		if ($split) $this->split = $split;
		if ($items) $this->add($items);
		return $this;
	}
	public function add($items)
	{
		$items = is_array($items) ? $items : explode($this->split, $items);
		foreach ($items as $item)
		{
			$item = trim($item);
			if (empty($item)) continue;
			
			$this->items[] = $item;
		}
		return $this;
	}
	public function build()
	{
		if (count($this->items) == 0) return '';
		
		return ' '.$this->name.'="'.implode($this->split, $this->items).'"';
	}
}


/**
 * Lage HTML attributter
 */
/*class htmlattr
{
	private static $structure = array(
		"id" => array(
			"multiple" => false
		),
		"class" => array(
			"multiple" => true,
			"seperator" => " "
		)
	);
	private $data = array();
	
	public function __construct()
	{
		
	}
	
	public static function clean($attr, $value)
	{
		if (!isset(self::$structure[$attr]))
		{
			throw new HSException("Ukjent attributt: $attr");
		}
		
		if (isset(self::$structure[$attr]['multiple']) && self::$structure[$attr]['multiple'])
		{
			$value = explode(self::$structure[$attr]['seperator'], $value);
			$value = array_map("trim", $value);
			foreach ($value as $key => $item)
			{
				if (empty($item)) unset($value[$key]);
			}
		}
		
		else
		{
			$value = array(trim($value));
		}
		
		return $value;
	}
	
	public function append($attr, $value)
	{
		
	}
	
	public function set($attr, $value)
	{
		$value = self::clean($attr, $value);
		if (isset($this->data[$attr])) unset($this->data[$attr]);
		
		foreach ($value as $item)
		{
			$this->data[$attr][] = $value;
		}
	}
	
	public function del($attr, $value = NULL)
	{
		
	}
	
	public function build()
	{
		if (count($this->data) == 0) return '';
		
		$data = array();
		foreach ($this->data as $attr)
		{
			$attr = implode(self::$structure[$attr]['seperator'], $attr);
			$data[] = ''
			
			if (!self::$structure[$attr]['multiple'])
			{
				$data[] 
			}
		}
	}
}*/