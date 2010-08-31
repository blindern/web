<?php

/**
 * This is a class for showing the content of a page
 *
 * @version $Id$
 * @copyright 2009
 */

class showContent{
	$this->category=0;
 	$this->id=0;

	//This section defines where to find the content of the page
 	$this->path = "layout\html";
 	$this->sources[0][0] = "index.html";
 	$this->sources[0][1] = "historie.html";
	$this->sources[0][2] = "om_stiftelsen.html";
	$this->sources[0][3] = "brukets_venner.html";
	$this->sources[1][0] = "studentbolig.html";
	$this->sources[1][1] = "velferdstilbud.html";
	$this->sources[1][2] = "digital_omvisning.php";
	$this->sources[1][3] = "leiepriser.html";
	$this->sources[1][4] = "beliggenhet.html";
	$this->sources[2][0] = "hvem_bor_soke.php";
	$this->sources[2][1] = "soknad.php";
	$this->sources[3][0] = "foreninger.html";
	$this->sources[3][1] = "hyttestyret.html";
	$this->sources[3][2] = "tradisjoner.html";
	$this->sources[3][3] = "arrangementplan.html";
	$this->sources[4][0] = "kontakt.html";
	$this->sources[4][1] = "ansatte.html";
	$this->sources[4][2] = "om_nettsidene.html";


 	/**
 	 * Constructor
 	 * @access protected
 	 */
 	function showContent ($category, $id){
		if(!(isset($category)&&is_numeric($category)))
			$category = 0;

		if((!(isset($category]&&is_numeric($category)))
			$category = 0;
		$this->category=$category;
		$this->id=$id;
 	}

	function getPage(){
		return file_get_contents($this->sources[$this->category][$this->id])
	}
}

?>