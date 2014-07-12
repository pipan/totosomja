<?php
class Size extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model("size_model");
	}
	
	public function index(){
		if (is_admin_login($this)){
			$data['title'] = "totosomja - size";
			$data['size'] = $this->size_model->get();
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/size/new_size',
							'text' => 'add size',
					),
			);
			
			$this->load->view("templates/header_manager", $data);
			if ($this->size_model->is_empty()){
				$data['empty_table'] = "ziadne velkosti";
				$data['empty_table_title'] = "Size - list";
				$this->load->view("templates/empty_table", $data);
			}
			else{
				$this->load->view("manager/size/index", $data);
			}
			$this->load->view("templates/right_body_manager", $data);
			$this->load->view("templates/footer", $data);
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function new_size(){
		if (is_admin_login($this)){
			$data['title'] = "totosomja - new size";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/size/new_size',
							'text' => 'add size',
					),
			);
			
			$this->form_validation->set_rules('name', 'size name', 'required');
			
			if ($this->form_validation->run() === FALSE){
				$this->load->view("templates/header_manager", $data);
				$this->load->view("manager/size/new_size", $data);
				$this->load->view("templates/right_body_manager", $data);
				$this->load->view("templates/footer", $data);
			}
			else{
				$table_data = array(
					'size_name' => $this->input->post('name'),
				);
				$this->size_model->save($table_name);
				redirect("admin/size");
			}
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function edit($id = 0){
		if (is_admin_login($this)){
			$data['title'] = "totosomja - new size";
			$data['functions'] = array(
				array(
					'link' => base_url().'index.php/admin/size/new_size',
					'text' => 'add size',
				),
			);
			
			if ($id > 0 && sizeof($this->size_model->get($id)) > 0){
				$data['size'] = $this->size_model->get($id);
				
				$this->form_validation->set_rules('name', 'size name', 'required');
				
				if ($this->form_validation->run() === FALSE){
					$this->load->view("templates/header_manager", $data);
					$this->load->view("manager/size/edit", $data);
					$this->load->view("templates/right_body_manager", $data);
					$this->load->view("templates/footer", $data);
				}
				else{
					$table_data = array(
						'size_name' => $this->input->post('name'),
					);
					$this->size_model->save($table_data, $id);
					redirect("admin/size");
				}
			}
			else{
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