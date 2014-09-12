<?php
class Supplier extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('delivery');
		$this->load->library('form_validation');
		$this->load->model("supplier_model");
	}
	
	public function index(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			
			$data['title'] = "totosomja - supplier";
			$data['supplier'] = $this->supplier_model->get();
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/supplier/new_supplier',
							'text' => 'add supplier',
					),
			);
		
			$this->load->view("templates/header_manager", $data);
			if ($this->supplier_model->is_empty()){
				$data['empty_table'] = "no supplier";
				$data['empty_table_title'] = "Supplier - list";
				$this->load->view("templates/empty_table", $data);
			}
			else{
				$this->load->view("manager/supplier/index", $data);
			}
			$this->load->view("templates/right_body_manager", $data);
			$this->load->view("templates/footer", $data);
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function new_supplier(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			
			$data['title'] = "totosomja - new supplier";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/supplier/new_supplier',
							'text' => 'add supplier',
					),
			);
		
			$this->form_validation->set_rules('name', 'supplier name', 'required|max_length[30]');
			$this->form_validation->set_rules('delivery_count', 'delivery number', 'required');
			$this->form_validation->set_rules('delivery_time_kind', 'delivery time type', 'required');
		
			if ($this->form_validation->run() === FALSE){
				$this->load->view("templates/header_manager", $data);
				$this->load->view("manager/supplier/new_supplier", $data);
				$this->load->view("templates/right_body_manager", $data);
				$this->load->view("templates/footer", $data);
			}
			else{
				$table_data = array(
						'supplier_name' => $this->input->post('name'),
						'supplier_delivery' => delivery_to_sec($this->input->post('delivery_count'), $this->input->post('delivery_time_kind')),
				);
				$this->supplier_model->save($table_data);
				redirect("admin/supplier");
			}
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function edit($id = 0){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			
			$data['title'] = "totosomja - edit supplier";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/supplier/new_supplier',
							'text' => 'add supplier',
					),
			);
		
			if ($id > 0 && sizeof($this->supplier_model->get($id)) > 0){
				$data['supplier'] = $this->supplier_model->get($id);
					
				$this->form_validation->set_rules('name', 'supplier name', 'required|max_length[30]');
				$this->form_validation->set_rules('delivery_count', 'delivery number', 'required');
			$this->form_validation->set_rules('delivery_time_kind', 'delivery time type', 'required');
					
				if ($this->form_validation->run() === FALSE){
					$this->load->view("templates/header_manager", $data);
					$this->load->view("manager/supplier/edit", $data);
					$this->load->view("templates/right_body_manager", $data);
					$this->load->view("templates/footer", $data);
				}
				else{
					$table_data = array(
							'supplier_name' => $this->input->post('name'),
							'supplier_delivery' => delivery_to_sec($this->input->post('delivery_count'), $this->input->post('delivery_time_kind')),
					);
					$this->supplier_model->save($table_data, $id);
					redirect("admin/supplier");
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