<?php

bs_side::set_title("Internmail");
bs_side::$head .= '
<meta name="robots" content="noindex, nofollow" />';

bs_side::$menu_active = "beboer";

echo '
<h1>Internmailen</h1>
<p><b>Avmelding:</b></p>
<ol>
       <li>Send en e-post til <b>sympa@studorg.uio.no</b> med emnet:<br />
               <code>unsubscribe blindernbeboere</code></li>
       <li>Du vil motta en bekreftelse for at du ble avmeldt</li>
       <li>Se <a href="http://www.uio.no/tjenester/it/e-post-kalender/e-postlister/abonnere/unsub.html">brukerveiledningen</a> for hjelp</li>
</ol>
<p>Mer informasjon om listen ligger i wikien:<br /><a href="https://foreningenbs.no/wiki/Internmailen">https://foreningenbs.no/wiki/Internmailen</a></p>';
