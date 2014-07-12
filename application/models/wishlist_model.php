<?php
class Wishlist_model extends CI_Model{
	
	public $relation;
	public static $select = array('wishlist.product_id' ,'wishlist.customer_id', 'wishlist.wish_date');
	public static $select_id = array('wishlist.id', 'wishlist.product_id' ,'wishlist.customer_id', 'wishlist.wish_date');
	
	public function __construct(){
		parent::__construct();
		$this->relation = array(
				'product' => array(
						'join' => 'product',
						'on' => 'wishlist.product_id=product.id',
						'type' => 'inner',
						'select' => Product_model::$select,
				),
				'customer' => array(
						'join' => 'customer',
						'on' => 'wishlist.customer_id=customer.id',
						'type' => 'inner',
						'select' => Customer_model::$select,
				),
		);
	}
	
	public function is_empty(){
		$this->db->select('id');
		$this->db->from('wishlist');
		$this->db->limit(1, 0);
		return (!$this->db->count_all_results() == 1);
	}
	
	public function is_customer_wishing($customer_id, $product_id){
		$this->db->select('id');
		$this->db->from('wishlist');
		$this->db->where(array('customer_id' => $customer_id, 'product_id' => $product_id));
		return ($this->db->count_all_results() > 0);
	}
	
	public function get($join = array(), $id = false){
		$select = Wishlist_model::$select_id;
		foreach ($join as $j){
			$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], $this->relation[$j]['type']);
			$select = array_merge($this->relation[$j]['select'], $select);
		}
		$this->db->select($select);
		if ($id == false){
			$query = $this->db->get('wishlist');
			return $query->result_array();
		}
		else{
			$query = $this->db->get_where('wishlist', array('id =' => $id));
			return $query->row_array();
		}
	}
	
	public function get_by_customer_id($customer_id){
		$select = Wishlist_model::$select_id;
		$join = array('product');
		foreach ($join as $j){
			$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], $this->relation[$j]['type']);
			$select = array_merge($this->relation[$j]['select'], $select);
		}
		$this->db->select($select);
		$query = $this->db->get_where('wishlist', array('customer_id =' => $customer_id));
		return $query->result_array();
	}
	
	public function save($data){
		$this->db->insert('wishlist', $data);
		$ret = $this->db->insert_id();
		return $ret;
	}
	
	public function remove_wish($customer_id, $product_id){
		$this->db->delete('wishlist', array('customer_id' => $customer_id, 'product_id' => $product_id));
	}
}