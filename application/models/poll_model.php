<?php
class Poll_model extends CI_Model{
	
	public $relation;
	public static $select = array('poll.admin_id', 'poll.question', 'poll.poll_post_date');
	public static $select_id = array('poll.id', 'poll.admin_id', 'poll.question', 'poll.poll_post_date');
	
	public function __construct(){
		parent::__construct();
		$this->relation = array(
				'admin' => array(
						'join' => 'admin',
						'on' => 'poll.admin_id=admin.id',
						'type' => 'inner',
						'select' => Admin_model::$select,
				),
		);
	}
	
	public function is_empty(){
		$this->db->select('id');
		$this->db->from('poll');
		$this->db->limit(1, 0);
		return (!$this->db->count_all_results() > 0);
	}
	
	public function exists($id){
		$this->db->select('id');
		$this->db->from('poll');
		$this->db->where('id', $id);
		return ($this->db->count_all_results() > 0);
	}
	
	public function join($join, $select = false){
		if ($select == false){
			$select = Poll_model::$select_id;
		}
		foreach ($join as $j){
			$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], $this->relation[$j]['type']);
			$select = array_merge($select, $this->relation[$j]['select']);
		}
		return $select;
	}
	
	public function get($join = array(), $id = false){
		$this->db->select($this->join($join, Poll_model::$select_id));
		if ($id == false){
			$query = $this->db->get('poll');
			return $query->result_array();
		}
		else{
			$query = $this->db->get_where('poll', array('id =' => $id));
			return $query->row_array();
		}
	}
	
	public function count_all(){
		return $this->db->count_all('poll');
	}
	
	public function save($data, $id = false){
		if ($id == false){
			$this->db->insert('poll', $data);
			$ret = $this->db->insert_id();
		}
		else{
			$this->db->where(array('id =' => $id));
			$this->db->update('poll', $data);
			$ret = $id;
		}
		return $ret;
	}
}