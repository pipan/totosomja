<?php
class Blog extends CI_Controller{
	
	public $data;
	public $limit = 6;
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('file');
		$this->load->helper('text');
		$this->load->helper('builder');
		$this->load->helper('login');
		$this->load->helper('MY_date');
		$this->load->library("blog_parser");
		$this->load->library("form_validation");
		$this->load->model("admin_model");
		$this->load->model("address_model");
		$this->load->model("customer_model");
		$this->load->model("blog_series_model");
		$this->load->model("blog_model");
		$this->load->model("comment_blog_model");
		$this->load->model("tag_model");
		$this->load->model("blog_in_tag_model");
		is_login($this);
		
		$this->data['login'] = $this->session->userdata('login');
		$this->data['lang'] = $this->lang;
		$this->data['style'] = array('style_blog');
	}
	
	public function valid_blog(){
		if ($this->blog_model->exists($this->input->post('blog_id'))){
			return true;
		}
		$this->form_validation->set_message('valid_blog', 'Invalid blog');
		return false;
	}
	
	/**
	 * zobrazuje index blogu, zoznam blogov o pocte $limit
	 * @param number $page - cislo stranky ktoru zobrazujem, default $page = 1
	 */
	public function index($page = 1, $language = "sk"){
		$language = valid_language($language);
		$this->data['language_ext'] = get_language_ext($language);
		$this->lang->load("general", $language);
		$this->data['language'] = $language;
		if ($page < 1){
			$page = 1;
		}
		$this->data['title'] = "totosomja - blog";
		$this->data['blogs'] = $this->blog_model->get_list(($page - 1) * $this->limit, $this->limit);
		$this->data['page'] = $page;
		$this->data['page_offset'] = 3;
		$this->data['last_page'] = ceil($this->blog_model->count_all() / $this->limit);
		$this->data['year_list'] = $this->blog_model->get_year_list();
		$this->data['blog_navigator'] = $this->blog_model->get_blog_navigator();
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('customer/blog/index', $this->data);
		$this->load->view('customer/blog/right_body', $this->data);
		$this->load->view('templates/footer', $this->data);
	}
	
	/**
	 * zobrazuje konkretny blog na zaklade $slug, specialny tvar nazvu blogu
	 * @param string $slug - specialny nazov blogu
	 */
	public function view($slug, $language = "sk"){
		$language = valid_language($language);
		$this->data['language_ext'] = get_language_ext($language);
		$lang_id = $this->language_model->get_by_name($language);
		$this->lang->load("general", $language);
		$this->lang->load("blog", $language);
		$this->data['language'] = $language;
		$this->data['show_error'] = false;
		$this->data['year_list'] = $this->blog_model->get_year_list();
		$this->data['blog_navigator'] = $this->blog_model->get_blog_navigator();
		$this->data['blog'] = $this->blog_model->get_by_slug($slug, $this->data['language_ext']);
		if ($this->data['blog'] != false){
			$tag_data = array(
					'blog_id' => $this->data['blog']['id'],
					'language_id' => $lang_id['id'],
			);
			$this->data['tag'] = $this->blog_in_tag_model->get_by_data($tag_data);
			
			//akcie ktore moze robit lognuty
			if (is_login($this)){
				//comment
				if ($this->input->post('send') != false){
					$this->data['show_error'] = true;
				}
				
				$this->form_validation->set_rules('comment', 'comment', 'required');
					
				if ($this->form_validation->run() != false){
					$this->data['show_error'] = false;
					$table_data = array(
							'blog_id' => $this->data['blog']['id'],
							'customer_id' => $this->session->userdata('login')['id'],
							'post_date' => date("Y-n-d H:i:s"),
							'value' => 0,
					);
					$comment_id = $this->comment_blog_model->save($table_data);
					write_file("./content/blog/".$this->data['blog']['id']."/comments/".$comment_id.".txt", $this->input->post('comment'));
				}
			}
			
			$this->data['comments'] = $this->comment_blog_model->get_by_blog_id($this->data['blog']['id']);
			$this->data['title'] = "totosomja - ".$this->data['blog']['title'];
			
			$this->load->view("templates/header", $this->data);
			$this->load->view("customer/blog/view", $this->data);
			$this->load->view("customer/blog/right_body", $this->data);
			$this->load->view("templates/footer", $this->data);
		}
		else{
			$this->load->view("templates/header", $this->data);
			$this->load->view("templates/wrong_id", $this->data);
			$this->load->view("customer/blog/right_body", $this->data);
			$this->load->view("templates/footer", $this->data);
		}
	}
	
	public function tag($tag, $page = 1, $language = "sk"){
		$language = valid_language($language);
		$this->data['language_ext'] = get_language_ext($language);
		$lang_id = $this->language_model->get_by_name($language);
		$this->lang->load("general", $language);
		$this->data['language'] = $language;
		
		if ($page < 1){
			$page = 1;
		}
		$tag_data = array(
				'tag_slug' => $tag,
				'language_id' => $lang_id['id'],
		);
		$this->data['title'] = "totosomja - blog";
		$this->data['blogs'] = $this->blog_in_tag_model->get_list_by_data($tag_data, ($page - 1) * $this->limit, $this->limit);
		$this->data['page'] = $page;
		$this->data['page_offset'] = 3;
		$this->data['last_page'] = ceil($this->blog_in_tag_model->count_all_by_tag_slug($tag) / $this->limit);
		$this->data['year_list'] = $this->blog_model->get_year_list();
		$this->data['blog_navigator'] = $this->blog_model->get_blog_navigator();
		$this->data['tag'] = $tag;
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('customer/blog/tag', $this->data);
		$this->load->view('customer/blog/right_body', $this->data);
		$this->load->view('templates/footer', $this->data);
		
	}
}