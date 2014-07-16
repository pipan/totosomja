<?php
class Poll extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('file');
		$this->load->helper('text');
		$this->load->library('form_validation');
		$this->load->model('admin_model');
		$this->load->model('customer_model');
		$this->load->model('poll_model');
		$this->load->model('message_model');
		$this->load->model('poll_answer_model');
		$this->load->model('poll_vote_model');
	}
	
	public function index(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
				
			$data['title'] = "totosomja - poll";
			$data['message'] = $this->message_model->get(array('poll'));
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/poll/new_poll',
							'text' => 'new poll',
					),
			);
			
			if (!$this->message_model->is_empty()){
				$this->load->view("templates/header_manager", $data);
				$this->load->view("manager/poll/index", $data);
				$this->load->view("manager/message/right_body", $data);
				$this->load->view("templates/footer", $data);
			}
			else{
				$data['empty_table'] = "no poll";
				$data['empty_table_title'] = "Poll - list";
				$this->load->view("templates/header_manager", $data);
				$this->load->view("templates/empty_table", $data);
				$this->load->view("manager/message/right_body", $data);
				$this->load->view("templates/footer", $data);
			}
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function new_message(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
		
			$data['title'] = "totosomja - message/poll";
			
			$data['jscript'] = array('jscript_message_oop');
			$data['poll'] = $this->poll_model->get();
			$data['message_title'] = "Title";
			$data['message_body'] = "Body";
				
			$this->load->view("templates/header_manager", $data);
			$this->load->view("manager/message/new_message", $data);
			$this->load->view("manager/message/right_body_message_edit", $data);
			$this->load->view("templates/footer", $data);
		}
		else{
			redirect("admin/manager/login");
		}
	}
}