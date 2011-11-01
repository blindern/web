<?php

$u = "removing cookies..<br />\n";

foreach ($_COOKIE as $key => $cookie)
{
	// rem cookie
	setcookie($key, "", time()-1728000, $__server['cookie_path'], $__server['cookie_domain']);
	$u .= "cookie removed: $key (original value: ".htmlspecialchars_utf8($cookie).")<br />\n";
}

echo $u;

?>