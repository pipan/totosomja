<?php
class Static_page extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		
		$this->load->helper('file');
		$this->load->helper('text');
		
		$this->load->library('blog_parser');
		
		$this->load->model('static_page_model');
		$this->load->model('page_link_block_model');
		$this->load->model('static_page_in_link_block_model');
		
		if (is_login($this)){
			$login = $this->customer_model->login_by_id($this->session->userdata('login')['id']);
			$this->data['login_custom'] = $this->paypal->encrypt_user($login['id'], $login['salt']);
		}
		else{
			$this->data['login_custom'] = 0;
		}
		
		$this->data['login'] = $this->session->userdata('login');
		$this->data['lang'] = $this->lang;
		$this->data['style'] = array('style_blog');
		
		$block = $this->page_link_block_model->get_by_name('footer');
		$this->data['footer'] = $this->static_page_in_link_block_model->get_by_block($block['id'], array('page'));
		$block = $this->page_link_block_model->get_by_name('header');
		$this->data['header'] = $this->static_page_in_link_block_model->get_by_block($block['id'], array('page'));
	}
	
	public function index($slug, $language = "sk"){
		$language = valid_language($language);
		$this->data['language_ext'] = get_language_ext($language);
		$this->lang->load("general", $language);
		$this->data['language'] = $language;
		
		if ($this->static_page_model->exists_by_slug($slug, $this->data['language_ext'])){
			$this->data['page'] = $this->static_page_model->get_by_slug($slug, $this->data['language_ext']);
			$this->data['page']['body'] = rawUrlDecode(read_file("./application/views/static_page/".$this->data['page']['folder']."/body".$this->data['language_ext'].".txt"));
			$this->data['page']['title'] = rawUrlDecode(read_file("./application/views/static_page/".$this->data['page']['folder']."/title".$this->data['language_ext'].".txt"));
			$replace = array(
					'en' => array(
							'%s' => $this->data['page']['page_slug_en'],
					),
					'sk' => array(
							'%s' => $this->data['page']['page_slug'],
					),
			);
			$this->data['lang_label'] = get_lang_label(base_url().'index.php/%l/%s', $replace, $language);
			$this->data['title'] = "totosomja - ".$this->data['page']['page_title'.$this->data['language_ext']];
		
			$this->load->view('templates/header', $this->data);
			$this->load->view('customer/static_page/index', $this->data);
			$this->load->view('templates/right_body_blank', $this->data);
			$this->load->view('templates/footer', $this->data);
		}
		else{
			$this->data['page']['title'] = $this->lang->line('static_page_error_body_title');
			$this->data['page']['body'] = $this->lang->line('static_page_error_body');
			$this->data['lang_label'] = get_lang_label(base_url().'index.php/%l/'.$slug, array(), $language);
			$this->data['title'] = "totosomja - ".$this->lang->line('static_page_error_title');
			$this->load->view('templates/header', $this->data);
			$this->load->view('customer/static_page/not_found', $this->data);
			$this->load->view('templates/right_body_blank', $this->data);
			$this->load->view('templates/footer', $this->data);
		}
	}
}