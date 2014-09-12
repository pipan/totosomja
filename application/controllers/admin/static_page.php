<?php
class Static_page extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		
		$this->load->helper('text');
		$this->load->helper('file');
		$this->load->library('form_validation');
		
		$this->load->model('static_page_model');
		$this->load->model('page_link_block_model');
		$this->load->model('static_page_in_link_block_model');
	}
	
	public function is_unique_folder(){
		$used_folders = array('log');
		if ($this->static_page_model->exists_by_folder($this->input->post('folder')) || in_array($this->input->post('folder'), $used_folders)){
			$this->form_validation->set_message('is_unique_folder', 'Folder has to hav unique name');
			return false;
		}
		return true;
	}
	
	public function index(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
				
			$data['style'] = array('style_blog');
			$data['title'] = "totosomja - pages";
			$data['page'] = $this->static_page_model->get();
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/static_page/new_page',
							'text' => 'new page',
					),
					array(
							'link' => base_url().'index.php/admin/static_page/links',
							'text' => 'links',
					),
					array(
							'link' => base_url().'index.php/admin/static_page/order_page',
							'text' => 'order',
					),
					array(
							'link' => base_url().'index.php/admin/static_page/add_link',
							'text' => 'add link',
					),
			);
				
			$this->load->view("templates/header_manager", $data);
			if ($this->static_page_model->is_empty()){
				$data['empty_table'] = "no page";
				$data['empty_table_title'] = "Page - list";
				$this->load->view("templates/empty_table", $data);
			}
			else{
				$this->load->view("manager/static_page/index", $data);
			}
			$this->load->view("manager/static_page/right_body", $data);
			$this->load->view("templates/footer", $data);
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function new_page(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			
			$this->form_validation->set_rules('folder', 'folder', 'required|max_length[30]|callback_is_unique_folder');
			$this->form_validation->set_rules('title', 'title', 'required|max_length[50]');
			$this->form_validation->set_rules('title_en', 'title en', 'required|max_length[50]');
			$data['title'] = "totosomja - page";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/static_page/new_page',
							'text' => 'new page',
					),
					array(
							'link' => base_url().'index.php/admin/static_page/links',
							'text' => 'links',
					),
					array(
							'link' => base_url().'index.php/admin/static_page/order_page',
							'text' => 'order',
					),
					array(
							'link' => base_url().'index.php/admin/static_page/add_link',
							'text' => 'add link',
					),
			);
				
			if ($this->form_validation->run() == false){
				$this->load->view("templates/header_manager", $data);
				$this->load->view("manager/static_page/add_page", $data);
				$this->load->view("manager/static_page/right_body", $data);
				$this->load->view("templates/footer", $data);
			}
			else{
				$table_data = array(
						'folder' => $this->input->post('folder'),
						'page_title' => $this->input->post('title'),
						'page_title_en' => $this->input->post('title_en'),
						'page_slug' => url_title(convert_accented_characters($this->input->post('title')), '-', TRUE),
						'page_slug_en' => url_title(convert_accented_characters($this->input->post('title_en')), '-', TRUE),
						'post_date' => date("Y-n-d H:i:s"),
				);
				$this->static_page_model->save($table_data);
				mkdir("./application/views/static_page/".$this->input->post('folder'), 0777);
				redirect("admin/static_page");
			}
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function edit($id, $edit_lang = "sk"){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
				
			$data['style'] = array('style_blog');
			$data['jscript'] = array('jscript_blog_oop');
			$data['title'] = "totosomja - edit page";
			$data['url'] = "admin/static_page";
			$data['url_save'] = "/save";
			if ($this->static_page_model->exists($id) != false){
				$edit_lang = valid_language($edit_lang);
				$edit_lang_id = $this->language_model->get_by_name($edit_lang);
				$lang_ext = get_language_ext($edit_lang);
				$data['page'] = $this->static_page_model->get(array(), $id);
				$data['series_id'] = 0;
				$data['thumbnail'] = 0;
				$data['blog_title'] = "";
				if (file_exists("./application/views/static_page/".$data['page']['folder']."/titleTextarea".$lang_ext.".txt")){
					$data['blog_title'] = read_file("./application/views/static_page/".$data['page']['folder']."/titleTextarea".$lang_ext.".txt");
				}
				$data['blog_body'] = "";
				if (file_exists("./application/views/static_page/".$data['page']['folder']."/bodyTextarea".$lang_ext.".txt")){
					$data['blog_body'] = read_file("./application/views/static_page/".$data['page']['folder']."/bodyTextarea".$lang_ext.".txt");
				}
				$data['blog_link'] = array();
				if (file_exists("./application/views/static_page/".$data['page']['folder']."/link".$lang_ext.".txt")){
					$data['blog_link'] = Blog_parser::parse_link(read_file("./application/views/static_page/".$data['page']['folder']."/link".$lang_ext.".txt"));
				}
				$data['blog_image'] = array();
				if (file_exists("./application/views/static_page/".$data['page']['folder']."/image".$lang_ext.".txt")){
					$data['blog_image'] = Blog_parser::parse_image(read_file("./application/views/static_page/".$data['page']['folder']."/image".$lang_ext.".txt"));
				}
				$data['blog_video'] = array();
				if (file_exists("./application/views/static_page/".$data['page']['folder']."/video".$lang_ext.".txt")){
					$data['blog_video'] = Blog_parser::parse_video(read_file("./application/views/static_page/".$data['page']['folder']."/video".$lang_ext.".txt"));
				}
				$data['blog_id'] = $id;
				$data['blog_lang'] = $edit_lang;
	
				$this->load->view("templates/header_manager", $data);
				$this->load->view("manager/blog/load_blog", $data);
				$this->load->view("manager/blog/new_blog", $data);
				$this->load->view("templates/right_body_blog_edit", $data);
				$this->load->view("templates/footer", $data);
			}
			else{
				$data['error_title'] = $this->lang->line('static_page_error_body_title');
				$data['error_body'] = $this->lang->line('static_page_error_body');
				$data['title'] = "totosomja - ".$this->lang->line('static_page_error_title');
				$this->load->view("templates/header_manager", $data);
				$this->load->view("templates/wrong_id", $data);
				$this->load->view("templates/right_body_blank", $data);
				$this->load->view("templates/footer", $data);
			}
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function save($edit_id, $edit_lang = ""){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
	
			if ($this->static_page_model->exists($edit_id)){
				$edit_lang = valid_language($edit_lang);
				$lang_ext = get_language_ext($edit_lang);
				$this->form_validation->set_rules('title', 'title', 'required');
				$this->form_validation->set_rules('titleTextarea', 'textarea title', 'required');
				$this->form_validation->set_rules('body', 'body', 'required');
				$this->form_validation->set_rules('bodyTextarea', 'textarea body', 'required');
	
				if ($this->form_validation->run() === FALSE){
					$log = "ID: ".$edit_id.PHP_EOL;
					$log .= "TITLE: ".$this->input->post('title').PHP_EOL;
					$log .= "TITLE_TEXTAREA: ".$this->input->post('titleTextarea').PHP_EOL;
					$log .= "BODY: ".$this->input->post('body').PHP_EOL;
					$log .= "BODY_TEXTAREA: ".$this->input->post('bodyTextarea').PHP_EOL;
					$log .= "LANG: ".$this->data['language']['lang_shortcut'].PHP_EOL;
					write_file("./application/views/static_page/log/".date("Y-n-d-H-i-s").".txt", $log);
					echo validation_errors();
				}
				else{
					$lang = $this->language_model->get_by_name($edit_lang);
					
					$page = $this->static_page_model->get(array(), $edit_id);
					
					write_file("./application/views/static_page/".$page['folder']."/title".$lang_ext.".txt", $this->input->post('title'));
					write_file("./application/views/static_page/".$page['folder']."/titleTextarea".$lang_ext.".txt", $this->input->post('titleTextarea'));
					write_file("./application/views/static_page/".$page['folder']."/body".$lang_ext.".txt", $this->input->post('body'));
					write_file("./application/views/static_page/".$page['folder']."/bodyTextarea".$lang_ext.".txt", $this->input->post('bodyTextarea'));
					if ($this->input->post('link') != false){
						$linkFileData = "";
						foreach ($this->input->post('link') as $link){
							$linkFileData .= "TEXT: ".$link['text'].PHP_EOL;
							$linkFileData .= "LINK: ".$link['link'].PHP_EOL;
						}
						write_file("./application/views/static_page/".$page['folder']."/link".$lang_ext.".txt", $linkFileData, 'w+');
					}
					else{
						delete_files("./application/views/static_page/".$page['folder']."/link".$lang_ext.".txt");
					}
					if ($this->input->post('image') != false){
						$imageFileData = "";
						foreach ($this->input->post('image') as $image){
							$imageFileData .= "TEXT: ".$image['text'].PHP_EOL;
							$imageFileData .= "LINK: ".$image['link'].PHP_EOL;
							$imageFileData .= "WIDTH: ".$image['width'].PHP_EOL;
							$imageFileData .= "ALIGNMENT: ".$image['alignment'].PHP_EOL;
						}
						write_file("./application/views/static_page/".$page['folder']."/image".$lang_ext.".txt", $imageFileData);
					}
					else{
						delete_files("./application/views/static_page/".$page['folder']."/image".$lang_ext.".txt");
					}
					if ($this->input->post('video') != false){
						$videoFileData = "";
						foreach ($this->input->post('video') as $video){
							$videoFileData .= "TEXT: ".$video['text'].PHP_EOL;
							$videoFileData .= "LINK: ".$video['link'].PHP_EOL;
							$videoFileData .= "CODE: ".$video['code'].PHP_EOL;
							$videoFileData .= "WIDTH: ".$video['width'].PHP_EOL;
							$videoFileData .= "ALIGNMENT: ".$video['alignment'].PHP_EOL;
						}
						write_file("./application/views/static_page/".$page['folder']."/video".$lang_ext.".txt", $videoFileData);
					}
					else{
						delete_files("./application/views/static_page/".$page['folder']."/video".$lang_ext.".txt");
					}
					echo "success";
				}
			}
			else{
				echo "fail";
			}
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function links(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
	
			$data['style'] = array('style_blog');
			$data['title'] = "totosomja - pages";
			$data['links'] = $this->static_page_in_link_block_model->get(array('page', 'block'));
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/static_page/new_page',
							'text' => 'new page',
					),
					array(
							'link' => base_url().'index.php/admin/static_page/links',
							'text' => 'links',
					),
					array(
							'link' => base_url().'index.php/admin/static_page/order_page',
							'text' => 'order',
					),
					array(
							'link' => base_url().'index.php/admin/static_page/add_link',
							'text' => 'add link',
					),
			);
	
			$this->load->view("templates/header_manager", $data);
			if ($this->static_page_in_link_block_model->is_empty()){
				$data['empty_table'] = "no page";
				$data['empty_table_title'] = "Links - list";
				$this->load->view("templates/empty_table", $data);
			}
			else{
				$this->load->view("manager/static_page/links", $data);
			}
			$this->load->view("manager/static_page/right_body", $data);
			$this->load->view("templates/footer", $data);
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function add_link(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
				
			$this->form_validation->set_rules('page', 'page', 'required|is_natural');
			$this->form_validation->set_rules('block', 'block', 'required|is_natural');
			$this->form_validation->set_rules('position', 'position', 'required|is_natural');
			$data['title'] = "totosomja - links";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/static_page/new_page',
							'text' => 'new page',
					),
					array(
							'link' => base_url().'index.php/admin/static_page/links',
							'text' => 'links',
					),
					array(
							'link' => base_url().'index.php/admin/static_page/order_page',
							'text' => 'order',
					),
					array(
							'link' => base_url().'index.php/admin/static_page/add_link',
							'text' => 'add link',
					),
			);
			$data['block'] = $this->page_link_block_model->get();
			$data['page'] = $this->static_page_model->get();
	
			if ($this->form_validation->run() == false){
				$this->load->view("templates/header_manager", $data);
				$this->load->view("manager/static_page/add_link", $data);
				$this->load->view("manager/static_page/right_body", $data);
				$this->load->view("templates/footer", $data);
			}
			else{
				$table_data = array(
						'page_id' => $this->input->post('page'),
						'block_id' => $this->input->post('block'),
						'position' => $this->input->post('position'),
				);
				$this->static_page_in_link_block_model->save($table_data);
				redirect("admin/static_page/links");
			}
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function remove_link($id){
		if (is_admin_login($this)){
			$this->static_page_in_link_block_model->remove($id);
			redirect("admin/static_page/links");
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function order_page(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
	
			$data['title'] = "totosomja - links";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/static_page/new_page',
							'text' => 'new page',
					),
					array(
							'link' => base_url().'index.php/admin/static_page/links',
							'text' => 'links',
					),
					array(
							'link' => base_url().'index.php/admin/static_page/order_page',
							'text' => 'order',
					),
					array(
							'link' => base_url().'index.php/admin/static_page/add_link',
							'text' => 'add link',
					),
			);
			$data['links'] = $this->static_page_in_link_block_model->get(array('page', 'block'));
			foreach ($data['links'] as $l){
				$this->form_validation->set_rules('position_'.$l['id'], 'position '.$l['id'], 'required|is_natural');
			}
			
			if ($this->form_validation->run() == false){
				$this->load->view("templates/header_manager", $data);
				$this->load->view("manager/static_page/order", $data);
				$this->load->view("manager/static_page/right_body", $data);
				$this->load->view("templates/footer", $data);
			}
			else{
				foreach ($data['links'] as $l){
					$table_data = array(
							'position' => $this->input->post('position_'.$l['id']),
					);
					$this->static_page_in_link_block_model->save($table_data, $l['id']);
				}
				redirect("admin/static_page/links");
			}
		}
		else{
			redirect("cms/login");
		}
	}
}