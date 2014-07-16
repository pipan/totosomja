<?php
class Poll_vote_model extends CI_Model{
	
	public $relation;
	public static $select = array('poll_vote.customer_id', 'poll_vote.poll_answer_id', 'poll_vote.vote_date');
	public static $select_id = array('poll_vote.id', 'poll_vote.customer_id', 'poll_vote.poll_answer_id', 'poll_vote.vote_date');
	
	public function __construct(){
		parent::__construct();
		$this->relation = array(
				'customer' => array(
						'join' => 'customer',
						'on' => 'poll_vote.customer_id=customer.id',
						'type' => 'inner',
						'select' => Customer_model::$select,
				),
				'answer' => array(
						'join' => 'answer',
						'on' => 'poll_vote.poll_answer_id=poll_answer.id',
						'type' => 'inner',
						'select' => Poll_answer_model::$select,
				),
		);
	}
	
	public function is_empty(){
		$this->db->select('id');
		$this->db->from('poll_vote');
		$this->db->limit(1, 0);
		return (!$this->db->count_all_results() > 0);
	}
	
	public function exists($id){
		$this->db->select('id');
		$this->db->from('poll_vote');
		$this->db->where('id', $id);
		return ($this->db->count_all_results() > 0);
	}
	
	public function can_vote($customer_id, $poll_id){
		$sql = "SELECT poll_vote.id FROM poll_vote
				INNER JOIN poll_answer ON poll_vote.poll_answer_id=poll_answer.id
				WHERE poll_vote.customer_id=".$customer_id." AND poll_answer.id IN (SELECT id from poll_answer WHERE poll_answer.poll_id=".$poll_id.")";
		$query = $this->db->query($sql);
		return (sizeof($query->result_array()) == 0);
	}
	
	public function join($join, $select = false){
		if ($select == false){
			$select = Poll_vote_model::$select_id;
		}
		foreach ($join as $j){
			$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], $this->relation[$j]['type']);
			$select = array_merge($select, $this->relation[$j]['select']);
		}
		return $select;
	}
	
	public function get($join = array(), $id = false){
		$this->db->select($this->join($join, Poll_vote_model::$select_id));
		if ($id == false){
			$query = $this->db->get('poll_vote');
			return $query->result_array();
		}
		else{
			$query = $this->db->get_where('poll_vote', array('id =' => $id));
			return $query->row_array();
		}
	}
	
	public function get_vote($poll_id){
		$sql = "SELECT COUNT(poll_vote.id) as vote, poll_answer.answer, poll_answer.id FROM poll_vote
				RIGHT JOIN poll_answer ON poll_vote.poll_answer_id=poll_answer.id
				WHERE poll_answer.id IN (SELECT id from poll_answer WHERE poll_answer.poll_id=".$poll_id.")
				GROUP BY poll_answer.id ORDER BY poll_answer.id ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	/*
	public function get_vote($answer_ids){
		$this->db->select('COUNT(*) as vote');
		$this->db->from('poll_vote');
		$this->db->where_in('poll_answer_id', $answer_ids);
		$this->db->group_by('poll_answer_id');
		$this->db->order_by('poll_answer_id ASC');
	}
	*/
	
	public function count_all(){
		return $this->db->count_all('poll_vote');
	}
	
	public function save($data){
		$this->db->insert('poll_vote', $data);
		$ret = $this->db->insert_id();
		return $ret;
	}
}