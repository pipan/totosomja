<?php
class Firm_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('firm');
		$this->select = array('firm.email', 'firm.firm_name', 'firm.address_id', 'firm.ico');
		$this->select_id = array('firm.id', 'firm.email', 'firm.firm_name', 'firm.address_id', 'firm.ico');
		$this->relation = array(
				'address' => array(
						'join' => 'address',
						'on' => 'firm.address_id=address.id',
						'type' => 'inner',
						'select' => Address_model::$select,
				),
		);
	}
	
	public static function get_select(){
		return array('firm.email', 'firm.firm_name', 'firm.address_id', 'firm.ico');
	}
	public static function get_select_id(){
		return array('firm.id', 'firm.email', 'firm.firm_name', 'firm.address_id', 'firm.ico');
	}
	
	public function get_last($join = array()){
		$this->db->select($this->join($join, $this->select_id));
		$this->db->order_by('id DESC');
		$query = $this->db->get($this->table, 1, 0);
		return $query->row_array();
	}
	
	public function save($data){
		$last = $this->get_last();
		$ret = "";
		if ($last != false){
			$ret = $last['id'];
		}
		if ($ret == "" || !$this->data_match($last_id, $data)){
			$this->db->insert($this->table, $data);
			$ret = $this->db->insert_id();
		}
		return $ret;
	}
}