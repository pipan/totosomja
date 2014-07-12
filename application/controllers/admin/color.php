<?php
class Color extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model("color_model");
	}
	
	public function index(){
		if (is_admin_login($this)){
			$data['title'] = "totosomja - color";
			$data['color'] = $this->color_model->get();
			$data['functions'] = array(
				array(
					'link' => base_url().'index.php/admin/color/new_color',
					'text' => 'add color',
				),
			);
			
			$this->load->view("templates/header_manager", $data);
			if ($this->color_model->is_empty()){
				$data['empty_table'] = "ziadne farby";
				$data['empty_table_title'] = "Color - list";
				$this->load->view("templates/empty_table", $data);
			}
			else{
				$this->load->view("manager/color/index", $data);
			}
			$this->load->view("templates/right_body_manager", $data);
			$this->load->view("templates/footer", $data);
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function new_color(){
		if (is_admin_login($this)){
			$data['title'] = "totosomja - new color";
			$data['functions'] = array(
				array(
					'link' => base_url().'index.php/admin/color/new_color',
					'text' => 'add color',
				),
			);
			
			$this->form_validation->set_rules('name', 'color name', 'required');
			
			if ($this->form_validation->run() === FALSE){
				$this->load->view("templates/header_manager", $data);
				$this->load->view("manager/color/new_color", $data);
				$this->load->view("templates/right_body_manager", $data);
				$this->load->view("templates/footer", $data);
			}
			else{
				$table_data = array(
					'color_name' => $this->input->post('name'),
				);
				$this->color_model->save($table_data);
				redirect("admin/color");
			}
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function edit($id = 0){
		if (is_admin_login($this)){
			$data['title'] = "totosomja - new color";
			$data['functions'] = array(
				array(
					'link' => base_url().'index.php/admin/color/new_color',
					'text' => 'add color',
				),
			);
			
			if ($id > 0 && sizeof($this->color_model->get($id)) > 0){
				$data['color'] = $this->color_model->get($id);
				
				$this->form_validation->set_rules('name', 'color name', 'required');
				
				if ($this->form_validation->run() === FALSE){
					$this->load->view("templates/header_manager", $data);
					$this->load->view("manager/color/edit", $data);
					$this->load->view("templates/right_body_manager", $data);
					$this->load->view("templates/footer", $data);
				}
				else{
					$table_data = array(
						'color_name' => $this->input->post('name'),
					);
					$this->color_model->save($table_data, $id);
					redirect("admin/color");
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