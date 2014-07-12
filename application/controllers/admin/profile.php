<?php
class Profile extends CI_Controller{
	
	public $data;
	
	public function __construct(){
		parent::__construct();
		
		$this->load->helper('form');
		$this->load->helper('builder');
		$this->load->helper('string');
		$this->load->library('form_validation');
		$this->load->library('bcrypt');
		$this->load->model('admin_model');
		
		$this->lang->load("general", "sk");
		$this->data['lang'] = $this->lang;
	}
	
	public function check_password(){
		if (sizeof($user = $this->admin_model->get_admin($this->session->userdata('admin_id'))) > 0){
			if ($this->bcrypt->check_password($this->input->post('old_password').$user['salt'], $user['password'])){
				return true;
			}
		}
		$this->form_validation->set_message('check_password', 'Wrong password');
		return false;
	}
	
	public function index(){
		$this->data['language'] = "sk";
		if (is_admin_login($this)){
			$this->data['title'] = "totosomja - edit admin profile";
			
			$this->data['functions'] = array(
					array(
							'text' => "change password",
							'link' => base_url().'index.php/admin/profile/password',
					),
			);
			
			$this->data['profile'] = $this->admin_model->get_admin($this->session->userdata('admin_id'));
			
			$this->form_validation->set_rules('admin_name', 'name', 'required');
			$this->form_validation->set_rules('admin_surname', 'surname', 'required');
			$this->form_validation->set_rules('admin_email', 'email', 'required|valid_email');
			
			if ($this->form_validation->run() == false){
				$this->load->view("templates/header_manager", $this->data);
				$this->load->view("manager/profile/edit", $this->data);
				$this->load->view("manager/profile/right_body", $this->data);
				$this->load->view("templates/footer", $this->data);
			}
			else{
				$table_data = array(
						'admin_email' => $this->input->post('admin_email'),
						'admin_name' => $this->input->post('admin_name'),
						'admin_surname' => $this->input->post('admin_surname'),
				);
				$this->admin_model->save($table_data, $this->session->userdata('admin_id'));
				redirect("admin");
			}
		}
		else{
			redirect("manager/login");
		}
	}
	
	public function password(){
		/*
		$admin = $this->admin_model->get_admin(1);
		$table_data = array(
				'password' => $this->bcrypt->hash_password("password".$admin['salt']),
		);
		$this->admin_model->save($table_data, 1);
		*/
		$this->data['language'] = "sk";
		if (is_admin_login($this)){
			$this->data['title'] = "totosomja - edit admin profile";
				
			$this->data['functions'] = array(
					array(
							'text' => "change password",
							'link' => base_url().'index.php/admin/profile/password',
					),
			);
			
			$this->form_validation->set_rules('old_password', 'old password', 'required|callback_check_password');
			$this->form_validation->set_rules('new_password', 'new password', 'required');
			$this->form_validation->set_rules('new_password_repeat', 'repeat new password', 'required|matches[new_password]');
			
			if ($this->form_validation->run() == false){
				$this->load->view("templates/header_manager", $this->data);
				$this->load->view("manager/profile/password", $this->data);
				$this->load->view("manager/profile/right_body", $this->data);
				$this->load->view("templates/footer", $this->data);
			}
			else{
				$admin = $this->admin_model->get_admin($this->session->userdata('admin_id'));
				$table_data = array(
						'password' => $this->bcrypt->hash_password($this->input->post('new_password').$admin['salt']),
				);
				$this->admin_model->save($table_data, $this->session->userdata('admin_id'));
				redirect("admin/profile");
			}
		}
		else{
			redirect("manager/login");
		}
	}
}