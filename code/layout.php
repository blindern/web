<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2009
 */
/**
 *
 *
 */
class layout{



	function layout(){
		$this->path = "layout/";
		$this->page = '<div id="container">
							<div id="header"><a href="index.php">
							<img src="graphics/layout/new_header.jpg" width="800" height="100" border=0></a>
						</div>';
		$this->menu = new menu();
		$this->output;
		$this->head= file_get_contents($this->path."html_top.html");
		$this->head.= "<head>";
		$this->head.= '<title>Blindern Studenterhjem - Et godt hjem for studenter</title>
						<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
						<link rel="stylesheet" type="text/css" href="layout/layout.css" />';
	}

	/**
	* Returns a string containing the top menu
	*/
	function getTopMenu(){
		$output = "\t\t<div id=\"menu-top\">";
		$i=0;
		for($nextName = $this->menu->getNextCategory(); $nextName!=NULL; $nextName = $this->menu->getNextCategory()){
			if($i!==0)
				$output .= " - ";
			$output .="\t\t\t<a href=\"site.php?category=$i&id=0\">$nextName</a>\n";
			$i++;
		}
		$output .= "\t\t</div>\n";
		$this->page .= $output;
	}

	function getRightMenu($categoryID, $thisItem){
		$output = "\t\t\t<div class=\"rightMenu\">\n";
		$output .= "\t\t\t\t<h1>".$this->menu->getCategoryName($categoryID)."</h1>\n";
		$i=0;
		for($nextItem = $this->menu->getNextItem($categoryID); $nextItem!=NULL;$nextItem = $this->menu->getNextItem($categoryID)){
			if($i == $thisItem)
				$highlight = " highlight";
			else
				$highlight = "";
			$output .="\t\t\t\t<a class=\"rightMenu$highlight\" href=\"site.php?category=$categoryID&id=$i\">» ".$nextItem[0]."</a>\n";
			$i++;
		}
		$output .= "\t\t\t</div>\n";
		$output .= "\t\t</div>\n";
		$this->page .= $output;
	}

	function getPageContent($categoryID, $itemID){
		$file = $this->menu->getItemSource($categoryID, $itemID);
		$this->page .= "\t\t<div id=\"contentContainer\">\n";
		$this->page .= "\t\t\t<img src='graphics/".$this->path."600x9topp.gif' style='display:block' width=600 height=9>\n";
		$this->page .= "\t\t\t<div id=\"content\">\n";

		if(substr($file, -4)==".php"){
			ob_start();
			include($this->path."html/".$file);
			$this->page .= ob_get_contents();
			ob_end_clean();
		} else {
			$this->page .= file_get_contents($this->path."html/".$file);
		}
		$this->page .="\t\t\t</div>\n";
	}

	function printBuffer(){
		$this->output = $this->head.$this->page;
		$this->output .= file_get_contents($this->path."footer.html");
		$this->output .= file_get_contents($this->path."html_bot.html");
		echo $this->output;
	}
}

?>