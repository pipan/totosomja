<?php
class Orders extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		
		$this->load->helper('address');
		
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
	
	public function view($id, $language = "sk"){
		$language = valid_language($language);
		$this->data['language_ext'] = get_language_ext($language);
		$this->lang->load("general", $language);
		$this->lang->load("order", $language);
		$this->data['lang'] = $this->lang;
		$this->data['language'] = $language;
		
		$this->data['title'] = $this->lang->line('invoic_title');
		if ($this->invoic_model->exists($id)){
			if (is_admin_login($this) || (is_login($this) && $this->invoic_model->exists_to_customer($id, $this->session->userdata('login')['id']))){
				$this->data['invoic'] = $this->invoic_model->get(array('seller', 'invoic_address', 'shipping_address', 'seller_address'), $id);
				if ($this->data['invoic']['shipping_address_id'] == null){
					$this->data['invoic']['sa_town'] = $this->data['invoic']['ia_town'];
					$this->data['invoic']['sa_postal_code'] = $this->data['invoic']['ia_postal_code'];
					$this->data['invoic']['sa_street'] = $this->data['invoic']['ia_street'];
					$this->data['invoic']['sa_street_number'] = $this->data['invoic']['ia_street_number'];
					$this->data['invoic']['sa_country'] = $this->data['invoic']['ia_country'];
				}
				$this->data['product_in_invoic'] = $this->product_in_invoic_model->get_by_invoic($id, array('product'));
				$this->data['title'] .= " ".$this->data['invoic']['invoic_id'];
				
				$this->load->view("customer/orders/view_header", $this->data);
				$this->load->view("customer/orders/view_body", $this->data);
				$this->load->view("customer/orders/view_footer", $this->data);
			}
			else{
				$this->load->view("customer/orders/view_header", $this->data);
				$this->load->view("customer/orders/view_error_message", $this->data);
				$this->load->view("customer/orders/view_footer", $this->data);
			}
		}
		else{
			$this->load->view("customer/orders/view_header", $this->data);
			$this->load->view("customer/orders/view_error_message", $this->data);
			$this->load->view("customer/orders/view_footer", $this->data);
		}
	}
}