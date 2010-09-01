<?php

bs_side::$head .= '
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
		<script type="text/javascript">
		var flashvars = {};
		flashvars.baseURL="simpleviewer/";
		flashvars.galleryURL = "gallery.xml";
		var params = {};
		params.bgcolor = "222222";
		params.allowfullscreen = true;
		params.allowscriptaccess = "always";
		swfobject.embedSWF("'.bs_side::$pagedata->doc_path.'/simpleviewer/simpleviewer.swf", "flashContent", "100%", "650", "9.0.124", false, flashvars, params);
		</script>';

?>
                            <!--
							<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="640" height="480" id="omvisning" align="middle">
                              <param name="allowScriptAccess" value="sameDomain" />
                              <param name="movie" value="omvisning.swf" />

                              <param name="quality" value="high" />
                              <param name="bgcolor" value="#ffffff" />
                              <embed src="omvisning.swf" quality="high" bgcolor="#ffffff" width="640" height="480" name="omvisning" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
                            </object>
                            -->
                            <h1>Digital Omvisning</h1>
                            <h2 style="margin-bottom: 10px">Blider fra Blinderen Studenterhjem</h2>
							<div id="flashContent">SimpleViewer requires JavaScript and the Flash Player.
							<a href="http://www.adobe.com/go/getflashplayer/">Get Flash.</a></div><br>
                            <h2 style="margin-top: 20px">Media om Blindern Studenterhjem: </h2>
                            <p>
                            	Blindern Studenterhjem ble k&aring;ret av TV-Norge
                            	til beste studentbolig i Oslo.<br>
							</p>
                            <object width="425" height="350">
                              <param name="movie" value="http://www.youtube.com/v/0q4U6N6Qsd4"></param>
                              <embed src="http://www.youtube.com/v/0q4U6N6Qsd4" type="application/x-shockwave-flash" width="425" height="350"></embed>
							</object>