<?php
class Language_model extends CI_Model{
	
	public $relation;
	public static $select = array('language.language_name');
	public static $select_id = array('language.id', 'language.language_name');
	
	public function __construct(){
		parent::__construct();
	}
	
	public function is_id($id){
		if (sizeof($this->get($id)) > 0){
			return true;
		}
		return false;
	}
	
	public function is_empty(){
		$this->db->select('id');
		$this->db->from('language');
		$this->db->limit(1, 0);
		return (!$this->db->count_all_results() > 0);
	}
	
	public function get($id = false){
		if ($id == false){
			$query = $this->db->get($this->table);
			return $query->result_array();
		}
		else{
			$query = $this->db->get_where('language', array('id =' => $id));
			return $query->row_array();
		}
	}
	
	public function get_by_name($name){
		$query = $this->db->get_where('language', array('language_name =' => $name));
		return $query->row_array();
	}
}