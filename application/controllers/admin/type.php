<?php
class Type extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('file');
		$this->load->library('form_validation');
		$this->load->model("type_model");
	}
	
	public function index(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			
			$data['title'] = "totosomja - type";
			$data['type'] = $this->type_model->get();
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/type/new_type',
							'text' => 'add type',
					),
			);
		
			$this->load->view("templates/header_manager", $data);
			if ($this->type_model->is_empty()){
				$data['empty_table'] = "no type";
				$data['empty_table_title'] = "Type - list";
				$this->load->view("templates/empty_table", $data);
			}
			else{
				$this->load->view("manager/type/index", $data);
			}
			$this->load->view("templates/right_body_manager", $data);
			$this->load->view("templates/footer", $data);
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function new_type(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			
			$data['title'] = "totosomja - new type";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/type/new_type',
							'text' => 'add type',
					),
			);
		
			$this->form_validation->set_rules('name', 'type name', 'required|max_length[30]');
			$this->form_validation->set_rules('name_en', 'type name en', 'required|max_length[30]');
			$this->form_validation->set_rules('description', 'description', 'required');
			$this->form_validation->set_rules('description_en', 'description en', 'required');
			
			$config['upload_path'] = './content/type/image/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	= '1024';
			
			$this->load->library('upload', $config);
			
			if ($this->form_validation->run() === FALSE){
				$this->load->view("templates/header_manager", $data);
				$this->load->view("manager/type/new_type", $data);
				$this->load->view("templates/right_body_manager", $data);
				$this->load->view("templates/footer", $data);
			}
			else{
				if ($this->upload->do_upload('image') && strlen($this->upload->data()['file_name']) <= 100){
					$table_data = array(
							'type_name' => $this->input->post('name'),
							'type_name_en' => $this->input->post('name_en'),
							'type_image' => $this->upload->data()['file_name'],
					);
				}
				else{
					$table_data = array(
							'type_name' => $this->input->post('name'),
							'type_name_en' => $this->input->post('name_en'),
					);
				}
				$id = $this->type_model->save($table_data);
				write_file("./content/type/description/".$id.".txt", $this->input->post('description'));
				write_file("./content/type/description/".$id."_en.txt", $this->input->post('description_en'));
				redirect("admin/type");
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
			
			$data['title'] = "totosomja - new type";
			$data['functions'] = array(
				array(
					'link' => base_url().'index.php/admin/type/new_type',
					'text' => 'add type',
				),
			);
		
			if ($id > 0 && sizeof($this->type_model->get($id)) > 0){
				$data['type'] = $this->type_model->get($id);
					
				$this->form_validation->set_rules('name', 'type name', 'required|max_length[30]');
				$this->form_validation->set_rules('name_en', 'type name en', 'required|max_length[30]');
				$this->form_validation->set_rules('description', 'description', 'required');
				$this->form_validation->set_rules('description_en', 'description en', 'required');
				
				$config['upload_path'] = './content/type/image/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '1024';
				
				$this->load->library('upload', $config);
					
				if ($this->form_validation->run() === FALSE){
					$this->load->view("templates/header_manager", $data);
					$this->load->view("manager/type/edit", $data);
					$this->load->view("templates/right_body_manager", $data);
					$this->load->view("templates/footer", $data);
				}
				else{
					if ($this->upload->do_upload('image') && strlen($this->upload->data()['file_name']) <= 100){
						delete_files("./content/type/image/".$data['type']['type_image']);
						$table_data = array(
								'type_name' => $this->input->post('name'),
								'type_name_en' => $this->input->post('name_en'),
								'type_image' => $this->upload->data()['file_name'],
						);
					}
					else{
						$table_data = array(
								'type_name' => $this->input->post('name'),
								'type_name_en' => $this->input->post('name_en'),
						);
					}
					$this->type_model->save($table_data, $id);
					write_file("./content/type/description/".$id.".txt", $this->input->post('description'));
					write_file("./content/type/description/".$id."_en.txt", $this->input->post('description_en'));
					redirect("admin/type");
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