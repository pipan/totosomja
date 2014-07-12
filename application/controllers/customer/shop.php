<?php
class Shop extends CI_Controller{
	
	public $data;
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('file');
		$this->load->helper('builder');
		is_login($this);
		
		$this->data['login'] = $this->session->userdata('login');
	}
	
	public function index($language = "sk"){
		$this->data['title'] = "totosomja - tri&#269;k&aacute; s joga, vegan a vegetarian tematikou";
		$this->lang->load("general", $language);
		$this->data['lang'] = $this->lang;
		$this->data['language'] = $language;
		
		$this->load->view("templates/header", $this->data);
		$this->load->view("templates/banner", $this->data);
		$this->load->view("templates/social", $this->data);
		$this->load->view("templates/footer", $this->data);
	}
}