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
		$this->load->model('address_model');
		$this->load->model('admin_model');
		$this->load->model('firm_model');
		
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
					array(
							'text' => "totosomja address",
							'link' => base_url().'index.php/admin/profile/firm_address',
					),
			);
			
			$this->data['profile'] = $this->admin_model->get_admin($this->session->userdata('admin_id'));
			
			$this->form_validation->set_rules('admin_name', 'name', 'required|max_length[50]');
			$this->form_validation->set_rules('admin_surname', 'surname', 'required|max_length[50]');
			$this->form_validation->set_rules('admin_email', 'email', 'required|valid_email|max_length[100]');
			
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
		$this->data['language'] = "sk";
		if (is_admin_login($this)){
			$this->data['title'] = "totosomja - edit admin profile";
				
			$this->data['functions'] = array(
					array(
							'text' => "change password",
							'link' => base_url().'index.php/admin/profile/password',
					),
					array(
							'text' => "totosomja address",
							'link' => base_url().'index.php/admin/profile/firm_address',
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
	
	public function firm_address(){
		$this->data['language'] = "sk";
		if (is_admin_login($this)){
			$this->data['title'] = "totosomja - edit firm address";
	
			$this->data['functions'] = array(
					array(
							'text' => "change password",
							'link' => base_url().'index.php/admin/profile/password',
					),
					array(
							'text' => "totosomja address",
							'link' => base_url().'index.php/admin/profile/firm_address',
					),
			);
				
			$this->form_validation->set_rules('email', 'email', 'required|max_length[100]');
			$this->form_validation->set_rules('name', 'name', 'required|max_length[50]');
			$this->form_validation->set_rules('street', 'street', 'required|max_length[50]');
			$this->form_validation->set_rules('street_number', 'street number', 'required|max_length[10]');
			$this->form_validation->set_rules('town', 'town', 'required|max_length[50]');
			$this->form_validation->set_rules('postal_code', 'postal code', 'required|max_length[10]');
			$this->form_validation->set_rules('country', 'country code', 'required|max_length[40]');
			$this->form_validation->set_rules('address_id', 'address id', '');
				
			if ($this->form_validation->run() == false){
				$this->data['profile'] = $this->firm_model->get_last(array('address'));
				if ($this->data['profile'] == false){
					$this->data['profile'] = array(
							'email' => "",
							'firm_name' => "",
							'ico' => "",
							'address_id' => null,
							'street' => "",
							'street_number' => "",
							'town' => "",
							'postal_code' => "",
							'country' => "",
					);
				}
				$this->load->view("templates/header_manager", $this->data);
				$this->load->view("manager/profile/firm_address", $this->data);
				$this->load->view("manager/profile/right_body", $this->data);
				$this->load->view("templates/footer", $this->data);
			}
			else{
				$table_data = array(
						'town' => $this->input->post('town'),
						'postal_code' => $this->input->post('postal_code'),
						'street' => $this->input->post('street'),
						'street_number' => $this->input->post('street_number'),
						'country' => $this->input->post('country'),
						'creator_id' => null,
				);
				$address_id = $this->address_model->save($table_data, $this->data['profile']['address_id']);
				
				$ico = null;
				if ($this->input->post('ico') != false){
					$ico = $this->input->post('ico');
				}
				$table_data = array(
						'email' => $this->input->post('email'),
						'firm_name' => $this->input->post('name'),
						'address_id' => $address_id,
						'ico' => $ico,
				);
				$this->firm_model->save($table_data);
				redirect("admin/profile");
			}
		}
		else{
			redirect("manager/login");
		}
	}
}