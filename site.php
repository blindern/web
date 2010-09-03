<?php

/*
 * Denne siden sørger for videresending fra gamle adresser til nye adresser.
 */

require "base/base.php";

if (!isset($_GET['category']) || !isset($_GET['id'])) redir();

$map = array(
	array(
		"index",
		"om/historie",
		"om/stiftelsen",
		"om/bruketsvenner"
	),
	array(
		"studentboliger",
		"studentboliger/velferdstilbud",
		"studentboliger/omvisning",
		"studentboliger/leiepriser",
		"studentboliger/beliggenhet"
	),
	array(
		"hvem_bor_soke",
		"hvem_bor_soke/sok_om_plass"
	),
	array(
		"foreninger",
		"smaabruket",
		"foreninger/tradisjoner",
		"foreninger/arrangementplan"
	),
	array(
		"administrasjonen",
		"administrasjonen/ansatte",
		"administrasjonen/om_nettsidene"
	)
);

if (!isset($map[$_GET['category']][$_GET['id']]))
{
	redir();
}

redir($map[$_GET['category']][$_GET['id']]);