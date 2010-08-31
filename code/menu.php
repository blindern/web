<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2009
 */

class menu{



	/**
	 * Constructor
	 * @access protected
	 */

	function menu(){
		$this->menu_items; //Contains link to source and link-name
		$this->category_items;  //Contains the category-names
		$this->menu_structure; //Links the links to their categories

		$this->categoryCounter=0;
		$this->itemCounter=0;

		$this->categoryIterator=0;
		$this->itemIterator=0;
		$this->readFile("layout/menu_structure.txt");
	}

	/**
	* This function reads in the menu-file, and adds the content
	* to the menu-structure.
	*/
	function readFile($file){
		$theFile = file($file);
		$currentCategory = -1;
		foreach($theFile as $line){
			$line = trim($line);
			if(substr($line, 0, 1)==":" && substr($line, -1)==":"){ //Were dealing with a category
				$currentCategory = $this->addCategory(substr($line, 1, -1));
			}elseif(substr($line, 0, 2)=="//")
				;
			else { //Were dealing with a menu-item
				$theItem = explode("->", $line);
				$this->addItem($currentCategory, trim($theItem[0]), trim($theItem[1]));
			}
		}
	}

	function addItem($categoryID, $itemName, $itemSource){
		$this->menu_items[$this->itemCounter][0]=$itemName;
		$this->menu_items[$this->itemCounter][1]=$itemSource;
		$this->menu_structure[$categoryID][] = $this->itemCounter;
		return $this->itemCounter++;
	}

	function addCategory($categoryName){
		$this->category_items[$this->categoryCounter]=$categoryName;
		return $this->categoryCounter++;
	}

	/**
	* Returns the name of the next category
	*/
	function getNextCategory(){
		if(isset($this->category_items[$this->categoryIterator]))
			return $this->category_items[$this->categoryIterator++];
		else
			return null;
	}

	/**
	* Returns a array containing [0] name and [1] link
	*/
	function getNextItem($categoryID){
		if(isset($this->menu_structure[$categoryID][$this->itemIterator]))
			return $this->menu_items[$this->menu_structure[$categoryID][$this->itemIterator++]];
		else
			return null;

	}

	function getItemSource($categoryID, $itemID){
		return $this->menu_items[$this->menu_structure[$categoryID][$itemID]][1];
	}

	function getCategoryName($categoryID){
		return $this->category_items[$categoryID];
	}
}

?>