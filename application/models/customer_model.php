<?php
class Customer_model extends CI_Model{
	
	public $relation;
	public static $login_field = array('customer.id', 'customer.salt', 'customer.password', 'customer.email', 'customer.customer_nickname');
	public static $select = array('customer.email', 'customer.customer_nickname', 'customer.customer_name', 'customer.customer_surname', 'customer.customer_gender', 'customer.customer_birthday', 'customer.address_id', 'DAY(customer.customer_birthday) as day', 'MONTH(customer.customer_birthday) as month', 'YEAR(customer.customer_birthday) as year');
	public static $select_id = array('customer.id', 'customer.email', 'customer.customer_nickname', 'customer.customer_name', 'customer.customer_surname', 'customer.customer_gender', 'customer.customer_birthday', 'customer.address_id', 'DAY(customer.customer_birthday) as day', 'MONTH(customer.customer_birthday) as month', 'YEAR(customer.customer_birthday) as year');
	
	public function __construct(){
		parent::__construct();
		$this->relation = array(
				'address' => array(
						'join' => 'address',
						'on' => 'customer.address_id=address.id',
						'type' => 'inner',
						'select' => Address_model::$select,
				),
		);
	}
	
	public function is_empty(){
		$this->db->select('id');
		$this->db->from('customer');
		$this->db->limit(1, 0);
		return (!$this->db->count_all_results() > 0);
	}
	
	public function join($join, $select = false){
		if ($select == false){
			$select = Customer_model::$select_id;
		}
		foreach ($join as $j){
			$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], $this->relation[$j]['type']);
			$select = array_merge($select, $this->relation[$j]['select']);
		}
		return $select;
	}
	
	public function get($join = array(), $id = false){
		$this->db->select($this->join($join, Customer_model::$select_id));
		if ($id == false){
			$query = $this->db->get('customer');
			return $query->result_array();
		}
		else{
			$query = $this->db->get_where('customer', array('customer.id =' => $id));
			return $query->row_array();
		}
	}
	
	public function login_by_nickname($nickname){
		$this->db->select(Customer_model::$login_field);
		$this->db->where(array('customer_nickname =' => $nickname));
		$query = $this->db->get('customer');
		return $query->row_array();
	}
	public function login_by_id($id){
		$this->db->select(Customer_model::$login_field);
		$this->db->where(array('id =' => $id));
		$query = $this->db->get('customer');
		return $query->row_array();
	}
	
	public function count_all(){
		return $this->db->count_all('customer');
	}
	
	public function save($data, $id = false){
		if ($id == false){
			$this->db->insert('customer', $data);
			$ret = $this->db->insert_id();
		}
		else{
			$this->db->where(array('id =' => $id));
			$this->db->update('customer', $data);
			$ret = $id;
		}
		return $ret;
	}
}