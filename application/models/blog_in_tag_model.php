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
	
	public function exists_by_data($data){
		$this->db->select('id');
		$this->db->from('blog_in_tag');
		$this->db->where(array('blog_id =' => $data['blog_id'], 'tag_id =' => $data['tag_id']));
		return ($this->db->count_all_results() > 0);
	}
	
	public function join($join, $select = false){
		if ($select == false){
			$select = Blog_in_tag_model::$select_id;
		}
		foreach ($join as $j){
			$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], $this->relation[$j]['type']);
			$select = array_merge($select, $this->relation[$j]['select']);
		}
		return $select;
	}
	
	public function get($join = array(), $id = false){
		$this->db->select($this->join($join, Blog_in_tag_model::$select_id));
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
		$this->db->select($this->join($join, $select));
		$query = $this->db->get_where('blog_in_tag', array('blog_id =' => $blog_id));
		return $query->result_array();
	}
	
	public function get_by_data($data){
		$select = array('tag.id');
		$join = array('tag');
		$this->db->select($this->join($join, $select));
		$query = $this->db->get_where('blog_in_tag', array('blog_in_tag.blog_id =' => $data['blog_id'], 'tag.language_id =' => $data['language_id']));
		return $query->result_array();
	}
	
	public function get_list_by_data($data, $limit_from, $limit){
		$select = Blog_in_tag_model::$select;
		$join = array('tag', 'blog');
		foreach ($join as $j){
			$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], $this->relation[$j]['type']);
			$select = array_merge($this->relation[$j]['select'], $select);
		}
		$this->db->select($select);
		$this->db->where(array('tag.tag_slug =' => $data['tag_slug'], 'tag.language_id =' => $data['language_id']));
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
			if ($this->exists_by_data($data) == false){
				$this->db->insert('blog_in_tag', $data);
				$ret = $this->db->insert_id();
			}
		}
		else{
			$this->db->where(array('id =' => $id));
			$this->db->update('blog_in_tag', $data);
			$ret = $id;
		}
		return $ret;
	}
	
	public function detach_tags($blog_id, $lang_id){
		$sql = "DELETE FROM blog_in_tag WHERE blog_id=".$blog_id." AND tag_id IN (SELECT id FROM tag WHERE language_id=".$lang_id.")";
		$this->db->query($sql);
	}
}