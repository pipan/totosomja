<?php
class Tag_model extends CI_Model{
	
	public $relation;
	public static $select = array('tag.tag_name', 'tag.tag_slug');
	public static $select_id = array('tag.id' ,'tag.tag_name', 'tag.tag_slug');
	
	public function __construct(){
		parent::__construct();
	}
	
	public function is_empty(){
		$this->db->select('id');
		$this->db->from('tag');
		$this->db->limit(1, 0);
		return (!$this->db->count_all_results() == 1);
	}
	
	public function get($join = array(), $id = false){
		foreach ($join as $j){
			$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], 'inner');
		}
		if ($id == false){
			$query = $this->db->get('blog');
			return $query->result_array();
		}
		else{
			$query = $this->db->get_where('tag', array('id =' => $id));
			return $query->row_array();
		}
	}
	
	public function get_by_name($name){
		$query = $this->db->get_where('tag', array('tag_name =' => $name));
		return $query->row_array();
	}
	
	public function save($data, $id = false){
		if ($id == false){
			if (($ret = $this->get_by_name($data['tag_name'])) == false){
				$this->db->insert('tag', $data);
				$ret = $this->db->insert_id();
			}
			else{
				$ret = $ret['id'];
			}
		}
		else{
			$this->db->where(array('id =' => $id));
			$this->db->update('tag', $data);
			$ret = $id;
		}
		return $ret;
	}
}