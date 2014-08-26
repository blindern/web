<?php

#if ($_SERVER['REQUEST_URI'] == "/beboer/matmeny") {
#	define("FORCE_HTTPS", true);
#}

require "base/base.php";

bs_side::main();
