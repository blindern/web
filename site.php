<?php

function redir($page = "")
{
	$https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? "s" : "";
	$port = $_SERVER['SERVER_PORT'] != 80 ? ($_SERVER['SERVER_PORT'] == 443 && $https ? "" : ":".$_SERVER['SERVER_PORT']) : "";
	$location = "http".$https."://".$_SERVER['SERVER_ADDR'].$port.dirname($_SERVER['SCRIPT_NAME']) . "/$page";
	
	// send til siden
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: $location");
	die('<HTML><HEAD><TITLE>302 Found</TITLE></HEAD><BODY><H1>Found</H1>You have been redirected <A HREF="'.$location.'">here</A>.<P></BODY></HTML>');
}

if (!isset($_GET['category']) || !isset($_GET['id'])) redir();

$map = array(
	array(
		"index",
		"historie",
		"stiftelsen",
		"bruketsvenner"
	),
	array(
		"studentboliger",
		"velferdstilbud",
		"omvisning",
		"leiepriser",
		"beliggenhet"
	),
	array(
		"hvem_bor_soke",
		"sok_om_plass"
	),
	array(
		"foreninger",
		"hyttestyret",
		"tradisjoner",
		"arrangementplan"
	),
	array(
		"administrasjonen",
		"ansatte",
		"om_nettsidene"
	)
);

if (!isset($map[$_GET['category']][$_GET['id']]))
{
	redir();
}

redir($map[$_GET['category']][$_GET['id']]);