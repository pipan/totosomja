<?php
class Material extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model("material_model");
	}
	
	public function index(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			
			$data['title'] = "totosomja - material";
			$data['material'] = $this->material_model->get();
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/material/new_material',
							'text' => 'add material',
					),
			);
			
			$this->load->view("templates/header_manager", $data);
			if ($this->material_model->is_empty()){
				$data['empty_table'] = "no material";
				$data['empty_table_title'] = "Material - list";
				$this->load->view("templates/empty_table", $data);
			}
			else{
				$this->load->view("manager/material/index", $data);
			}
			$this->load->view("templates/right_body_manager", $data);
			$this->load->view("templates/footer", $data);
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function new_material(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			
			$data['title'] = "totosomja - new material";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/material/new_material',
							'text' => 'add material',
					),
			);
			
			$this->form_validation->set_rules('name', 'material name', 'required|max_length[30]');
			$this->form_validation->set_rules('name_en', 'material name en', 'required|max_length[30]');
			
			if ($this->form_validation->run() === FALSE){
				$this->load->view("templates/header_manager", $data);
				$this->load->view("manager/material/new_material", $data);
				$this->load->view("templates/right_body_manager", $data);
				$this->load->view("templates/footer", $data);
			}
			else{
				$table_data = array(
						'material_name' => $this->input->post('name'),
						'material_name_en' => $this->input->post('name_en'),
				);
				$this->material_model->save($table_data);
				redirect("admin/material");
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
			
			$data['title'] = "totosomja - new material";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/material/new_material',
							'text' => 'add material',
					),
			);
			
			if ($id > 0 && sizeof($this->material_model->get($id)) > 0){
				$data['material'] = $this->material_model->get($id);
				
				$this->form_validation->set_rules('name', 'material name', 'required|max_length[30]');
				$this->form_validation->set_rules('name_en', 'material name en', 'required|max_length[30]');
				
				if ($this->form_validation->run() === FALSE){
					$this->load->view("templates/header_manager", $data);
					$this->load->view("manager/material/edit", $data);
					$this->load->view("templates/right_body_manager", $data);
					$this->load->view("templates/footer", $data);
				}
				else{
					$table_data = array(
							'material_name' => $this->input->post('name'),
							'material_name_en' => $this->input->post('name_en'),
					);
					$this->material_model->save($table_data, $id);
					redirect("admin/material");
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