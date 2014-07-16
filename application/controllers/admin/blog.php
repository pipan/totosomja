<?php
class Blog extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('file');
		$this->load->helper('text');
		$this->load->library('form_validation');
		$this->load->library('blog_parser');
		$this->load->model("admin_model");
		$this->load->model("blog_series_model");
		$this->load->model("blog_model");
		$this->load->model("blog_series_model");
		$this->load->model("tag_model");
		$this->load->model("blog_in_tag_model");
	}
	
	public function index(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			
			$data['title'] = "totosomja - blog";
			$data['blog'] = $this->blog_model->get(array('admin', 'series'));
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/blog/new_blog',
							'text' => 'new blog',
					),
			);
			
			$this->load->view("templates/header_manager", $data);
			if ($this->blog_model->is_empty()){
				$data['empty_table'] = "no blog";
				$data['empty_table_title'] = "Blog - list";
				$this->load->view("templates/empty_table", $data);
			}
			else{
				$this->load->view("manager/blog/index", $data);
			}
			$this->load->view("templates/right_body_blog", $data);
			$this->load->view("templates/footer", $data);
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function new_blog(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			
			$data['title'] = "totosomja - new blog";
			$data['series'] = $this->blog_series_model->get();
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/blog/new_blog',
							'text' => 'new blog',
					),
			);
			$data['blog_title'] = "Title";
			$data['blog_body'] = "Body";
		
			$this->load->view("templates/header_manager", $data);
			$this->load->view("manager/blog/new_blog", $data);
			$this->load->view("templates/right_body_blog_edit", $data);
			$this->load->view("templates/footer", $data);
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
			
			$data['title'] = "totosomja - edit blog";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/blog/new_blog',
							'text' => 'new blog',
					),
			);
			if ($this->blog_model->get(array(), $id) != false){
				$data['series'] = $this->blog_series_model->get();
				$data['blog'] = $this->blog_model->get(array(), $id);
				$data['series_id'] = 0;
				if ($data['blog']['series_id'] != null){
					$data['series_id'] = $data['blog']['series_id']; 
				}
				$data['thumbnail'] = 0;
				$data['blog_title'] = read_file("./content/blog/".$id."/titleTextarea.txt");
				$data['blog_body'] = read_file("./content/blog/".$id."/bodyTextarea.txt");
				$data['blog_link'] = Blog_parser::parse_link(read_file("./content/blog/".$id."/link.txt"));
				$data['blog_image'] = Blog_parser::parse_image(read_file("./content/blog/".$id."/image.txt"));
				$data['blog_video'] = Blog_parser::parse_video(read_file("./content/blog/".$id."/video.txt"));
				$data['blog_tag'] = $this->blog_in_tag_model->get_by_blog_id($id); 
				$data['blog_id'] = $id;
				
				$this->load->view("templates/header_manager", $data);
				$this->load->view("manager/blog/load_blog", $data);
				$this->load->view("manager/blog/new_blog", $data);
				$this->load->view("templates/right_body_blog_edit", $data);
				$this->load->view("templates/footer", $data);
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
	
	public function save_new_blog($edit_id = 0){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			
			if ($this->blog_model->get(array(), $edit_id) != false){
				$data['title'] = "totosomja - new blog";
				$data['functions'] = array(
						array(
								'link' => base_url().'index.php/admin/blog/new_blog',
								'text' => 'new blog',
						),
				);
				
				$this->form_validation->set_rules('title', 'title', 'required');
				$this->form_validation->set_rules('titleTextarea', 'textarea title', 'required');
				$this->form_validation->set_rules('body', 'body', 'required');
				$this->form_validation->set_rules('bodyTextarea', 'textarea body', 'required');
				$this->form_validation->set_rules('thumbnail', 'image thumbnail', 'required');
				
				if ($this->form_validation->run() === FALSE){
					$log = "ID: ".$edit_id.PHP_EOL;
					$log .= "TITLE: ".$this->input->post('title').PHP_EOL;
					$log .= "TITLE_TEXTAREA: ".$this->input->post('titleTextarea').PHP_EOL;
					$log .= "BODY: ".$this->input->post('body').PHP_EOL;
					$log .= "BODY_TEXTAREA: ".$this->input->post('bodyTextarea').PHP_EOL;
					$log .= "THUMBNAIL: ".$this->input->post('thumbnail').PHP_EOL;
					write_file("./content/blog/log/".date("Y-n-d-H-i-s").".txt", $log);
					//echo "fail";
				}
				else{
					$title = $this->input->post('titleTextarea');
					$thumbnail = null;
					$series = null;
					if ($this->input->post('link') != false){
						$i = 1;
						foreach ($this->input->post('link') as $link){
							$title = str_replace("[LINK-".$i."]", $link['text'], $title);
							$i++;
						}
					}
					if ($this->input->post('thumbnail') > 0 && $this->input->post('image') != false && sizeof($this->input->post('image')) >=  $this->input->post('thumbnail')){
						$thumbnail = $this->input->post('image')[$this->input->post('thumbnail') - 1]['link'];
					}
					if ($this->input->post('series') > 0){
						$series = $this->input->post('series');
					}
					
					
					$table_data = array(
							'admin_id' => $this->session->userdata('admin_id'),
							'title' => $title,
							'slug' => url_title(convert_accented_characters($title), '-', TRUE),
							'series_id' => $series,
							'post_date' => date("Y-n-d H:i:s"),
							'thumbnail' => $thumbnail,
					);
					
					if ($edit_id > 0){
						$id = $this->blog_model->save($table_data, $edit_id);
					}
					else{
						$id = $this->blog_model->save($table_data);
						mkdir("./content/blog/".$id, 0777);
					}
					write_file("./content/blog/".$id."/title.txt", $this->input->post('title'));
					write_file("./content/blog/".$id."/titleTextarea.txt", $this->input->post('titleTextarea'));
					write_file("./content/blog/".$id."/body.txt", $this->input->post('body'));
					write_file("./content/blog/".$id."/bodyTextarea.txt", $this->input->post('bodyTextarea'));
					if ($this->input->post('link') != false){
						$linkFileData = "";
						foreach ($this->input->post('link') as $link){
							$linkFileData .= "TEXT: ".$link['text'].PHP_EOL;
							$linkFileData .= "LINK: ".$link['link'].PHP_EOL;
						}
						write_file("./content/blog/".$id."/link.txt", $linkFileData, 'w+');
					}
					else{
						delete_files("./content/blog/".$id."/link.txt");
					}
					if ($this->input->post('image') != false){
						$imageFileData = "";
						foreach ($this->input->post('image') as $image){
							$imageFileData .= "TEXT: ".$image['text'].PHP_EOL;
							$imageFileData .= "LINK: ".$image['link'].PHP_EOL;
							$imageFileData .= "WIDTH: ".$image['width'].PHP_EOL;
							$imageFileData .= "ALIGNMENT: ".$image['alignment'].PHP_EOL;
						}
						write_file("./content/blog/".$id."/image.txt", $imageFileData);
					}
					else{
						delete_files("./content/blog/".$id."/image.txt");
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
						write_file("./content/blog/".$id."/video.txt", $videoFileData);
					}
					else{
						delete_files("./content/blog/".$id."/video.txt");
					}
					if ($edit_id > 0){
						$this->blog_in_tag_model->detach_tags($edit_id);
					}
					if ($this->input->post('tag') != false){
						foreach ($this->input->post('tag') as $tag){
							$table_data = array(
									'tag_name' => $tag['text'],
									'tag_slug' => url_title(convert_accented_characters($tag['text']), '-', TRUE),
							);
							$tag_id = $this->tag_model->save($table_data);
							$table_data = array(
									'blog_id' => $id,
									'tag_id' => $tag_id,
							);
							$this->blog_in_tag_model->save($table_data);
						}
					}
					mkdir("./content/blog/".$id."/comments", 0777);
					//echo "success";
				}
			}
			else{
				//echo "fail";
			}
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function error_save(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
			
			$data['title'] = "totosomja - blog error";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/blog/new_blog',
							'text' => 'new blog',
					),
			);
				
			$this->load->view("templates/header_manager", $data);
			$this->load->view("manager/blog/error_save", $data);
			$this->load->view("templates/right_body_blog", $data);
			$this->load->view("templates/footer", $data);
		}
		else{
			redirect("admin/manager/login");
		}
	}
}