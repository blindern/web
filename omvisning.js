
$(document).ready(function() {
	alert("we are ready!");
	
}
/*

window.addEvent("domready", function()
{
	active_img = null;
	load_hm();
	var images = {};
	
	window.HM.addEvent("img-changed", function(data) {
		set_img(data);
	});
	window.HM.addEvent("img-removed", function() {
		set_img(null);
	});
	
	$$("#omvisning_bilder p").addEvent("click", function(e)
	{
		window.HM.set("img", this.get("id").substring(4));
		prepare(get_upcoming(this));
		
		(function(){$("omvisning_bilde").getParent().goto(-10);}).delay(1);
		
		e.stop();
	});
	$("omvisning_back").addEvent("click", function(){ window.HM.remove("img"); }).addEvent("mousedown", function(e){e.stop()});
	$("omvisning_prev").addEvent("click", function(){ rotate_img(true); }).addEvent("mousedown", function(e){e.stop()});
	$("omvisning_next").addEvent("click", function(){ rotate_img(); }).addEvent("mousedown", function(e){e.stop()});
	$("omvisning_bilde").addEvent("click", function(){ rotate_img(); });
	
	window.HM.recheck();
	
	function set_img(id)
	{
		var pa = active_img;
		var p = active_img = $("img_"+id);
		if (!p)
		{
			$("omvisning_bilde_inactive").setStyle("display", "");
			$("omvisning_bilde_w").addClass("omvisning_bilde_skjult");
			if (id) window.HM.remove("img");
			
			if (pa) pa.goto(-30);
			
			return;
		}
		
		$$("#omvisning_bilder p").removeClass("omvisning_aktiv");
		$("omvisning_bilde_inactive").setStyle("display", "none");
		
		var c = $("omvisning_bilde");
		c.empty().getParent().removeClass("omvisning_bilde_skjult");
		
		prepare(p).inject(c);
		new Element("p", {text: p.getElement("img").get("alt")}).inject(c);
		
		// sett thumbnail som aktivt
		p.addClass("omvisning_aktiv");
	}
	
	document.addEvent("keydown", function(event)
	{
		if (event.alt || event.control || event.meta || event.shift) return;
		
		// 27: esc
		if (event.code == 27)
		{
			window.HM.remove("img");
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
	
	function rotate_img(prev, event)
	{
		// har vi bilde som referanse?
		if (!active_img) return;
		
		// hent bildet vi skal gå til
		var to = get_upcoming(active_img, prev);
		
		// last inn neste bilde vi forventer at blir vist
		prepare(get_upcoming(to, prev));
		
		window.HM.set("img", to.get("id").substring(4));
	}
	
	function get_upcoming(elm, prev)
	{
		var to = prev ? elm.getPrevious("p") : elm.getNext("p");
		
		// prøv neste gruppe
		if (!to)
		{
			to = elm.getParent(".omvisning_bilder_cat")[prev ? "getPrevious" : "getNext"](".omvisning_bilder_cat");
			if (to) to = to.getElement("div")[prev ? "getLast" : "getFirst"]("p");
		}
		
		// roter til første/siste bilde
		if (!to)
		{
			f = prev ? "getLast" : "getFirst";
			to = $("omvisning_bilder")[f]("div").getElement("div")[f]("p");
		}
		
		return to;
	}
	
	function prepare(p)
	{
		var id = p.get("id").substring(4);
		if (!images[id])
		{
			images[id] = new Element("img");
			images[id].set("src", p.getElement("a").get("href"));
		}
		
		return images[id];
	}
});*/