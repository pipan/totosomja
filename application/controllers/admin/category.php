<?php
class Category extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('file');
		$this->load->library('form_validation');
		$this->load->model("category_model");
	}
	
	public function index(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			
			$data['title'] = "totosomja - category";
			$data['category'] = $this->category_model->get();
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/category/new_category',
							'text' => 'add category',
					),
			);
		
			$this->load->view("templates/header_manager", $data);
			if ($this->category_model->is_empty()){
				$data['empty_table'] = "no category";
				$data['empty_table_title'] = "Category - list";
				$this->load->view("templates/empty_table", $data);
			}
			else{
				$this->load->view("manager/category/index", $data);
			}
			$this->load->view("templates/right_body_manager", $data);
			$this->load->view("templates/footer", $data);
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function new_category(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			
			$data['title'] = "totosomja - new category";
			$data['functions'] = array(
				array(
					'link' => base_url().'index.php/admin/category/new_category',
					'text' => 'add category',
				),
			);
		
			$this->form_validation->set_rules('name', 'category name', 'required|max_length[30]');
			$this->form_validation->set_rules('name_en', 'category name en', 'required|max_length[30]');
			$this->form_validation->set_rules('description', 'description', 'required');
			$this->form_validation->set_rules('description_en', 'description en', 'required');
			
			$config['upload_path'] = './content/category/image/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	= '1024';
			
			$this->load->library('upload', $config);
			
			if ($this->form_validation->run() === FALSE){
				$this->load->view("templates/header_manager", $data);
				$this->load->view("manager/category/new_category", $data);
				$this->load->view("templates/right_body_manager", $data);
				$this->load->view("templates/footer", $data);
			}
			else{
				if ($this->upload->do_upload('image') && strlen($this->upload->data()['file_name']) <= 100){
					$table_data = array(
							'category_name' => $this->input->post('name'),
							'category_name_en' => $this->input->post('name_en'),
							'category_image' => $this->upload->data()['file_name'],
					);
				}
				else{
					$table_data = array(
							'category_name' => $this->input->post('name'),
							'category_name_en' => $this->input->post('name_en'),
					);
				}
				$id = $this->category_model->save($table_data);
				write_file("./content/category/description/".$id.".txt", $this->input->post('description'));
				write_file("./content/category/description/".$id."_en.txt", $this->input->post('description_en'));
				redirect("admin/category");
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
			
			$data['title'] = "totosomja - new category";
			$data['functions'] = array(
				array(
					'link' => base_url().'index.php/admin/category/new_category',
					'text' => 'add category',
				),
			);
		
			if ($id > 0 && sizeof($this->category_model->get($id)) > 0){
				$data['category'] = $this->category_model->get($id);
					
				$this->form_validation->set_rules('name', 'category name', 'required|max_length[30]');
				$this->form_validation->set_rules('name_en', 'category name en', 'required|max_length[30]');
				$this->form_validation->set_rules('description', 'description', 'required');
				$this->form_validation->set_rules('description_en', 'description en', 'required');
				
				$config['upload_path'] = './content/category/image/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '1024';
				
				$this->load->library('upload', $config);
					
				if ($this->form_validation->run() === FALSE){
					$this->load->view("templates/header_manager", $data);
					$this->load->view("manager/category/edit", $data);
					$this->load->view("templates/right_body_manager", $data);
					$this->load->view("templates/footer", $data);
				}
				else{
					if ($this->upload->do_upload('image') && strlen($this->upload->data()['file_name']) <= 100){
						delete_files("./content/category/image/".$data['category']['category_image']);
						$table_data = array(
								'category_name' => $this->input->post('name'),
								'category_name_en' => $this->input->post('name_en'),
								'category_image' => $this->upload->data()['file_name'],
						);
					}
					else{
						$table_data = array(
								'category_name' => $this->input->post('name'),
								'category_name_en' => $this->input->post('name_en'),
						);
					}
					$this->category_model->save($table_data, $id);
					write_file("./content/category/description/".$id.".txt", $this->input->post('description'));
					write_file("./content/category/description/".$id."_en.txt", $this->input->post('description_en'));
					redirect("admin/category");
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