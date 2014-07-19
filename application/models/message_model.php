<?php
class Message_model extends CI_Model{
	
	public $relation;
	public static $select = array('message.admin_id', 'message.message_name', 'message.message_name_en', 'message.poll_id', 'message.post_date');
	public static $select_id = array('message.id', 'message.admin_id', 'message.message_name', 'message.message_name_en', 'message.poll_id', 'message.post_date');
	
	public function __construct(){
		parent::__construct();
		$this->relation = array(
				'admin' => array(
						'join' => 'admin',
						'on' => 'message.admin_id=admin.id',
						'type' => 'inner',
						'select' => Admin_model::$select,
				),
				'poll' => array(
						'join' => 'poll',
						'on' => 'message.poll_id=poll.id',
						'type' => 'left',
						'select' => Poll_model::$select,
				),
		);
	}
	
	public function is_empty(){
		$this->db->select('id');
		$this->db->from('message');
		$this->db->limit(1, 0);
		return (!$this->db->count_all_results() > 0);
	}
	
	public function exists($id){
		$this->db->select('id');
		$this->db->from('message');
		$this->db->where('id', $id);
		return ($this->db->count_all_results() > 0);
	}
	
	public function join($join, $select = false){
		if ($select == false){
			$select = Message_model::$select_id;
		}
		foreach ($join as $j){
			$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], $this->relation[$j]['type']);
			$select = array_merge($select, $this->relation[$j]['select']);
		}
		return $select;
	}
	
	public function get($join = array(), $id = false){
		$this->db->select($this->join($join, Message_model::$select_id));
		if ($id == false){
			$query = $this->db->get('message');
			return $query->result_array();
		}
		else{
			$query = $this->db->get_where('message', array('message.id =' => $id));
			return $query->row_array();
		}
	}
	
	public function get_last(){
		$join = array('poll');
		$this->db->select($this->join($join, Message_model::$select_id));
		$this->db->order_by('message.id DESC');
		$this->db->limit(1, 0);
		$query = $this->db->get('message');
		return $query->row_array();
	}
	
	/**
	 * @param integet $limit_from - od ktoreo zaznamu treba vytvarat dopyt
	 * @param integer $limit - aky je maximalny pocet (limit) v zazname
	 * @return array - pole zaznamov, maximalny pocet je $limit
	 */
	public function get_list($limit_from, $limit){
		$this->db->select($this->join(array('admin', 'poll'), Message_model::$select_id));
		$query = $this->db->get('message', $limit, $limit_from);
		return $query->result_array();
	}
	
	public function count_all(){
		return $this->db->count_all('message');
	}
	
	public function save($data, $id = false){
		if ($id == false){
			$this->db->insert('message', $data);
			$ret = $this->db->insert_id();
		}
		else{
			$this->db->where(array('id =' => $id));
			$this->db->update('message', $data);
			$ret = $id;
		}
		return $ret;
	}
}