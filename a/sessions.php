<?php

require "base.php";

a_sessions::page_ses();
class a_sessions
{
	/**
	 * Økter
	 */
	public static function page_ses()
	{
		// logge ut noen økter
		if (isset($_POST['delete']))
		{
			$delete = array();
			if (isset($_POST['session']))
			{
				foreach ($_POST['session'] as $del)
				{
					$del = intval($del);
					if ($del != 0) $delete[] = $del;
				}
			}
			
			if (count($delete) == 0)
			{
				ess::$b->page->add_message("Fant ingen økter å logge ut.", "error");
				redirect::handle();
			}
			
			else
			{
				// forsøk å logg ut de merkede øktene
				$delete = implode(",", $delete);
				ess::$b->db->query("UPDATE sessions SET ses_active = 0, ses_logout_time = ".time()." WHERE ses_active = 1 AND ses_expire_time > ".time()." AND ses_u_id = ".login::$user->id." AND ses_id != ".login::$info['ses_id']." AND FIND_IN_SET(ses_id, '$delete')");
				
				$dels = ess::$b->db->affected_rows();
				ess::$b->page->add_message("<b>$dels</b> økt".($dels == 1 ? '' : 'er')." ble logget ut.");
				redirect::handle();
			}
		}
		
		ess::$b->page->add_title("Økter");
		
		echo '
	<div class="bg1_c">
		<h2 class="bg1">Aktive økter<span class="left2"></span><span class="right2"></span></h2>
		<div class="bg1">
			<p><a href="index.php">Tilbake</a></p>
			<p>Her er en oversikt over alle stedene hvor brukeren er logget inn uten å ha blitt logget ut manuelt og som fortsatt er aktive.</p>';
		
		$time = time();
		$result = ess::$b->db->query("SELECT * FROM sessions WHERE ses_u_id = ".login::$user->id." AND ses_expire_time > $time AND ses_active = 1 ORDER BY ses_id DESC");
		
		echo '
			<form action="" method="post">
				<table class="table center">
					<thead>
						<tr>
							<th>Opprettet</th>
							<th>IP</th>
							<th>Type</th>
							<th>Varighet</th>
							<th>Hits</th>
							<th>Siste visning</th>
						</tr>
					</thead>
					<tbody>';
		
		$i = 0;
		while ($row = mysql_fetch_assoc($result))
		{
			$class = new attr("class");
			if ($row['ses_id'] != login::$info['ses_id']) $class->add("box_handle");
			
			$i++;
			if ($row['ses_id'] == login::$info['ses_id']) $class->add("highlight"); 
			elseif ($i % 2 == 0) $class->add("color");
			
			$type = $row['ses_expire_type'];
			$type = $type == LOGIN_TYPE_TIMEOUT ? 'Tidsavbrudd' : ($type == LOGIN_TYPE_BROWSER ? 'Lukke nettleser' : 'Alltid innlogget');
			echo '
						<tr'.$class->build().'>
							<td class="r">'.($row['ses_id'] == login::$info['ses_id'] ? '' : '<input type="checkbox" name="session[]" value="'.$row['ses_id'].'" /> ').ess::$b->date->get($row['ses_created_time'])->format("d.m.Y H:i").'</td>
							<td>'.$row['ses_created_ip'].'</td>
							<td class="c">'.$type.'</td>
							<td class="c">'.($row['ses_expire_type'] == LOGIN_TYPE_ALWAYS ? 'Alltid' : timespan::format($row['ses_expire_time'], timespan::TIME_ABS)).'</td>
							<td class="r">'.format_num($row['ses_hits']).'</td>
							<td class="r">'.ess::$b->date->get($row['ses_last_time'])->format("d.m.Y H:i").($row['ses_last_time'] != 0 ? '<br />'.timespan::format($row['ses_last_time'], timespan::TIME_ABS) : '').'</td>
						</tr>';
		}
		
		echo '
					</tbody>
				</table>
				<p class="c">'.show_sbutton("Logg ut merkede", 'name="delete"').'</p>
			</form>
		</div>
	</div>';
		
		// hent øktene på denne siden
		$pagei = new pagei(pagei::ACTIVE_GET, "side", pagei::PER_PAGE, 7);
		$result = $pagei->query("SELECT ses_id, ses_created_time, ses_created_ip, ses_expire_type, ses_expire_time, ses_active, ses_hits, ses_last_time, ses_last_ip FROM sessions WHERE ses_u_id = ".login::$user->id." ORDER BY ses_last_time DESC");
		
		echo '
	<div class="bg1_c">
		<h2 class="bg1">Tidligere økter<span class="left2"></span><span class="right2"></span></h2>
		<div class="bg1">
			<p>Dette er en oversikt over alle innlogginger på brukeren.</p>
			<table class="table'.($pagei->pages == 1 ? ' tablemb' : '').' center">
				<thead>
					<tr>
						<th>ID</th>
						<th>Opprettet</th>
						<th>IP</th>
						<th>Type</th>
						<th>Status</th>
						<th>Hits</th>
						<th>Siste visning</th>
					</tr>
				</thead>
				<tbody>';
		
		$i = 0;
		while ($row = mysql_fetch_assoc($result))
		{
			$type = $row['ses_expire_type'];
			$type = $type == LOGIN_TYPE_TIMEOUT ? 'Tidsavbrudd' : ($type == LOGIN_TYPE_BROWSER ? 'Lukke nettleser' : 'Alltid innlogget');
			echo '
					<tr'.(++$i % 2 == 0 ? ' class="color"' : '').'>
						<td class="r">'.$row['ses_id'].'</td>
						<td class="r">'.ess::$b->date->get($row['ses_created_time'])->format("d.m.Y H:i").'<br /><span style="color: #888">'.timespan::format($row['ses_created_time'], timespan::TIME_ABS).'</span></td>
						<td class="c">'.$row['ses_created_ip'].'</td>
						<td class="c">'.$type.'</td>
						<td class="c">'.($row['ses_active'] == 1 ? ($row['ses_expire_time'] < $time ? 'Ikke aktiv' : ($row['ses_expire_type'] == LOGIN_TYPE_ALWAYS ? '<b>Aktiv</b><br />Alltid logget inn' : '<b>'.timespan::format($row['ses_expire_time'], timespan::TIME_ABS).'</b>')) : 'Logget ut').'</td>
						<td class="r">'.format_num($row['ses_hits']).'</td>
						<td class="r">'.ess::$b->date->get($row['ses_last_time'])->format("d.m.Y H:i").($row['ses_last_time'] != 0 ? '<br /><span style="color: #888">'.timespan::format($row['ses_last_time'], timespan::TIME_ABS).'</span>' : '').'</td>
					</tr>';
		}
		
		echo '
				</tbody>
			</table>'.($pagei->pages > 1 ? '
			<p class="c">'.$pagei->pagenumbers().'</p>' : '').'
		</div>
	</div>';
	}
}


ess::$b->page->load();