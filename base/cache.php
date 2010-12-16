<?php

define("CACHE_FILES_DIR", "c:\\windows\\temp");
define("CACHE_FILES_PREFIX", "blinderncache_");

class cache
{
	/** Prefiks for nøkkelen */
	protected static $prefix = null;
	
	/** For å deaktivere caching */
	protected static $disabled = false;
	
	/**
	 * Cache-motor
	 * @var cache_engine
	 */
	protected static $engine;
	
	/**
	 * Hent data
	 * @param string $key
	 */
	public static function fetch($key)
	{
		if (self::$disabled) return false;
		return self::$engine->fetch(self::$prefix . $key);
	}
	
	/**
	 * Lagre data
	 * @param string $key
	 * @param mixed $data
	 * @param int $ttl seconds
	 */
	public static function store($key, $data, $ttl = 0)
	{
		if (self::$disabled) return false;
		return self::$engine->store(self::$prefix . $key, $data, $ttl);
	}
	
	/**
	 * Slett data
	 * @param string $key
	 */
	public static function delete($key)
	{
		if (self::$disabled) return false;
		return self::$engine->delete(self::$prefix . $key);
	}
	
	/**
	 * Initialize
	 */
	public static function init()
	{
		// apc?
		if (function_exists("apc_fetch"))
		{
			self::$engine = new cache_apc();
		}
		
		else
		{
			self::$engine = new cache_file();
		}
		
		#self::$disabled = true;
		
		// generer key prefiks
		self::$prefix = "blindern_";
	}
}

interface cache_engine
{
	public function fetch($key);
	public function store($key, $data, $ttl);
	public function delete($key);
}

class cache_apc implements cache_engine
{
	public function fetch($key)
	{
		return apc_fetch($key);
	}
	
	public function store($key, $data, $ttl)
	{
		return apc_store($key, $data, $ttl);
	}
	
	public function delete($key)
	{
		return apc_delete($key);
	}
}

class cache_file implements cache_engine
{
	protected $cache_p;
	public function __construct()
	{
		$this->cache_p = CACHE_FILES_DIR . "/" . CACHE_FILES_PREFIX;
	}
	
	public function fetch($key)
	{
		$file = $this->get_path($key);
		if (!file_exists($file)) return false;
		
		$data = file_get_contents($file);
		if (!$data) return false;
		
		$data = unserialize($data);
		if ($data[0] != 0 && $data[0] < time())
		{
			@unlink($file);
			return false;
		}
		
		return $data[1];
	}
	
	public function store($key, $data, $ttl)
	{
		$file = $this->get_path($key);
		$data = serialize(array(
			$ttl > 0 ? time() + $ttl : 0,
			$data
		));
		$res = file_put_contents($file, $data);
		
		if ($res)
		{
			@chmod($file, 0777);
		}
		
		return $res;
	}
	
	public function delete($key)
	{
		return @unlink($this->get_path($key));
	}
	
	protected function get_path($key)
	{
		return $this->cache_p . str_replace("..", "__", $key);
	}
}

// initialize cacher
cache::init();