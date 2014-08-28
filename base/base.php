<?php

error_reporting(E_ALL);

// starter utdata buffer
ob_start();

// grunnpath
define("ROOT", dirname(dirname(__FILE__)));

// mappe hvor vi skal cache for fil-cache (om ikke APC er til stede)
define("CACHE_FILES_DIR", "/tmp");
define("CACHE_FILES_PREFIX", "blindernstudcache_");

// mappe hvor bildene til galleriet er
define("GALLERY_FOLDER", ROOT."/graphics/omvisning");

require ROOT."/base/extra/class.bs.php";
require ROOT."/base/extra/class.bs_matmeny.php";
require ROOT."/base/bs_side.php";