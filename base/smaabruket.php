<?php

class smaabruket_kalender
{
	public $weeks_show_before = 0;
	public $weeks_show_after = 20;
	
	public static $xml_files = array(
		// utleid
		"http://www.google.com/calendar/feeds/hyttestyret%40gmail.com/private-ab4f8e009eaf37cfa69cc113a4f98cf0/full",
		
		// reservert
		"http://www.google.com/calendar/feeds/8iosbn0p0pn8fegofi5o2n88v0%40group.calendar.google.com/private-619428ecdc4fb56774f2727bec3f1b2d/full",
		
		// blindern studenterhjem
		"http://www.google.com/calendar/feeds/km7ghn4c18busf05t4e22q0bgk%40group.calendar.google.com/private-24ccc8d119f49e7feec147f859531957/full"
	);
	
	public function get_cache_id()
	{
		return "smaabruket_xml_data_".$this->weeks_show_before."_".$this->weeks_show_after;
	}
	
	public function get_xml()
	{
		$cache_id = $this->get_cache_id();
		
		$data = cache::fetch($cache_id);
		if ($data && is_array($data)) return $data;
		
		$end = time() + 86400 * 7 * $this->weeks_show_after;
		$start = time() - 86400 * 7 * ($this->weeks_show_before + 1);
		
		$start_text = date("Y-m-d\\TH:i:s", $start);
		$end_text = date("Y-m-d\\TH:i:s", $end);
		
		$data = array();
		foreach (self::$xml_files as $file)
		{
			$d = @file_get_contents($file."?singleevents=true&start-min=$start_text&start-max=$end_text&max-results=50");
			if ($d) $data[] = $d;
		}
		
		cache::store($cache_id, $data, 600);
		return $data;
	}
	
	public function get_data()
	{
		$datas = $this->get_xml();
		if (!$datas) return null;
		
		$start = array();
		$items = array();
		$confirmed = 'http://schemas.google.com/g/2005#event.confirmed';
		foreach ($datas as $data)
		{
			$xml = simplexml_load_string($data);
			foreach ($xml->entry as $item)
			{
				$gd = $item->children('http://schemas.google.com/g/2005');
				if ($gd->eventStatus->attributes()->value != $confirmed) continue;
				
				// $item->title
				$startTime = 0;
				$endTime = 0;
				if ($gd->when)
				{
					$startTime = strtotime($gd->when->attributes()->startTime);
					$endTime = strtotime($gd->when->attributes()->endTime);
				}
				elseif ($gd->recurrence)
				{
					$startTime = strtotime($gd->recurrence->when->attributes()->startTime);
					$endTime = strtotime($gd->recurrence->when->attributes()->endTime);
				}
				
				$start[] = $startTime;
				$items[] = array(
					"title" => (string) $item->title,
					"start" => $startTime,
					"start_text" => date("r", $startTime),
					"end" => $endTime,
					"end_text" => date("r", $endTime),
					"value" => (string) $gd->where->attributes()->valueString,
					"calendar" => substr((string)$item->title, 0, 10) == "Reservert:" ? "Reservert" : (string) $xml->title
				);
			}
		}
		
		array_multisort($start, SORT_ASC, $items);
		return $items;
	}
	
	public function get_calendar_status()
	{
		$items = $this->get_data();
		if (!$items) return null;
		
		$date_start = new DateTime();
		$date_start->setTimeZone(new DateTimeZone("Europe/Oslo"));
		$date_start->setTime(0, 0, 0);
		$date_start->modify("-".($this->weeks_show_before*7)." days");
		while ($date_start->format("N") != 1)
		{
			$date_start->modify("-1 day");
		}
		
		$days = array();
		$show_days = 7 * $this->weeks_show_before + 7 * $this->weeks_show_after;
		for ($i = 0; $i < $show_days; $i++)
		{
			$days[$date_start->format("Y-m-d")] = false;
			$date_start->modify("+1 day");
		}
		
		foreach ($items as $item)
		{
			$start = new DateTime("@".$item['start']);
			$start->setTimeZone(new DateTimeZone("Europe/Oslo"));
			$start->setTime(0, 0, 0);
			#if ($start->format("H:i:s") !== "00:00:00") continue;
			
			$end = new DateTime("@".$item['end']);
			$end->setTimeZone(new DateTimeZone("Europe/Oslo"));
			
			// marker datoene med kalendernavnet
			do
			{
				$day = $start->format("Y-m-d");
				if (isset($days[$day]))
				{
					$days[$day] = $item['calendar'];
				}
				$start->modify("+1 day");
			} while ($start->format("U") < $end->format("U"));
		}
		
		return $days;
	}
}
