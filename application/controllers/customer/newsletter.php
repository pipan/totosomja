<?php
class Newsletter extends CI_Controller{
	
	public $data;
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('builder');
		$this->load->helper('login');
		$this->load->library("form_validation");
		$this->load->model("newsletter_subscriber_model");
		is_login($this);
		
		$this->data['login'] = $this->session->userdata('login');
		$this->data['lang'] = $this->lang;
		$this->data['style'] = array('style_newsletter');
		
		$block = $this->page_link_block_model->get_by_name('footer');
		$this->data['footer'] = $this->static_page_in_link_block_model->get_by_block($block['id'], array('page'));
		$block = $this->page_link_block_model->get_by_name('header');
		$this->data['header'] = $this->static_page_in_link_block_model->get_by_block($block['id'], array('page'));
	}
	
	public function index($language = "sk"){
		$language = valid_language($language);
		$this->data['language_ext'] = get_language_ext($language);
		$this->lang->load("general", $language);
		$this->lang->load("newsletter", $language);
		$this->data['language'] = $language;
		$this->data['title'] = "totosomja - newsletter";
		
		$this->data['lang_label'] = get_lang_label(base_url().'index.php/%l/newsletter', array(), $language);
		
		$this->form_validation->set_rules('newsletter_email', 'email', 'required|valid_email|is_unique[newsletter_subscriber.email]');
		$this->form_validation->set_rules('newsletter_agree', 'agreement', 'required');
		
		if ($this->form_validation->run() == false){
			$this->load->view('templates/header', $this->data);
			$this->load->view('customer/newsletter/index', $this->data);
			$this->load->view('templates/right_body_blank', $this->data);
			$this->load->view('templates/footer', $this->data);
		}
		else{
			$table_data = array(
					'email' => $this->input->post('newsletter_email'),
					'subscribe_date' => date("Y-n-d H:i:s"),
			);
			$this->newsletter_subscriber_model->save($table_data);
			$this->load->view('templates/header', $this->data);
			$this->load->view('customer/newsletter/success_subscribe', $this->data);
			$this->load->view('templates/right_body_blank', $this->data);
			$this->load->view('templates/footer', $this->data);
		}
	}
}