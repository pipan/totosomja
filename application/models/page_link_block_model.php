<?php
class Page_link_block_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('page_link_block');
		$this->select = array('page_link_block.block');
		$this->select_id = array('page_link_block.id', 'page_link_block.block');
	}
	
	public static function get_select(){
		return array('page_link_block.block');
	}
	public static function get_select_id(){
		return array('page_link_block.id', 'page_link_block.block');
	}
	
	public function get_by_name($name, $join = array()){
		$this->db->select($this->join($join, $this->select_id));
		$query = $this->db->get_where($this->table, array($this->table.'.block =' => $name));
		return $query->row_array();
	}
}