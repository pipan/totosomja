<?php
class Blog_series_model extends CI_Model{
	
	public $relation;
	public static $select = array('blog_series.admin_id', 'blog_series.series_name');
	public static $select_id = array('blog_series.id', 'blog_series.admin_id', 'blog_series.series_name');
	
	public function __construct(){
		parent::__construct();
	}
	
	public function is_empty(){
		$this->db->select('id');
		$this->db->from('blog_series');
		$this->db->limit(1, 0);
		return (!$this->db->count_all_results() == 1);
	}
	
	public function get($id = false){
		if ($id == false){
			$query = $this->db->get('blog_series');
			return $query->result_array();
		}
		else{
			$query = $this->db->get_where('blog_series', array('id =' => $id));
			return $query->row_array();
		}
	}
	
	public function can_edit($id, $admin_id){
		$series = $this->get($id);
		return ($series['admin_id'] == $admin_id);
	}
	
	public function save($data, $id = false){
		if ($id == false){
			$this->db->insert('blog_series', $data);
			$ret = $this->db->insert_id();
		}
		else{
			$this->db->where(array('id =' => $id));
			$this->db->update('blog_series', $data);
			$ret = $id;
		}
		return $ret;
	}
}