/**
 * Markeringsbokser (som rader)
 */
var boxHandleElms = {};
var boxHandleItem = new Class({
	initialize: function(wrap, box)
	{
		box.setStyle("display", "none");
		
		// deaktivert?
		this.disabled = false;
		if (box.get("disabled"))
		{
			this.disabled = true;
		}
		
		// legg til elementet
		this.name = box.get("rel") || box.get("name").replace(new RegExp("^(.*)\\[.+?\\]$"), "$1[]");
		//this.multiple = !this.name.test("\\[\\]$");
		this.multiple = box.get("type") == "checkbox";
		boxHandleElms[this.name] = boxHandleElms[this.name] || [];
		boxHandleElms[this.name].push(this);
		
		this.wrap = wrap;
		this.box = box;
		this.elements = this.wrap.get("tag") == "tr" ? this.wrap.getChildren("td") : [this.wrap];
		
		// sjekk for mellomrom i cellen
		if (this.wrap.get("tag") == "tr" || this.wrap.get("tag") == "td")
		{
			//var height = 0;
			//console.log(this.wrap.getSize().y);
			//console.log(this.elements[0].getStyle("height") == "auto");
			//height = Math.max(this.wrap.getSize().y, this.elements[0].getStyle("height").toInt()+this.elements[0].getStyle("paddingTop").toInt())
			//console.log(height);
			if (this.wrap.getSize().y < 25 || this.elements[0].getStyle("height") == "auto") this.wrap.addClass("spacerfix");
			//console.log(this.elements[0].getStyle("minHeight"));
		}
		
		if (!this.disabled)
		{
			// sett pointer
			this.wrap.setStyle("cursor", "pointer");
			
			wrap.addEvent("mouseenter", this.mouseover.bind(this));
			wrap.addEvent("mouseleave", this.mouseout.bind(this));
			wrap.addEvent("click", this.click.bind(this));
		}
		
		this.hover = false;
		this.checked = this.box.get("checked");
		this.classname = null;
		this.showimg = !this.wrap.hasClass("box_handle_noimg");
		
		// TODO
		if (this.showimg && false)
		{
			this.elements[0].setStyles({
				"backgroundImage": 'url('+static_link+'/other/checkbox_'+(this.disabled ? 'disabled' : (this.checked ? 'yes' : 'no'))+'.gif)',
				"backgroundPosition": 'left center',
				"backgroundRepeat": 'no-repeat',
				"paddingLeft": '25px'
			});
		}
		
		if (!this.disabled) this.check();
	},
	mouseover: function()
	{
		this.hover = true;
		this.setBackground();
	},
	mouseout: function()
	{
		this.hover = false;
		this.setBackground();
	},
	click: function(event)
	{
		// klikket vi en link?
		if ($(event.target).get("tag") == "a")
		{
			return;
		}
		
		this.checked = !this.checked;
		
		// har vi noen andre elementer som må krysses ut?
		var self = this;
		if (this.checked && !this.multiple && boxHandleElms[this.name].length > 1)
		{
			boxHandleElms[this.name].each(function(obj)
			{
				if (!obj.checked || obj == self) return;
				obj.checked = false;
				obj.check();
			});
		}
		
		this.check();
	},
	check: function()
	{
		this.box.set("checked", this.checked);
		this.box.fireEvent((this.checked ? "" : "un")+"click");
		
		// TODO
		if (this.showimg && false)
		{
			this.elements[0].setStyle("backgroundImage", 'url('+static_link+'/other/checkbox_'+(this.checked ? 'yes' : 'no')+'.gif)');
		}
		this.setBackground();
	},
	setBackground: function()
	{
		// finn ut fargen
		var classname = this.checked ? (this.hover ? "box_handle_checked_hover" : "box_handle_checked") : (this.hover ? "box_handle_hover" : "box_handle_normal");
		if (classname != this.classname)
		{
			var self = this;
			this.elements.each(function(elm)
			{
				elm.removeClass(self.classname).addClass(classname);
			});
			
			this.classname = classname;
		}
		
		return;
			
		//var color = this.checked ? (this.hover ? this.colors[3] : this.colors[2]) : (this.hover ? this.colors[1] : this.colors[0]);
		
		/*this.elements.each(function(elm)
		{
			elm.setStyle("backgroundColor", color);
		});*/
	}
});
var boxHandleObj = {
	locate: function(element)
	{
		// finn alle bokswrappere
		$(element).getElements(".box_handle").each(function(wrap)
		{
			// finn boksen
			var box = wrap.getElement("input");
			
			// allerede gått gjennom denne?
			if (box.retrieve("boxHandle")) return;
			box.store("boxHandle", true);
			
			// legg til boksen
			new boxHandleItem(wrap, box);
		});
		
		// finn alle toogle linker
		$(element).getElements(".box_handle_toggle").each(function(elm)
		{
			// allerede gått gjennom denne?
			if (elm.retrieve("boxHandleOK")) return;
			elm.store("boxHandleOK", true);
			
			// finn navn
			var name = elm.get("rel");
			if (!name || !boxHandleElms[name] || !boxHandleElms[name][0].multiple) return;
			
			// legg til event
			elm.addEvent("click", function(event)
			{
				event.stop();
				
				//var checked = !boxHandleElms[name][0].checked;
				boxHandleElms[name].each(function(obj)
				{
					obj.checked = !obj.checked;
					//obj.checked = checked;
					obj.check();
				});
			});
		});
	}
};