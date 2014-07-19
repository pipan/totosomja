<?php
class Shirt extends CI_Controller{
	
	public $limit = 6;
	public $data;
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('file');
		$this->load->helper('form');
		$this->load->helper('builder');
		$this->load->helper('gender');
		$this->load->helper('store');
		$this->load->helper('MY_date');
		$this->load->helper('login');
		$this->load->library('form_validation');
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
		$this->load->model("comment_model");
		is_login($this);
		
		$this->data['login'] = $this->session->userdata('login');
	}
	
	public function filter_to_where($filter){
		$filter_array = explode('-', $filter);
		$where = array();
		if ($filter_array[0] != 0){
			$where['gender ='] = ($filter_array[0] - 1); 
		}
		if ($filter_array[1] != 0){
			$where['size_id ='] = $filter_array[1];
		}
		if ($filter_array[2] != 0){
			$where['color_id ='] = $filter_array[2];
		}
		if ($filter_array[3] != 0){
			$where['price <'] = $filter_array[3];
		}
		return $where;
	}
	
	public function filter_to_array($filter){
		$filter_array = explode('-', $filter);
		$ret = array(
				'page_link' => "/".$filter,
				'gender' => $filter_array[0],
				'size' => $filter_array[1],
				'color' => $filter_array[2],
				'price' => $filter_array[3],
		);
		return $ret;
	}
	
	public function wish($slug, $language){
		if (is_login($this)){
			$language = valid_language($language);
			$language_ext = get_language_ext($language);
			$product = $this->product_model->get_by_slug($slug, $language_ext);
			if ($product != false){
				if (!$this->wishlist_model->is_customer_wishing($this->session->userdata('login')['id'], $product['id'])){
					$table_data = array(
							'product_id' => $product['id'],
							'customer_id' => $this->session->userdata('login')['id'],
							'wish_date' => date("Y-n-d H:i:s"),
					);
					$this->wishlist_model->save($table_data);
				}
			}
		}
		redirect($language."/shirt/".$slug);
	}
	
	public function index($page = 1, $language = "sk", $filter = false){
		$language = valid_language($language);
		$this->data['language_ext'] = get_language_ext($language);
		$this->lang->load("general", $language);
		$this->lang->load("filter", $language);
		$this->data['lang'] = $this->lang;
		$this->data['language'] = $language;
		if ($page < 1){
			$page = 1;
		}
		
		$where = array();
		$this->data['filter'] = array(
			'page_link' => "",
			'gender' => "",
			'size' => "",
			'color' => "",
			'price' => "",
		);
		
		if ($filter != false){
			$where = $this->filter_to_where($filter);
			$this->data['filter'] = $this->filter_to_array($filter);
		}
		
		$this->data['title'] = $this->lang->line('title_t_shirt_index');
		$this->data['shirt'] = $this->product_model->get_sellable_list($where, ($page - 1) * $this->limit, $this->limit);
		$this->data['page'] = $page;
		$this->data['page_offset'] = 3;
		$this->data['last_page'] = ceil($this->product_model->count_all_sellable($where) / $this->limit);
		$this->data['limit'] = $this->limit;
		$this->data['db'] = array(
				'size' => $this->size_model->get(),
				'color' => $this->color_model->get(),
		);
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('customer/shirt/index', $this->data);
		$this->load->view('customer/shirt/right_body', $this->data);
		$this->load->view('templates/footer', $this->data);
	}
	
	public function view($slug, $language = "sk"){
		$language = valid_language($language);
		$this->data['language_ext'] = get_language_ext($language);
		$this->lang->load("general", $language);
		$this->lang->load("filter", $language);
		$this->lang->load("product", $language);
		$this->data['lang'] = $this->lang;
		$this->data['language'] = $language;
		$this->data['shirt'] = $this->product_model->get_by_slug($slug, $this->data['language_ext']);
		$this->data['show_error'] = false;
		if ($this->data['shirt'] != false){
			//akcie co moze robit lognuty user
			if (is_login($this)){
				//comment
				if ($this->input->post('send') != false){
					$this->data['show_error'] = true;
				}
			
				$this->form_validation->set_rules('comment', 'comment', 'required');
					
				if ($this->form_validation->run() != false){
					$this->data['show_error'] = false;
					$table_data = array(
							'product_id' => $this->data['shirt']['id'],
							'customer_id' => $this->session->userdata('login')['id'],
							'post_date' => date("Y-n-d H:i:s"),
							'value' => 0,
					);
					$comment_id = $this->comment_model->save($table_data);
					write_file("./content/product/comments/".$comment_id.".txt", $this->input->post('comment'));
				}
			}
			
			$this->data['comments'] = $this->comment_model->get_by_product_id($this->data['shirt']['id']);
			$this->data['title'] = "totosomja - ".$this->data['shirt']['product_name'];
			$this->data['db'] = array(
					'size' => $this->size_model->get(),
					'color' => $this->color_model->get(),
			);
			$this->data['filter'] = array(
					'page_link' => "",
					'gender' => "",
					'size' => "",
					'color' => "",
					'price' => "",
			);
			$this->data['wish'] = $this->wishlist_model->is_customer_wishing($this->session->userdata('login')['id'], $this->data['shirt']['id']);
			
			$this->load->view("templates/header", $this->data);
			$this->load->view("customer/shirt/view", $this->data);
			$this->load->view("customer/shirt/right_body", $this->data);
			$this->load->view("templates/footer", $this->data);
		}
		else{
			$this->load->view("templates/header", $this->data);
			$this->load->view("templates/wrong_id", $this->data);
			$this->load->view("customer/blog/right_body", $this->data);
			$this->load->view("templates/footer", $this->data);
		}
	}
}