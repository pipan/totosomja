<?php
class Blog_series extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model("blog_series_model");
	}
	
	public function index(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			
			$data['title'] = "totosomja - blog series";
			$data['series'] = $this->blog_series_model->get();
			$data['admin_id'] = $this->session->userdata('admin_id');
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/blog_series/new_blog_serie',
							'text' => 'new serie',
					),
			);
			
			$this->load->view("templates/header_manager", $data);
			if ($this->blog_series_model->is_empty()){
				$data['empty_table'] = "no blog serie";
				$data['empty_table_title'] = "Blog series - list";
				$this->load->view("templates/empty_table", $data);
			}
			else{
				$this->load->view("manager/blog_series/index", $data);
			}
			$this->load->view("templates/right_body_blog", $data);
			$this->load->view("templates/footer", $data);
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function new_blog_serie(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			
			$data['title'] = "totosomja - new series";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/blog_series/new_blog_serie',
							'text' => 'new serie',
					),
			);
			
			$this->form_validation->set_rules('name', 'serie name', 'required|max_length[50]');
			$this->form_validation->set_rules('name_en', 'serie name en', 'required|max_length[50]');
			
			if ($this->form_validation->run() == false){
				$this->load->view("templates/header_manager", $data);
				$this->load->view("manager/blog_series/new_blog_serie", $data);
				$this->load->view("templates/right_body_blog", $data);
				$this->load->view("templates/footer", $data);
			}
			else{
				$table_data = array(
						'admin_id' => $this->session->userdata('admin_id'),
						'series_name' => $this->input->post('name'),
						'series_name_en' => $this->input->post('name_en'),
				);
				$this->blog_series_model->save($table_data);
				redirect("admin/blog_series");
			}
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
			
			$data['title'] = "totosomja - new series";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/blog_series/new_blog_serie',
							'text' => 'new serie',
					),
			);
				
			if ($id > 0 && sizeof($this->blog_series_model->get($id)) > 0 && $this->blog_series_model->can_edit($id, $this->session->userdata('admin_id'))){
				$data['series'] = $this->blog_series_model->get($id);
			
				$this->form_validation->set_rules('name', 'serie name', 'required|max_length[50]');
				$this->form_validation->set_rules('name_en', 'serie name en', 'required|max_length[50]');
			
				if ($this->form_validation->run() === FALSE){
					$this->load->view("templates/header_manager", $data);
					$this->load->view("manager/blog_series/edit", $data);
					$this->load->view("templates/right_body_blog", $data);
					$this->load->view("templates/footer", $data);
				}
				else{
					$table_data = array(
							'admin_id' => $this->session->userdata('admin_id'),
							'series_name' => $this->input->post('name'),
							'series_name_en' => $this->input->post('name_en'),
					);
					$this->blog_series_model->save($table_data, $id);
					redirect("admin/blog_series");
				}
			}
			else{
				$this->load->view("templates/header_manager", $data);
				$this->load->view("templates/wrong_id", $data);
				$this->load->view("templates/right_body_blog", $data);
				$this->load->view("templates/footer", $data);
			}
		}
		else{
			redirect("admin/manager/login");
		}
	}
}