<?php

require "../base/base.php";
ess::$b->page->theme = "a";

if (!defined("ALLOW_GUEST"))
{
	access::no_guest();
}

define("ADMIN_AREA", true);
nodes::add_node(0, "Administrasjon", ess::$s['relative_path'].'/a/index.php');