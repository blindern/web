$(document).ready(function() {
	boxHandleObj.locate(document);
})


/**
 * Markeringsbokser (som rader)
 */
var boxHandleElms = {};

function boxHandleItem(wrap, box) {
	this.init = function(wrap, box) {
		wrap = $(wrap); box = $(box);
		box.css("display", "none");
		
		// deaktivert?
		this.disabled = false;
		if (box.prop("disabled")) {
			this.disabled = true;
		}
		
		// legg til elementet
		this.name = box.attr("rel") || box.prop("name")+"".replace(new RegExp("^(.*)\\[.+?\\]$"), "$1[]");
		this.multiple = box.attr("type") == "checkbox";
		boxHandleElms[this.name] = boxHandleElms[this.name] || [];
		boxHandleElms[this.name].push(this);
		
		this.wrap = wrap;
		this.box = box;
		this.elements = this.wrap.tagName == "tr" ? this.wrap.find("td") : [this.wrap];
		
		
		// sjekk for mellomrom i cellen
		/* FIXME if (this.wrap.tagName == "tr" || this.wrap.tagName == "td")
		{
			if (this.wrap.getSize().y < 25 || this.elements[0].getStyle("height") == "auto") this.wrap.addClass("spacerfix");
		}*/
		
		if (!this.disabled) {
			// sett pointer
			wrap.css("cursor", "pointer");
			var self = this;
			wrap.hover(function() {
					self.mouseover();
				}, function() {
					self.mouseout();
				}).click(function(e) {
					console.log(e.target.tagName);
					self.click(e);
				});
		}
		
		this.hover = false;
		this.checked = this.box.prop("checked");
		this.classname = null;
		this.showimg = !this.wrap.hasClass("box_handle_noimg");
		
		// TODO
		if (this.showimg && false) {
			this.elements[0].css({
				"background-image": 'url(https://hsw.no/static/other/checkbox_'+(this.disabled ? 'disabled' : (this.checked ? 'yes' : 'no'))+'.gif)',
				"background-position": 'left center',
				"background-repeat": 'no-repeat',
				"paddingLeft": '25px'
			});
		}
		
		if (!this.disabled) this.check();
	};
	
	this.mouseover = function() {
		this.hover = true;
		this.set_background();
	};
	
	this.mouseout = function() {
		this.hover = false;
		this.set_background();
	};
	
	this.click = function(e) {
		// klikket vi en link?
		if ($(e.target).tagName == "a") return;
		
		this.checked = !this.checked;
		
		// har vi noen andre elementer som må krysses ut?
		var self = this;
		if (this.checked && !this.multiple && boxHandleElms[this.name].length > 1) {
			boxHandleElms[this.name].each(function(i, obj) {
				if (!obj.checked || obj == self) return;
				obj.checked = false;
				obj.check();
			});
		}
		
		this.check();
	};
	
	this.check = function() {
		this.box.prop("checked", this.checked);
		//this.box.trigger((this.checked ? "" : "un")+"click");
		
		// TODO
		if (this.showimg && false)
		{
			this.elements[0].css("background-image", 'url(https://hsw.no/other/checkbox_'+(this.checked ? 'yes' : 'no')+'.gif)');
		}
		this.set_background();
	};
	
	this.set_background = function() {
		// finn ut fargen
		var classname = this.checked ? (this.hover ? "box_handle_checked_hover" : "box_handle_checked") : (this.hover ? "box_handle_hover" : "box_handle_normal");
		if (classname != this.classname) {
			
			var self = this;
			$(this.elements).each(function(i, elm) {
				$(elm).removeClass(self.classname).addClass(classname);
			});
			
			this.classname = classname;
		}
		
		return;
	};
	
	this.init(wrap, box);
}
var boxHandleObj = {
	locate: function(element) {
		// finn alle bokswrappere
		$(element).find(".box_handle").each(function(i, wrap) {
			// finn boksen
			var box = $(wrap).find("input:first");
			
			// allerede gått gjennom denne?
			if (box.data("boxHandle")) return;
			box.data("boxHandle", true);
			
			// legg til boksen
			new boxHandleItem(wrap, box);
		});
		
		// finn alle toogle linker
		$(element).find(".box_handle_toggle").each(function(i, elm) {
			elm = $(elm);
			
			// allerede gått gjennom denne?
			if (elm.data("boxHandleOK")) return;
			elm.data("boxHandleOK", true);
			
			// finn navn
			var name = elm.attr("rel");
			if (!name || !boxHandleElms[name] || !boxHandleElms[name][0].multiple) return;
			
			// legg til event
			elm.click(function() {
				$(boxHandleElms[name]).each(function(i, obj) {
					obj.checked = !obj.checked;
					obj.check();
				});
				
				return false;
			});
		});
	}
};