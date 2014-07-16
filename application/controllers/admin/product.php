<?php
class Product extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('file');
		$this->load->helper('text');
		$this->load->helper('gender');
		$this->load->library('form_validation');
		$this->load->model('admin_model');
		$this->load->model('change_label_model');
		$this->load->model('type_model');
		$this->load->model('category_model');
		$this->load->model('color_model');
		$this->load->model('size_model');
		$this->load->model('material_model');
		$this->load->model('supplier_model');
		$this->load->model("product_model");
		$this->load->model("product_changelog_model");
	}
	
	public function valid_id($val, $id){
		if ($id == 0 || $this->product_model->is_sellable(array('id' => $id))){
			return true;
		}
		$this->form_validation->set_message('valid_id', 'Wrong product id');
		return false;
	}
	
	public function image_upload($val, $id){
		if ($this->upload->do_upload('image')){
			return $this->upload->data()['file_name'];
		}
		else if ($id > 0){
			$product = $this->product_model->get($id);
			return $product['product_image'];
		}
		$this->form_validation->set_message('image_upload', 'Cannot upload image '.$id.', make sure image size is less then 512kB or contact system admin');
		return false;
	}
	
	public function is_unique_sellable($val, $id){
		if (($same_id = $this->product_model->is_unique_sellable($val)) == true || $same_id === $id){
			return true;
		}
		$this->form_validation->set_message('is_unique_sellable', 'product name has to be unique');
		return false;
	}
	
	public function index(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			
			$data['title'] = "totosomja - products";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/product/new_product',
							'text' => 'add product',
					),
					array(
							'link' => base_url().'index.php/admin/product/help',
							'text' => 'help',
					),
			);
			
			if ($this->product_model->is_sellable()){
				$data['product'] = $this->product_model->get_sellable();
				$this->load->view("templates/header_manager", $data);
				$this->load->view("manager/product/index", $data);
				$this->load->view("templates/right_body_manager", $data);
				$this->load->view("templates/footer", $data);
			}
			else{
				$data['empty_table'] = "ziadne produkty";
				$data['empty_table_title'] = "Product - list";
				$this->load->view("templates/header_manager", $data);
				$this->load->view("templates/empty_table", $data);
				$this->load->view("templates/right_body_manager", $data);
				$this->load->view("templates/footer", $data);
			}
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function help(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
				
			$data['title'] = "totosomja - products help";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/product/new_product',
							'text' => 'add product',
					),
					array(
							'link' => base_url().'index.php/admin/product/help',
							'text' => 'help',
					),
			);
			
			$this->load->view("templates/header_manager", $data);
			$this->load->view("manager/product/help", $data);
			$this->load->view("templates/right_body_manager", $data);
			$this->load->view("templates/footer", $data);
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function update($id){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
				
			$data['title'] = "totosomja - products";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/product/new_product',
							'text' => 'add product',
					),
			);
			
			if ($id > 0 && $this->product_model->is_sellable(array('product.id =' => $id))){	
				$data['product'] = $this->product_model->get_sellable(array('product.id =' => $id), false);
				
				$this->form_validation->set_rules('store', 'store', 'required|is_natural');
				$this->form_validation->set_rules('sellable', 'sellable', '');
				
				if ($this->form_validation->run() === FALSE){
					$this->load->view("templates/header_manager", $data);
					$this->load->view("manager/product/update", $data);
					$this->load->view("templates/right_body_manager", $data);
					$this->load->view("templates/footer", $data);
				}
				else{
					$sellable = 0;
					if ($this->input->post('sellable') != false){
						$sellable = 1;
					}
					$table_data = array(
							'store' => $this->input->post('store'),
							'sellable' => $sellable,
					);
					$this->product_model->update($id, $table_data);
					$table_data = array(
							'product_id' => $id,
							'admin_id' => $this->session->userdata('admin_id'),
							'change_id' => 8,
							'change_date' => date("Y-n-d H:i:s"),
					);
					$this->product_changelog_model->save($table_data);
					if ($sellable == 0){
						$table_data = array(
								'product_id' => $id,
								'admin_id' => $this->session->userdata('admin_id'),
								'change_id' => 1,
								'change_date' => date("Y-n-d H:i:s"),
						);
						$this->product_changelog_model->save($table_data);
					}
					redirect("admin/product");
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
	
	public function new_product($id = false){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			if ($id != false){
				$data['product'] = $this->product_model->get($id);
				$data['product']['description'] = read_file("./content/product/description/".$id.".txt");
			}
			else{
				$data['product'] = array(
						'id' => 0,
						'product_name' => '',
						'type_id' => 0,
						'category_id' => 0,
						'size_id' => 0,
						'color_id' => 0,
						'material_id' => 0,
						'supplier_id' => 0,
						'price' => '',
						'store' => '',
						'gender' => 0,
						'description' => '',
				);
			}
			
			$this->form_validation->set_rules('name', 'name', 'required|callback_is_unique_sellable[0]|valid_id['.$id.']');
			$this->form_validation->set_rules('category_id', 'category', 'required');
			$this->form_validation->set_rules('type_id', 'type', 'required');
			$this->form_validation->set_rules('price', 'price', 'required');
			$this->form_validation->set_rules('color_id', 'color', 'required');
			$this->form_validation->set_rules('size_id', 'size', 'required');
			$this->form_validation->set_rules('material_id', 'material', 'required');
			$this->form_validation->set_rules('supplier_id', 'supplier', 'required');
			$this->form_validation->set_rules('store', 'store', 'required');
			$this->form_validation->set_rules('gender', 'gender', 'required');
			$this->form_validation->set_rules('description', 'description', 'required');
			$this->form_validation->set_rules('image_name', 'image', 'callback_image_upload['.$id.']');
			
			$config['upload_path'] = './content/product/image/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	= '512';
			$this->load->library('upload', $config);
			
			$data['title'] = "totosomja - new product";
			$data['model'] = array(
				'type' => $this->type_model,
				'category' => $this->category_model,
				'color' => $this->color_model,
				'size' => $this->size_model,
				'material' => $this->material_model,
				'supplier' => $this->supplier_model,
					
			);
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/product/new_product',
							'text' => 'add product',
					),
			);
			
			if ($this->form_validation->run() === FALSE){
				$this->load->view("templates/header_manager", $data);
				$this->load->view("manager/product/new_product", $data);
				$this->load->view("templates/right_body_manager", $data);
				$this->load->view("templates/footer", $data);
			}
			else{
				$table_data = array(
						'product_name' => $this->input->post('name'),
						'product_slug' => url_title(convert_accented_characters($this->input->post('name')), '-', TRUE),
						'category_id' => $this->input->post('category_id'),
						'type_id' => $this->input->post('type_id'),
						'color_id' => $this->input->post('color_id'),
						'size_id' => $this->input->post('size_id'),
						'material_id' => $this->input->post('material_id'),
						'supplier_id' => $this->input->post('supplier_id'),
						'price' => $this->input->post('price'),
						'store' => $this->input->post('store'),
						'gender' => $this->input->post('gender'),
						'product_image' => $this->input->post('image_name'),
						'sellable' => 1,
						'canceled' => 0,
						'created' => date("Y-n-d H:i:s"),
				);
				$id = $this->product_model->save($table_data);
				write_file("./content/product/description/".$id.".txt", $this->input->post('description'));
				$table_data = array(
						'product_id' => $id,
						'admin_id' => $this->session->userdata('admin_id'),
						'change_id' => 7,
						'change_date' => date("Y-n-d H:i:s"),
				);
				$this->product_changelog_model->save($table_data);
				redirect("admin/product");
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
			
			$data['title'] = "totosomja - edit product";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/product/new_product',
							'text' => 'add product',
					),
			);
			if ($id > 0 && $this->product_model->is_sellable(array('product.id =' => $id))){
				$this->form_validation->set_rules('name', 'name', 'required|callback_is_unique_sellable['.$id.']');
				$this->form_validation->set_rules('category_id', 'category', 'required');
				$this->form_validation->set_rules('type_id', 'type', 'required');
				$this->form_validation->set_rules('price', 'price', 'required');
				$this->form_validation->set_rules('color_id', 'color', 'required');
				$this->form_validation->set_rules('size_id', 'size', 'required');
				$this->form_validation->set_rules('material_id', 'material', 'required');
				$this->form_validation->set_rules('supplier_id', 'supplier', 'required');
				$this->form_validation->set_rules('store', 'store', 'required');
				$this->form_validation->set_rules('gender', 'gender', 'required');
				$this->form_validation->set_rules('description', 'description', 'required');
				
				$config['upload_path'] = './content/product/image/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '512';
				$this->load->library('upload', $config);
				
				$data['model'] = array(
					'type' => $this->type_model,
					'category' => $this->category_model,
					'color' => $this->color_model,
					'size' => $this->size_model,
					'material' => $this->material_model,
					'supplier' => $this->supplier_model,
						
				);
				$data['product'] = $this->product_model->get_sellable(array('product.id =' => $id), false);
				
				if ($this->form_validation->run() === FALSE){
					$this->load->view("templates/header_manager", $data);
					$this->load->view("manager/product/edit", $data);
					$this->load->view("templates/right_body_manager", $data);
					$this->load->view("templates/footer", $data);
				}
				else{
					$this->product_model->set_canceled($id);
					$image = $data['product']['product_image'];
					if ($this->image_upload()){
						$image = $this->upload->data()['file_name'];
					}
					$table_data = array(
							'product_name' => $this->input->post('name'),
							'product_slug' => url_title(convert_accented_characters($this->input->post('name')), '-', TRUE),
							'category_id' => $this->input->post('category_id'),
							'type_id' => $this->input->post('type_id'),
							'color_id' => $this->input->post('color_id'),
							'size_id' => $this->input->post('size_id'),
							'material_id' => $this->input->post('material_id'),
							'supplier_id' => $this->input->post('supplier_id'),
							'price' => $this->input->post('price'),
							'store' => $this->input->post('store'),
							'gender' => $this->input->post('gender'),
							'product_image' => $image,
							'sellable' => 1,
							'canceled' => 0,
							'created' => date("Y-n-d H:i:s"),
					);
					$id = $this->product_model->save($table_data);
					write_file("./content/product/description/".$id.".txt", $this->input->post('description'));
					$table_data = array(
							'product_id' => $id,
							'admin_id' => $this->session->userdata('admin_id'),
							'change_id' => 6,
							'change_date' => date("Y-n-d H:i:s"),
					);
					$this->product_changelog_model->save($table_data);
					redirect("admin/product");
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