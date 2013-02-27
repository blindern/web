<?php

require ROOT."/base/omvisning.php";
bs_side::$page_class = "omvisninga";

class omvisning__admin extends omvisning {
	protected $show_hidden = true;
	
	public function __construct() {
		bs_side::set_title("Digital omvisning", "Omorganiser bilder");
		jquery();
		
		access::no_guest();
		
		ess::$b->page->add_js_file(ess::$s['rpath'].'/omvisning.js');
		
		// hent inn alle bildene
		$this->get_images();
		
		$this->show();
	}
	
	private function show() {
		// lagre alle bilder for javascript
		list($img_i, $data) = $this->get_js_array();
		
		ess::$b->page->add_js('
var omvisning_i = '.$img_i.';
var omvisning_data = '.json_encode($data).';');
		
		echo '
	<h1>Omorganiser bilder</h1>
	<div id="omvisning_bilder">';
		
		foreach ($this->galleries as $gallery_id => $gallery)
		{
			echo '
		<div class="omvisning_bilder_cat">
			<h2 id="c'.$gallery_id.'">'.htmlspecialchars($gallery['title']).'</h2>
			<div class="omvisning_bilder_sort omvisning_bilder_g">';
			
			foreach ($gallery['images'] as $image)
			{
				$text = $this->get_image_text($image);
				
				echo '<!-- avoid inline-block spacing
			--><p id="img_'.$image['gi_id'].'"><!--
				--><img src="'.ess::$s['relative_path'].'/o.php?a=gi&amp;gi_id='.$image['gi_id'].'&amp;gi_size=thumb_omvisning" alt="'.htmlspecialchars($text).'" title="'.htmlspecialchars($text).'" /><!--
				--></p>';
			}
			
			echo '
			</div>
		</div>';
		}
		
		echo '
	</div>';
	}
}

new omvisning__admin();