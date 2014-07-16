<?php
class Poll_answer_model extends CI_Model{
	
	public $relation;
	public static $select = array('poll_answer.poll_id', 'poll_answer.answer');
	public static $select_id = array('poll_answer.id', 'poll_answer.poll_id', 'poll_answer.answer');
	
	public function __construct(){
		parent::__construct();
		$this->relation = array(
				'poll' => array(
						'join' => 'poll',
						'on' => 'poll_answer.poll_id=poll.id',
						'type' => 'inner',
						'select' => Poll_model::$select,
				),
		);
	}
	
	public function is_empty(){
		$this->db->select('id');
		$this->db->from('poll_answer');
		$this->db->limit(1, 0);
		return (!$this->db->count_all_results() > 0);
	}
	
	public function exists($id){
		$this->db->select('id');
		$this->db->from('poll_answer');
		$this->db->where('id', $id);
		return ($this->db->count_all_results() > 0);
	}
	
	public function join($join, $select = false){
		if ($select == false){
			$select = Poll_answer_model::$select_id;
		}
		foreach ($join as $j){
			$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], $this->relation[$j]['type']);
			$select = array_merge($select, $this->relation[$j]['select']);
		}
		return $select;
	}
	
	public function get($join = array(), $id = false){
		$this->db->select($this->join($join, Poll_answer_model::$select_id));
		if ($id == false){
			$query = $this->db->get('poll_answer');
			return $query->result_array();
		}
		else{
			$query = $this->db->get_where('poll_answer', array('id =' => $id));
			return $query->row_array();
		}
	}
	
	public function get_by_poll_id($poll_id){
		$this->db->select(Poll_answer_model::$select_id);
		$this->db->where('poll_id', $poll_id);
		$query = $this->db->get('poll_answer');
		return $query->result_array();
	}
	
	public function count_all(){
		return $this->db->count_all('poll_answer');
	}
	
	public function save($data, $id = false){
		if ($id == false){
			$this->db->insert('poll_answer', $data);
			$ret = $this->db->insert_id();
		}
		else{
			$this->db->where(array('id =' => $id));
			$this->db->update('poll_answer', $data);
			$ret = $id;
		}
		return $ret;
	}
	
	public function delete_by_poll_id($poll_id){
		$this->db->delete('poll_answer', array('poll_id' => $poll_id));
	}
}