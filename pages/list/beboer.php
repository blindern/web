<?php

bs_side::set_title("Beboere");
bs_side::$head .= '
<meta name="robots" content="noindex, nofollow" />';

bs_side::$menu_active = "beboer";

// gi status som beboer siden vi ser på denne siden
bs::beboer_cookie_set();

header("Location: https://foreningenbs.no/beboer");
die;