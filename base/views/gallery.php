<?php

class view_gallery
{
	protected static $active_gallery;
	
	/**
	 * 
	 */
	protected static function pre()
	{
		//ess::$b->page->add_title("Glimt fra UKA");
		
		return '';
	}
	
	/**
	 * Vis hovedsiden for gallerier
	 */
	public static function main($pagei, $galleries)
	{
		$content = self::pre();
		
		$content .= '
<h2>Glimt fra UKA</h2>';
		
		$content .= self::list_galleries($pagei, $galleries, true);
		
		return $content;
	}
	
	/**
	 * List opp gallerier
	 */
	protected static function list_galleries($pagei, $galleries, $show_none = null)
	{
		$content = '';
		
		// ingen gallerier?
		if ($pagei->total == 0)
		{
			if ($show_none)
				$content .= '
<p>Ingen gallerier eksisterer enda.</p>';
		}
		
		else
		{
			// FIXME
			//page::add_css('.gal_list img { margin-bottom: 5px } .gal_list a { background-color: #F8F8F8; border: 1px solid #DDDDDD; text-decoration: none; margin: 5px; padding: 7px; display: block } .gal_list a:hover { text-decoration: none; background-color: #EEEEEE; border-color: #CCCCCC }');
			
			$content .= '
<div class="gc_list">';
			
			foreach ($galleries as $row)
			{
				$link = ess::$s['rpath'].'/galleri/'.$row['gc_id'];
				$d = ess::$b->date->get($row['gc_created']);
				$img = $row['gc_gi_id'] ? '<a href="'.$link.'"><img src="'.ess::$s['rpath'].'/o.php?a=gi&amp;gi_id='.$row['gc_gi_id'].'&amp;gi_size=inside" alt="Galleri bilde" /></a>' : '';
				
				$desc = self::get_short_desc($row['gc_description']);
				
				$content .= '<!--
	--><div class="gc_item'.($img ? '' : ' noimg').'">
		<h3><a href="'.$link.'" title="Gå til galleri">
					<span>'.$d->format("d.m.y").'</span>
					'.htmlspecialchars_utf8($row['gc_title']).'
					</a></h3>'.($img ? '
		<p class="gc_item_img">'.$img.'</p>' : '').($desc ? '
		<div class="gc_desc_w">
			<div class="gc_desc">'.$desc.'</div>
		</div>' : '').'
	</div>';
			}
			
			$content .= '
</div>';
			
			// flere sider med gallerier?
			if ($pagei->pages > 1)
			{
				$content .= '
<p>'.$pagei->pagenumbers().'</p>';
			}
		}
		
		return $content;
	}
	
	/**
	 * Tittel for gallerier
	 */
	protected static function gallery_titles(gallery $gallery)
	{
		$gallery->get_parents();
		foreach ($gallery->parents as $item)
		{
			ess::$b->page->add_title($item[0]);
		}
		
		// legg til tittel for siden
		ess::$b->page->add_title($gallery->data['gc_title']);
	}
	
	/**
	 * Vis et galleri
	 */
	public static function gallery(gallery $gallery, $pagei_gc, $pagei_gi)
	{
		#ess::$b->page->params['no_container'] = true;
		$content = self::pre();
		
		self::gallery_titles($gallery);
		#ess::$b->page->params["no_right"] = true;
		
		// vis informasjon
		$content .= '
		<h2>'.htmlspecialchars_utf8($gallery->data['gc_title']).'</h2>'.(login::$logged_in ? '
		<p class="h_right"><a href="'.ess::$s['rpath'].'/a/galleries.php'.($gallery->data['gc_id'] ? '?gc_id='.$gallery->data['gc_id'] : '').'">Administrer</a></p>' : '');
		
		if ($gallery->data['gc_parent_gc_id'] !== null) $content .= '
		<p><a href="'.ess::$s['rpath'].'/galleri'.($gallery->data['gc_parent_gc_id'] != 0 ? '/'.$gallery->data['gc_parent_gc_id'] : '').'">Tilbake til forrige galleri</a></p>';
		
		// beskrivelse
		if (!empty($gallery->data['gc_description']))
		{
			$content .= '
<div class="gc_desc">'.$gallery->data['gc_description'].'</div>';
		}
		
		// har ingenting?
		if ($pagei_gc->total == 0 && $pagei_gi->total == 0)
		{
			$content .= '
<p>Dette gallerier er tomt.</p>';
		}
		
		// vis undergallerier
		if ($pagei_gc->total > 0)
		{
			$content .= '
<div class="gal_list_sub">'.self::list_galleries($pagei_gc, $gallery->sub_gc).'
</div>';
		}
		
		// vis bilder
		if ($pagei_gi->total > 0)
		{
			$content .= self::list_images($pagei_gi, $gallery->images);
		}
		
		$content .= share_box();
		
		return $content;
	}
	
	/**
	 * List opp bilder
	 */
	protected static function list_images($pagei, $list)
	{
		$content = '';
		
		/*$content = '
		<h2>Bilder</h2>
		<p>Trykk på et bilde for å vise i stor størrelse.</p>';*/
		
		// vis bildene på denne siden
		#$table = new tbody(min($pageinfo->total, 3), "\t\t", false);
		# FIXME page::add_css('.gi_list img { margin-bottom: 5px } .gi_list a { background-color: #F8F8F8; border: 1px solid #DDDDDD; text-decoration: none; margin: 5px; padding: 7px; display: block } .gi_list a:hover { text-decoration: none; background-color: #EEEEEE; border-color: #CCCCCC }');
		
		$content .='
<div class="gi_list">';
		
		foreach ($list as $row)
		{
			$link = ess::$s['rpath'].'/galleri/bilde/'.$row['gi_id'];
			$title = $row['gi_title'] ? htmlspecialchars_utf8($row['gi_title']) : '';
			
			$content .= '<!--
	--><div class="gi_item">
		<div class="gi_item_w">
			<p><a href="'.$link.'" title="'.htmlspecialchars_utf8($row['gi_title']).'"><img src="'.ess::$s['rpath'].'/o.php?a=gi&amp;gi_id='.$row['gi_id'].'&amp;gi_size=gclist" alt="Bilde i galleriet" /></a></p>
		</div>
	</div>';
		}
		
		$content .= '
</div>';
		
		if ($pagei->pages > 1)
		{
			$content .= '
<p>'.$pagei->pagenumbers().'</p>';
		}
		
		return $content;
	}
	
	/**
	 * Enkeltbilde
	 * @TODO
	 */
	public static function image(gallery_image $img, $images, $prev, $next)
	{
		$content = self::pre();
		
		self::gallery_titles($img->gallery);
		#ess::$b->page->params["no_right"] = true;
		
		$js_img = array();
		$js_img_i = array();
		$js_img_active = 0;
		$i = 0;
		foreach ($images as $row)
		{
			$row[3] = $i;
			$js_img[(int)$row[0]] = $row;
			$js_img_i[] = (int)$row[0];
			if ($row[0] == $img->id) $js_img_active = $i;
			
			$i++;
		}
		
		ess::$b->page->add_css('
#bs_footer { margin-bottom: 500px }');
		
		// TODO: analytics sporing når man viser et bilde i mer enn rundt 200ms
		
		ess::$b->page->add_js_domready('
	(function()
	{
		var imgs = '.json_encode($js_img).',
			imgs_i = '.json_encode($js_img_i).',
			active_i = '.json_encode($js_img_active).',
			images = {}, view_timer1, view_timer2;
		
		var img_w = $("gi_image_w"), title = $("gi_title"),
			img_outer = $("gi_image"), img_a = img_outer.getElement("a"),
			img = img_outer.getElement("img"), desc = $("gi_desc"),
			share = $$(".article-share").getFirst();
		load_hm();
		
		window.HM.addEvent("img-changed", function(data) {
			set_img(data);
		});
		window.HM.addEvent("img-removed", function() {
			set_img(null);
		});
		
		var has_history = ("history" in window && "pushState" in window.history);
		if (has_history) (function(){window.history.replaceState({"id": imgs_i[active_i]}, "", '.json_encode(ess::$s['rpath']).'+"/galleri/bilde/"+imgs_i[active_i]);}).delay(100);
		
		$("gi_prev").addEvent("click", function(e){ rotate_img(true); e.stop(); }).addEvent("mousedown", function(e){e.stop()});
		$("gi_next").addEvent("click", function(e){ rotate_img(); e.stop(); }).addEvent("mousedown", function(e){e.stop()});
		
		window.HM.recheck();
		
		function get_path(id, fullsize)
		{
			return '.json_encode(ess::$s['rpath'].'/o.php?a=gi&gi_id=').'+id+"&gi_size="+(fullsize ? "original" : "inside");
		}
		
		function set_img(id, skip_hist)
		{
			if (!imgs[id])
			{
				window.HM.remove("img");
				return;
			}
			
			var d = imgs[id];
			if (d[4] == active_i) return;
			
			img_a.set("href", get_path(id, true));
			img.set("src", get_path(id));
			title.set("text", d[1]);
			desc.set("html", d[2] || "");
			desc.setStyle("display", (d[2] ? "" : "none"));
			
			share.setStyle("visibility", "hidden");
			share.addEvent("load", function()
			{
				share.setStyle("visibility", "visible");
			});
			
			$clear(view_timer1); $clear(view_timer2);
			view_timer1 = (function()
			{
				if (typeof(_gaq) != "undefined") _gaq.push(["_trackPageview", '.json_encode(ess::$s['rpath']).'+"/galleri/bilde/"+id]);
			}).delay(300);
			view_timer2 = (function()
			{
				share.set("src", '.json_encode(share_box_src("SUBST_URL")).'.replace("SUBST_URL", encodeURIComponent('.json_encode(ess::$s['path']).'+"/galleri/bilde/"+id)));
			}).delay(500);
			
			active_i = d[3];
			
			if (!skip_hist)
			{
				if (has_history)
				{
					window.history.pushState({"id": id}, "", '.json_encode(ess::$s['rpath']).'+"/galleri/bilde/"+id);
				}
				else window.HM.set("img", id);
			}
		}
		
		document.addEvent("keydown", function(event)
		{
			if (event.alt || event.control || event.meta || event.shift) return true;
			
			// 27: esc
			if (event.code == 27)
			{
				window.location = $("gi_back").get("href");
			}
			
			// 37: left, 39: right
			else if (event.code == 37 || event.code == 39)
			{
				var t = $(event.target).get("tag");
				if (t == "input" || t == "textarea") return;
				rotate_img(event.code == 37, event);
				
				event.stop();
			}
		});
		
		Element.NativeEvents["popstate"] = 2;
		window.addEvent("popstate", function(e)
		{
			if (!e.event.state || !e.event.state.id) return;
			set_img(e.event.state.id, true);
		});
		
		function rotate_img(prev, event)
		{
			// hent bildet vi skal gå til
			var to = get_upcoming(active_i, prev);
			
			// last inn neste bilde vi forventer at blir vist
			prepare(imgs_i[get_upcoming(to, prev)]);
			
			var id = imgs_i[to];
			set_img(id);
		}
		
		function get_upcoming(i, prev)
		{
			var to = i + (prev ? -1 : 1);
			if (to < 0) to = imgs_i.length-1;
			else if (to >= imgs_i.length) to = 0;
			
			return to;
		}
		
		function prepare(id)
		{
			if (!images[id])
			{
				var d = imgs[id];
				images[id] = new Element("img");
				images[id].set("src", get_path(id));
			}
			
			return images[id];
		}
	})();');
		
		// vis info
		$content .= '
	<h2>'.htmlspecialchars_utf8($img->gallery->data['gc_title']).'</h2>'.(login::$logged_in ? '
	<p class="h_right"><a href="'.ess::$s['rpath'].'/a/galleries.php'.($img->gallery->id ? '?gc_id='.$img->gallery->id : '').'">Administrer</a></p>' : '');
		
		if (!empty($img->gallery->data['gc_description']))
		{
			$content .= '
	<div class="gc_desc">
		'.$img->gallery->data['gc_description'].'
	</div>';
		}
		
		// vis informasjon
		$content .= '
	<p id="gi_nav">
		<a id="gi_back" href="'.ess::$s['rpath'].'/galleri/'.$img->gallery->id.'"><span>Tilbake til galleriet</span></a>
		<a id="gi_prev" href="'.ess::$s['rpath'].'/galleri/bilde/'.$prev[0].'"><span>Forrige bilde</span></a>
		<a id="gi_next" href="'.ess::$s['rpath'].'/galleri/bilde/'.$next[0].'"><span>Neste bilde</span></a><br />(Piltaster kan også benyttes.)
	</p>';
		
		// legg til tittel på siden
		ess::$b->page->add_title($img->data['gi_title'] ?: "Bilde");
		
		// vis informasjon om selve bildet
		$content .= '
	<div class="clear"></div>
	<div id="gi_image_w">
		<h3 id="gi_title">'.(empty($img->data['gi_title']) ? '<i>Mangler tittel</i>' : htmlspecialchars($img->data['gi_title'])).'</h3>
		<p id="gi_image">
			<a href="'.ess::$s['relative_path'].'/o.php?a=gi&amp;gi_id='.$img->data['gi_id'].'&amp;gi_size=original" alt="Vis stort format" class="gi_link">
				<img src="'.ess::$s['relative_path'].'/o.php?a=gi&amp;gi_id='.$img->data['gi_id'].'&amp;gi_size=inside" alt="Bildet" />
			</a>
		</p>
		<!--<p class="gi_sizeinfo">(Trykk på bildet for å vise bildet i full størrelse.)</p>-->
		<div id="gi_desc"'.(!$img->data['gi_description'] ? ' style="display: none"' : '').'>'.$img->data['gi_description'].'</div>
	</div>';
		
		$content .= share_box();
		return $content;
	}
	
	protected function get_short_desc($d)
	{
		return strip_tags($d);
		
		//return preg_replace("~(</p>)?\\s*(<p>\\s*</p>)?$~m", '$1', $d, 1);
	}
}