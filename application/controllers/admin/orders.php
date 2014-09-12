<?php
class Orders extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		
		$this->load->helper('text');
		$this->load->helper('address');
		$this->load->library('form_validation');
		
		$this->load->model('address_model');
		$this->load->model('firm_model');
		$this->load->model('customer_model');
		$this->load->model('order_status_model');
		$this->load->model('type_model');
		$this->load->model('category_model');
		$this->load->model('color_model');
		$this->load->model('size_model');
		$this->load->model('material_model');
		$this->load->model('supplier_model');
		$this->load->model('product_model');
		$this->load->model('invoic_model');
		$this->load->model('product_in_invoic_model');
	}
	
	public function index(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			
			$data['title'] = "totosomja - orders";
			$data['invoic'] = $this->invoic_model->get(array('customer', 'status'));
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/orders/search',
							'text' => 'search',
					),
			);
			$this->load->view("templates/header_manager", $data);
			if ($this->invoic_model->is_empty()){
				$data['empty_table'] = "no orders";
				$data['empty_table_title'] = "Orders - list";
				$this->load->view("templates/empty_table", $data);
			}
			else{
				$this->load->view("manager/invoic/index", $data);
			}
			$this->load->view("manager/invoic/right_body", $data);
			$this->load->view("templates/footer", $data);
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function edit($id){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			$data['title'] = "totosomja - invoic";
			if ($this->invoic_model->exists($id)){
				$data['invoic'] = $this->invoic_model->get(array('customer', 'status', 'invoic_address', 'shipping_address'), $id);
				$data['product_in_invoic'] = $this->product_in_invoic_model->get_by_invoic($data['invoic']['id']);
				$data['product'] = $this->product_model->get_sellable();
				
				$this->form_validation->set_rules('order_status', 'order status', 'required|is_neutral');
				$this->form_validation->set_rules('ia_town', 'invoice town', 'required|max_length[50]');
				$this->form_validation->set_rules('ia_postal_code', 'invoice postal code', 'required|max_length[10]');
				$this->form_validation->set_rules('ia_street', 'invoice street', 'required|max_length[50]');
				$this->form_validation->set_rules('ia_street_number', 'invoice street_number', 'max_length[10]');
				$this->form_validation->set_rules('ia_country', 'invoice country', 'required|max_length[40]');
				$this->form_validation->set_rules('sa_town', 'shipping town', 'required|max_length[50]');
				$this->form_validation->set_rules('sa_postal_code', 'shipping postal code', 'required|max_length[10]');
				$this->form_validation->set_rules('sa_street', 'shipping street', 'required|max_length[50]');
				$this->form_validation->set_rules('sa_street_number', 'shipping street_number', 'max_length[10]');
				$this->form_validation->set_rules('sa_country', 'shipping country', 'required|max_length[40]');
				
				if ($this->form_validation->run() == false){
					$data['order_status'] = $this->order_status_model->get();
					if ($data['invoic']['shipping_address_id'] == null){
						$data['invoic']['sa_town'] = $data['invoic']['ia_town']; 
						$data['invoic']['sa_postal_code'] = $data['invoic']['ia_postal_code'];
						$data['invoic']['sa_street'] = $data['invoic']['ia_street'];
						$data['invoic']['sa_street_number'] = $data['invoic']['ia_street_number'];
						$data['invoic']['sa_country'] = $data['invoic']['ia_country'];
					}
					$data['title'] = "totosomja - invoic ".$data['invoic']['invoic_id'];
					
					$data['functions'] = array(
							array(
									'link' => base_url().'index.php/admin/orders/search',
									'text' => 'search',
							),
							array(
									'link' => base_url().'index.php/orders/view/'.$id,
									'text' => 'print',
									'target' => '_blank',
							),
							array(
									'link' => base_url().'index.php/admin/orders/add_product/'.$id,
									'text' => 'add product',
							),
					);
					$this->load->view("templates/header_manager", $data);
					$this->load->view("manager/invoic/edit", $data);
					$this->load->view("manager/invoic/right_body", $data);
					$this->load->view("templates/footer", $data);
				}
				else{
					if (invoic_address_match($this->input)){
						$table_data = array(
								'town' => $this->input->post('ia_town'),
								'postal_code' => $this->input->post('ia_postal_code'),
								'street' => $this->input->post('ia_street'),
								'street_number' => $this->input->post('ia_street_number'),
								'country' => $this->input->post('ia_country'),
						);
						$ia = $this->address_model->save_override($table_data, $data['invoic']['invoic_address_id']);
						$sa = null;
					}
					else{
						$table_data = array(
								'town' => $this->input->post('ia_town'),
								'postal_code' => $this->input->post('ia_postal_code'),
								'street' => $this->input->post('ia_street'),
								'street_number' => $this->input->post('ia_street_number'),
								'country' => $this->input->post('ia_country'),
						);
						$ia = $this->address_model->save_override($table_data, $data['invoic']['invoic_address_id']);
						$table_data = array(
								'town' => $this->input->post('sa_town'),
								'postal_code' => $this->input->post('sa_postal_code'),
								'street' => $this->input->post('sa_street'),
								'street_number' => $this->input->post('sa_street_number'),
								'country' => $this->input->post('sa_country'),
						);
						$shipping_id = false;
						if ($data['invoic']['shipping_address_id'] == null){
							$shipping_id = $data['invoic']['shipping_address_id'];
						}
						$sa = $this->address_model->save_override($table_data, $shipping_id);
					}
					$table_data = array(
							'order_status_id' => $this->input->post('order_status'),
							'invoic_address_id' => $ia,
							'shipping_address_id' => $sa,
					);
					$this->invoic_model->save($table_data, $data['invoic']['id']);
					redirect("admin/orders");
				}
			}
			else{
				$data['error_title'] = $this->lang->line('static_page_error_body_title');
				$data['error_body'] = $this->lang->line('static_page_error_body');
				$data['title'] = "totosomja - ".$this->lang->line('static_page_error_title');
				$this->load->view("templates/header_manager", $data);
				$this->load->view("templates/wrong_id", $data);
				$this->load->view("templates/right_body_manager", $data);
				$this->load->view("templates/footer", $data);
			}
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function products($id){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			$data['title'] = "totosomja - invoic";
			if ($this->invoic_model->exists($id)){
				$data['invoic'] = $this->invoic_model->get(array(), $id);
				$data['product_in_invoic'] = $this->product_in_invoic_model->get_by_invoic($data['invoic']['id']);
				$data['product'] = $this->product_model->get_sellable();
				
				$this->form_validation->set_rules('edit', 'edit', 'required');
					
				if ($this->form_validation->run() == false){
					$data['title'] = "totosomja - invoic ".$data['invoic']['invoic_id']." products";
		
					$data['functions'] = array(
							array(
									'link' => base_url().'index.php/admin/orders/search',
									'text' => 'search',
							),
							array(
									'link' => base_url().'index.php/orders/view/'.$id,
									'text' => 'print',
									'target' => '_blank',
							),
							array(
									'link' => base_url().'index.php/admin/orders/add_product/'.$id,
									'text' => 'add product',
							),
					);
					$this->load->view("templates/header_manager", $data);
					$this->load->view("manager/invoic/products", $data);
					$this->load->view("manager/invoic/right_body", $data);
					$this->load->view("templates/footer", $data);
				}
				else{
					$i = 0;
					$table_data['invoic_id'] = $id;
					$this->product_in_invoic_model->detach_by_invoic($id);
					foreach ($data['product_in_invoic'] as $pii){
						$i++;
						if ($this->input->post('item'.$i.'_delete') == false){
							$table_data['product_id'] = $pii['product_id'];
							if ($this->input->post('item'.$i.'_id') != false){
								$table_data['product_id'] = $this->input->post('item'.$i.'_id');
							} 
							$table_data['quantity'] = $pii['quantity'];
							if ($this->input->post('item'.$i.'_quantity') != false){
								$table_data['quantity'] = $this->input->post('item'.$i.'_quantity');
							}
							$this->product_in_invoic_model->save($table_data);
						} 
					}
					redirect("admin/orders");
				}
			}
			else{
				$data['error_title'] = $this->lang->line('static_page_error_body_title');
				$data['error_body'] = $this->lang->line('static_page_error_body');
				$data['title'] = "totosomja - ".$this->lang->line('static_page_error_title');
				$this->load->view("templates/header_manager", $data);
				$this->load->view("templates/wrong_id", $data);
				$this->load->view("templates/right_body_manager", $data);
				$this->load->view("templates/footer", $data);
			}
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function add_product($id){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			$data['title'] = "totosomja - invoic";
			if ($this->invoic_model->exists($id)){
				$data['invoic'] = $this->invoic_model->get(array('customer', 'status', 'invoic_address', 'shipping_address'), $id);
				$data['product'] = $this->product_model->get_sellable();
				
				$this->form_validation->set_rules('product_id', 'product id', 'required|is_natural');
				$this->form_validation->set_rules('quantity', 'quantity', 'required|is_natural');
		
				if ($this->form_validation->run() == false){
					$data['title'] = "totosomja - invoic ".$data['invoic']['invoic_id']." add product";
		
					$data['functions'] = array(
							array(
									'link' => base_url().'index.php/admin/orders/search',
									'text' => 'search',
							),
							array(
									'link' => base_url().'index.php/admin/orders/print/'.$id,
									'text' => 'print',
							),
							array(
									'link' => base_url().'index.php/admin/orders/add_product/'.$id,
									'text' => 'add product',
							),
					);
					$this->load->view("templates/header_manager", $data);
					$this->load->view("manager/invoic/add_product", $data);
					$this->load->view("manager/invoic/right_body", $data);
					$this->load->view("templates/footer", $data);
				}
				else{
					$table_data = array(
							'invoic_id' => $id,
							'product_id' => $this->input->post('product_id'),
							'quantity' => $this->input->post('quantity'), 
					);
					$this->product_in_invoic_model->save($table_data);
					redirect("admin/orders");
				}
			}
			else{
				$data['error_title'] = $this->lang->line('static_page_error_body_title');
				$data['error_body'] = $this->lang->line('static_page_error_body');
				$data['title'] = "totosomja - ".$this->lang->line('static_page_error_title');
				$this->load->view("templates/header_manager", $data);
				$this->load->view("templates/wrong_id", $data);
				$this->load->view("templates/right_body_manager", $data);
				$this->load->view("templates/footer", $data);
			}
		}
		else{
			redirect("admin/manager/login");
		}
	}
}