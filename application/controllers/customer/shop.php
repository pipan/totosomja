<?php
class Shop extends CI_Controller{
	
	public $limit = 6;
	public $data;
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('file');
		$this->load->helper('builder');
		$this->load->helper('vote');
		$this->load->helper('my_string');
		$this->load->library('form_validation');
		$this->load->library('paypal');
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
		$this->load->model("firm_model");
		$this->load->model("order_status_model");
		$this->load->model("invoic_model");
		$this->load->model("product_in_invoic_model");
		
		if (is_login($this)){
			$login = $this->customer_model->login_by_id($this->session->userdata('login')['id']);
			$this->data['login_custom'] = $this->paypal->encrypt_user($login['id'], $login['salt']);
		}
		else{
			$this->data['login_custom'] = 0;
		}
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
	
	public function purchase($language = "sk"){
		$language = valid_language($language);
		$this->data['language_ext'] = get_language_ext($language);
		$this->data['title'] = "totosomja - thank you for purchase";
		$this->lang->load("general", $language);
		$this->lang->load("message", $language);
		$this->lang->load("purchase", $language);
		$this->data['lang'] = $this->lang;
		$this->data['language'] = $language;
		
		$this->data['lang_label'] = get_lang_label(base_url().'index.php/%l/shop/purchase', array(), $language);
		
		$this->paypal->_pdt();
		$this->data['paypal_data'] = $this->paypal->data;
		$this->data['txn_id'] = $this->input->get('tx');
		
		if ($this->paypal->is_valid_pdt()){
			$replace = array(
					'%fn' => $this->data['paypal_data']['first_name'],
					'%ln' => $this->data['paypal_data']['last_name'],
					'%email' => $this->data['paypal_data']['payer_email'],
			);
			$this->data['thank_you'] = str_replace_array($replace, $this->lang->line('purchase_success'));
			$this->data['item'] = array();
			for ($i = 1; $i <= $this->data['paypal_data']['num_cart_items']; $i++){
				$this->data['item'][$i]['name'] = $this->data['paypal_data']['item_name'.$i];
				$this->data['item'][$i]['quantity'] = $this->data['paypal_data']['quantity'.$i];
				$this->data['item'][$i]['price'] = $this->data['paypal_data']['mc_gross_'.$i];
			}
			write_file("./content/paypal/pdt/".date("Y-n-d-H-i-s").".txt", $this->paypal->to_string());
			$this->load->view("templates/header", $this->data);
			$this->load->view("customer/shop/purchase_success", $this->data);
			$this->load->view("templates/right_body_blank", $this->data);
			$this->load->view("templates/footer", $this->data);
		}
		else{
			$this->load->view("templates/header", $this->data);
			$this->load->view("customer/shop/purchase_fail", $this->data);
			$this->load->view("templates/right_body_blank", $this->data);
			$this->load->view("templates/footer", $this->data);
		}
	}
	
	public function ipn(){
		$this->paypal->_ipn();
		write_file("./content/paypal/ipn/".date("Y-n-d-H-i-s").".txt", $this->paypal->to_string());
		if ($this->paypal->is_valid_ipn()){
			$paypal_data = $this->paypal->data;
			//len update statusu platby
			if ($this->invoic_model->exists_by_txn_id($paypal_data['txn_id'])){
				$table_data = array(
						'payment_status' => $paypal_data['payment_status'],
				);
				$this->invoic_model->save_by_txn_id($table_data, $paypal_data['txn_id']);
			}
			//nova platba
			else{
				$user = $this->paypal->decrypt_user($paypal_data['custom']);
				$user_id = null;
				if ($user != false){
					
					$user_login = $this->customer_model->login_by_id($user['id']);
					if ($this->paypal->compare_user($user, $user_login)){
						$user_id = $user_login['id'];
					}
				}
				$seller = $this->firm_model->get_last();
				$table_data = array(
						'town' => $paypal_data['address_city'],
						'postal_code' => $paypal_data['address_zip'],
						'street' => $paypal_data['address_street'],
						'street_number' => $paypal_data['address_state'],
						'country' => $paypal_data['address_country'],
						'creator_id' => null, 
				);
				$invoic_address_id = $this->address_model->save($table_data);
				$shipping_address_id = null;
				$date_explode = explode(" ", $paypal_data['payment_date']);
				$last_invoic = $this->invoic_model->get_last();
				if ($last_invoic != false){
					$last_invoic['invoic_id'] += 1;
					$last_invoic_id = substr($last_invoic['invoic_id'], 4);
				}
				else{
					$last_invoic_id = "0001";
				}
				$note = null;
				if (isset($paypal_data['memo'])){
					$note = $paypal_data['memo'];
				}
				$invoic_unique_id = $date_explode[3].$last_invoic_id;
				$table_data = array(
						'seller_id' => $seller['id'],
						'buyer_name' => $paypal_data['first_name'],
						'buyer_surname' => $paypal_data['last_name'],
						'payer_email' => $paypal_data['payer_email'],
						'customer_id' => $user_id,
						'invoic_address_id' => $invoic_address_id,
						'shipping_address_id' => $shipping_address_id,
						'transaction_id' => $paypal_data['txn_id'],
						'transaction_date' => date('Y-m-d H:i:s', strtotime ($paypal_data['payment_date'])),
						'order_status_id' => 1,
						'invoic_id' => $invoic_unique_id,
						'payment_status' => $paypal_data['payment_status'],
						'tax' => TAX,
						'note' => $note,
				);
				$invoic_id = $this->invoic_model->save($table_data);
				for($i = 1; $i <= $paypal_data['num_cart_items']; $i++){
					$product = $this->product_model->get_by_slug($paypal_data['item_name'.$i], "_en");
					$table_data = array(
							'product_id' => $product['id'],
							'invoic_id' => $invoic_id,
							'quantity' => $paypal_data['quantity'.$i],
					);
					$this->product_in_invoic_model->save($table_data);
				}
			}
		}
		else{
			//log	
		}
	}
}