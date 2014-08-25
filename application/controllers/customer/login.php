<?php
class Login extends CI_Controller{
	
	public $data;
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('file');
		$this->load->helper('form');
		$this->load->helper('builder');
		$this->load->helper('string');
		$this->load->library('form_validation');
		$this->load->library('bcrypt');
		$this->load->model('address_model');
		$this->load->model('customer_model');
		is_login($this);
		
		$this->data['login'] = $this->session->userdata('login');
		$this->data['style'] = array('style_registration');
	}
	
	public function login_validation(){
		if (sizeof($user = $this->customer_model->login_by_nickname($this->input->post('login_nickname'))) > 0){
			if ($this->bcrypt->check_password($this->input->post('login_password').$user['salt'], $user['password'])){
				return TRUE;
			}
		}
		$this->form_validation->set_message('login_validation', 'Wrong password or login');
		return FALSE;
	}
	
	public function index($language = "sk"){
		if (is_login($this) == false){
			$this->data['title'] = "totosomja - login";
			$this->lang->load("general", $language);
			$this->lang->load("login", $language);
			$this->data['lang'] = $this->lang;
			$this->data['language'] = $language;
			$this->data['login_error'] = true;
			
			$this->data['lang_label'] = get_lang_label(base_url().'index.php/%l/login', array(), $language);
			
			$this->form_validation->set_rules('login_nickname', 'nickname', 'required');
			$this->form_validation->set_rules('login_password', 'password', 'required|callback_login_validation');
			
			if ($this->form_validation->run() === FALSE){		
				$this->load->view("templates/header", $this->data);
				$this->load->view("customer/login/index", $this->data);
				$this->load->view("templates/right_body_blank", $this->data);
				$this->load->view("templates/footer", $this->data);
			}
			else{
				$customer = $this->customer_model->login_by_nickname($this->input->post('login_nickname'));
				//remember login
				if ($this->input->post('login_remember') != false){
					$cookie = array(
							'name'   => 'login',
							'value'  => $customer['id'],
							'expire' => '604800',
					);
					$this->input->set_cookie($cookie);
				}
				//login
				$session_data = array(
						'login' => array(
								'id' => $customer['id'],
								'nickname' => $customer['customer_nickname'],
						), 
				);
				$this->session->set_userdata($session_data);
				redirect($language);
			}
		}
		else{
			redirect($language);
		}
	}
	
	public function registration($language = "sk"){
		if (is_login($this) == false){
			$this->data['title'] = "totosomja - login";
			$this->lang->load("general", $language);
			$this->lang->load("login", $language);
			$this->data['lang'] = $this->lang;
			$this->data['language'] = $language;
			$this->data['login_error'] = false;
			
			$this->form_validation->set_rules('reg_nickname', 'nickname', 'required|max_length[50]|is_unique[customer.customer_nickname]');
			$this->form_validation->set_rules('reg_name', 'name', 'required|max_length[50]');
			$this->form_validation->set_rules('reg_surname', 'surname', 'required|max_length[50]');
			$this->form_validation->set_rules('reg_email', 'email', 'required|valid_email|max_length[100]');
			$this->form_validation->set_rules('reg_pass1', 'password', 'required');
			$this->form_validation->set_rules('reg_pass2', 'repeated password', 'required|matches[reg_pass1]');
			
			$this->form_validation->set_rules('reg_gender', 'gender', '');
			$this->form_validation->set_rules('reg_day', 'day', 'is_natural');
			$this->form_validation->set_rules('reg_month', 'month', 'is_natural');
			$this->form_validation->set_rules('reg_year', 'year', 'is_natural');
			
			$this->form_validation->set_rules('reg_street', 'street', 'required|max_length[50]');
			$this->form_validation->set_rules('reg_street_number', 'street number', 'required|max_length[10]');
			$this->form_validation->set_rules('reg_town', 'town', 'required|max_length[50]');
			$this->form_validation->set_rules('reg_postal_code', 'postal code', 'required|max_length[10]');
			$this->form_validation->set_rules('reg_country', 'country code', 'required|max_length[40]');
			
			if ($this->form_validation->run() === FALSE){
				$this->load->view("templates/header", $this->data);
				$this->load->view("customer/login/index", $this->data);
				$this->load->view("templates/right_body_blank", $this->data);
				$this->load->view("templates/footer", $this->data);
			}
			else{
				$table_data = array(
						'town' => $this->input->post('reg_town'),
						'postal_code' => $this->input->post('reg_postal_code'),
						'street' => $this->input->post('reg_street'),
						'street_number' => $this->input->post('reg_street_number'),
						'country' => $this->input->post('reg_country'),
				);
				$address_id = $this->address_model->save($table_data);
				$gender = null;
				if ($this->input->post('reg_gender') != false){
					$gender = $this->input->post('reg_gender') - 1;
				}
				$birthday = null;
				if ($this->input->post('reg_day') != false && $this->input->post('reg_month') != false && $this->input->post('reg_year') != false){
					$birthday = $this->input->post('reg_year')."-".$this->input->post('reg_month')."-".$this->input->post('reg_day');
				}
				$salt = random_string('alnum', 16);
				$table_data = array(
						'email' => $this->input->post('reg_email'),
						'salt' => $salt,
						'password' => $this->bcrypt->hash_password($this->input->post('reg_pass1').$salt),
						'customer_nickname' => $this->input->post('reg_nickname'),
						'customer_name' => $this->input->post('reg_name'),
						'customer_surname' => $this->input->post('reg_surname'),
						'customer_gender' => $gender,
						'customer_birthday' => $birthday,
						'address_id' => $address_id,
				);
				$customer_id = $this->customer_model->save($table_data);
				$table_data = array(
						'creator_id' => $custoemr_id,
				);
				$this->address_model->set_creator($address_id, $table_data);
				redirect($language."/login");
			}
		}
		else{
			redirect($language);
		}
	}
	
	public function logout($language = "sk"){
		if (is_login($this) == true){
			$this->session->unset_userdata('login');
			$cookie = array(
					'name'   => 'login',
					'value'  => '',
					'expire' => '',
			);
			$this->input->set_cookie($cookie);
		}
		redirect($language);
	}
}