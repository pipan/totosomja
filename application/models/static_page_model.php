<?php
class Static_page_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('static_page');
		$this->select = array('static_page.folder', 'static_page.post_date', 'static_page.page_title', 'static_page.page_title_en', 'static_page.page_slug', 'static_page.page_slug_en');
		$this->select_id = array('static_page.id', 'static_page.folder', 'static_page.post_date', 'static_page.page_title', 'static_page.page_title_en', 'static_page.page_slug', 'static_page.page_slug_en');
	}
	
	public static function get_select(){
		return array('static_page.folder', 'static_page.post_date', 'static_page.page_title', 'static_page.page_title_en', 'static_page.page_slug', 'static_page.page_slug_en');
	}
	public static function get_select_id(){
		return array('static_page.id', 'static_page.folder', 'static_page.post_date', 'static_page.page_title', 'static_page.page_title_en', 'static_page.page_slug', 'static_page.page_slug_en');
	}
	
	public function exists_by_slug($slug, $ext){
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->where('page_slug'.$ext, $slug);
		return ($this->db->count_all_results() > 0);
	}
	
	public function exists_by_folder($folder){
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->where('folder', $folder);
		return ($this->db->count_all_results() > 0);
	}
	
	public function get_by_slug($slug, $ext, $join = array()){
		$this->db->select($this->join($join, $this->select_id));
		$query = $this->db->get_where($this->table, array('page_slug'.$ext => $slug));
		return $query->row_array();
	}
}