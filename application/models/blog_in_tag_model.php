<?php
class Blog_in_tag_model extends CI_Model{
	
	public $relation;
	public static $select = array('blog_in_tag.blog_id' ,'blog_in_tag.tag_id');
	public static $select_id = array('blog_in_tag.id' ,'blog_in_tag.blog_id' ,'blog_in_tag.tag_id');
	
	public function __construct(){
		parent::__construct();
		$this->relation = array(
				'tag' => array(
						'join' => 'tag',
						'on' => 'blog_in_tag.tag_id=tag.id',
						'type' => 'inner',
						'select' => Tag_model::$select,
				),
				'blog' => array(
						'join' => 'blog',
						'on' => 'blog_in_tag.blog_id=blog.id',
						'type' => 'inner',
						'select' => Blog_model::$select,
				),
		);
	}
	
	public function is_empty(){
		$this->db->select('id');
		$this->db->from('blog_in_tag');
		$this->db->limit(1, 0);
		return (!$this->db->count_all_results() == 1);
	}
	
	public function get($join = array(), $id = false){
		$select = Blog_in_tag_model::$select_id;
		foreach ($join as $j){
			$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], $this->relation[$j]['type']);
			$select = array_merge($this->relation[$j]['select'], $select);
		}
		$this->db->select($select);
		if ($id == false){
			$query = $this->db->get('blog_in_tag');
			return $query->result_array();
		}
		else{
			$query = $this->db->get_where('blog_in_tag', array('id =' => $id));
			return $query->row_array();
		}
	}
	
	public function get_by_blog_id($blog_id){
		$select = array('tag.id');
		$join = array('tag');
		foreach ($join as $j){
			$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], $this->relation[$j]['type']);
			$select = array_merge($this->relation[$j]['select'], $select);
		}
		$this->db->select($select);
		$query = $this->db->get_where('blog_in_tag', array('blog_id =' => $blog_id));
		return $query->result_array();
	}
	
	public function get_list_by_tag_slug($tag, $limit_from, $limit){
		$select = Blog_in_tag_model::$select;
		$join = array('tag', 'blog');
		foreach ($join as $j){
			$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], $this->relation[$j]['type']);
			$select = array_merge($this->relation[$j]['select'], $select);
		}
		$this->db->select($select);
		$this->db->where(array('tag_slug =' => $tag));
		$query = $this->db->get('blog_in_tag', $limit, $limit_from);
		return $query->result_array();
	}
	
	public function count_all_by_tag_slug($tag){
		$select = Blog_in_tag_model::$select;
		$join = array('tag');
		foreach ($join as $j){
			$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], $this->relation[$j]['type']);
			$select = array_merge($this->relation[$j]['select'], $select);
		}
		$this->db->select($select);
		$this->db->where(array('tag_slug =' => $tag));
		return $this->db->count_all_results('blog_in_tag');
	}
	
	public function save($data, $id = false){
		if ($id == false){
			$this->db->insert('blog_in_tag', $data);
			$ret = $this->db->insert_id();
		}
		else{
			$this->db->where(array('id =' => $id));
			$this->db->update('blog_in_tag', $data);
			$ret = $id;
		}
		return $ret;
	}
	
	public function detach_tags($blog_id){
		$this->db->delete('blog_in_tag', array('blog_id' => $blog_id));
	}
}