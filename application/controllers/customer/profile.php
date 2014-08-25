<?php
class Profile extends CI_Controller{
	
	public $data;
	
	public function __construct(){
		parent::__construct();
		
		$this->load->helper('form');
		$this->load->helper('builder');
		$this->load->helper('login');
		$this->load->helper('string');
		$this->load->helper('MY_date');
		$this->load->library('form_validation');
		$this->load->library('bcrypt');
		$this->load->model('type_model');
		$this->load->model('category_model');
		$this->load->model('color_model');
		$this->load->model('size_model');
		$this->load->model('material_model');
		$this->load->model('supplier_model');
		$this->load->model("address_model");
		$this->load->model("product_model");
		$this->load->model("customer_model");
		$this->load->model("wishlist_model");
		is_login($this);
		
		$this->data['login'] = $this->session->userdata('login');
		$this->data['lang'] = $this->lang;
		$this->data['style'] = array('style_registration');
	}
	
	public function check_password(){
		if (sizeof($user = $this->customer_model->login_by_id($this->session->userdata('login')['id'])) > 0){
			if ($this->bcrypt->check_password($this->input->post('old_password').$user['salt'], $user['password'])){
				return true;
			}
		}
		$this->form_validation->set_message('check_password', 'Wrong password');
		return false;
	}
	
	public function edit($language = "sk"){
		if (is_login($this)){
			$this->data['title'] = "totosomja - edit profile";
			$this->lang->load("general", $language);
			$this->lang->load("profile", $language);
			$this->lang->load("login", $language);
			$this->data['language'] = $language;
			$this->data['lang_label'] = get_lang_label(base_url().'index.php/%l/profile/edit', array(), $language);
			
			$this->data['functions'] = array(
					array(
							'text' => $this->lang->line('profile_change_password'),
							'link' => base_url().'index.php/'.$language.'/profile/password',
					),
			);
			
			$this->data['profile'] = $this->customer_model->get(array('address'), $this->session->userdata('login')['id']);
			
			$this->form_validation->set_rules('reg_name', 'name', 'required|max_length[50]');
			$this->form_validation->set_rules('reg_surname', 'surname', 'required|max_length[50]');
			$this->form_validation->set_rules('reg_email', 'email', 'required|valid_email|max_length[100]');
			
			$this->form_validation->set_rules('reg_gender', 'gender', '');
			$this->form_validation->set_rules('reg_day', 'day', 'is_natural');
			$this->form_validation->set_rules('reg_month', 'month', 'is_natural');
			$this->form_validation->set_rules('reg_year', 'year', 'is_natural');
			
			$this->form_validation->set_rules('reg_street', 'street', 'required|max_length[50]');
			$this->form_validation->set_rules('reg_street_number', 'street number', 'required|max_length[10]');
			$this->form_validation->set_rules('reg_town', 'town', 'required|max_length[50]');
			$this->form_validation->set_rules('reg_postal_code', 'postal code', 'required|max_length[10]');
			$this->form_validation->set_rules('reg_country', 'country code', 'required|max_length[40]');
			$this->form_validation->set_rules('reg_address_id', 'address id', 'required|is_natural');
			
			if ($this->form_validation->run() == false){
				$this->load->view("templates/header", $this->data);
				$this->load->view("customer/profile/edit", $this->data);
				$this->load->view("customer/profile/right_body", $this->data);
				$this->load->view("templates/footer", $this->data);
			}
			else{
				$table_data = array(
						'town' => $this->input->post('reg_town'),
						'postal_code' => $this->input->post('reg_postal_code'),
						'street' => $this->input->post('reg_street'),
						'street_number' => $this->input->post('reg_street_number'),
						'country' => $this->input->post('reg_country'),
						'creator_id' => $this->session->userdata('login')['id'], 
				);
				$address_id = $this->address_model->save($table_data, $this->input->post('reg_address_id'));
				$gender = null;
				if ($this->input->post('reg_gender') != false){
					$gender = $this->input->post('reg_gender') - 1;
				}
				$birthday = null;
				if ($this->input->post('reg_day') != false && $this->input->post('reg_month') != false && $this->input->post('reg_year') != false){
					$birthday = $this->input->post('reg_year')."-".$this->input->post('reg_month')."-".$this->input->post('reg_day');
				}
				$table_data = array(
						'email' => $this->input->post('reg_email'),
						'customer_name' => $this->input->post('reg_name'),
						'customer_surname' => $this->input->post('reg_surname'),
						'customer_gender' => $gender,
						'customer_birthday' => $birthday,
						'address_id' => $address_id,
				);
				$this->customer_model->save($table_data, $this->session->userdata('login')['id']);
				redirect($language);
			}
		}
		else{
			redirect($language."/login");
		}
	}
	
	public function password($language = "sk"){
		if (is_login($this)){
			$this->data['title'] = "totosomja - edit profile";
			$this->lang->load("general", $language);
			$this->lang->load("profile", $language);
			$this->lang->load("login", $language);
			$this->data['language'] = $language;
			$this->data['lang_label'] = get_lang_label(base_url().'index.php/%l/profile/password', array(), $language);
				
			$this->data['functions'] = array(
					array(
							'text' => $this->lang->line('profile_change_password'),
							'link' => base_url().'index.php/'.$language.'/profile/password',
					),
			);
			
			$this->form_validation->set_rules('old_password', 'old password', 'required|callback_check_password');
			$this->form_validation->set_rules('new_password', 'new password', 'required');
			$this->form_validation->set_rules('new_password_repeat', 'repeat new password', 'required|matches[new_password]');
			
			if ($this->form_validation->run() == false){
				$this->load->view("templates/header", $this->data);
				$this->load->view("customer/profile/password", $this->data);
				$this->load->view("customer/profile/right_body", $this->data);
				$this->load->view("templates/footer", $this->data);
			}
			else{
				$user = $this->customer_model->login_by_id($this->session->userdata('login')['id']);
				$table_data = array(
						'password' => $this->bcrypt->hash_password($this->input->post('new_password').$user['salt']),
				);
				$this->customer_model->save($table_data, $this->session->userdata('login')['id']);
				redirect($language."/profile/edit");
			}
		}
		else{
			redirect($language."/login");
		}
	}
	
	public function wishlist($language = "sk"){
		if (is_login($this)){
			$this->data['language_ext'] = get_language_ext($language);
			$this->data['title'] = "totosomja - edit profile";
			$this->lang->load("general", $language);
			$this->lang->load("profile", $language);
			$this->lang->load("login", $language);
			$this->lang->load("wishlist", $language);
			$this->data['language'] = $language;
			$this->data['lang_label'] = get_lang_label(base_url().'index.php/%l/profile/wishlist', array(), $language);
			$this->data['wish'] = $this->wishlist_model->get_by_customer_id($this->session->userdata('login')['id']);
			
			$this->load->view("templates/header", $this->data);
			$this->load->view("customer/profile/wishlist", $this->data);
			$this->load->view("customer/profile/right_body", $this->data);
			$this->load->view("templates/footer", $this->data);
		}
		else{
			redirect($language."/login");
		}
	}
	
	public function remove_wish($product_id, $language = "sk"){
		if (is_login($this)){
			$this->wishlist_model->remove_wish($this->session->userdata('login')['id'], $product_id);
			
			redirect($language."/profile/wishlist");
		}
		else{
			redirect($language."/login");
		}
	}
}