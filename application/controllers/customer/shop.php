<?php
class Shop extends CI_Controller{
	
	public $limit = 6;
	public $data;
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('file');
		$this->load->helper('builder');
		$this->load->helper('vote');
		$this->load->library('form_validation');
		$this->load->model('type_model');
		$this->load->model('category_model');
		$this->load->model('color_model');
		$this->load->model('size_model');
		$this->load->model("admin_model");
		$this->load->model('material_model');
		$this->load->model('supplier_model');
		$this->load->model("address_model");
		$this->load->model("product_model");
		$this->load->model("customer_model");
		$this->load->model("poll_model");
		$this->load->model("poll_answer_model");
		$this->load->model("poll_vote_model");
		$this->load->model("message_model");
		$this->load->model("static_page_model");
		$this->load->model("page_link_block_model");
		$this->load->model("static_page_in_link_block_model");
		
		is_login($this);
		$this->data['login'] = $this->session->userdata('login');
		$block = $this->page_link_block_model->get_by_name('footer');
		$this->data['footer'] = $this->static_page_in_link_block_model->get_by_block($block['id'], array('page'));
		$block = $this->page_link_block_model->get_by_name('header');
		$this->data['header'] = $this->static_page_in_link_block_model->get_by_block($block['id'], array('page'));
	}
	
	public function index($language = "sk"){
		$language = valid_language($language);
		$this->data['language_ext'] = get_language_ext($language);
		$this->data['title'] = "totosomja - tri&#269;k&aacute; s joga, vegan a vegetarian tematikou";
		$this->lang->load("general", $language);
		$this->lang->load("message", $language);
		$this->data['lang'] = $this->lang;
		$this->data['language'] = $language;
		
		$this->data['lang_label'] = get_lang_label(base_url().'index.php/%l', array(), $language);
		
		$this->data['message'] = $this->message_model->get_last();
		if ($this->data['message'] != false){
			$this->data['message_title'] = rawUrlDecode(read_file("./content/message/".$this->data['message']['id']."/title".$this->data['language_ext'].".txt"));
			$this->data['message_body'] = rawUrlDecode(read_file("./content/message/".$this->data['message']['id']."/body".$this->data['language_ext'].".txt"));
			if ($this->data['message']['poll_id'] != false){
				$this->data['can_vote'] = ($this->session->userdata('login') != false && $this->poll_vote_model->can_vote($this->session->userdata('login')['id'], $this->data['message']['poll_id']));
				$this->data['poll_answer'] = $this->poll_vote_model->get_vote($this->data['message']['poll_id']);
				$this->data['vote'] = 0;
				foreach($this->data['poll_answer'] as $vote){
					$this->data['vote'] += $vote['vote'];
				}
			}
		}
		
		$this->data['shirt'] = $this->product_model->get_sellable_list(array(), 0, $this->limit);
		$this->data['page'] = 1;
		$this->data['page_offset'] = 3;
		$this->data['last_page'] = ceil($this->product_model->count_all_sellable(array()) / $this->limit);
		$this->data['limit'] = $this->limit;
		$this->data['vote_options'] = $this->load->view("customer/shop/vote_options", $this->data, true);
		
		$this->load->view("templates/header", $this->data);
		$this->load->view("templates/banner", $this->data);
		$this->load->view("templates/social", $this->data);
		$this->load->view("customer/shop/index", $this->data);
		$this->load->view("customer/shop/right_panel", $this->data);
		$this->load->view("templates/footer", $this->data);
	}
	
	public function vote($language = "sk"){
		if (is_login($this)){
			$language = valid_language($language);
			$this->data['language_ext'] = get_language_ext($language);
			$this->form_validation->set_rules('poll_id', 'poll id', 'required');
			$this->form_validation->set_rules('answer_id', 'answer id', 'required');
			
			if ($this->form_validation->run() != false){
				$this->lang->load("general", $language);
				$this->data['lang'] = $this->lang;
				$this->data['language'] = $language;
				$table_data = array(
						'customer_id' => $this->session->userdata('login')['id'],
						'poll_answer_id' => $this->input->post('answer_id'),
						'vote_date' => date("Y-n-d H:i:s"),
				);
				$this->poll_vote_model->save($table_data);
				
				$this->data['can_vote'] = ($this->session->userdata('login') != false && $this->poll_vote_model->can_vote($this->session->userdata('login')['id'], $this->input->post('poll_id')));
				$this->data['message']['poll_id'] = $this->input->post('poll_id');
				$this->data['poll_answer'] = $this->poll_vote_model->get_vote($this->input->post('poll_id'));
				$this->data['vote'] = 0;
				foreach($this->data['poll_answer'] as $vote){
					$this->data['vote'] += $vote['vote'];
				}
				
				$this->load->view("customer/shop/vote_options", $this->data);
			}
			else{
				echo "Error: not enought information";
			}
		}
		else{
			echo "Error: you have to log in";
		}
	}
}