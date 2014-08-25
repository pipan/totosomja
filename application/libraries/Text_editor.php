<?php
class Text_editor{
	
	private $layout;
	private $correct = false;
	
	public function __construct(){
		
	}
	
	public function set_layout($file){
		if (file_exists($file)){
			echo "TRUE";
		}
		$open = popen($file, "r");
		$this->layout = fread($open, filesize($file));
		echo $this->layout;
		if (preg_match_all('/\$.+;/', $this->layout, $match) == 1){
			foreach ($match as $m){
				echo $m;
			}
			$correct = true;
		}
		else{
			echo "false";
		}
	} 
}