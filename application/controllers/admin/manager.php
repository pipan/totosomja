<?php
class Manager extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('bcrypt');
		$this->load->model('admin_model');
	}
	
	public function login_validation(){
		if ($admin = $this->admin_model->search_full_nick($this->input->post('name'))){
			if ($this->bcrypt->check_password($this->input->post('password').$admin['salt'], $admin['password'])){
				return true;
			}
		}
		$this->form_validation->set_message('login_validation', 'Wrong password or login');
		return false;
	}
	
	public function login_session($name){
		$this->session->set_userdata('admin_id', $this->admin_model->search_full_nick($name)['id']);
	}
	
	public function index(){
		if (is_admin_login($this)){
			$language = "sk";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language; 
			
			$data['title'] = "totosomja - sprava login";
			 
			$this->load->view("templates/header_manager", $data);
			$this->load->view("manager/index", $data);
			$this->load->view("templates/right_body_manager", $data);
			$this->load->view("templates/footer", $data);
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function login(){
		$language = "sk";
		$this->lang->load("general", $language);
		$data['lang'] = $this->lang;
		$data['language'] = $language;
		$data['login'] = $this->session->userdata('login');
		
		$this->form_validation->set_rules('name', 'name', 'required');
		$this->form_validation->set_rules('password', 'password', 'required|callback_login_validation');
		
		if ($this->form_validation->run() === FALSE){
			$data['title'] = "totosomja - sprava login";
			
			$this->load->view("templates/header", $data);
			$this->load->view("manager/login", $data);
			$this->load->view("templates/right_body_blank", $data);
			$this->load->view("templates/footer", $data);
		}
		else{
			$this->login_session($this->input->post('name'));
			redirect("admin/manager");
		}
	} 
	
	public function logout(){
		$this->session->unset_userdata('admin_id');
		redirect("admin/manager/login");
	}
}