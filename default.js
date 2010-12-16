/*
 * JavaScript for Blindern Studenterhjem
 * Skrevet av Henrik Steen
 * www.henrist.net
 *
 * Beskyttet av åndsverkloven
 * Alle rettigheter tilhører Henrik Steen dersom ikke annet er oppgitt
 *
 * Copyright (c) 2010 All rights reserved
 */

/**
 * Scrolle til et element i y-retning
 */
Element.implement({
	goto: function(offset, instant)
	{
		if (!offset) offset = 0;
		
		// direkte
		if (instant)
		{
			window.scrollTo(false, this.getPosition().y+offset);
		}
		
		// myk scroll
		else
		{
			if (!window.scroll.start) window.scroll = new Fx.Scroll(window, {duration: 250, transition: Fx.Transitions.Expo.easeOut});
			window.scroll.start(false, this.getPosition().y+offset);
		}
		
		return this;
	}
});

// start HashListener 1.0
/*
---
description: A Class that provides a cross-browser history-management functionaility, using the browser hash to store the application's state

license: MIT-style

authors:
- Arieh Glazer
- Dave De Vos
- Digitarald

requires:
- core/1.2.4: [Class,Class.Extras,Element]

provides: [HashListener]

patched by Henrik Steen
...
*/
$extend(Element.NativeEvents, {
	hashchange: 1
});

var HashListener = new Class({
	Implements : [Options,Events],
	options : {
		blank_page : 'blank.html',
		start : false
	},
	iframe : null,
	currentHash : '',
	firstLoad : true,
	handle : false,
	useIframe : (Browser.Engine.trident && (typeof(document.documentMode)=='undefined' || document.documentMode < 8)),
	ignoreLocationChange : false,
	initialize : function(options){
		var $this=this;
		
		this.setOptions(options);
		
		// Disable Opera's fast back/forward navigation mode
		if (Browser.Engine.presto && window.history.navigationMode) {
			window.history.navigationMode = 'compatible';
		}
		
		// IE8 in IE7 mode defines window.onhashchange, but never fires it...
		if (('onhashchange' in window) && (typeof(document.documentMode) == 'undefined' || document.documentMode > 7)){
			// The HTML5 way of handling DHTML history...
			window.addEvent('hashchange' , function () {
				$this.handleChange($this.getHash());
			});
		} else  {
			if (this.useIframe){
				this.initializeHistoryIframe();
			} 
		} 
		
		window.addEvent('unload', function(event) {
			$this.firstLoad = null;
		});
		
		if (this.options.start) this.start();
	},
	initializeHistoryIframe : function(){
		var hash = this.getHash(), doc;
		this.iframe = new IFrame({
			src		: this.options.blank_page,
			styles	: { 
				'position'	: 'absolute',
				'top'		: 0,
				'left'		: 0,
				'width'		: '1px', 
				'height'	: '1px',
				'visibility': 'hidden'
			}
		}).inject(document.body);

		doc	= (this.iframe.contentDocument) ? this.iframe.contentDocument  : this.iframe.contentWindow.document;
		doc.open();
		doc.write('<html><body id="state">' + hash + '</body></html>');
		doc.close();
		return;
	},
	checkHash : function(){
		var hash = this.getHash(), ie_state, doc;
		if (this.ignoreLocationChange) {
			this.ignoreLocationChange = false;
			return;
		}

		if (this.useIframe){
			doc	= (this.iframe.contentDocument) ? this.iframe.contentDocumnet  : this.iframe.contentWindow.document;
			ie_state = doc.body.innerHTML;
			
			if (ie_state!=hash){
				this.setHash(ie_state);
				hash = ie_state;
			} 
		}		
		
		if (this.currentLocation == hash) {
			return;
		}
		
		this.currentLocation = hash;
		
		this.handleChange(hash);
	},
	setHash : function(newHash){
		window.location.hash = this.currentLocation = newHash;
		
		if (
			('onhashchange' in window) &&
			(typeof(document.documentMode) == 'undefined' || document.documentMode > 7)
		   ) return;
		
		this.handleChange(newHash);
	},
	getHash : function(){
		var m;
		if (Browser.Engine.gecko){
			m = /#(.*)$/.exec(window.location.href);
			return m && m[1] ? m[1] : '';
		}else if (Browser.Engine.webkit){
			return decodeURI(window.location.hash.substr(1));
		}else{
			return window.location.hash.substr(1);
		}
	},
	handleChange: function(newHash)
	{
		if (newHash == this.currentHash) return;
		this.currentHash = newHash;
		
		this.fireEvent('hashChanged',newHash);
		this.fireEvent('hash-changed',newHash);
	},
	setIframeHash: function(newHash) {
		var doc	= (this.iframe.contentDocument) ? this.iframe.contentDocumnet  : this.iframe.contentWindow.document;
		doc.open();
		doc.write('<html><body id="state">' + newHash + '</body></html>');
		doc.close();
		
	},
	updateHash : function (newHash){
		if ($type(document.id(newHash))) {
			this.debug_msg(
				"Exception: History locations can not have the same value as _any_ IDs that might be in the document,"
				+ " due to a bug in IE; please ask the developer to choose a history location that does not match any HTML"
				+ " IDs in this document. The following ID is already taken and cannot be a location: "
				+ newLocation
			);
		}
		
		this.ignoreLocationChange = true;
		
		if (this.useIframe) this.setIframeHash(newHash);
		else this.setHash(newHash);
	},
	start : function(){
		this.handle = this.checkHash.periodical(100, this);
	},
	stop : function(){
		$clear(this.handle);
	}
});
// end HashListener


/**
 * Hent HistoryManager objekt
 * @requires HashListener
 * Syntaks i document.hash: #var1=data1;var2=data2
 * I utgangspunktet kun ment for enkel data hvor ; og = ikke er inkludert i nøkkel/verdi
 */
function load_hm()
{
	if (window.HM) return;
	
	var HM = new Class({
		Extends: HashListener,
		initialize: function(options)
		{
			this.parent(options);
			this.addEvent("hashChanged", this.checkChange.bind(this));
			this.start();
		},
		hashlist: new Hash(),
		hashtmp: new Hash(),
		checkChange: function(hash)
		{
			if (hash.substring(0, 1) != "?") hash = "";
			var list = this.getHashObj(hash.substring(1));
			
			this.hashlist.each(function(value, key)
			{
				// fjernet?
				if (!list.has(key))
				{
					this.fireEvent(key+"-removed");
					this.hashlist.erase(key);
					return;
				}
				
				// oppdatert?
				var v = list.get(key);
				if (value != v)
				{
					this.hashlist.set(key, v);
					this.fireEvent(key+"-updated", v);
					this.fireEvent(key+"-changed", v);
				}
				
				list.erase(key);
			}.bind(this));
			
			list.each(function(value, key)
			{
				// lagt til
				this.hashlist.set(key, value);
				this.fireEvent(key+"-added", value);
				this.fireEvent(key+"-changed", value);
			}.bind(this));
			
			this.hashtmp = new Hash(this.hashlist);
		},
		getHashObj: function(string)
		{
			var list = new Hash();
			string.split(";").each(function(val)
			{
				if (val == "") return;
				var d = val.split("=", 2);
				if (!d[1]) d[1] = "";
				list.set(d[0], d[1]);
			});
			return list;
		},
		getString: function(hash)
		{
			var list = [];
			hash.each(function(value, key)
			{
				list.push(key+(value == "" ? "" : "=" + value));
			});
			return list.join(";");
		},
		set: function(key, value)
		{
			this.hashtmp.set(key, value);
			this.update();
		},
		remove: function(key)
		{
			this.hashtmp.erase(key);
			this.update();
		},
		update: function()
		{
			if (this.hashtmp.getLength() == 0) this.updateHash("");
			else this.updateHash("?"+this.getString(this.hashtmp));
		},
		recheck: function()
		{
			this.hashlist = new Hash();
			this.checkChange(this.getString(this.hashtmp));
		}
	});
	
	window.HM = new HM();
}