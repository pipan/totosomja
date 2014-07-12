<?php
class Comment_blog_model extends CI_Model{
	
	public $relation;
	public static $select = array('comment_blog.blog_id', 'comment_blog.customer_id', 'comment_blog.post_date', 'comment_blog.value');
	public static $select_id = array('comment_blog.id', 'comment_blog.blog_id', 'comment_blog.customer_id', 'comment_blog.post_date', 'comment_blog.value');
	
	public function __construct(){
		parent::__construct();
		$this->relation = array(
				'blog' => array(
						'join' => 'blog',
						'on' => 'comment_blog.blog_id=blog.id',
						'type' => 'inner',
						'select' => Blog_model::$select,
				),
				'customer' => array(
						'join' => 'customer',
						'on' => 'comment_blog.customer_id=customer.id',
						'type' => 'left',
						'select' => Customer_model::$select,
				),
		);
	}
	
	public function is_empty(){
		$this->db->select('id');
		$this->db->from('comment_blog');
		$this->db->limit(1, 0);
		return (!$this->db->count_all_results() > 0);
	}
	
	public function exists($id){
		$this->db->select('id');
		$this->db->from('comment_blog');
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
		$this->db->select($this->join($join, Comment_blog_model::$select_id));
		if ($id == false){
			$query = $this->db->get('comment_blog');
			return $query->result_array();
		}
		else{
			$query = $this->db->get_where('comment_blog', array('id =' => $id));
			return $query->row_array();
		}
	}
	
	public function get_by_blog_id($blog_id){
		$this->db->select($this->join(array('customer'), Comment_blog_model::$select_id));
		$this->db->where(array('blog_id' => $blog_id));
		$query = $this->db->get('comment_blog');
		return $query->result_array();
	}
	
	public function save($data){
		$this->db->insert('comment_blog', $data);
		$ret = $this->db->insert_id();
		return $ret;
	}
}