<?php
class Comment_model extends CI_Model{
	
	public $relation;
	public static $select = array('comment.product_id', 'comment.customer_id', 'comment.post_date', 'comment.value');
	public static $select_id = array('comment.id', 'comment.product_id', 'comment.customer_id', 'comment.post_date', 'comment.value');
	
	public function __construct(){
		parent::__construct();
		$this->relation = array(
				'product' => array(
						'join' => 'product',
						'on' => 'comment.product_id=product.id',
						'type' => 'inner',
						'select' => Product_model::$select,
				),
				'customer' => array(
						'join' => 'customer',
						'on' => 'comment.customer_id=customer.id',
						'type' => 'left',
						'select' => Customer_model::$select,
				),
		);
	}
	
	public function is_empty(){
		$this->db->select('id');
		$this->db->from('comment');
		$this->db->limit(1, 0);
		return (!$this->db->count_all_results() > 0);
	}
	
	public function exists($id){
		$this->db->select('id');
		$this->db->from('comment');
		$this->db->where('id', $id);
		return (!$this->db->count_all_results() > 0);
	}
	
	public function join($join, $select = false){
		if ($select == false){
			$select = Comment_blog_model::$select_id;
		}
		foreach ($join as $j){
			$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], $this->relation[$j]['type']);
			$select = array_merge($select, $this->relation[$j]['select']);
		}
		return $select;
	}
	
	public function get($join = array(), $id = false){
		$this->db->select($this->join($join, Comment_model::$select_id));
		if ($id == false){
			$query = $this->db->get('comment');
			return $query->result_array();
		}
		else{
			$query = $this->db->get_where('comment', array('id =' => $id));
			return $query->row_array();
		}
	}
	
	public function get_by_product_id($product_id){
		$this->db->select($this->join(array('customer'), Comment_model::$select_id));
		$this->db->where(array('product_id' => $product_id));
		$query = $this->db->get('comment');
		return $query->result_array();
	}
	
	public function save($data){
		$this->db->insert('comment', $data);
		$ret = $this->db->insert_id();
		return $ret;
	}
}