$(document).ready(function() {
	if ($("#omvisning_bilde_w").length == 0) return;
	
	$("#omvisning_nav").append('<br />Piltaster kan også benyttes til å bla mellom bildene.</span>');
	
	var back_link = $("#omvisning_back");
	var prev_link = $("#omvisning_prev");
	var next_link = $("#omvisning_next");
	var next_link2 = $("#omvisning_bilde a")
	var cat = $("#omvisning_cat");
	var link = $("#omvisning_stort a");
	var img = $("#omvisning_bilde img");
	var text = $("#omvisning_bilde_tekst");
	
	var images = {};
	var History = window.History;
	
	prev_link.click(function() { rotate_img(true); return false; });
	next_link.click(function() { rotate_img(); return false; });
	next_link2.click(function() { rotate_img(); return false; });
	
	$(document).keydown(function(e) {
		if (e.altKey || e.ctrlKey || e.metaKey || e.shiftKey) return;
		
		// 27: esc
		if (e.keyCode == 27) {
			window.location.href = "/omvisning/oversikt#c"+omvisning_data[omvisning_i][3];
			return false;
		}
		
		// 37: left, 39: right
		else if (e.keyCode == 37 || e.keyCode == 39) {
			var t = $(e.target).get("tag");
			if (t == "input" || t == "textarea") return;
			rotate_img(e.keyCode == 37, e);
			
			return false;
		}
	});
	
	History.Adapter.bind(window, "statechange", function() {
		var State = History.getState();
		if (State.data.id && State.data.id != omvisning_i) {
			set_active(State.data.id, true);
		}
	});
	
	function rotate_img(prev) {
		var to = get_upcoming(omvisning_i, prev);
		
		// last inn neste bilde vi forventer at blir vist
		prepare(get_upcoming(to, prev));
		
		set_active(to);
	}
	
	function get_upcoming(i, prev) {
		i = prev ? i-1 : i+1;
		if (i < 0) i = omvisning_data.length - 1;
		else if (i >= omvisning_data.length) i = 0;
		
		return i;
	}
	
	function set_active(i, ignore_history) {
		omvisning_i = i;
		prepare(i);
		
		// sett data
		cat.text(omvisning_data[i][0]);
		link.attr("href", '/o.php?a=gi&gi_id='+omvisning_data[i][1]+'&gi_size=original');
		img.attr("src", images[i].attr("src"));
		img.attr("alt", omvisning_data[i][2]);
		text.text(omvisning_data[i][2]);
		
		// oppdater adresse
		back_link.attr("href", "/omvisning/oversikt#c"+omvisning_data[omvisning_i][3]);
		if (!ignore_history) set_state(i);
	}
	
	function set_state(i) {
		if (!History.enabled) return;
		History.pushState({"id": i}, "", "/omvisning/"+omvisning_data[i][1]);
	}
	
	function prepare(i) {
		if (!images[i]) {
			images[i] = $("<img/>");
			images[i].attr("src", '/o.php?a=gi&gi_id='+omvisning_data[i][1]+'&gi_size=inside');
		}
	}
});

$(document).ready(function() {
	if (!$(".omvisning_bilder_sort")) return;
	
	var wrap = $(".omvisning_bilder_sort");
	wrap.sortable({
		opacity: 0.7,
		connectWith: ".omvisning_bilder_sort",
		update: function(e, ui) {
			// hvis flyttet til ny kategori: sørg for at dette er den nye
			if ($(ui.item[0]).parent(".omvisning_bilder_sort").index(this) == -1) {
				return;
			}
			
			var order = $(ui.item[0]).prevAll("p").length + 1;
			var data = {
				"id": $(ui.item[0]).attr("id").substring(4),
				"cat": $(this).parent().find("h2:first").attr("id").substring(1),
				"order": order
			};

			console.log(data);
			
			$.ajax({
				beforeSend: function() {
					console.log("sending");
				},
				complete: function() {
					console.log("saved");
				},
				data: data,
				type: "post",
				url: "/ajax/omvisning.php?move"
			});
		}
	}); // wrap.sortable
});
