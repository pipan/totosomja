<?php
class Editor extends CI_Controller{
	
	public function index(){
		$this->load->helper("file");
		$this->load->library("text_editor");
		echo file_get_contents("./application/views/static/basic_body.php");
		$this->text_editor->set_layout("./application/views/static/basic_body.php");
	}
}