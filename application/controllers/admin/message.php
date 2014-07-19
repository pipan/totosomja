<?php
class Message extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('file');
		$this->load->helper('text');
		$this->load->library('form_validation');
		$this->load->library('blog_parser');
		$this->load->model('admin_model');
		$this->load->model('customer_model');
		$this->load->model('poll_model');
		$this->load->model('message_model');
		$this->load->model('poll_answer_model');
		$this->load->model('poll_vote_model');
	}
	
	public function isset_poll(){
		if ($this->input->post('poll_question') != false && $this->input->post('poll') != false){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function index(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
				
			$data['title'] = "totosomja - message/poll";
			$data['message'] = $this->message_model->get(array('admin', 'poll'));
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/message/new_message',
							'text' => 'new message',
					),
			);
			
			if (!$this->message_model->is_empty()){
				$this->load->view("templates/header_manager", $data);
				$this->load->view("manager/message/index", $data);
				$this->load->view("manager/message/right_body", $data);
				$this->load->view("templates/footer", $data);
			}
			else{
				$data['empty_table'] = "no message";
				$data['empty_table_title'] = "Message - list";
				$this->load->view("templates/header_manager", $data);
				$this->load->view("templates/empty_table", $data);
				$this->load->view("manager/message/right_body", $data);
				$this->load->view("templates/footer", $data);
			}
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function new_message(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
		
			$data['title'] = "totosomja - message";
			
			$data['jscript'] = array('jscript_message_oop');
			$data['poll_question'] = "";
			$data['poll_question_en'] = "";
			$data['message_title'] = "Title";
			$data['message_body'] = "Body";
				
			$this->load->view("templates/header_manager", $data);
			$this->load->view("manager/message/new_message", $data);
			$this->load->view("manager/message/right_body_message_edit", $data);
			$this->load->view("templates/footer", $data);
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function edit($id, $edit_lang = "sk"){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
	
			$data['title'] = "totosomja - edit message";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/message/new_message',
							'text' => 'new message',
					),
			);
			if ($this->message_model->get(array('poll'), $id) != false){
				$edit_lang = valid_language($edit_lang);
				$edit_lang_id = $this->language_model->get_by_name($edit_lang);
				$lang_ext = get_language_ext($edit_lang);
				$data['poll_question'] = "";
				$data['poll_question_en'] = "";
				$data['jscript'] = array('jscript_message_oop');
				$data['message'] = $this->message_model->get(array('poll'), $id);
				if ($data['message']['poll_id'] != null){
					$data['message_poll_answer'] = $this->poll_answer_model->get_by_poll_id($data['message']['poll_id']);
					$data['poll_question'] = $data['message']['question'];
					$data['poll_question_en'] = $data['message']['question_en'];
				}
				if (file_exists("./content/message/".$id."/titleTextarea".$lang_ext.".txt")){
					$data['message_title'] = read_file("./content/message/".$id."/titleTextarea".$lang_ext.".txt");
				}
				else{
					$data['message_title'] = read_file("./content/message/".$id."/titleTextarea.txt");
				}
				if (file_exists("./content/message/".$id."/bodyTextarea".$lang_ext.".txt")){
					$data['message_body'] = read_file("./content/message/".$id."/bodyTextarea".$lang_ext.".txt");
				}
				else{
					$data['message_body'] = read_file("./content/message/".$id."/bodyTextarea.txt");
				}
				if (file_exists("./content/message/".$id."/link".$lang_ext.".txt")){
					$data['message_link'] = Blog_parser::parse_link(read_file("./content/message/".$id."/link".$lang_ext.".txt"));
				}
				else{
					$data['message_link'] = Blog_parser::parse_link(read_file("./content/message/".$id."/link.txt"));
				}
				$data['message_lang'] = $edit_lang;
	
				$this->load->view("templates/header_manager", $data);
				$this->load->view("manager/message/load_message", $data);
				$this->load->view("manager/message/new_message", $data);
				$this->load->view("manager/message/right_body_message_edit", $data);
				$this->load->view("templates/footer", $data);
			}
			else{
				$this->load->view("templates/header_manager", $data);
				$this->load->view("templates/wrong_id", $data);
				$this->load->view("manager/message/right_body_message", $data);
				$this->load->view("templates/footer", $data);
			}
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function save_new_message($edit_id = false, $edit_lang = "sk"){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
				
			if ($edit_id == false || $this->message_model->exists($edit_id) == true){
				$edit_lang = valid_language($edit_lang);
				$lang_ext = get_language_ext($edit_lang);
				$data['title'] = "totosomja - new message";
				$data['functions'] = array(
						array(
								'link' => base_url().'index.php/admin/message/new_message',
								'text' => 'new blog',
						),
				);
	
				$this->form_validation->set_rules('title', 'title', 'required');
				$this->form_validation->set_rules('titleTextarea', 'textarea title', 'required');
				$this->form_validation->set_rules('body', 'body', 'required');
				$this->form_validation->set_rules('bodyTextarea', 'textarea body', 'required');
	
				if ($this->form_validation->run() === FALSE && $this->isset_poll() == false){
					$log = "ID: ".$edit_id.PHP_EOL;
					$log .= "TITLE: ".$this->input->post('title').PHP_EOL;
					$log .= "TITLE_TEXTAREA: ".$this->input->post('titleTextarea').PHP_EOL;
					$log .= "BODY: ".$this->input->post('body').PHP_EOL;
					$log .= "BODY_TEXTAREA: ".$this->input->post('bodyTextarea').PHP_EOL;
					$log .= "LANG: ".$edit_lang.PHP_EOL;
					write_file("./content/message/log/".date("Y-n-d-H-i-s").".txt", $log);
					//echo "fail";
				}
				else{
					$post_date = date("Y-n-d H:i:s");
					if ($this->form_validation->run() === FALSE){
						$title = null;
					}
					else{
						$title = $this->input->post('titleTextarea');
						if ($this->input->post('link') != false){
							$i = 1;
							foreach ($this->input->post('link') as $link){
								$title = str_replace("[LINK-".$i."]", $link['text'], $title);
								$i++;
							}
						}
					}
					
					$poll_id_table = null;
					if ($this->isset_poll()){
						$poll_id = false;
						if ($edit_id != false){
							$poll_id = $this->message_model->get(array(), $edit_id)['poll_id'];
							if ($poll_id != null){
								echo $poll_id['poll_id'];
								$this->poll_answer_model->delete_by_poll_id($poll_id);
							}
						}
						
						$table_data = array(
								'admin_id' => $this->session->userdata('admin_id'),
								'question' => $this->input->post('poll_question'),
								'question_en' => $this->input->post('poll_question_en'),
						);
						if ($edit_id == false){
							$table_data['post_date'] = $post_date;
						}
						$poll_id = $this->poll_model->save($table_data, $poll_id);
						$poll_id_table = $poll_id;
						foreach ($this->input->post('poll') as $answer){
							$table_data = array(
									'poll_id' => $poll_id,
									'answer' => $answer['answer'],
									'answer_en' => $answer['answer_en'],
							);
							$this->poll_answer_model->save($table_data);
						}
						
					}
						
					
					$table_data = array(
							'admin_id' => $this->session->userdata('admin_id'),
							'message_name'.$lang_ext => $title,
							'poll_id' => $poll_id_table,
							'post_date' => $post_date,
					);
						
					$id = $this->message_model->save($table_data, $edit_id);
					if ($edit_id == false){
						mkdir("./content/message/".$id, 0777);
					}
					write_file("./content/message/".$id."/title".$lang_ext.".txt", $this->input->post('title'));
					write_file("./content/message/".$id."/titleTextarea".$lang_ext.".txt", $this->input->post('titleTextarea'));
					write_file("./content/message/".$id."/body".$lang_ext.".txt", $this->input->post('body'));
					write_file("./content/message/".$id."/bodyTextarea".$lang_ext.".txt", $this->input->post('bodyTextarea'));
					if ($this->input->post('link') != false){
						$linkFileData = "";
						foreach ($this->input->post('link') as $link){
							$linkFileData .= "TEXT: ".$link['text'].PHP_EOL;
							$linkFileData .= "LINK: ".$link['link'].PHP_EOL;
						}
						write_file("./content/message/".$id."/link".$lang_ext.".txt", $linkFileData, 'w+');
					}
					else{
						delete_files("./content/message/".$id."/link".$lang_ext.".txt");
					}
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
			
			$data['title'] = "totosomja - message error";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/message/new_message',
							'text' => 'new message',
					),
			);
	
			$this->load->view("templates/header_manager", $data);
			$this->load->view("manager/message/error_save", $data);
			$this->load->view("manager/message/right_body", $data);
			$this->load->view("templates/footer", $data);
		}
		else{
			redirect("admin/manager/login");
		}
	}
}