<?php

/**
 * This displays the standard menues, and a page according to the GET-varables
 * category and id.
 *
 * @version $Id$
 * @copyright 2009
 */

include "code/layout.php";
include "code/menu.php";


$layoutObj = new layout();
$layoutObj->getTopMenu();
$layoutObj->getPageContent($_GET['category'], $_GET['id']);
$layoutObj->getRightMenu($_GET['category'], $_GET['id']);
$layoutObj->printBuffer();

?>